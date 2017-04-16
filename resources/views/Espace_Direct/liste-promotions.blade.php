@extends('layouts.main_master')

@section('title') Promotions @endsection

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
            $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
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

        <h1 class="page-header">Liste des Promotions <small> </small></h1>

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
                    <table {{ !$data->isEmpty() ? 'id="example"' : ''  }} class="table table-striped table-bordered table-hover" width="100%">
                      <thead bgcolor="#DBDAD8">
                        <tr>
                          <th width="2%"> # </th>
                          <th>Article</th>
                          <th>Magasin</th>
                          <th>Taux</th>
                          <th>Date debut</th>
                          <th>Date fin</th>
                          <th width="10%">Autres</th>
                        </tr>
                      </thead>
                      @if( $data->isEmpty() )
                      <tr>
                          <td colspan="7" align="center">Aucune promotion</td>
                      </tr>
                      @else
                      <tfoot bgcolor="#DBDAD8">
                          <tr>
                              <th width="2%"> # </th>
                              <th>Article</th>
                              <th>Magasin</th>
                              <th>Taux</th>
                              <th>Date debut</th>
                              <th>Date fin</th>
                              <th width="10%">Autres</th>
                          </tr>
                      </tfoot>
                      <tbody>
                        @foreach( $data as $item )
                        <tr class="odd gradeA">
                          <td>{{ $loop->index+1 }}</td>
                          <td>{{ $item->id_article }}</td>
                          <td>{{ $item->id_magasin }}</td>
                          <td>{{ $item->taux }}</td>
                          <td>{{ $item->date_debut }}</td>
                          <td>{{ $item->date_fin }}</td>
                          <td>
                            <a href="{{ Route('direct.info',['p_table'=> 'promotions' , 'p_id' => $item->id_promotion  ]) }}" title="detail"><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{{ Route('direct.update',['p_table'=> 'promotions' , 'p_id' => $item->id_promotion  ]) }}" title="modifier"><i class="glyphicon glyphicon-pencil"></i></a>
                            <a onclick="return confirm('Êtes-vous sure de vouloir effacer la promotion numero {{ $loop->index+1 }}?')" href="{{ Route('direct.delete',['p_table' => 'magasins' , 'p_id' => $item->id_magasin ]) }}" title="supprimer"><i class="glyphicon glyphicon-trash"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                      @endif
                    </table>
                </div>
            </div>
        </div>
        <!-- end row table -->
    </div>
    <!-- end main row -->


    <div class="row" align="center">
        <a href="{{ Route('direct.add',[ 'p_table' => 'promotions' ]) }}" type="button" class="btn btn-outline btn-default">  Creer des promotions </a>
    </div>


</div>
<!-- end Container-->
@endsection @section('menu_1')
  @include('Espace_Direct._nav_menu_1')
@endsection

@section('menu_2')
  @include('Espace_Direct._nav_menu_2')
@endsection
