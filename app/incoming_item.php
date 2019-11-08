<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class incoming_item extends Model
{
    protected $fillable = [
    	'no_seri',
    	'barcode',
	];
}
