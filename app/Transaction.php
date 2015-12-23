<?php

namespace Registration;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $table = "transactions";

    protected $fillable = ["status", "buyer_id", "provider", "txid", "money", "product", "extra"];

    protected $hidden = [];
}
