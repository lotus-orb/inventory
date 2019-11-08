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
							<h4 class="card-title">SPK Barang</h4>
							<a href="{{ route('spks.create') }}" class="btn btn-primary btn-round ml-auto">
								<i class="fa fa-plus"></i>
								Tambah SPK
							</a>
						</div>
					</div>
					<div class="card-body">
						<!-- Modal -->
						<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">
											<span class="fw-bold">
											Tambah SPK Barang
											</span> 
										</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<form action="{{route('spks.store')}}" method="POST">
													{{csrf_field()}}
													<div class="form-group" >
														<label for="nm_kategori">Nomor SPK</label>
														<input type="text" class="form-control" name="no_spk" required>
													</div>
													<div class="form-group" >
														<label for="tahun_anggaran">Tahun Anggaran</label>
														<input type="text" class="form-control" name="tahun_anggaran" required>
													</div>
													<div class="form-group" >
														<label for="vendor_id">Nama Perusahaan</label>
														<select name="vendor_id" class="form-control">
															<option value="">Pilih Nama Vendor</option>
															@foreach ($vendors as $vendor)
														<option value="{{ $vendor->id }}">{{ $vendor->nm_vendor }}</option>
															@endforeach
														</select>
													</div>
													<div class="form-group" >
														<label for="nm_pic">Nama PIC</label>
														<input type="text" class="form-control" name="nm_pic" required>
													</div>
													<div class="form-group" >
														<label for="ketarangan">Keterangan (Optional)</label>
														<textarea class="form-control" name="keterangan"></textarea>
													</div>
													<input type="hidden" class="form-control" name="status">
													<input type="hidden" class="form-control" name="jml_barang">
													<div class="modal-footer">
														<button class="btn btn-primary" type="submit">Simpan</button>
														<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
													</div>
												</form>
											</div>
										</div>
									</div>
						    	</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="datatable" class="display table-head-bg-primary table table-striped table-hover" >
								<thead>
									<tr>
										<th>No</th>
							            <th>Nomor SPK</th>
							            <th>Tahun Anggaran</th>
										<th>Nama Vendor</th>
										<th>Status</th>
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

@section('scripts')
  	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
	<script type="text/javascript">
	    $(document).ready(function() {

	      var t = $('#datatable').DataTable({
	      	  "drawCallback": function( settings ) {
	      	 	$('body').on('click', '.hapus', function( e ) {
		            e.preventDefault();
		            var me = $(this),
		            	url = me.attr('href'),
		            	title = me.attr('title');

		            Swal.fire({
					  title: 'Anda yakin akan menghapus ' + title + ' ?',
					  text: 'Kami tidak bertanggung jawab atas tindakan ini!',
					  type: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, hapus data!'
					}).then((result) => {
				        if (result.value) {
				            $.ajax({
				                url: url,
					            type: 'DELETE',
					            data: {method: '_DELETE'},
					            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				                success: function (response) {
				                    $('#datatable').DataTable().ajax.reload();
				                    Swal.fire({
				                        type: 'success',
				                        title: 'Success!',
				                        text: 'Data berhasil dihapus!'
				                    });
				                },
				                error: function (xhr) {
				                    Swal.fire({
				                        type: 'error',
				                        title: 'Oops...',
				                        text: 'Terjadi Kesalahan!'
				                    });
				                }
				            });
				        }
				    });
		        });
		        $('body').on('click', '.photos', function( e ) {
	      	 		$('#myModal').modal('show');  
		        });
			  },
	          processing: true,
	          serverSide: true,
	          "aaSorting": [[ 0,"desc" ]] ,
	          "searchable": false,
	          "orderable": false,
	          "targets": 0,
	          ajax: '{{ route('data_spk') }}',
	          columns: [
	              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
	              {data: 'no_spk', name: 'no_spk'},
	              {data: 'tahun_anggaran', name: 'tahun_anggaran'},
	              {data: 'nm_vendor', name: 'nm_vendor'},
	              {data: 'stats', name: 'stats'},
	              {data: 'action', name: 'action', orderable: false, searchable: false, "width" : "20%"}
	          ]
	        });
	      });
	</script>
 @endsection