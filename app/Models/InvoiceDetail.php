<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model {

    protected $table = 'tb_invoice_detail';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

}
