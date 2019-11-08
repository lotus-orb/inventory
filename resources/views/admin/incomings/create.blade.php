@extends('layouts.admin')

@section('styles')
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@endsection

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
							<h4 class="card-title">Tambah Barang Masuk</h4>
						</div>
					</div>
					<div class="card-body">
						<form action="{{route('incomings.store')}}" method="POST" id="add_item">
				          {{csrf_field()}}
				          	<div class="form-group">
								<label for="no_spk">Nomor SPK</label>
								<select id="spk" name="spk_id" class="form-control" required>
									<option value="">Pilih Nomor SPK</option>
									@foreach ($spks as $spk)
										<option value="{{$spk->id}}">{{$spk->no_spk}} </option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="tahun_anggaran">Tahun Anggaran</label>
								<select id="thn" name="tahun_anggaran" class="form-control" readonly disabled>
								  	@foreach ($spks as $spk)
										<option value="{{$spk->tahun_anggaran}}" class="{{$spk->id}}">{{$spk->tahun_anggaran}} </option>
									@endforeach
				                </select>
							</div>
							
							<div class="form-group">
								<label for="tgl_masuk">Tanggal Masuk Barang</label>
								<input class="form-control" name="tgl_masuk" id="datepicker" autocomplete="off" required>
							</div>

							<div class="form-group">
								<div class="table-responsive">
									<table class="table no-border">
				                        <td style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
				                        	<label for="barang">Kategori Barang</label>
								          	<select id="category" class="form-control" style="height: calc(2.25rem + 2px) !important;">
							                  <option value="">Pilih Kategori</option>
							                  @foreach ($categories as $category)
							                    <option value="{{$category->id}}">{{$category->nm_kategori}} </option>
							                  @endforeach
							                </select>
				                        </td>
				                        <td style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
				                        	<label for="barang">Nama Barang Masuk</label>
								          	<select id="item" class="form-control" style="height: calc(2.25rem + 2px) !important;">
							                  <option value="">Pilih Nama barang</option>
							                  @foreach ($items as $item)
							                    <option value="{{$item->id}}" class="{{$item->category_id}}">{{$item->nm_barang}} </option>
							                  @endforeach
							                </select>
				                        </td>
				                        <td style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
				                        	<label for="barang"><i>Satuan</i></label>
				                        	<select id="satuan" class="form-control" readonly disabled style="height: calc(2.25rem + 2px) !important;">
											  	@foreach ($items as $item)
													<option value="{{$item->satuan}}" class="{{$item->id}}">{{$item->satuan}} </option>
												@endforeach
							                </select>
				                        </td>
				                        <td style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
				                        	<label for="barang"><i>Serial Number</i></label>
				                        	<input class="form-control" id="no_seri" style="height: calc(2.25rem + 2px) !important;">
								          	
				                        </td>
				                        <input type="hidden" id="balance">
				                        <td>
				                        	<button type="button" id="add" class="btn btn-primary btn-sm m-t-15">
												<i class="fa fa-plus"></i>
											</button>
				                        </td> 
					                </table>
					            </div>
			            	</div>

			            	<div class="form-group">
			            		<div class="table-responsive">
				            		<table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
				            			<thead>
				            				<tr>
					            				<th>Kategori Barang</th>
					            				<th>Nama Barang Masuk</th>
					            				<th>Satuan</th>
					            				<th>Serial Number</th>
					            				<th></th>
				            				</tr>
				            			</thead>
				            			<tbody id="tab"></tbody>
				            		</table>
			            		</div>
			            	</div>

			            	<div class="form-group">
								<label for="pic">Nomor Referensi Barang</label>
								<input class="form-control" name="no_ref" required>
							</div>

			            	<div class="form-group">
								<label for="pic">Nama PIC</label>
								<input class="form-control" name="nm_pic" required>
							</div>

							<div class="form-group">
								<label for="pic">Keterangan</label>
								<textarea class="form-control" name="keterangan"></textarea>
							</div>

							<a href="{{route('incomings.index')}}" class="btn btn-danger m-r-10"><i class="fa fa-angle-left m-r-10"></i> Batal</a>
					        <button class="btn btn-primary" type="submit" id="submit">Simpan</button>
				        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.js" integrity="sha256-d0sQauu0SjMeA9n9U4ceDvED7pxvslcUR9eQSu9fsts=" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$("#thn").chained("#spk");
		$("#item").chained("#category");
		$("#satuan").chained("#item");
	</script>
	<script>
		$(document).ready(function(){
			var i=1;
			$('#add').click(function(){
				var cat = $("#category option:selected");
				var cat_v = cat.val();
				var cat_t = cat.text();
				var item = $("#item option:selected");
				var item_v = item.val();
				var item_t = item.text();
				var sat = $("#satuan option:selected");
				var sat_v = sat.val();
				var sat_t = sat.text();
				var no_seri = $('input[id=no_seri]').val();
				var barcode = $('input[id=barcode]').val();
				i++;
				$('#tab').append(
				'<tr id="row'+i+'" class="tab_added">'+
					'<td>' + '<input type="hidden" name= "category_id[]" value="' + cat_v + '">' + cat_t + '</td>'+
					'<td>' + '<input type="hidden" name= "items[]" value="' + item_v + '">' + item_t + '</td>'+
					'<td>' + '<input type="hidden" name= "satuan[]" value="' + sat_v + '">' + sat_t + '</td>'+
					'<td>' + '<input type="hidden" name= "no_seri[]" value="' + no_seri + '">' + no_seri + '</td>'+
					'<input type="hidden" name= "barcode" value="' + barcode + '">'+
					'<td>'+
			           	'<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-sm btn_remove">'+
			           		'<i class="fa fa-times"></i>'+
			           	'</button>'+
		           	'</td>'+
	           	'</tr>');
			});

			$(document).on('click', '.btn_remove', function(){  
				var button_id = $(this).attr("id");   
				$('#row'+button_id+'').remove();  
			});

			$.ajaxSetup({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#submit').click(function(){            
	           $.ajax({   
	                method:"POST",  
	                data:$('#add_name').serialize(),
	                type:'POST',
	                success:function(data)  
	                {
	                    if(data.error){
	                        Swal.fire({
							  type: 'error',
							  title: 'Oops...',
							  text: 'Something went wrong!'
							})
	                    }else{
	                        i=1;
	                        $('.tab_added').remove();
	                        $('#add_name')[0].reset();
								Swal.fire({
			                        type: 'success',
			                        title: 'Success!',
			                        text: 'Data berhasil ditambah!'
			                    });
	                    }
	                }  
	           });  
	      	});		  
		});
	</script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script>
	  $(function() {
	    $( "#datepicker" ).datepicker({
	    	changeMonth: true,
	    	dateFormat: 'dd MM yy',
      		changeYear: true
	    });
	  });
	</script>
@endsection