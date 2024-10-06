<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserRepositoryImplement extends Eloquent implements UserRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

public function getAllUser(Request $request)
{

    return $this->model->all();
   
}

public function storeUser(Request $request){

    $request->validate([
        'username_user' => 'required|string|max:255',
        'password_user' => 'required|string|min:8|max:225',  // Ensure password is at least 8 characters
        'nama_user' => 'required|string|max:255',
        'alamat_user' => 'required|string|max:255',
        'nomor_telp' => 'required|string|max:15',
        'jabatan' => 'required|string|in:admin,user', // Ensure jabatan is either 'admin' or 'user'
    ]);

   
    User::create([
        'username_user' => $request->username_user,
        'password_user' => bcrypt($request->password_user), // Hash the password
        'nama_user' => $request->nama_user,
        'alamat_user' => $request->alamat_user,
        'nomor_telp' => $request->nomor_telp,
        'jabatan' => $request->jabatan,
    ]);



}

public function updateUser(Request $request , $id)
{

    $validator = Validator::make($request->all(), [
        'username_user' => 'required',
        'password_user' => 'required',
        'nama_user' => 'required',
        'alamat_user' => 'required',
        'nomor_telp' => 'required',
        'jabatan' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $user = $this->model::find($id);
    if (!$user) {
    return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
    }

    $user->update([
        'username_user' => $request->username_user,
        'password_user' => bcrypt($request->password_user),
        'nama_user' => $request->nama_user,
        'alamat_user' => $request->alamat_user,
        'nomor_telp' => $request->nomor_telp,
        'jabatan' => $request->jabatan,
    ]);

    


}

public function destroyUser($id){

    $this->model->where('id_user', $id)->delete();

}

public function loginUser(Request $request){

 
    $request->validate([
        'username_user' => 'required|string',
        'password_user' => 'required|string',
    ]);


}

public function logoutUser(Request $request){

    Auth::logout(); 
    $request->session()->invalidate();
    $request->session()->regenerateToken();

}

}