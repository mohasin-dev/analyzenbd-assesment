<?php

namespace App\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    public function listUsers();
    
    public function addUser(array $data);
    
    public function updateUser(array $data, User $user);
    
    public function softDeleteUser(User $user);
    
    public function listDeletedUsers();

    public function restoreUser(int $id);

    public function permanentDeleteUser(int $id);
}