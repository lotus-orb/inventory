<?php

namespace App\Http\Controllers;
use App\Item;
use App\Category;
use App\Spk;
use App\Vendor;
use DataTables;
use Validator; 

use Illuminate\Http\Request;

class SpkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spks = Spk::all();
        $vendors = Vendor::all();
        $items = Item::all();
        return view ('admin.spks.index', compact('spks', 'vendors','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $spks = Spk::all();
        $vendors = Vendor::all();
        $items = Item::all();
        $categories = Category::all();
        return view ('admin.spks.create', compact('spks', 'vendors','items','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_spk' => 'required|unique:spks',
            'item_id' => 'unique:item_spks',
        ]);

        if ($validator->fails()) {
            return redirect()->route('spks.index')->withError('Gagal Menyimpan Data! Pastikan Data Tidak Duplikasi');
        }
        $vendors = Vendor::all();
        $spks = new Spk();
        $spks->no_spk = $request->no_spk;
        $spks->tahun_anggaran = $request->tahun_anggaran;
        $spks->vendor_id = $request->vendor_id;
        $spks->nm_pic = $request->nm_pic;
        $spks->keterangan = $request->keterangan;
        $spks->save();

        $categories = $request->input('category_id');
        $items = $request->input('items');
        $jumlah = $request->input('jumlah');
        $balance = $request->input('balance');

        foreach($items as $index => $value) 
        {
          $spks->item()->attach($value , ['jumlah' => $jumlah[$index], 'balance' => $balance[$index]]);
        }

        return redirect()->route('spks.show', $spks->id)->withSuccess('Data Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $spks = Spk::findOrFail($id);
        $vendors = Vendor::all();
        $categories = Category::all();
        $items = $spks->item;
        return view('admin.spks.show', compact('spks', 'vendors', 'items', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spks = Spk::findOrFail($id);
        $vendors = Vendor::all();
        $categories = Category::all();
        $items = Item::all();
        $itemspk = $spks->item;
        
        return view('admin.spks.edit', compact('spks', 'vendors', 'items', 'itemspk', 'categories'));
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
        $validator = Validator::make($request->all(), [
            'item_id' => 'unique:item_spks',
        ]);

        if ($validator->fails()) {
            return redirect()->route('spks.show', $id)->withError('Gagal Menyimpan Data! Pastikan Data Tidak Duplikasi');
        }

        $spks = Spk::findOrFail($id);
        $vendors = Vendor::all();
        $spks->no_spk = $request->no_spk;
        $spks->tahun_anggaran = $request->tahun_anggaran;
        $spks->vendor_id = $request->vendor_id;
        $spks->nm_pic = $request->nm_pic;
        $spks->keterangan = $request->keterangan;
        $spks->save();

        if (is_array($request->input) && count($request->input)) {
            $items = [];
            
            foreach ($request->input as $item) {
                $items[$item['items']] = [
                    'jumlah' => $item['jumlah'],
                    'balance' => $item['balance'],
                ];
            }

            $spks->item()->sync($items);
        }

        // $categories = $request->input('category_id');
        // $items = $request->input('items');       
        // $jumlah = $request->input('jumlah');
        // $balance = $request->input('balance');

        // $spks->item()->sync($items , ['jumlah' => $jumlah, 'balance' => $balance]);

        return redirect()->route('spks.show', $id)->withSuccess('Data Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $spks = Spk::findOrFail($id);
        $spks->delete();
    }

    public function data_spk() {
        $spks = Spk::all();
        $items = Item::all();
        $vendors = Vendor::all();
        return Datatables::of($spks)
  
            ->addColumn('nm_vendor', function($spks) use ($vendors)  {
                foreach ($vendors as $vendor) {
                  if ($vendor->id == $spks->vendor_id) {
                    return  $return = $vendor->nm_vendor;
                  }
                }
            })

            ->addColumn('stats', function($spks) use ($items) {
                $spkss = $spks->item;

                foreach ($spkss as $spk) {

                    if ($spk->pivot->balance == 0) {

                        return  'Complete';

                    }else{

                        return  'Progress';
                    }
                }
            })
  
  
            ->addColumn('action', function($spks){
              return  '<a href="'.route('spks.edit', $spks->id).'" class="btn btn-info btn-sm m-r-5 edit"><i class="fa fa-edit"></i></a>'.
                      '<a href="'.route('spks.show', $spks->id).'" class="btn btn-primary btn-sm m-r-5"><i class="fa fa-eye"></i></a>'.
                      '<a href="'.route('spks.destroy', $spks->id).'" class="btn btn-danger btn-sm m-r-5 hapus" title="'.$spks->no_spk.'"><i class="fa fa-trash"></i></a>';
            })
            ->addIndexColumn()
            ->make(true);
      }
}
