@extends('layouts.main_master')

@section('title') Marques @endsection

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
<div class="container-fluid">
  <!-- main row -->
  <div class="row">

    <h1 class="page-header">Liste des Marques <small> </small></h1>

    <!-- row -->
    <div class="row">

      <div class="table-responsive">
	       <table class="table table-bordered table-hover table-striped" id="dataTables-example">

           <thead>
             <tr><th width="2%"> # </th><th width="25%"> Marque </th><th>Description</th><th width="10%">Autres</th></tr>
           </thead>

           <tbody>
             @if ( isset( $data ) )
             @if( $data->isEmpty() )
             <tr><td colspan="4" align="center">Aucune Marque</td></tr>
             @else
             @foreach( $data as $item )
             <tr class="odd gradeA">
               <td>{{ $loop->index+1 }}</td>
               <td>{{ $item->libelle }}</td>
               <td>{{ $item->description }}</td>
               <td>
                 <a href="{{ Route('admin.infoUser',['id'=> 1]) }}" ><i class="glyphicon glyphicon-user"></i></a>
                 <a href="{{ Route('admin.updateUser',['id' => 1 ]) }}" ><i class="glyphicon glyphicon-pencil"></i></a>
                 <a onclick="return confirm('Êtes-vous sure de vouloir effacer la Marque: {{ $item->libelle }} ?')" href="{{ Route('direct.delete',['p_table' => 'marques' , 'p_id' => $item->id_marque ]) }}" ><i class="glyphicon glyphicon-trash"></i></a>
               </td>
             </tr>
             @endforeach
             @endif
             @endif

           </tbody>
         </table>
       </div>

     </div>
    <!-- row -->


      <!-- row -->
      <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
          <a type="button" class="btn btn-outline btn-default"><i class="fa fa-file-pdf-o" aria-hidden="true">  Imprimer </i></a>
          <a href="{{ Route('direct.addForm',[ 'param' => 'marque' ]) }}" type="button" class="btn btn-outline btn-default">  Ajouter une Marque</a>
        </div>
      </div>
      <!-- row -->

    </div>
    <!-- end main row -->

</div>
@endsection


@section('menu_1')
	@include('Espace_Direct._nav_menu_1')
@endsection

@section('menu_2')
	@include('Espace_Direct._nav_menu_2')
@endsection
