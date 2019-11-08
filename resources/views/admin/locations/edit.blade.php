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
						<div class="card-title">Edit Lokasi ({{$locations->nm_lokasi}})</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<form action="{{route('locations.update', $locations->id)}}" method="POST">
									{{method_field('PUT')}}
									{{csrf_field()}}
									<div class="form-group">
										<label for="nm_lokasi">Nama Lokasi</label>
										<input type="text" class="form-control" name="nm_lokasi" value="{{ $locations->nm_lokasi }}" required>
									</div>
									<div class="card-footer">
										<div class="row">
											<div class="col-md-12">
												<a href="{{route('locations.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Batal</a>
												<button class="btn btn-primary m-r-10">Simpan</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection