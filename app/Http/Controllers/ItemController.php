<?php

namespace App\Http\Controllers;
use App\Item;
use App\Category;
use DataTables;
use Validator;
use Storage;
use File;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        $categories = Category::all();
        return view('admin.items.index', compact('items','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_barang' => 'required|unique:items',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('items.index')->withError('Gagal Menyimpan Data! Pastikan Data Tidak Duplikasi');
        }

        $items = Item::all();
        $categories = Category::all();
        if($request->hasfile('photo'))
        {
            foreach($request->file('photo') as $image)
            {
                $filenameWithExt = $image->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $photos = $filename.'_'.time().'.'.$extension;
                $path = $image->storeAs('public/upload/', $photos); 
                $data[] = $photos;
            }
        }
        $nm_barangs = $request->input('nm_barang');
        $satuans = $request->input('satuan');
        $categories = $request->input('category_id');

        foreach($nm_barangs as $index =>$value) 
        {
            Item::create([
                'nm_barang'=>$value,
                'satuan'=>$satuans[$index],
                'photo'=>$data[$index],
                'category_id'=>$categories[$index]
            ]);
        }
        return redirect()->route('items.index')->withSuccess('Data Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::all();
        $items = Item::findOrFail($id);
        return view('admin.items.show', compact('items', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $items = Item::findOrFail($id);
        return view('admin.items.edit', compact('items', 'categories'));
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
        $categories = Category::all();
        $items = Item::findOrFail($id);

        if ($request->hasFile('photo')) {
            $dir = 'public/upload/';
            if ($items->photo != '' && File::exists($dir . $items->photo))
                File::delete($dir . $items->photo);
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $photos = $filename.'_'.time().'.'.$extension;
            $path = $request->file('photo')->storeAs('public/upload/', $photos);
            $items->photo = $photos;
        }elseif ($request->remove == 1 && File::exists('public/upload/' . $items->photo)) {
            File::delete('public/upload/' . $items->photo);
            $items->photo = null;
        }
        $items->nm_barang = $request->nm_barang;
        $items->satuan = $request->satuan;
        $items->category_id = $request->category_id;
        $items->save();
        return redirect()->route('items.show', $id)->withSuccess('Data Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = Item::findOrFail($id);
        
        $items->delete();
    }

    public function data_item() {
      $items = Item::all();
      $categories = Category::all();
      return Datatables::of($items)

          ->addColumn('photos', function($items){
              
              return '<a href="#" data-toggle="modal" data-target="#myModal'.$items->id.'">
                        <img id="preview" src="'.Storage::url('public/upload/'.$items->photo) .'" width="100" height="75" style="padding:10px; max-height: 100px !important;"/>
                      </a>';
            })

           ->addColumn('categories', function($items) use ($categories){
              
                foreach ($categories as $category) {
                    if ($category->id == $items->category_id) {
                    $return =
                        $category->nm_kategori;
                    return $return;
                    }
                }
            })
          ->addColumn('action', function($items){
            return  '<a href="'.route('items.edit', $items->id).'" class="btn btn-info btn-sm m-r-5 edit"><i class="fa fa-edit"></i></a>'.
                    '<a href="'.route('items.show', $items->id).'" class="btn btn-primary btn-sm m-r-5"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route('items.destroy', $items->id).'" class="btn btn-danger btn-sm m-r-5 hapus" title="'.$items->nm_barang.'"><i class="fa fa-trash"></i></a>';
          })
          ->addIndexColumn()
          ->rawColumns(['photos','categories','action'])
          ->make(true);
    }
}