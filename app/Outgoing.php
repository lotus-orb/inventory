<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outgoing extends Model
{
    protected $fillable = [
    	'incoming_id',
	    'nm_pic',
	    'kebutuhan',
	    'author',
	];

	public function item()
	{
		return $this->belongsToMany(Item::class,outgoing_item::class);
	}
}
