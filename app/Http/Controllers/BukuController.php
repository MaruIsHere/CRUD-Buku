<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Buku\BukuRepository;
use App\Services\Buku\BukuService;

class BukuController extends Controller
{


    protected $bukuService;
    public function __construct(BukuService $bukuService)
    {

        $this->bukuService = $bukuService;
        
    }
    /**
     * index
     *
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($this->bukuService->getAllBuku($request))
                ->addIndexColumn()
                ->addColumn('cover', function($row){
                    return '<img src="'.asset('cover/'.$row->cover).'" width="50%" height="50%"/>';
                })
                ->addColumn('download', function($row){
                    return '<a href="'.asset('dokumen/'.$row->dokumen).'" class="btn btn-primary" target="_blank">Download</a>';
                })
                ->addColumn('aksi', function($row){
                    $btn = '<a href="javascript:void(0)" id="btn-edit-post" data-id="'.$row->id_buku.'" class="edit btn btn-success btn-sm">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" id="btn-delete-post" data-id="'.$row->id_buku.'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['cover', 'download', 'aksi'])
                ->make(true);
        }
        $tittle = 'Dashboard';
        return view('posts',compact('tittle'));
    }
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        
        $this->bukuService->storeBuku($request);

    }
    
    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(Buku $buku)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Buku',
            'data'    => $buku  
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
     
        $this->bukuService->updateBuku($request , $id);
    
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
       
        $this->bukuService->destroyBuku($id);
       
    }
}