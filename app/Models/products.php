<?php

namespace App\Models;

use App\Models\invoices;
use App\Models\sections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{
    protected $fillable=["section_id","product_name"," description"];
    public function section(){
        return $this->belongsTo(sections::class);
    }
    public function invoice(){
        return $this->hasMany(invoices::class);
    }
    use HasFactory;
}
