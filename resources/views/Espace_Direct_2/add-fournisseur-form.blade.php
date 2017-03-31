@extends('layouts.masters.direct')

@section('title')
Ajout Fournisseur
@endsection

@section('main')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ajouter un Fournisseur <small> </small></h1>

		<div id="page-wrapper">

			<div class="container-fluid">

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



					{{-- *************** formulaire ***************** --}}
					<form role="form" method="post" action="{{ Route('direct.submitAddFournisseur') }}">
						{{ csrf_field() }}


						<!-- Row 1 -->
						<div class="row">

							<div class="col-lg-3">
								{{-- Code --}}
								<div class="form-group">
									<label>Code</label>
									<input type="text" class="form-control" placeholder="Code Fournisseur" name="code" id="code" value="{{ old('code') }}" autofocus>
								</div>
							</div>

							<div class="col-lg-4">
								{{-- Libelle --}}
								<div class="form-group">
									<label>Libelle</label>
									<input type="text" class="form-control" placeholder="Nom du Fournisseur" name="libelle" id="libelle" value="{{ old('libelle') }}" required>
								</div>
							</div>

							<div class="col-lg-4">
								{{-- Telephone --}}
								<div class="form-group">
									<label>Telephone</label>
									<input type="text" class="form-control" placeholder="Telephone" name="telephone" id="telephone" value="{{ old('telephone') }}">
								</div>

								{{-- Telephone --}}
								<div class="form-group">
									<label>Fax</label>
									<input type="text" class="form-control" placeholder="fax" name="fax" id="fax" value="{{ old('fax') }}">
								</div>
							</div>

						</div>
						<!-- end row 1 -->

						<!-- row 2 -->
						<div class="row">

							<div class="col-lg-7">
								{{-- Description --}}
								<div class="form-group">
									<label>Description</label>
									<textarea type="text" class="form-control" rows="5" placeholder="Description" name="description" id="description">{{ old('description') }}</textarea>
								</div>
							</div>

							<div class="col-lg-5">
								<br/><br/>
								{{-- Submit & Reset --}}
								<button type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
								<button type="submit" name="submit" value="verifier" class="btn btn-default">verifier</button>
								<button type="reset" class="btn btn-default">Effacer</button>
							</div>

						</div>

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
	<!-- /.row -->
	@endsection



	@section('content_messages')
<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
					<ul class="dropdown-menu message-dropdown">
						<li class="message-footer">
							<a href="#">Read All New Messages</a>
						</li>
					</ul>
				</li>
@endsection


@section('content_alerts')
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
	<ul class="dropdown-menu alert-dropdown">
		<li><a href="#">Alert Name <span class="label label-default">Alert Badge</span></a></li>
	</ul>
</li>
@endsection


@section('content_compte')
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> @yield('nom_compte') username <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li>
			<a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
		</li>
	</ul>
</li>
@endsection
