@extends('layouts.admin')

@section('content')
<div class="content">
	<div class="page-inner">
		<div class="page-header">
			<ul class="breadcrumbs" style="margin: 0 !important; padding: 0px !important;">
				<li class="nav-home">
					<a href="#">
						<i class="flaticon-home"></i>
					</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a href="#">Tables</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a href="#">Datatables</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="card-title">SPK Detail ({{$spks->no_spk}})</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Nomor SPK</label>
									<pre>{{$spks->no_spk}}</pre>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Tahun Anggaran</label>
									<pre>{{$spks->tahun_anggaran}}</pre>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Nama Vendor</label>
									@foreach($vendors as $vendor)
										@if($spks->vendor_id == $vendor->id)
										<pre>{{$vendor->nm_vendor}}</pre>
										@endif	
									@endforeach
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<div class="table-responsive">
										<table class="table table-bordered table-head-bg-primary table-bordered-bd-primary">
											<thead>
												<tr>
													<th>Kategori Barang</th>
													<th>Nama Barang</th>
													<th>Jumlah Barang</th>
													<th>Satuan Barang</th>
													<th>Foto Barang</th>
												</tr>
											</thead>
											<tbody>
												@foreach($items as $item)
							                    <tr>
						                        	<td>{{$item->category->nm_kategori}}</td>
							                        <td>{{$item->nm_barang}}</td>
							                        <td style="text-align: center;">{{$item->pivot->jumlah}}</td>
							                        <td style="text-align: center;">{{$item->satuan}}</td>
							                        <td style="text-align: center;">
							                        	<figure class="has-text-centered">
										                  <a href="#" data-toggle="modal" data-target="#addRowModal{{$item->id}}">
										                    <img src="{{ Storage::url('public/upload/'.$item->photo) }}" class="m-t-10" alt="photo" width="100" height="50">
										                  </a>
										                </figure>
										                <div class="modal fade" id="addRowModal{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-header no-bd">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true" style="color: #fff;">&times;</span>
																	</button>
																</div>
																<div class="modal-content">
										                    		<img src="{{ Storage::url('public/upload/'.$item->photo) }}" alt="photo" width="100%">
										                    	</div>
										                    </div>
										                </div>
							                        </td>
							                    </tr>
							                    @endforeach
						                    </tbody>
						                </table>
						            </div>
				            	</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Nama PIC</label>
									<pre>{{$spks->nm_pic}}</pre>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Keterangan</label>
									<pre>{{$spks->keterangan}}</pre>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Status</label>
									<pre>{{$spks->status}}</pre>	
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<a href="{{route('spks.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Batal</a>
								<a href="{{route('spks.edit', $spks->id)}}" class="btn btn-primary m-r-10"><i class="fa fa-edit m-r-10"></i> Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection