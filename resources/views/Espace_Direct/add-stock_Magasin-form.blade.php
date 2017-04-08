@extends('layouts.main_master')

@section('title') Ajout Stock du magasin {{ $magasin->libelle }}  @endsection

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
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ajouter au Stock du magasin {{ $magasin->libelle }} <small> </small></h1>

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
					<form role="form" method="post" action="{{ Route('direct.submitAdd',['param' => 'stock']) }}">
						{{ csrf_field() }}


						<!-- Row 1 -->
						<div class="row">

							<div class="table-responsive">

								<div class="col-lg-12">
								 <table class="table table-bordered table-hover table-striped" id="dataTables-example">

									 <thead>
										 <tr><th width="2%"> # </th><th width="25%">Article</th><th>Designation</th><th>Prix (HT)</th><th>Prix (TTC)</th><th width="10%">Autres</th></tr>
									 </thead>

									 <tbody>
										 @if ( isset( $articles ) )
										 @if( $articles->isEmpty() )
										 <tr><td colspan="5" align="center">Aucun Article</td></tr>
										 @else
										 @foreach( $articles as $item )
										 <tr class="odd gradeA">
											 <td>{{ $loop->index+1 }}</td>
											 <td>{{ $item->designation_c }}</td>
											 <td>{{ $item->designation_c }}</td>

											 <td>{{ $item->prix }}</td>
											 <td>{{ ($item->prix)*1.2 }}</td>
											 <td>
												 <a href="{{ Route('direct.info',['p_table' => 'articles', 'p_id'=> $item->id_article ]) }}" title="detail" ><i class="glyphicon glyphicon-eye-open"></i></a>
												 <a href="{{ Route('direct.updateForm',['p_table' => 'articles', 'p_id' => $item->id_article ]) }}" title="Modifier"><i class="glyphicon glyphicon-pencil"></i></a>
												 <a onclick="return confirm('Êtes-vous sure de vouloir effacer l\'article: {{ $item->designation_c }} ?')" href="{{ Route('direct.delete',['p_table' => 'articles' , 'p_id' => $item->id_article ]) }}" title="effacer"><i class="glyphicon glyphicon-trash"></i></a>
											 </td>
										 </tr>
										 @endforeach
										 @endif
										 @endif
									 </tbody>

								 </table>
							 </div>
							</div>

						</div>
						<!-- end row 1 -->


						<!-- row 2 -->
						<div class="row">

							<div class="col-lg-4"></div>
							<div>
								{{-- Submit & Reset --}}
								<button type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
								<button type="submit" name="submit" value="verifier" class="btn btn-default">Vérifier</button>
								<button type="reset" class="btn btn-default">Effacer</button>
							</div>

						</div>
						<!-- end row 2 -->

						{{-- verifier si data exist et non vide --}}
						@if( isset($data) && !$data->isEmpty())
						<hr>
						<!-- row 5 -->
						<div class="row">
							<div class="col-lg-3"></div>

							<div class="col-lg-6" align="center">
								<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo10" title="Cliquez ici pour visualiser la liste des articles existants">Liste des Articles</button>
								<div id="demo10" class="collapse">
									<br>
									<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title" align="center">Articles <span class="badge">{{ App\Models\Article::count() }}</span></h3>
										</div>
										<div class="panel-body">
											<ul class="list-group" align="center">
												@foreach($data as $item)
													<li class="list-group-item"><a href="{{ route('direct.info',[ 'p_table' => 'articles' , 'p_id' => $item->id_article ]) }}" title="detail sur l'article">{{ $item->num_article }}: {{ $item->designation_c }}</a></li>
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
