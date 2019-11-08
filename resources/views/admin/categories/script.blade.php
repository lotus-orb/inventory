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
	           	'<div class="input-group m-t-10" id="id'+i+'" class="dynamic-added">'+
					'<input type="text" class="form-control" name="nm_kategori[]" required>'+
					'<div class="input-group-append">'+
						'<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-sm btn_remove">'+
						'<i class="fa fa-times"></i>'+
						'</button>'+
					'</div>'+
				'</div>');  
	      });  


	      $(document).on('click', '.btn_remove', function(){  
	           var button_id = $(this).attr("id");   
	           $('#id'+button_id+'').remove();  
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
			  },
	          processing: true,
	          serverSide: true,
	          "aaSorting": [[ 0,"desc" ]] ,
	          "searchable": false,
	          "orderable": false,
	          "targets": 0,
	          ajax: '{{ route('data_category') }}',
	          columns: [
	              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
	              {data: 'nm_kategori', name: 'nm_kategori'},
	              {data: 'updated_at', name: 'updated_at'},
	              {data: 'action', name: 'action', orderable: false, searchable: false}
	          ]
	        });
	      });
	</script>
 @endsection