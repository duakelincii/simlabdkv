<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'return', 'status','tgl_pinjam'];

    public function barangs()
    {
    	return $this->belongsToMany(Barang::class)->withPivot('qty');
    }

    public function member()
    {
    	return $this->belongsTo(Member::class);
    }
}
