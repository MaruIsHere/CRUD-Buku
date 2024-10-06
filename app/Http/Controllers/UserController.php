<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {

        $this->userService = $userService;
        
    }
    /**
     * index
     *
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {  
            return DataTables::of($this->userService->getAllUser($request))
                ->addIndexColumn()
                ->addColumn('userame_user', function($row){
                    return $row->username_user;
                })
                ->addColumn('nama_user', function($row){
                    return $row->nama_user;
                })
                ->addColumn('alamat_user', function($row){
                    return $row->alamat_user;
                })
                ->addColumn('nomor_telp', function($row){
                    return $row->nomor_telp;
                })
                ->addColumn('jabatan', function($row){
                    return $row->jabatan;
                })
                ->addColumn('aksi', function($row){
                    $btn = '<a href="javascript:void(0)" id="btn-edit-post"  data-id="'.$row->id_user.'" class="edit btn btn-success btn-sm">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" id="btn-delete-post" data-id="'.$row->id_user.'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['username_user', 'nama_user','alamat_user','nomor_telp','jabatan','aksi'])
                ->make(true);
        }
    
        $tittle = 'Dashboard';
        return view('users', compact('tittle'));
    }
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
       $this->userService->storeUser($request);

    }
    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(User $user)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data User',
            'data'    => $user  
        ]); 
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id)
    {
        $result = $this->userService->updateUSer($request , $id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $result  
        ]);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $this->userService->destroyUser($id);
       
    }

    public function logindisplay(Request $request){

        $tittle ="Login";

        return view('login', compact('tittle'));

    }


    public function login(Request $request)
    {

        $cek = [
            'username_user' => $request->username_user, // Ganti sesuai dengan kolom di database
            'password' => $request->password_user,
        ];   
       
        if (Auth::attempt($cek)) {
            return response()->json(['success' => true, 'message' => 'Login berhasil']);
        } else {
            return response()->json(['success' => false, 'message' => 'Username atau password salah']);
        }
     
        $this->userService->loginUser($request);
        
    
    }
    
    public function logout(Request $request)
    {
        $this->userService->logoutUser($request);
        return redirect()->route('login');
    }
}