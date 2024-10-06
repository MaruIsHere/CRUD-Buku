<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;
use Illuminate\Http\Request;

interface UserRepository extends Repository
{
    public function getAllUser(Request $request);
    public function storeUser(Request $request);
    public function updateUser(Request $request , $id);
    public function destroyUser($id);
    public function loginUser(Request $request);
    public function logoutUser(Request $request);
}


