<?php

namespace App\Models;

use App\Models\invoices;
use App\Models\products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sections extends Model
{
    protected $fillable=["section_name","description","created_by"];
    protected $dates=["deleted_at"];
        public function product()
        {
            return $this->hasMany(products::class);
        }
        public function invoice(){
            return $this->hasMany(invoices::class);
        }

    use HasFactory;
}
