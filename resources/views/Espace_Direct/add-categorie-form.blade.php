@extends('layouts.main_master')

@section('title') Ajout Categorie @endsection

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
		<h1 class="page-header">Ajouter une Categorie <small> </small></h1>

		<div id="page-wrapper">

			<div class="container-fluid">

				{{-- **************Alerts**************  --}}
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
				{{-- **************endAlerts**************  --}}

					{{-- *************** formulaire ***************** --}}
					<form role="form" method="post" action="{{ Route('direct.submitAdd',['p_table' => 'categories']) }}">
						{{ csrf_field() }}


						<!-- Row 1 -->
						<div class="row">

							<div class="col-lg-6">
								{{-- Libelle --}}
								<div class="form-group">
									<label>Nom de la Categorie</label>
									<input type="text" class="form-control" placeholder="Libelle " name="libelle" value="{{ old('libelle') }}" required autofocus>
								</div>
							</div>

							<div class="col-lg-6">
								{{-- Description --}}
								<div class="form-group">
									<label>Description</label>
									<textarea type="text" class="form-control" rows="3" placeholder="Description" name="description">{{ old('description') }}</textarea>
								</div>
							</div>

						</div>
						<!-- end row 1 -->


						<!-- row 4 -->
						<div class="row" align="center">
								{{-- Submit & Reset --}}
								<label title="aa">cochez pour forcer l'ajout de l'article</label>
								<input type="checkbox" name="force" value="true"><br>
								<button type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
								<button type="reset" class="btn btn-default">Effacer</button>
						</div>
						<!-- end row 4 -->

						{{-- verifier si data exist et non vide --}}
						@if( isset($data) && !$data->isEmpty())
						<hr>
						<!-- row 5 -->
						<div class="row">
							<div class="col-lg-3"></div>

							<div class="col-lg-6" align="center">
								<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo10" title="Cliquez ici pour visualiser la liste des articles existants">Liste des Categories</button>
								<div id="demo10" class="collapse">
									<br>
									<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title" align="center">Categories <span class="badge">{{ App\Models\Categorie::count() }}</span></h3>
										</div>
										<div class="panel-body">
											<ul class="list-group" align="center">
												@foreach($data as $item)
													<li class="list-group-item"><a href="{{ route('direct.info',[ 'p_table' => 'categories' , 'p_id' => $item->id_categorie ]) }}" title="detail sur la categorie"> {{ $item->libelle }}</a></li>
												@endforeach
											</ul>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-3"></div>
						</div>

						<!-- end row 5 -->
						@endif
						{{-- fin if --}}

					</form>



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
