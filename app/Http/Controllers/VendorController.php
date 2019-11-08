<?php

namespace App\Http\Controllers;
use App\Vendor;
use DataTables;
use Auth;
use Validator;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();
        return view('admin.vendors.index', compact('vendors'));
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
            'nm_vendor' => 'required|unique:vendors',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vendors.index')->withError('Gagal Menyimpan Data! Pastikan Data Tidak Duplikasi');
        }

        $vendors = Vendor::all();
        $nm_vendor = $request->input('nm_vendor');

        if (is_array($nm_vendor)) {
            foreach($nm_vendor as $value) 
            {
                Vendor::create([
                    'nm_vendor'=>$value
                ]);
            }
        }
        return redirect()->route('vendors.index')->withSuccess('Data Berhasil Disimpan!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendors = Vendor::findOrFail($id);
        return view('admin.vendors.show', compact('vendors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendors = Vendor::findOrFail($id);
        return view('admin.vendors.edit', compact('vendors'));
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
        $vendors = Vendor::findOrFail($id);
        $vendors->nm_vendor = $request->nm_vendor;
        $vendors->save();
        return redirect()->route('vendors.index')->withSuccess('Data Berhasil Diperbarui!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendors = Vendor::findOrFail($id);
        $vendors->delete();
    }

    public function data_vendor() {
      $vendors = Vendor::all();
      return Datatables::of($vendors)

          // ->addColumn('opdz', function($users) use ($opds)  {
          //     foreach ($opds as $opd) {
          //       if ($opd->id == $users->opd_id) {
          //       $return =
          //           $opd->name;
          //     return $return;
          //       }
          //     }
          //   })

          ->addColumn('action', function($vendors){
            return  '<a href="'.route('vendors.edit', $vendors->id).'" class="btn btn-info btn-sm m-r-5 edit"><i class="fa fa-edit"></i></a>'.
                    // '<a href="'.route('vendors.show', $vendors->id).'" class="btn btn-primary btn-sm m-r-5"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route('vendors.destroy', $vendors->id).'" class="btn btn-danger btn-sm m-r-5 hapus" title="'.$vendors->nm_vendor.'"><i class="fa fa-trash"></i></a>';
          })
          ->addIndexColumn()
          ->make(true);
    }
}
