@extends('layouts.main_master')

@section('title') Ajout Fournisseur @endsection

@section('styles')
<link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
<link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
<link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
<script src="{{  asset('js/jquery.js') }}"></script>
<script src="{{  asset('js/bootstrap.js') }}"></script>
@endsection

@section('main_content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ajouter un Fournisseur <small> </small></h1>

		<div id="page-wrapper">

			<div class="container-fluid">

				<div class="row">
					<div class="col-lg-2"></div>

					<div class="col-lg-8">
						{{-- Debut Alerts --}}
						@if (session('alert_success'))
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('alert_success') !!}
						</div>
						@endif

						@if (session('alert_info'))
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('alert_info') !!}
						</div>
						@endif

						@if (session('alert_warning'))
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('alert_warning') !!}
						</div>
						@endif

						@if (session('alert_danger'))
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('alert_danger') !!}
						</div>
						@endif
						{{-- Fin Alerts --}}
					</div>

					<div class="col-lg-2"></div>

				</div>

					{{-- *************** formulaire ***************** --}}
					<form role="form" method="post" action="{{ Route('direct.submitAdd',['param' => 'fournisseur']) }}">
						{{ csrf_field() }}


						<!-- Row 1 -->
						<div class="row">

								<div class="col-lg-2">
									{{-- Code --}}
									<div class="form-group">
										<label>Code du fournisseur</label>
										<input type="text" class="form-control" placeholder="Code" name="code" value="{{ old('code') }}" autofocus>
									</div>
								</div>

								<div class="col-lg-5">
								{{-- Libelle --}}
								<div class="form-group">
									<label>Libelle</label>
									<input type="text" class="form-control" placeholder="Libelle" name="libelle" value="{{ old('libelle') }}" required>
								</div>
								</div>

								<div class="col-lg-5">
								{{-- Agent --}}
								<div class="form-group">
									<label>Nom du representant</label>
									<input type="text" class="form-control" placeholder="Agent" name="agent" value="{{ old('agent') }}" >
								</div>
								</div>

						</div>
						<!-- end row 1 -->

						<!-- Row 2 -->
						<div class="row">

							<div class="col-lg-6">
								{{-- Email --}}
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
								</div>
							</div>

							<div class="col-lg-3">
								{{-- Telephone --}}
								<div class="form-group">
									<label>Telephone</label>
									<input type="text" class="form-control" placeholder="Telephone" name="telephone" value="{{ old('telephone') }}">
								</div>
							</div>

							<div class="col-lg-3">
								{{-- Fax --}}
								<div class="form-group">
									<label>Fax</label>
									<input type="text" class="form-control" placeholder="Fax" name="fax" value="{{ old('fax') }}">
								</div>
							</div>

						</div>
						<!-- end row 2 -->

						<!-- row 3 -->
						<div class="row">

							<div class="col-lg-12">
								{{-- Description --}}
								<div class="form-group">
									<label>Description</label>
									<textarea type="text" class="form-control" rows="2" placeholder="Description" name="description">{{ old('description') }}</textarea>
								</div>
							</div>

						</div>
						<!-- end row 3 -->

						<!-- row 4 -->
						<div class="row">

							<div class="col-lg-4"></div>
							<div>
								{{-- Submit & Reset --}}
								<button type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
								<button type="submit" name="submit" value="verifier" class="btn btn-default">Vérifier</button>
								<button type="reset" class="btn btn-default">Effacer</button>
							</div>

						</div>
						<!-- end row 4 -->

						{{-- verifier si data exist et non vide --}}
						@if( isset($data) && !$data->isEmpty())
						<hr>
						<!-- row 5 -->
						<div class="row">
							<div class="col-lg-2"></div>
							<div class="col-lg-6">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title">Fournisseurs</h3>
									</div>
									<div class="panel-body">
										<ul class="list-group" align="center">
											@foreach($data as $item)
												<li class="list-group-item">{{ $item->code }}: {{ $item->libelle }}</li>
											@endforeach
                    </ul>
									</div>
								</div>
							</div>

						</div>
						<!-- end row 5 -->
						@endif
						{{-- fin if --}}

					</form>

					{{-- erreur (not used) --}}
					@if( isset($error) )
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<strong>Oh snap!</strong> {{ $error }}
						</div>
					</div>
					@endif



			</div>
			<!-- /#page-wrapper -->
		</div>
	</div>
</div>
	<!-- /.row -->
@endsection


@section('menu_1')
	@include('Espace_Direct._nav_menu_1')
@endsection

@section('menu_2')
	@include('Espace_Direct._nav_menu_2')
@endsection