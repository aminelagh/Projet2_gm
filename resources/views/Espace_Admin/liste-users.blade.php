@extends('layouts.masters.admin') @section('title') Employes @endsection @section('username') Amine Laghlabi @endsection @section('content') Welcome Admin @endsection @section('main')

<!-- Page Heading -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Liste des Employes <small> </small></h1>

		<div id="page-wrapper">

			<div class="container-fluid">

				<div class="row">

					<div class="col-lg-1"></div>

					<div class="col-lg-10">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'id_role']) }}">Role</a></th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'nom']) }}">Nom</a></th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'prenom']) }}">Prenom</a></th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'ville']) }}">Ville</a></th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'email']) }}">Email</a></th>
										<th><a href="{{ Route('admin.listerOrder',['orderby' => 'id_magasin']) }}">Magasin</a></th>
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
									<tr>
										<td>{{ $loop->index+1 }}</td>
										<td>{{ getRoleName( $item->id_role ) }}</td>
										<td>{{ $item->nom }}</td>
										<td>{{ $item->prenom }}</td>
										<td>{{ $item->ville }}</td>
										<td>{{ $item->email }}</td>
										<td><a href=""> {!! getMagasinName( $item->id_magasin )!=null ? getMagasinName( $item->id_magasin ) : '<i>Aucun</i>'   !!}</a></td>
										<td>
											<a type="button" class="btn btn-outline btn-info btn-xs">Info</a>
											<a type="button" class="btn btn-outline btn-default btn-xs">Default</a>
											<a type="button" class="btn btn-outline btn-danger btn-xs">Effacer</a>
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
					<div class="col-lg-12">
						<a type="button" class="btn btn-outline btn-default">Imprimer </a>
						<a href="#" type="button" onclick="alert('Hello world!')" class="btn btn-outline btn-primary" target="_blank">Exporter </a>

						<!-- formtarget="_blank|_self|_parent|_top|framename" -->
						<button type="button" class="btn btn-outline btn-success">Success</button>
						<button type="button" class="btn btn-outline btn-info">Info</button>
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
