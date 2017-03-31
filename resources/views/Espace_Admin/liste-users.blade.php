@extends('layouts.main_master')

@section('title') Utlisateurs @endsection

@section('styles')
<link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
<link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
<link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
<script src="{{  asset('js/jquery.js') }}"></script>
<script src="{{  asset('js/bootstrap.js') }}"></script>

<script src="{{  asset('table/jquery.js') }}"></script>
<script src="{{  asset('table/jquery.dataTables.js') }}"></script>
<script src="{{  asset('table/dataTables.bootstrap.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
@endsection

@section('main_content')
<!-- Page Heading -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Liste des Employes <small> </small></h1>

		<div id="page-wrapper">

			<div class="container-fluid">
					<div class="col-lg-1"></div>

					<div class="col-lg-10">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped" id="dataTables-example" width="100%">
								<thead>
									<tr>
										<th width="2%">#</th>
										<th width="6%">Role<a href="{{ Route('admin.listerOrder',['orderby' => 'id_role']) }}"><i align="right" class="glyphicon glyphicon-sort"></i></a></th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'nom']) }}">Nom</a></th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'prenom']) }}">Prenom</a></th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'ville']) }}">Ville</a></th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'email']) }}">Email</a></th>
										<th width="10%"><a href="{{ Route('admin.listerOrder',['orderby' => 'id_magasin']) }}">Magasin</a></th>
										<th width="5%">Autres</a></th>
									</tr>
								</thead>

								<tbody>
									@if ( isset( $data ) )
									@if( $data->isEmpty() )
									<tr>
										<td colspan="7">Aucun employe</td>
									</tr>
									@else
									@foreach( $data as $item )
									<tr class="odd gradeA">
										<td>{{ $loop->index+1 }}</td>
										<td>{{ getRoleName( $item->id_role ) }}</td>
										<td>{{ $item->nom }}</td>
										<td>{{ $item->prenom }}</td>
										<td>{{ $item->ville }}</td>
										<td>{{ $item->email }}</td>
										<td><a href=""> {!! getMagasinName( $item->id_magasin )!=null ? getMagasinName( $item->id_magasin ) : '<i>Aucun</i>'   !!}</a></td>
										<td>
											<a href="{{ Route('admin.infoUser',['id'=> $item->id_user]) }}" ><i class="glyphicon glyphicon-user"></i></a>
											<a href="{{ Route('admin.updateUser',['id' => $item->id_user ]) }}" ><i class="glyphicon glyphicon-cog"></i></a>
											<a onclick="return confirm('Êtes-vous sure de vouloir effacer l\'utilisateur: {{ $item->nom }} {{ $item->prenom }} ?')" href="{{ Route('admin.deleteUser',['id' => $item->id_user ]) }}" ><i class="glyphicon glyphicon-trash"></i></a>
										</td>
									</tr>
									@endforeach
									@endif
									@endif

								</tbody>
							</table>
						</div>
					</div>

					<div class="col-lg-1"></div>
        </div>
        <div class="row">
          <div class="col-lg-4"></div>
					<div class="col-lg-8">
						<a type="button" class="btn btn-outline btn-default"><i class="fa-file-pdf-o"></i>Imprimer </a>
					</div>

			</div>
			<!-- /.container-fluid -->

		</div>
		<!-- /#page-wrapper -->
	</div>
</div>
<!-- /.row -->
@endsection


@section('menu_1')
	@include('Espace_Admin._nav_menu_1')
@endsection

@section('menu_2')
	@include('Espace_Admin._nav_menu_2')
@endsection
