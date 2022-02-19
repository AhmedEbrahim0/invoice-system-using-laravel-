<?php

namespace App\Models;

use App\Models\products;
use App\Models\sections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices extends Model
{
    protected $guarded=[];
    protected $dates=["deleted_at"];
    public function section(){
        return $this->belongsTo(sections::class);
    }

    public function product()
    {
        return $this->belongsTo(products::class);
    }

    use HasFactory;
    use SoftDeletes;
}
