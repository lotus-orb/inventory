<?php

namespace App\Http\Controllers;
use App\Category;
use DataTables;
use Validator;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
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
            'nm_kategori' => 'required|unique:categories',
        ]);

        if ($validator->fails()) {
            return redirect()->route('categories.index')->withError('Gagal Menyimpan Data! Pastikan Data Tidak Duplikasi');
        }

        $categories = Category::all();
        $nm_category = $request->input('nm_kategori');

        if (is_array($nm_category)) {
            foreach($nm_category as $value) 
            {
                Category::create([
                    'nm_kategori'=>$value
                ]);
            }
        }
        return redirect()->route('categories.index')->withSuccess('Data Berhasil Disimpan!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::find($id);
        return view('admin.categories.show', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('admin.categories.edit', compact('categories'));
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
        $categories = Category::findOrFail($id);
        $categories->nm_kategori = $request->nm_kategori;
        $categories->save();
        return redirect()->route('categories.show', $id)->withSuccess('Data Berhasil Disimpan!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Category::findOrFail($id);
        $categories->delete();
    }

    public function data_category() {
      $categories = Category::all();
      return Datatables::of($categories)

          // ->addColumn('opdz', function($users) use ($opds)  {
          //     foreach ($opds as $opd) {
          //       if ($opd->id == $users->opd_id) {
          //       $return =
          //           $opd->name;
          //     return $return;
          //       }
          //     }
          //   })

          ->addColumn('action', function($categories){
            return  '<a href="'.route('categories.edit', $categories->id).'" class="btn btn-info btn-sm m-r-5 edit"><i class="fa fa-edit"></i></a>'.
                    '<a href="'.route('categories.show', $categories->id).'" class="btn btn-primary btn-sm m-r-5"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route('categories.destroy', $categories->id).'" class="btn btn-danger btn-sm m-r-5 hapus" title="'.$categories->nm_kategori.'"><i class="fa fa-trash"></i></a>';
          })
          ->addIndexColumn()
          ->make(true);
    }
}
