<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'type', 'barang_id','from','keterangan'];

    public function barang()
	{
	    return $this->belongsTo(Barang::class);
	}
}
