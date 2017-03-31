@extends('layouts.masters.direct')

@section('title')
Ajout Article
@endsection

@section('main')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ajouter un Article <small> </small></h1>

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
					<form role="form" method="post" action="{{ Route('direct.submitAddArticle') }}">
						{{ csrf_field() }}


						<!-- Row 1 -->
						<div class="row">

							<div class="col-lg-3">
								{{-- Categorie --}}
								<div class="form-group">
									<label>Categorie</label>
									<select class="form-control" name="id_categorie" id="id_categorie" autofocus>
										<option value="0" >Aucun</option>
									@if( !$categories->isEmpty() )
										@foreach( $categories as $item )
											<option value="{{ $item->id_categorie }}" >{{ $item->libelle }}</option>
										@endforeach
									@endif
								</select>
								</div>
							</div>

							<div class="col-lg-3">
								{{-- Fournisseur --}}
								<div class="form-group">
									<label>Fournisseur</label>
									<select class="form-control" name="id_fournisseur" id="id_fournisseur">
										<option value="0" >Aucun</option>
									@if( !$fournisseurs->isEmpty() )
										@foreach( $fournisseurs as $item )
											<option value="{{ $item->id_fournisseur }}" >{{ $item->code }}: {{ $item->libelle }}</option>
										@endforeach
									@endif
								</select>
								<p class="help-block">code et nom du fournisseur</p>
								</div>
							</div>

							<div class="col-lg-3">
								{{-- Num_Article --}}
								<div class="form-group">
									<label>Numero Article</label>
									<input type="text" class="form-control" placeholder="Numero Article" name="num_article" id="num_article" value="{{ old('num_article') }}">
								</div>
							</div>

							<div class="col-lg-3">
								{{-- Code_Barre --}}
								<div class="form-group">
									<label>Code a Barres</label>
									<input type="text" class="form-control" placeholder="Code a Barres" name="code_barre" id="code_barre" value="{{ old('code_barre') }}">
								</div>
							</div>

						</div>
						<!-- end row 1 -->

						<!-- row 2 -->
						<div class="row">

							<div class="col-lg-6">
								{{-- Designation --}}
								<div class="form-group">
									<label>Designation</label>
									<input type="text" class="form-control" placeholder="Designation" name="designation" id="designation" value="{{ old('designation') }}" required>
								</div>
							</div>

							<div class="col-lg-3">
								{{-- Taille --}}
								<div class="form-group">
									<label>Taille</label>
									<input type="text" class="form-control" placeholder="Taille" name="taille" id="taille" value="{{ old('taille') }}">
								</div>
							</div>

							<div class="col-lg-3">
								{{-- Couleur --}}
								<div class="form-group">
									<label>Couleur</label>
									<input type="color" class="form-control" placeholder="Couleur" name="couleur_value" id="couleur"  value="{{ old('couleur_value') ? old('couleur_value') :'#ffffff'   }}">ou
									<input type="text" class="form-control" placeholder="Couleur" name="couleur_name" id="couleur"  value="{{ old('couleur_name') ? old('couleur_name') :''   }}">
								</div>
							</div>
						</div>


						<!-- row 3 -->
						</div class="row">

							<div class="col-lg-4">
								{{-- Sexe --}}
								<div class="form-group">
									<label>Sexe</label>
									<div class="radio">
										<label><input type="radio" name="sexe" id="sexe" value="null" checked>Aucun</label>
										<label><input type="radio" name="sexe" id="sexe" value="h">Homme</label>
										<label><input type="radio" name="sexe" id="sexe" value="f">Femme</label>
									</div>
								</div>
							</div>
						</div>

							<div class="col-lg-3">
								{{-- Prix --}}
								<div class="form-group">
									<label>Prix (HT)</label>
									<input type="number" step="0.0001" pattern=".####" min="0" class="form-control" placeholder="Prix" name="prix" id="prix" value="{{ old('prix') }}">
								</div>
							</div>


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
								<button type="submit" name="submit" value="verifier" class="btn btn-default">vérifier</button>
								<button type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
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
