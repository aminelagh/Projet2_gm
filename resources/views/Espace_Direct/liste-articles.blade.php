@extends('layouts.masters.direct')

@section('title')
Articles
@endsection

@section('main')

<!-- Page Heading -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Liste des Articles <small> </small></h1>

		<div id="page-wrapper">

			<div class="container-fluid">

				{{-- row 1 --}}
				<div class="row">
					<div class="col-lg-12">
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
				</div>

				{{-- Row 2 --}}

				<div class="row">

					<div class="col-lg-1"></div>

					<div class="col-lg-10">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Categorie</th>
										<th>Fournisseur</th>
										<th>Numéro</th>
										<th>Désignation</th>
										<th>Taille</th>
										<th>Couleur</th>
										<th>Sexe</th>
										<th>Prix(HT)</th>
									</tr>
								</thead>

								<tbody>
									@if( isset( $data ) )
									@if( $data->isEmpty() )
									<tr>
										<td colspan="7">Aucun Article</td>
									</tr>
									@else
									@foreach( $data as $item )
									<tr>
										<td>{{ $loop->index+1 }}</td>
										<td>{!! getCategorieName( $item->id_categorie ) !!}</td>
										<td>{!! getFournisseurName( $item->id_fournisseur ) !!}</td>
										<td>{{ $item->num_article }}</td>
										<td>{{ $item->designation }}</td>
										<td>{{ $item->taille }}</td>

										@if( isColor( $item->couleur ) )
											<td bgcolor="{{ $item->couleur }}">{{ $item->couleur }}</td>
										@else
											<td>{{ $item->couleur }}</td>
										@endif

										<td>{{ getSexeName( $item->sexe ) }}</td>
										<td>{{ $item->prix }}</td>
										<td>
											<a type="button" class="btn btn-outline btn-info btn-xs">Info</a>
											<a type="button" class="btn btn-outline btn-default btn-xs">Modifier</a>
											<a href="{{ Route('direct.delete', ['p_table'=>'articles','p_id'=> $item->id_article ] ) }}" type="button" class="btn btn-outline btn-danger btn-xs">Effacer</a>
										</td>
									</tr>
									@endforeach
									@endif
									@endif

								</tbody>
							</table>
						</div>
					</div>

					<div class="col-lg-2">
					</div>
					<div class="col-lg-10">
						<a href="{{ Route('direct.addForm' ,['param' => 'article']) }}" type="button" class="btn btn-outline btn-info">Ajouter Article</a>

						<a type="button" class="btn btn-outline btn-default">Imprimer </a>
						<a href="#" type="button" onclick="alert('Hello world!')" class="btn btn-outline btn-primary" target="_blank">Exporter </a>

						<!-- formtarget="_blank|_self|_parent|_top|framename" -->
						<button type="button" class="btn btn-outline btn-success">Success</button>

						<button type="button" class="btn btn-outline btn-warning">Warning</button>
						<button type="button" class="btn btn-outline btn-danger">Vider La Liste</button>
					</div>

				</div>
				<!-- /.row -->

			</div>
			<!-- /.container-fluid -->

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
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> @yield('nom_compte') <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li>
			<a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
		</li>
	</ul>
</li>
@endsection
