<?php

namespace App\Repositories\Buku;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuRepositoryImplement extends Eloquent implements BukuRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    */
    protected $model;

    public function __construct(Buku $model)
    {
        $this->model = $model;
    }

    
    public function getAllBuku(Request $request){

        return $this->model->all();

    }
    public function storeBuku(Request $request){

        // Validate input
        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|string|max:255',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dokumen' => 'required|mimes:pdf|max:10000',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Handle file uploads

        $cover = $request->file('cover');
        $cover_baru = 'cover_' . time() . '.' . $cover->getClientOriginalExtension();
        $cover->move('cover/',$cover_baru);
        
            
        $dokumen = $request->file('dokumen');
        $dokumen_baru = 'dokumen_' . time() . '.' . $dokumen->getClientOriginalExtension();
        $dokumen->move('dokumen/', $dokumen_baru);

    
        // Create the Buku model instance
        $this->model::create([
            'judul_buku' => $request->judul_buku,
            'cover' => $cover_baru,
            'dokumen' => $dokumen_baru,
        ]);

    }
    public function updateBuku(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dokumen' => 'nullable|mimes:pdf|max:10000',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Find the book by ID
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json(['success' => false, 'message' => 'Buku tidak ditemukan.'], 404);
        }
    
        // Update the title
        $buku->judul_buku = $request->judul_buku;
    
        // Handle file uploads
        if ($request->hasFile('cover')) {
            // Delete old cover file if exists
            if ($buku->cover) {
                $coverPath = public_path('cover/' . $buku->cover);
                if (file_exists($coverPath)) {
                    unlink($coverPath);
                }
            }
            // Upload new cover
            $cover = $request->file('cover');
            $cover_baru = 'cover_' . time() . '.' . $cover->getClientOriginalExtension();
            $cover->move('cover/', $cover_baru);
            $buku->cover = $cover_baru;
        }
    
        if ($request->hasFile('dokumen')) {
            // Delete old document file if exists
            if ($buku->dokumen) {
                $dokumenPath = public_path('dokumen/' . $buku->dokumen);
                if (file_exists($dokumenPath)) {
                    unlink($dokumenPath);
                }
            }
            // Upload new document
            $dokumen = $request->file('dokumen');
            $dokumen_baru = 'dokumen_' . time() . '.' . $dokumen->getClientOriginalExtension();
            $dokumen->move('dokumen/', $dokumen_baru);
            $buku->dokumen = $dokumen_baru;
        }
    
        // Save the updated book information
        $buku->save();

    }
    public function destroyBuku($id){

         // Temukan pengguna berdasarkan ID
         $buku = $this->model::find($id);
    
         // Pastikan pengguna ditemukan
         if (!$buku) {
             return response()->json([
                 'success' => false,
                 'message' => 'Pengguna tidak ditemukan.',
             ], 404);
         }
     
         // Hapus file terkait (misalnya, gambar profil)
         if ($buku->cover) { 
             $coverpath = public_path('cover/' . $buku-> cover); // Ubah path sesuai dengan struktur foldermu
             
             // Cek apakah file ada dan hapus
             if (file_exists($coverpath)) {
                 unlink($coverpath);
             }
         }
 
         if ($buku->dokumen) {
             $dokumenpath = public_path('dokumen/' . $buku-> dokumen); // Ubah path sesuai dengan struktur foldermu
             
             // Cek apakah file ada dan hapus
             if (file_exists($dokumenpath)) {
                 unlink($dokumenpath);
             }
         }
     
         // Hapus pengguna dari database
         Buku::where('id_buku', $id)->delete();
     
         // Kembalikan respons

    }

}
