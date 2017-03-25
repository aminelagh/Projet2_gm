@extends('layouts.masters.admin')

@section('title') Ajouter Utilisateur @endsection

@section('username') Amine Laghlabi @endsection

@section('content') Welcome Admin @endsection

@section('main')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ajouter un Utilisateur <small> </small></h1>

		<div id="page-wrapper">

			<div class="container-fluid">

				{{-- Alert message ==> Ajout Reussit --}} @if (session('msgAjoutReussi'))
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('msgAjoutReussi') !!}
				</div>
				@endif {{-- Alert Message ==> Erreur Ajout --}} @if (session('msgErreur'))
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('msgErreur') !!}
				</div>
				@endif {{-- *************** formulaire ***************** --}}
				<form role="form" method="post" action="{{ Route('admin.submitAddUser') }}">
					{{ csrf_field() }}


					<!-- Row 1 -->
					<div class="row">

						<div class="col-lg-2">
							{{-- Role --}}
							<div class="form-group">
								<label>Role</label>
								<select class="form-control" name="id_role" id="id_role">
									@if( !$roles->isEmpty() )
										@foreach( $roles as $item )
											<option value="{{ $item->id_role }}" >{{ $item->libelle }} -> {{ $item->id_role }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>

						<div class="col-lg-2">
							{{-- Magasin --}}
							<div class="form-group">
								<label>Magasin</label>
								<select class="form-control" name="id_magasin" id="id_magasin">
									<option value="0" selected>Aucun</option>
									@if( !$magasins->isEmpty() )
										@foreach( $magasins as $magasin )
											<option value="{{ $magasin->id_magasin }}">{{ $magasin->libelle }} -> {{ $magasin->id_magasin }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>

						<div class="col-lg-4">
							{{-- Email --}}
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" placeholder="E-mail" name="email" id="email" value="{{ old('email') }}" required autofocus>
								<p class="help-block">utilisé pour l'authentification</p>
							</div>
						</div>

						<div class="col-lg-4">
							{{-- Password --}}
							<div class="form-group">
								<label>Password</label>
								<input type="text" class="form-control" placeholder="Password" name="password" id="password" required min="9">
							</div>
						</div>

					</div>
					<!-- end row 1 -->

					<!-- row 2 -->
					<div class="row">

						<div class="col-lg-3">
							{{-- nom --}}
							<div class="form-group">
								<label>Nom</label>
								<input type="text" class="form-control" placeholder="Nom" name="nom" id="nom" value="{{ old('nom') }}" required>
							</div>
						</div>

						<div class="col-lg-3">
							{{-- Prenom --}}
							<div class="form-group">
								<label>Prenom</label>
								<input type="text" class="form-control" placeholder="Prenom" name="prenom" id="prenom" value="{{ old('prenom') }}">
							</div>
						</div>

						<div class="col-lg-3">
							{{-- Ville --}}
							<div class="form-group">
								<label>Ville</label>
								<input type="text" class="form-control" placeholder="Ville" name="ville" id="ville" value="{{ old('ville') }}">
							</div>
						</div>

						<div class="col-lg-3">
							{{-- Telephone --}}
							<div class="form-group">
								<label>Telephone</label>
								<input type="number" class="form-control" placeholder="Telephone" name="telephone" id="telephone" value="{{ old('telephone') }}">
							</div>
						</div>

					</div>
					<!-- end row 2 -->

					<!-- row 3 -->
					<div class="row">

						<div class="col-lg-6">
							{{-- Description --}}
							<div class="form-group">
								<label>Description</label>
								<textarea type="text" class="form-control" rows="5" placeholder="Description" name="description" id="description" value="{{ old('description') }}"></textarea>
							</div>
						</div>

						<div class="col-lg-6">
							<br/><br/> {{-- Submit & Reset --}}
							<button type="submit" class="btn btn-default" width="60">Valider</button>
							<button type="reset" class="btn btn-default">Effacer</button>
						</div>

					</div>

				</form>

				{{-- erreur (not used) --}} @if( isset($error) )
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
