<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoiceAttachment extends Model
{
    protected $table="invoice_attachments";
    protected $guarded=[];
    use HasFactory;
}
