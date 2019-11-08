<?php

namespace App\Http\Controllers;
use App\Location;
use DataTables;
use Auth;
use Validator;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();
        return view('admin.locations.index', compact('locations'));
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
            'nm_lokasi' => 'required|unique:locations',
        ]);

        if ($validator->fails()) {
            return redirect()->route('locations.index')->withError('Gagal Menyimpan Data! Pastikan Data Tidak Duplikasi');
        }

        $locations = Location::all();
        $nm_lokasi = $request->input('nm_lokasi');

        if (is_array($nm_lokasi)) {
            foreach($nm_lokasi as $value) 
            {
                Location::create([
                    'nm_lokasi'=>$value
                ]);
            }
        }
        return redirect()->route('locations.index')->withSuccess('Data Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $locations = Location::findOrFail($id);
        return view('admin.locations.edit', compact('locations'));
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
        $locations = Location::findOrFail($id);
        $locations->nm_lokasi = $request->nm_lokasi;
        $locations->save();
        return redirect()->route('locations.index')->withSuccess('Data Berhasil Diperbarui!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $locations = Location::findOrFail($id);
        $locations->delete();
    }

    public function data_location() {
      $locations = Location::all();
      return Datatables::of($locations)

          // ->addColumn('opdz', function($users) use ($opds)  {
          //     foreach ($opds as $opd) {
          //       if ($opd->id == $users->opd_id) {
          //       $return =
          //           $opd->name;
          //     return $return;
          //       }
          //     }
          //   })

          ->addColumn('action', function($locations){
            return  '<a href="'.route('locations.edit', $locations->id).'" class="btn btn-info btn-sm m-r-5 edit"><i class="fa fa-edit"></i></a>'.
                    // '<a href="'.route('vendors.show', $vendors->id).'" class="btn btn-primary btn-sm m-r-5"><i class="fa fa-eye"></i></a>'.
                    '<a href="'.route('locations.destroy', $locations->id).'" class="btn btn-danger btn-sm m-r-5 hapus" title="'.$locations->nm_lokasi.'"><i class="fa fa-trash"></i></a>';
          })
          ->addIndexColumn()
          ->make(true);
    }
}
