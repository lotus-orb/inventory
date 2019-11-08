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
						<div class="card-title">Nama dan Tipe Barang ({{$items->nm_barang}})</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Nama dan Tipe Barang</label>
									@foreach ($categories as $category)
										@if ($category->id == $items->category_id)
											<pre>{{$category->nm_kategori}}</pre>
										@endif
									@endforeach
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Nama dan Tipe Barang</label>
									<pre>{{$items->nm_barang}}</pre>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Satuan Barang</label>
									<pre>{{$items->satuan}}</pre>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Foto Barang</label>
									<figure class="has-text-centered">
					                  <a href="#" data-toggle="modal" data-target="#addRowModal">
					                    <img src="{{ Storage::url('public/upload/'.$items->photo) }}" alt="photo" width="300">
					                  </a>
					                </figure>
					                <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-header no-bd">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true" style="color: #fff;">&times;</span>
												</button>
											</div>
											<div class="modal-content">
					                    		<img src="{{ Storage::url('public/upload/'.$items->photo) }}" alt="photo" width="100%">
					                    	</div>
					                    </div>
					                </div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Tanggal Update</label>
									<pre>{{$items->updated_at}}</pre>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Stok Barang</label>
									<pre>{{$items->stok}} {{$items->satuan}}</pre>	
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<a href="{{route('items.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Batal</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection