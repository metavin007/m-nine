<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    protected $table = 'tb_customer';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function invoice() {
        return $this->hasMany(Invoice::class)->where('status', '=', 0);
    }

}
