<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'tb_categories';
    protected $primaryKey = 'id_categories';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nama_categories',
        'price',
        'photo',
        'description'
    ];
}