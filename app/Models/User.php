<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    
    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    protected $fillable = ['username_user', 'password_user','nama_user','alamat_user','nomor_telp','jabatan'];

    public function getAuthPassword()
    {
    return $this->password_user;
    }

}
