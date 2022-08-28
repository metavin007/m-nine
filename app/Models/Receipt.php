<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model {

    protected $table = 'tb_receipt';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function receipt_detail() {
        return $this->hasMany(ReceiptDetail::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

}
