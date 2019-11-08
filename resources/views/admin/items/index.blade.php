@extends('layouts.admin')

@section('content')
<div class="content">
	<div class="page-inner">
		<div class="page-header">
			<ul class="breadcrumbs" style="margin: 0 !important; padding: 0px !important;">
				<li class="nav-home">
					<a href="#">
						<i class="flaticon-home"></i>
						Dashboard
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
						<div class="d-flex align-items-center">
							<h4 class="card-title">Nama dan Tipe Barang</h4>
							<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
								<i class="fa fa-plus"></i>
								Tambah Nama dan Tipe Barang
							</button>
						</div>
					</div>
					<div class="card-body">
						<!-- Modal -->
						<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog" role="document" style="max-width: 80%">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">
											<span class="fw-bold">
											Tambah Nama dan Tipe Barang
											</span> 
										</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<form action="{{route('items.store')}}" method="POST" id="add_name" enctype="multipart/form-data">
					          						{{csrf_field()}}
													<div class="table-responsive">
														<table class="table no-border" id="dynamic_field">
										                    <tr>  
										                        <td width="200" style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
										                        	<label for="category">Kategori Barang</label>
										                        	<select id="category" name="category_id[]" class="form-control m-b-10" style="height: calc(2.25rem + 5px) !important;" required>
													                  <option value="">Pilih Kategori</option>
													                  @foreach ($categories as $category)
													                    <option value="{{$category->id}}">{{$category->nm_kategori}} </option>
													                  @endforeach
													                </select>
										                        </td>
										                        <td width="300" style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
										                        	<label for="nm_barang">Nama Barang</label>
										                        	<input type="text" name="nm_barang[]" class="form-control name_list m-b-10" style="height: calc(2.25rem + 5px) !important;" required />
										                        </td>
										                        <td width="300" style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
										                        	<label for="nm_barang">Satuan Barang</label>
										                        	<select name="satuan[]" class="form-control m-b-10" style="height: calc(2.25rem + 5px) !important;" required>
													                  <option value="">Pilih Satuan</option>
													                  <option value="Unit">Unit</option>
													                  <option value="Buah">Buah</option>
													                  <option value="Roll">Roll</option>
													                  <option value="Box">Box</option>
													                </select>
										                        </td>
										                        <td  width="200" style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
										                        	<label for="photo">Foto Barang</label>
										                        	<input type="file" name="photo[]" id="photo" class="form-control-file name_list m-b-10" style="height: calc(2.25rem + 2px) !important;" required />
										                        </td>
										                        <td>
										                        	<button type="button" name="add" id="add" class="btn btn-primary btn-sm m-t-15">
																		<i class="fa fa-plus"></i>
																	</button>
										                        </td> 
										                    </tr>  
										                </table>
										            </div>
										            <div class="modal-footer">
														<button class="btn btn-primary" name="submit" id="submit">Simpan</button>
														<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
													</div>
												</form>
											</div>
										</div>
									</div>
						    	</div>
							</div>
						</div>
						@foreach($items as $itemphoto)
							<div class="modal fade" id="myModal{{$itemphoto->id}}" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-header no-bd">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true" style="color: #fff;">&times;</span>
										</button>
									</div>
									<div class="modal-content">
			                    		<img src="{{ Storage::url('public/upload/' .$itemphoto->photo) }}" alt="photo" width="100%">
			                    	</div>
			                    </div>
			                </div>
		                @endforeach
						<div class="table-responsive">
							<table id="datatable" class="display table-head-bg-primary table table-striped table-hover" >
								<thead>
									<tr>
										<th>No</th>
										<th>Kategori Barang</th>
							            <th>Nama dan Tipe Barang</th>
							            <th>Satuan Barang</th>
							            <th>Foto Barang</th>
							            <th>Stok Barang</th>
							            <th></th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@include('admin.items.script')