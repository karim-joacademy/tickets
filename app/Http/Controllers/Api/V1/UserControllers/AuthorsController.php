<?php

namespace App\Http\Controllers\Api\V1\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserRequests\StoreUserRequest;
use App\Http\Requests\Api\V1\UserRequests\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class AuthorsController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(StoreUserRequest $request)
    {
        //
    }

    public function show(User $user)
    {
        //
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
