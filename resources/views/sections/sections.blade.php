@extends('layouts.master')
@section('title')
	الاقسام
@endsection
@section('css')
	<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الاقسام</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	@if (session()->has('Add'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ session()->get('Add') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

				<!-- row -->
				<div class="row row-sm">

					<div class="col-xl-12">


							<div class="card">
								<div class="card-header pb-0">
									<div class="col-sm-6 col-md-4 col-xl-3">
										<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo1">اضافة قسم </a>
									</div>
								</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
										<thead>
										<tr>
											<th class="border-bottom-0">#</th>
											<th class="border-bottom-0">اسم القسم </th>
											<th class="border-bottom-0">الوصف</th>
											<th class="border-bottom-0">العمليات</th>
										</tr>
										</thead>
										<tbody>
										<?php $i = 0; ?>
										@foreach ($sections as $section)
												<?php $i++; ?>
										<tr>
											<td>{{$i}}</td>
											<td>{{$section->section_name}}</td>
											<td>{{$section->description}}</td>
											<td>edit</td>
										</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->



					<div class="modal" id="modaldemo1">
						<div class="modal-dialog" role="document">
							<div class="modal-content modal-content-demo">
								<div class="modal-header">
									<h6 class="modal-title">اضافة قسم </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<form action="{{ route('sections.store') }}" method="post">
										@csrf

										<div class="form-group">
											<label for="exampleInputEmail1">اسم القسم</label>
											<input type="text" class="form-control" id="section_name" name="section_name">
										</div>

										<div class="form-group">
											<label for="exampleFormControlTextarea1">ملاحظات</label>
											<textarea class="form-control" id="description" name="description" rows="3"></textarea>
										</div>

										<div class="modal-footer">
											<button type="submit" class="btn btn-success">تاكيد</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
										</div>
									</form>
							</div>
						</div>
					</div>


				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
	<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
	<!--Internal  Datatable js -->
	<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
	<!-- Internal Modal js-->
	<script src="{{URL::asset('assets/js/modal.js')}}"></script>

@endsection