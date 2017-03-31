@extends('layouts.masters.direct')

@section('title')
Ajout Categorie
@endsection

@section('main')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ajouter une Categorie <small> </small></h1>

		<div id="page-wrapper">

			<div class="container-fluid">

					{{-- Alert message ==> Ajout Reussit --}}
					@if (session('msgAjoutReussi'))
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('msgAjoutReussi') !!}
					</div>
					@endif {{-- Alert Message ==> Erreur Ajout --}}

					@if (session('msgErreur'))
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('msgErreur') !!}
					</div>
					@endif

					{{-- *************** formulaire ***************** --}}
					<form role="form" method="post" action="{{ Route('direct.submitAddCategorie') }}">
						{{ csrf_field() }}


						<!-- Row 1 -->
						<div class="row">

							<div class="col-lg-5">
								{{-- Libelle --}}
								<div class="form-group">
									<label>Libelle</label>
									<input type="text" class="form-control" placeholder="Nom de la Categorie" name="libelle" id="libelle" value="{{ old('libelle') }}" required autofocus>
								</div>
							</div>

							<div class="col-lg-7">
								{{-- Description --}}
								<div class="form-group">
									<label>Description</label>
									<textarea type="text" class="form-control" rows="5" placeholder="Description" name="description" id="description">{{ old('description') }}</textarea>
								</div>
							</div>

						</div>
						<!-- end row 1 -->

						<!-- row 2 -->
						<div class="row">

							<div class="col-lg-6">
								{{-- Submit & Reset --}}
								<button type="submit" class="btn btn-default" width="60">Valider</button>
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
