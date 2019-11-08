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
						@foreach($spks as $spk)
							@if($spk->id == $incomings->spk_id)
								<div class="card-title">Barang Masuk Detail untuk Nomor SPK ({{$spk->no_spk}})</div>
							@endif
						@endforeach
					</div>
					<div class="card-body">
						<div class="row">
							@foreach($spks as $spk)
								@if($spk->id == $incomings->spk_id)
									<div class="col-sm-12">
										<div class="form-group">
											<label for="name">Nomor SPK</label>
											<pre>{{$spk->no_spk}}</pre>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label for="name">Tahun Anggaran</label>
											<pre>{{$spk->tahun_anggaran}}</pre>
										</div>
									</div>
								@endif
							@endforeach
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Tanggal Masuk Barang</label>
									<pre>{{$incomings->tgl_masuk}}</pre>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<div class="table-responsive">
										<table class="table table-bordered table-head-bg-primary table-bordered-bd-primary">
											<thead>
												<tr>
													<th>Kode Barang</th>
													<th>Kategori Barang</th>
													<th>Nama Barang Masuk</th>
													<th>Satuan Barang</th>
													<th><i>Serial Number</i></th>
													<th>Foto Barang</th>
													<th>Barcode</th>
												</tr>
											</thead>
											<tbody>
												@foreach($items as $item)
							                    <tr>
							                    	<td style="text-align: center;">KDBR000{{$item->pivot->id}}</td>
						                        	<td>{{$item->category->nm_kategori}}</td>
							                        <td>{{$item->nm_barang}}</td>
							                        <td>{{$item->satuan}}</td>
							                        <td>{{$item->pivot->no_seri}}</td>
							                        <td>
							                        	<figure class="has-text-centered">
										                  <a href="#" data-toggle="modal" data-target="#addRowModal{{$item->id}}">
										                    <img src="{{ Storage::url('public/upload/'.$item->photo) }}" class="m-t-10" alt="photo" width="100">
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
							                        <td>
							                        	<figure class="has-text-centered">
										                  <a href="#" data-toggle="modal" data-target="#myModal{{$item->pivot->id}}">
										                    <button class="btn btn-round btn-primary btn-sm m-t-10">Generate Barcode</button>
										                  </a>
										                </figure>
										                <div class="modal fade" id="myModal{{$item->pivot->id}}" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-header no-bd">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true" style="color: #fff;">&times;</span>
																	</button>
																</div>
																<div class="modal-content">
																	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge('\qr_bg.png', .3)->size(500)->errorCorrection('H')->generate($item->pivot->barcode.' '.$item->category->nm_kategori.' '.$item->nm_barang.' ('.$item->pivot->no_seri.')')); !!} " style="width: 100%">
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
									<label for="name">Nomor Referensi Barang (No. Surat Jalan/Terima Barang)</label>
									<pre>{{$incomings->no_ref}}</pre>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Nama PIC</label>
									<pre>{{$incomings->nm_pic}}</pre>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Keterangan (Optional)</label>
									<pre>{{$incomings->keterangan}}</pre>	
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<a href="{{route('incomings.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Back</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	 $('#myModal').modal('show');  
</script>
@endsection