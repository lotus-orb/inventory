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
						<div class="card-title">Update Nama dan Tipe Barang ({{$items->nm_barang}})</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<form action="{{route('items.update', $items->id)}}" method="POST" enctype="multipart/form-data">
									{{method_field('PUT')}}
									{{csrf_field()}}
									<div class="form-group">
										<select id="category" name="category_id" class="form-control m-b-10" style="height: calc(2.25rem + 5px) !important;" required>
											@foreach ($categories as $category)
												@if ($category->id == $items->category_id)
													<option value="{{$category->id}}">{{$category->nm_kategori}}</option>
												@endif
											@endforeach
											<option value="">Pilih Kategori</option>
											@foreach ($categories as $category)
												<option value="{{$category->id}}">{{$category->nm_kategori}} </option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label for="nm_kategori">Nama dan Tipe Barang</label>
										<input type="text" class="form-control" name="nm_barang" value="{{ $items->nm_barang }}" required>
									</div>
									<div class="form-group">
										<label for="satuan">Satuan Barang</label>
										<select name="satuan" class="form-control" required>
										  <option value="{{$items->satuan}}">{{$items->satuan}}</option>
						                  <option value="">Pilih Satuan</option>
						                  <option value="Unit">Unit</option>
						                  <option value="Buah">Buah</option>
						                  <option value="Roll">Roll</option>
						                  <option value="Box">Box</option>
						                </select>
						            </div>
									<div class="form-group">
										<label for="name">Foto Barang</label>
										<figure class="has-text-centered">
						                  <a href="#" data-toggle="modal" data-target="#addRowModal">
						                    <img id="preview" src="{{ Storage::url('public/upload/'.$items->photo) }}" width="500"/>
						                  </a>
						                </figure>
						                <input type="file" id="photo" name="photo" class="form-control-file" style="display: none;" />
						                <a href="javascript:changePhoto();" class="btn btn-primary btn-sm">Ubah Foto</a>
        								<input type="hidden" style="display: none" value="0" name="remove" id="remove">
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
									<div class="card-footer">
										<div class="row">
											<div class="col-md-12">
												<a href="{{route('items.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Batal</a>
												<button class="btn btn-primary m-r-10" type="submit">Simpan</button>
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

@section('scripts')
	<script>
        function changePhoto() {
            $('#photo').click();
        }
        $('#photo').change(function () {
            var imgPath = $(this)[0].value;
            var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg")
                readURL(this);
            else
                alert("Please select Photo file (jpg, jpeg, png).")
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.readAsDataURL(input.files[0]);
                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                    $('#remove').val(0);
                }
            }
        }
        function removeImage() {
            $('#preview').attr('src', '{{url('images/no-image.jpg')}}');
            $('#remove').val(1);
        }
    </script>
@endsection