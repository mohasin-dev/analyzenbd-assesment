<?php

namespace App\Services;

use App\Models\User;
use App\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    /**
     * User list
     */
    public function listUsers(): LengthAwarePaginator
    {
        return User::latest('id')->paginate(10);
    }

    /**
     * Add users
     */
    public function addUser(array $data): User
    {
        if (request()->hasFile('avatar')) {
            $data['avatar'] = request()->file('avatar')->store('avatars', 'public');
        }

        return User::create($data);
    }

    /**
     * Update user
     */
    public function updateUser(array $data, User $user): void
    {
        if (request()->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = request()->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
    }

    /**
     * Soft delete user
     */
    public function softDeleteUser(User $user): void
    {
        $user->delete();
    }

    /**
     * Soft deleted user list
     */
    public function listDeletedUsers(): LengthAwarePaginator
    {
        return User::onlyTrashed()->paginate(10);
    }

    /**
     * Restore soft deleted user
     */
    public function restoreUser(int $id): void
    {
        $user = User::onlyTrashed()->find($id);

        $user->restore();
    }

    /**
     * Delete user permanently
     */
    public function permanentDeleteUser(int $id): void
    {
        $user = User::onlyTrashed()->find($id);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->forceDelete();
    }
}
