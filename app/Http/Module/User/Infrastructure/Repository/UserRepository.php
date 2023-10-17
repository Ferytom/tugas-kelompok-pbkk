<?php

namespace App\Http\Module\User\Infrastructure\Repository;

use App\Http\Module\User\Domain\Model\User;
use App\Http\Module\User\Domain\Services\Repository\UserRepositoryInterface;
use DB;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user)
    {
        DB::table('users')->upsert(
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'role' => $user->role
            ],
            ['email']
        );
    }
}