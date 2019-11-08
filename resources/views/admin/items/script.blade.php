@section('scripts')
  	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
  	<script type="text/javascript">
	    $(document).ready(function(){      
	      var i=1;
	      var num=1;


	      $('#add').click(function(){  
	           i++;
	           num++;  
	           $('#dynamic_field').append(
	           	'<tr id="row'+i+'" class="dynamic-added">'+
	           		'<td width="200" style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">'+
		           		'<select id="category" name="category_id[]" class="form-control m-b-10" style="height: calc(2.25rem + 5px) !important;" required>'+
		                  '<option value="">Pilih Kategori</option>'+
		                  '@foreach ($categories as $category)'+
		                    '<option value="{{$category->id}}">{{$category->nm_kategori}} </option>'+
		                  '@endforeach'+
		                '</select>'+
		           	'</td>'+
		           	'<td width="300" style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">'+
		           		'<input type="text" name="nm_barang[]" class="form-control name_list" style="height: calc(2.25rem + 2px) !important;" required/>'+
		           	'</td>'+
		           	'<td width="300" style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">'+
                    	'<select name="satuan[]" class="form-control m-b-10" style="height: calc(2.25rem + 5px) !important;" required>'+
		                  '<option value="">Pilih Satuan</option>'+
		                  '<option value="Unit">Unit</option>'+
		                  '<option value="Buah">Buah</option>'+
		                  '<option value="Roll">Roll</option>'+
		                  '<option value="Box">Box</option>'+
		                '</select>'+
                    '</td>'+
		           	'<td width="200" style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">'+
		           		'<input type="file" name="photo[]" class="form-control-file name_list" style="height: calc(2.25rem + 2px) !important;" required/>'+
		           	'</td>'+
		           	'<td>'+
			           	'<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-sm btn_remove">'+
			           		'<i class="fa fa-minus"></i>'+
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
	                data:$('#add_name').validate().serialize(),
	                type:'POST',
	           });  
	      });
	    });  
	</script>
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
	          ajax: '{{ route('data_item') }}',
	          columns: [
	              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
	              {data: 'categories', name: 'categories'},
	              {data: 'nm_barang', name: 'nm_barang'},
	              {data: 'satuan', name: 'satuan'},
	              {data: 'photos', name: 'photos'},
	              {data: 'stok', name: 'stok', "style" : "text-align:center"},
	              {data: 'action', name: 'action', orderable: false, searchable: false, "width" : "25%"}
	          ]
	        });
	      });
	</script>
 @endsection