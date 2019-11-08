<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incoming extends Model
{
    protected $fillable = [
	    'spk_id',
	    'tgl_masuk',
	    'no_ref',
	    'nm_pic',
	    'keterangan',
	    'author',
	];

	public function item()
	{
		return $this->belongsToMany(Item::class,incoming_item::class)->withPivot('id','no_seri', 'barcode');
	}
}
