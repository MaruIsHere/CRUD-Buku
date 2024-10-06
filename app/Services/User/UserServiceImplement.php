<?php

namespace App\Services\User;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserServiceImplement extends ServiceApi implements UserService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "";
     /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     * protected $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function getAllUser(Request $request){

        try {

          return $this->mainRepository->getAllUser($request);

        }catch(Exception $exception){
          Log::debug($exception->getMessage());
          return[];
        }
  }

    public function storeUser(Request $request){

      try {

        return $this->mainRepository->storeUser($request);

    } catch(Exception $exception){
      Log::debug($exception->getMessage());
      return[];
    }
  }
   
    public function updateUser(Request $request , $id){
      
      try {

        return $this->mainRepository->updateUser($request , $id);

    } catch(Exception $exception){
      Log::debug($exception->getMessage());
      return[];
    }

    }

    public function destroyUser($id){

      try {

        return $this->mainRepository->destroyUser($id);

    } catch(Exception $exception){
      Log::debug($exception->getMessage());
      return[];
    }

    }
    public function loginUser(Request $request){

      try {

        return $this->mainRepository->loginUser($request);

    } catch(Exception $exception){
      Log::debug($exception->getMessage());
      return[];
    }
      
    }

    public function logoutUser(Request $request){

      try {

        return $this->mainRepository->logoutUser($request);

    } catch(Exception $exception){
      Log::debug($exception->getMessage());
      return[];
    }

    }
}