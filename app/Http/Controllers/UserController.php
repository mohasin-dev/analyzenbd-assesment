<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\User\CreatedOrUpdated;
use Illuminate\Http\RedirectResponse;
use App\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;

class UserController extends Controller
{

    public function __construct(protected UserServiceInterface $userService)
    {
        //
    }

    /**
     * Display the user list.
     */
    public function index(): View
    {
        $users = $this->userService->listUsers();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('user.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            $user = $this->userService->addUser($validatedData);

            if (count($validatedData['addresses'])) {
                CreatedOrUpdated::dispatch($user, $validatedData['addresses']);
            }

            DB::commit();

            return Redirect::route('users.index')->with('success', 'User Created.');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return Redirect::back()->with('error', 'An error occurred while creating the user.');
        }
    }

    /**
     * Display the user.
     */
    public function show(User $user): View
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the user.
     */
    public function edit(User $user): View
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the user in storage.
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            $this->userService->updateUser($validatedData, $user);

            CreatedOrUpdated::dispatch($user, $validatedData['addresses'], $userUpdating = true);

            DB::commit();

            return Redirect::route('users.index')->with('success', 'User Updated.');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return Redirect::back()->with('error', 'An error occurred while updating the user.');
        }
    }

    /**
     * Remove the user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->id === auth()->id(), 403);

        $this->userService->softDeleteUser($user);

        return Redirect::route('users.index')->with('success', 'User Deleted.');;
    }

    /**
     * Display the deleted user list.
     */
    public function deletedUsers(): View
    {
        $deletedUsers = $this->userService->listDeletedUsers();

        return view('user.deleted', compact('deletedUsers'));
    }

    /**
     * Restore soft deleted user.
     */
    public function restore($id): RedirectResponse
    {
        $this->userService->restoreUser($id);

        return Redirect::route('deletedUsers.index')->with('success', 'User Restored.');;
    }

    /**
     * Delete user permanently.
     */
    public function permanentDestroy($id): RedirectResponse
    {
        abort_if($id === auth()->id(), 403);

        $this->userService->permanentDeleteUser($id);

        return Redirect::route('deletedUsers.index')->with('success', 'User Deleted Permanently.');;
    }
}
