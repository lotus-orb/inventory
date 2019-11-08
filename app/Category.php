<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
	    'nm_kategori',
	];

	public function item(){
    	return $this->hasMany(Item::class);
    }
}
