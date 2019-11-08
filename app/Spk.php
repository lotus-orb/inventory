<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spk extends Model
{
    protected $fillable = [
		'vendor_id',
	    'no_spk',
	    'tahun_anggaran',
		'nm_pic',
		'keterangan',
		'status',
		'jml_barang',
	];

	public function item()
	{
		return $this->belongsToMany(Item::class, Item_spk::class)->withPivot('jumlah','balance');
	}
}
