<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->userService = app(UserService::class);
    }

    public function testListUsers()
    {
        User::factory()->count(3)->create();

        $users = $this->userService->listUsers();

        $this->assertInstanceOf(LengthAwarePaginator::class, $users);

        // Here 4 because we create 1 in setup method
        $this->assertCount(4, $users->items());
    }

    public function testAddUser()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ];

        $user = $this->userService->addUser($data);

        $this->assertInstanceOf(User::class, $user);

        $this->assertDatabaseHas('users', $data);
    }

    public function testUpdateUser()
    {
        $newData = [
            'name' => 'Updated Name',
            'email' => 'doe@example.com'
        ];

        $this->userService->updateUser($newData, $this->user);

        $this->user->refresh();

        $this->assertEquals($newData['name'], $this->user->name);
        $this->assertEquals($newData['email'], $this->user->email);
    }

    public function testSoftDeleteUser()
    {
        $this->userService->softDeleteUser($this->user);

        $this->assertSoftDeleted('users', ['id' => $this->user->id]);
    }

    public function testListDeletedUsers()
    {
        User::factory()->count(15)->create();

        $deletedUsers = User::factory()->count(5)->create();

        $deletedUsers->map(function ($user) {
            return $user->delete();
        });

        // foreach ($deletedUsers as $user) {
        //     $user->delete();
        // }

        $deletedUsersPaginator = $this->userService->listDeletedUsers();

        $this->assertInstanceOf(LengthAwarePaginator::class, $deletedUsersPaginator);

        $this->assertCount(5, $deletedUsersPaginator->items());
    }

    public function testRestoreUser()
    {
        $user = User::factory()->create(['deleted_at' => now()]);

        $this->userService->restoreUser($user->id);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    public function testPermanentDeleteUser()
    {
        $user = User::factory()->create(['deleted_at' => now()]);

        $this->userService->permanentDeleteUser($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
