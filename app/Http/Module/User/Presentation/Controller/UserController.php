<?php

namespace App\Http\Module\User\Presentation\Controller;

use App\Http\Module\User\Application\Services\CreateUser\CreateUserRequest;
use App\Http\Module\User\Application\Services\CreateUser\CreateUserService;
use Illuminate\Http\Request;

class UserController
{
    public function __construct(
        private CreateUserService $create_product_service
    )
    {
    }

    public function createUser(Request $request){
        $request = new CreateUserRequest(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
            $request->input('role'),
        );

        return $this->create_product_service->execute($request);
    }
}