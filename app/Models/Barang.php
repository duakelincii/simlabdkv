<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'satuan', 'year', 'category_id','gambar'];

    public function stocks()
    {
    	return $this->hasMany(Stock::class);
    }

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->belongsToMany(Loan::class);
    }
}
