<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
    	'category_id',
	    'nm_barang',
	    'photo',
	    'satuan',
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function spk()
	{
		return $this->belongsToMany(Spk::class,item_spk::class);
	}

	public function incoming()
	{
		return $this->belongsToMany(Incoming::class,incoming_item::class);
	}

	public function outgoing()
	{
		return $this->belongsToMany(Outgoing::class,outgoing_item::class);
	}
}
