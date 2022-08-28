<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerMainPrice extends Model {

    protected $table = 'tb_customer_main_price';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

}
