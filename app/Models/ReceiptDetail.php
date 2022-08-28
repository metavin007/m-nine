<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptDetail extends Model {

    protected $table = 'tb_receipt_detail';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function receipt() {
        return $this->belongsTo(Receipt::class);
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

}
