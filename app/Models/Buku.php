<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $table = 'tb_buku';
    protected $primaryKey = 'id_buku';
    protected $fillable = [
        'judul_buku',
        'cover',
        'dokumen',
    ];
}