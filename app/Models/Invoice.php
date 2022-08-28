<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

    protected $table = 'tb_invoice';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function invoice_detail() {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function dealer() {
        return $this->belongsTo(Dealer::class);
    }

    public function receipt_detail() {
        return $this->belongsTo(ReceiptDetail::class,'id','invoice_id');
    }

}
