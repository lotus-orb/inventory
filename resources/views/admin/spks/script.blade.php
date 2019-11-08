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
				var jumlah = $('input[id=jumlah]').val();
				var balance = $('input[id=balance]').val();
				var sat = $("#satuan option:selected");
				var sat_v = sat.val();
				var sat_t = sat.text();
				i++;
				$('#tab').append(
				'<tr id="row'+i+'" class="tab_added">'+
					'<td>' + '<input type="hidden" name= "category_id[]" value="' + cat_v + '">' + cat_t + '</td>'+
					'<td>' + '<input type="hidden" name= "items[]" value="' + item_v + '">' + item_t + '</td>'+
					'<td>' + '<input type="hidden" name= "jumlah[]" value="' + jumlah + '">' + jumlah + '</td>'+
					'<td>' + '<input type="hidden" name= "satuan[]" value="' + sat_v + '">' + sat_t + '</td>'+
					'<input type="hidden" name= "balance[]" value="0">'+
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
	                data:$('#add_name').validate().serialize(),
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
@endsection