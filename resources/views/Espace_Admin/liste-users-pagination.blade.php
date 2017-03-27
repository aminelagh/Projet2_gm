@extends('layouts.masters.admin') @section('title') Employes @endsection @section('username') Amine Laghlabi @endsection @section('content') Welcome Admin @endsection @section('main')

<!-- Page Heading -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Liste des Employes <small> Total : {{ $data->total() }}</small></h1>

		<div id="page-wrapper">

			<div class="container-fluid">


				<form role="form" method="post" action="{{ Route('admin.listerP') }}">
					{{ csrf_field() }}

					<!-- begin row  -->
					<div class="row">

						<div class="col-lg-1">
							<div class="form-group">
								<label>Filtre</label>
								@foreach( $roles as $item )
									<div class="checkbox"><label><input type="radio" name="role" value="{{ $item->id_role }}">{{ $item->libelle }}</label></div>
								@endforeach
							</div>
						</div>

						<div class="col-lg-1"><a href="/test/?id_role=1">Admin</a></div>
						<div class="col-lg-1"><a href="/test/">Reset</a></div>

						<div class="col-lg-6">
							{{-- Submit & Reset --}}
							<button type="submit" name="submitFilter" value="filtrer" class="btn btn-default">Filtrer</button>
							<button type="submit" name="reset" value="notfiltrer"class="btn btn-default">Réinitialiser</button>
							<button type="reset" class="btn btn-default">Effacer</button>
						</div>
					</div>
					<!-- end row  -->

					<!-- begin row  -->
					<div class="row">



					</div>
					<!-- end row  -->

			</form>



				<hr/>

				<!-- begin row  -->
				<div class="row">

					<div class="col-lg-12">
						{{-- $data->appends(['sort' => 'ville'])->links() --}}

						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th><a href="{{ Route('admin.listerP',['orderby' => 'id_role']) }}">Role</a></th>
										<th><a href="{{ Route('admin.listerP',['orderby' => 'nom']) }}">Nom</a></th>
										<th><a href="{{ Route('admin.listerP',['orderby' => 'prenom']) }}">Prenom</a></th>
										<th><a href="{{ Route('admin.listerP',['orderby' => 'ville']) }}">Ville</a></th>
										<th><a href="{{ Route('admin.listerP',['orderby' => 'email']) }}">Email</a></th>
										<th><a href="{{ Route('admin.listerP',['orderby' => 'id_magasin']) }}">Magasin</a></th>
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
							<div class="pagination">{{ $data->links() }}</div>
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
				<!-- end row  -->

			</div>
			<!-- /.container-fluid -->

		</div>
		<!-- /#page-wrapper -->
	</div>
</div>
<!-- /.row -->
@endsection
