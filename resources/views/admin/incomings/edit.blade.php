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
							<h4 class="card-title">Edit Barang Masuk</h4>
						</div>
					</div>
					<div class="card-body">
						<form action="{{route('incomings.update', $incomings->id)}}" method="POST" id="add_item">
						  {{method_field('PUT')}}
				          {{csrf_field()}}
				          	<div class="form-group">
								<label for="no_spk">Nomor SPK</label>
								<select id="spk" name="spk_id" class="form-control" required>
									@foreach ($spks as $spk)
										@if(!empty($incomings->spk_id) and $incomings->spk_id == $spk->id)
											<option value="{{$incomings->spk_id}}">{{$spk->no_spk}} </option>
										@endif
									@endforeach
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
								<input class="form-control" name="tgl_masuk" id="datepicker" autocomplete="off" value="{{ $incomings->tgl_masuk }}" required>
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
							                  @foreach ($itemall as $itemss)
							                    <option value="{{$itemss->id}}" class="{{$itemss->category_id}}">{{$itemss->nm_barang}} </option>
							                  @endforeach
							                </select>
				                        </td>
				                        <td style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
				                        	<label for="barang"><i>Serial Number</i></label>
				                        	<input class="form-control" id="no_seri" style="height: calc(2.25rem + 2px) !important;">
								          	
				                        </td>
				                        <td style="padding: 0 !important; border-color: #ffffff !important;border-right: 20px solid;">
				                        	<label for="barang">Barcode</label>
								          	<input class="form-control" id="barcode" style="height: calc(2.25rem + 2px) !important;">
				                        </td>
				                        <td>
				                        	<button type="button" id="add" class="btn btn-primary btn-sm m-t-15">
												<i class="fa fa-plus"></i>
											</button>
				                        </td> 
					                </table>
					            </div>
			            	</div>

			            	<div class="form-group">
			            		<table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
			            			<thead>
			            				<tr>
				            				<th>Kategori Barang</th>
				            				<th>Nama Barang Masuk</th>
				            				<th>Serial Number</th>
				            				<th>Barcode</th>
				            				<th></th>
			            				</tr>
			            			</thead>
			            			<tbody id="tab">
			            				@php 
			            					$i = 1;
			            					$c = 1;
			            				@endphp
			            				@foreach($items as $item)
						                    <tr id="row{{$i++}}" class="tab_added">
					                        	<td>
					                        		<input type="hidden" name= "category_id[]" value="{{$item->category->id}}">
					                        		{{$item->category->nm_kategori}}
					                        	</td>
						                        <td>
						                        	<input type="hidden" name= "items[]" value="{{$item->id}}">
						                        	{{$item->nm_barang}}
						                        </td>
						                        <td>
						                        	<input type="hidden" name= "no_seri[]" value="{{$item->pivot->no_seri}}">
						                        	{{$item->pivot->no_seri}}
						                        </td>
						                        <td>
						                        	<input type="hidden" name= "barcode[]" value="{{$item->pivot->barcode}}">
						                        	{{$item->pivot->barcode}}
						                        </td>
						                        <td>
										           	<button type="button" name="remove" id="{{$c++}}" class="btn btn-danger btn-sm btn_remove">
										           		<i class="fa fa-times"></i>
										           	</button>
									           	</td>
						                    </tr>
					                    @endforeach
			            			</tbody>
			            		</table>
			            	</div>

			            	<div class="form-group">
								<label for="pic">Nomor Referensi Barang (No. Surat Jalan/Terima Barang)</label>
								<input class="form-control" name="no_ref" value="{{ $incomings->no_ref }}" required>
							</div>

			            	<div class="form-group">
								<label for="pic">Nama PIC</label>
								<input class="form-control" name="nm_pic" value="{{ $incomings->nm_pic }}" required>
							</div>

							<div class="form-group">
								<label for="pic">Keterangan</label>
								<textarea class="form-control" name="keterangan"> {{ $incomings->keterangan }}</textarea>
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

@include('admin.incomings.script')