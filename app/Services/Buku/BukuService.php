<?php

namespace App\Services\Buku;

use LaravelEasyRepository\BaseService;
use Illuminate\Http\Request;

interface BukuService extends BaseService{

    public function getAllBuku(Request $request);
    public function storeBuku(Request $request);
    public function updateBuku(Request $request, $id);
    public function destroyBuku($id);
}
