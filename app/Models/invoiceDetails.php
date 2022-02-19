<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoiceDetails extends Model
{
    protected $table="invoices_details";
    protected $guarded=[];
    use HasFactory;
}
