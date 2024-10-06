<?php

namespace App\Services\User;

use LaravelEasyRepository\BaseService;
use Illuminate\Http\Request;


interface UserService extends BaseService{

    public function getAllUser(Request $request);
    public function storeUser(Request $request);
    public function updateUser(Request $request , $id);
    public function destroyUser($id);
    public function loginUser(Request $request);
    public function logoutUser(Request $request);

}