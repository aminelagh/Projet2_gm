@extends('layouts.main_master')

@section('title') Magasins @endsection

@section('styles')
<link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
<link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
<link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
<script src="{{  asset('table2/datatables.min.js') }}"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example tfoot th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" size="10" class="form-control" placeholder="Rechercher par ' + title + '" />');
        });
        // DataTable
        var table = $('#example').DataTable();
        // Apply the search
        table.columns().every(function() {
            var that = this;
            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
    });
</script>
@endsection

@section('main_content')
<!-- Container -->
<div class="container-fluid">
    <!-- main row -->
    <div class="row">

        <h1 class="page-header">Liste des Magasins <small> </small></h1>

        <!-- row 1  row des alerts-->
        <div class="row">

            {{-- **************Alerts************** --}}
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    {{-- Debut Alerts --}} @if (session('alert_success'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('alert_success') !!}
                    </div>
                    @endif @if (session('alert_info'))
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('alert_info') !!}
                    </div>
                    @endif @if (session('alert_warning'))
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('alert_warning') !!}
                    </div>
                    @endif @if (session('alert_danger'))
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> {!! session('alert_danger') !!}
                    </div>
                    @endif {{-- Fin Alerts --}}
                </div>
                <div class="col-lg-2"></div>
            </div>
            {{-- **************endAlerts************** --}}
        </div>
        <!-- end row 1 des alerts -->

        <!-- row table -->
        <div class="row">
            <div class="table-responsive">
                <div class="col-lg-12">
                    <table id="example" class="table table-striped table-bordered table-hover" width="100%">
                      <thead bgcolor="#DBDAD8">
                          <tr>
                              <th width="2%"> # </th>
                              <th width="25%"> Nom du Magasin </th>
                              <th>Ville</th>
                              <th>Etat Stock</th>
                              <th width="10%">Autres</th>
                          </tr>
                      </thead>
                      <tfoot bgcolor="#DBDAD8">
                          <tr>
                              <th width="2%"> # </th>
                              <th width="25%"> Nom du Magasin </th>
                              <th>Ville</th>
                              <th>Etat Stock</th>
                              <th width="10%">Autres</th>
                          </tr>
                      </tfoot>

                      <tbody>
                          @if ( isset( $data ) ) @if( $data->isEmpty() )
                          <tr>
                              <td colspan="4">Aucun Magasin</td>
                          </tr>
                          @else @foreach( $data as $item )
                          <tr class="odd gradeA">
                              <td>{{ $loop->index+1 }}</td>
                              <td>{{ $item->libelle }}</td>
                              <td>{{ $item->ville }}</td>
                              <td>Etat du <a href="{{ route('direct.stocks', [ 'p_id_magasin' => $item->id_magasin ] ) }}" title="voir le stock ">Stock</a></td>
                              <td>
                                  <a href="{{ Route('direct.info',['p_table'=> 'magasins' , 'p_id' => $item->id_magasin  ]) }}" title="detail"><i class="glyphicon glyphicon-eye-open"></i></a>
                                  <a href="{{ Route('direct.update',['p_table'=> 'magasins' , 'p_id' => $item->id_magasin  ]) }}" title="modifier"><i class="glyphicon glyphicon-pencil"></i></a>
                                  <a onclick="return confirm('Êtes-vous sure de vouloir effacer le magasin: {{ $item->libelle }} ?')" href="{{ Route('direct.delete',['p_table' => 'magasins' , 'p_id' => $item->id_magasin ]) }}" title="supprimer"><i class="glyphicon glyphicon-trash"></i></a>
                              </td>
                          </tr>
                          @endforeach @endif @endif

                      </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end row table -->
    </div>
    <!-- end main row -->


    <div class="row" align="center">
        <a href="{{ Route('direct.add',[ 'p_table' => 'magasins' ]) }}" type="button" class="btn btn-outline btn-default">  Ajouter un Magasin </a>
    </div>



</div>
<!-- end Container-->
@endsection @section('menu_1') @include('Espace_Direct._nav_menu_1') @endsection @section('menu_2') @include('Espace_Direct._nav_menu_2') @endsection
