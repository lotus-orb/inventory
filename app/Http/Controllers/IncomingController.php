<?php

namespace App\Http\Controllers;
use App\Category;
use App\Item;
use App\Spk;
use App\Incoming;
use Auth;
use DataTables;
use Validator;
use QrCode;

use Illuminate\Http\Request;

class IncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomings = Incoming::all();
        $spks = Spk::all();
        return view ('admin.incomings.index', compact('incomings','spks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $incomings = Incoming::all();
        $spks = Spk::all();
        $categories = Category::all();
        $items = Item::all();
        return view ('admin.incomings.create', compact('incomings','spks','categories','items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $spks = Spk::all();
        $incomings = new Incoming();
        $incomings->spk_id = $request->spk_id;
        $incomings->tgl_masuk = $request->tgl_masuk;
        $incomings->no_ref = $request->no_ref;
        $incomings->nm_pic = $request->nm_pic;
        $incomings->keterangan = $request->keterangan;
        $incomings->author = Auth::user()->name;
        $incomings->save();

        $categories = $request->input('category_id');
        $items = $request->input('items');
        $no_seri = $request->input('no_seri');

        // foreach ($items->id as $item) {
        //     $barcode = 'KDBR0000' .$item;
        // }
        
        foreach($items as $index => $value) 
        {
          $incomings->item()->attach($value , ['barcode' => 'KDBR0000'.$no_seri[$index], 'no_seri' => $no_seri[$index]]);
        }

        return redirect()->route('incomings.show', $incomings->id)->withSuccess('Data Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $incomings = Incoming::findOrFail($id);
        $spks = Spk::all();
        $items = $incomings->item;
        return view ('admin.incomings.show', compact('incomings', 'spks', 'items'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $incomings = Incoming::findOrFail($id);
        $spks = Spk::all();
        $items = $incomings->item;
        $itemall = Item::all();
        $categories = Category::all();
        return view ('admin.incomings.edit', compact('incomings', 'spks', 'items','categories', 'itemall'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $spks = Spk::all();
        $incomings = Incoming::findOrFail($id);
        $incomings->spk_id = $request->spk_id;
        $incomings->tgl_masuk = $request->tgl_masuk;
        $incomings->no_ref = $request->no_ref;
        $incomings->nm_pic = $request->nm_pic;
        $incomings->keterangan = $request->keterangan;
        $incomings->author = Auth::user()->name;
        $incomings->save();

        $categories = $request->input('category_id');
        $item_id = $request->input('item_id');
        $items = Item::findOrFail($item_id);
        $incomings->item()->sync($items);
        $barcode = $request->input('barcode');
        $no_seri = $request->input('no_seri');

        foreach($items as $index => $value) 
        {
          $incomings->item()->sync($value , ['barcode' => $barcode[$index], 'no_seri' => $no_seri[$index]]);
        }

        // $jml_barang = $incomings->item->count();
        // $spks->item()->attach($incomings->spk_id, ['jml_barang' => $jml_barang]);
        return redirect()->route('incomings.index')->withSuccess('Data Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $incomings = Incoming::findOrFail($id);
        $incomings->delete();
    }

    public function data_incoming() {
      $incomings = Incoming::all();
      $spks = Spk::all();
      $categories = Category::all();
      $items = Item::all();
      return Datatables::of($incomings)

          ->addColumn('no_spk', function($incomings) use ($spks)  {
              foreach ($spks as $spk) {
                if ($spk->id == $incomings->spk_id) {
                $return =
                    $spk->no_spk;
              return $return;
                }
              }
            })

          ->addColumn('action', function($incomings){
            return  '<a href="'.route('incomings.edit', $incomings->id).'" class="btn btn-info btn-sm m-r-5 edit"><i class="fa fa-edit"></i></a>'.
                    '<a href="'.route('incomings.show', $incomings->id).'" class="btn btn-primary btn-sm m-r-5"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route('incomings.destroy', $incomings->id).'" class="btn btn-danger btn-sm m-r-5 hapus" title="'.$incomings->spk_id.'"><i class="fa fa-trash"></i></a>';
          })
          ->addIndexColumn()
          ->make(true);
    }
}
