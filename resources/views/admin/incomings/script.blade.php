@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.js" integrity="sha256-d0sQauu0SjMeA9n9U4ceDvED7pxvslcUR9eQSu9fsts=" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$("#thn").chained("#spk");
		$("#item").chained("#category");
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
				var no_seri = $('input[id=no_seri]').val();
				var barcode = $('input[id=barcode]').val();
				i++;
				$('#tab').append(
				'<tr id="row'+i+'" class="tab_added">'+
					'<td>' + '<input type="hidden" name= "category_id[]" value="' + cat_v + '">' + cat_t + '</td>'+
					'<td>' + '<input type="hidden" name= "items[]" value="' + item_v + '">' + item_t + '</td>'+
					'<td>' + '<input type="hidden" name= "no_seri[]" value="' + no_seri + '">' + no_seri + '</td>'+
					'<td>' + '<input type="hidden" name= "barcode[]" value="' + barcode + '">' + barcode + '</td>'+
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