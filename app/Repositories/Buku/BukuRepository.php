<?php

namespace App\Repositories\Buku;

use LaravelEasyRepository\Repository;
use Illuminate\Http\Request;
interface BukuRepository extends Repository{

    public function getAllBuku(Request $request);
    public function storeBuku(Request $request);
    public function updateBuku(Request $request, $id);
    public function destroyBuku($id);

}
