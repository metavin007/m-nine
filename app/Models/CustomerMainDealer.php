<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerMainDealer extends Model {

    protected $table = 'tb_customer_main_dealer';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function dealer() {
        return $this->belongsTo(Dealer::class);
    }

}
