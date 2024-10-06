<?php

namespace App\Services\Buku;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Buku\BukuRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BukuServiceImplement extends ServiceApi implements BukuService{

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

    public function __construct(BukuRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }
    public function getAllBuku(Request $request){

      try {

        return $this->mainRepository->getAllBuku($request);

      }catch(Exception $exception){
        Log::debug($exception->getMessage());
        return[];
      }
    }

    public function storeBuku(Request $request){

      try {

        return $this->mainRepository->storeBuku($request);

      }catch(Exception $exception){
        Log::debug($exception->getMessage());
        return[];
      }
    }

    public function updateBuku(Request $request, $id){

      try {

        return $this->mainRepository->updateBuku($request , $id);

      }catch(Exception $exception){
        Log::debug($exception->getMessage());
        return[];
      }
    }
    public function destroyBuku($id){

      try {

        return $this->mainRepository->destroyBuku($id);

      }catch(Exception $exception){
        Log::debug($exception->getMessage());
        return[];
      }
}
}
