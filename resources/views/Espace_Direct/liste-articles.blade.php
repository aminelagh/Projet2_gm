@extends('layouts.main_master')

@section('title') Articles @endsection

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
            if(title!="")
            {
                $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
            }
            if(title=="numero" || title=="code")
            {
                $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
            }
            if(title=="Designation")
            {
                $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
            }
            if(title=="Taille")
            {
                $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
            }
            if(title=="Couleur")
            {
                $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
            }
        });


        var table = $('#example').DataTable( {
            //"scrollY": "50px",
            //"scrollX": true,
            "searching": true,
            "paging": true,
            //"autoWidth": true,
            "info": true,
            stateSave: false,


            "columnDefs": [
                { "width": "2%", "targets": 0 },//#
                { "width": "5%", "targets": 1 },//numero
                { "width": "7%", "targets": 2 },//code
                { "width": "3%", "targets": 4 },//taille
                { "width": "6%", "targets": 5 },//couleur
                { "width": "6%", "targets": 6 },//sexe
                { "width": "5%", "targets": 7 },//pr
                { "width": "5%", "targets": 8 },//pr
                { "width": "10%", "targets": 9 }//autre
            ]
        } );

        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
            var column = table.column( $(this).attr('data-column') );
            column.visible( ! column.visible() );
        } );

        table.columns().every(function() {
            var that = this;
            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
    });

    //script pour le popover detail
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>

@endsection

@section('main_content')
<div class="container-fluid">
  <!-- main row -->
  <div class="row">
    <h1 class="page-header">Liste des Articles <small> </small></h1>

    <!-- row -->
    <div class="row">

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

      <div class="table-responsive">
        <div class="col-lg-12">

            <div>
                Toggle column: <a class="toggle-vis" data-column="1">Numero</a> -
                <a class="toggle-vis" data-column="2">Code</a> -
                <a class="toggle-vis" data-column="3">Designation</a> -
                <a class="toggle-vis" data-column="4">Taille</a> -
                <a class="toggle-vis" data-column="5">Couleur</a> -
                <a class="toggle-vis" data-column="6">Sexe</a>
            </div>

            <table id="example" class="table table-striped table-bordered table-hover" width="100%">
            <thead bgcolor="#DBDAD8">
              <tr>
                  <th> # </th>
                  <th>numero</th>
                  <th>Code</th>
                  <th>Designation</th>
                  <th>Taille</th>
                  <th>Couleur</th>
                  <th>Sexe</th>
                  <th title="prix HT">Prix d'achat</th>
                  <th>Prix de vente</th>
                  <th>Autres</th>
              </tr>
            </thead>
            <tfoot bgcolor="#DBDAD8">
              <tr>
                  <th></th>
                  <th>numero</th>
                  <th>Code</th>
                  <th>Designation</th>
                  <th>Taille</th>
                  <th>Couleur</th>
                  <th>Sexe</th>
                  <th title="prix HT">Prix d'achat</th>
                  <th>Prix de vente</th>
                  <th></th>
              </tr>
            </tfoot>

            <tbody>
              @if( $data->isEmpty() )
              <tr><td colspan="5" align="center">Aucun Article</td></tr>
              @else
              @foreach( $data as $item )
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $item->num_article }}</td>
                <td>{{ $item->code_barre }}</td>
                <td>{{ $item->designation_c }}</td>
                <td>{{ $item->taille }}</td>
                <td>{{ $item->couleur }}</td>
                <td>{{ getSexeName($item->sexe) }}</td>
                <td align="right">{{ $item->prix_achat }}</td>
                <td align="right">{{ $item->prix_vente }}</td>
                <td align="center">
                  <a href="{{ Route('direct.info',['p_table' => 'articles', 'p_id'=> $item->id_article ]) }}" title="detail" ><i class="glyphicon glyphicon-eye-open"></i></a>
                  <a href="{{ Route('direct.update',['p_table' => 'articles', 'p_id' => $item->id_article ]) }}" title="Modifier"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a onclick="return confirm('Êtes-vous sure de vouloir effacer l\'article: {{ $item->designation_c }} ?')" href="{{ Route('direct.delete',['p_table' => 'articles' , 'p_id' => $item->id_article ]) }}" title="effacer"><i class="glyphicon glyphicon-trash"></i></a>
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">Detail</button>
                </td>

                {{-- Modal (pour afficher les details de chaque article) --}}
                <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ $item->designation_c }}</h4>
                      </div>
                      <div class="modal-body">
                        <p><b>numero</b> {{ $item->num_article }}</p>
                        <p><b>code a barres</b> {{ $item->code_barre }}</p>
                        <p><b>Taille</b> {{ $item->taille }}</p>
                        <p><b>Couleur</b> {{ $item->couleur }}</p>
                        <p><b>sexe</b> {{ getSexeName($item->sexe) }}</p>
                        <p><b>Prix d'achat</b> {{ $item->prix_achat }}</p>
                        <p><b>Prix de vente</b> {{ $item->prix_vente }}</p>
                        <p>{{ $item->designation_l }}</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- fin Modal (pour afficher les details de chaque article) --}}

              </tr>
              @endforeach
              @endif
            </tbody>

        </table>
       </div>
     </div>

     </div>
    <!-- row -->


      <!-- row -->
      <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
          <a type="button" class="btn btn-outline btn-default"><i class="fa fa-file-pdf-o" aria-hidden="true">  Imprimer </i></a>
          <a href="{{ Route('direct.add',[ 'p_table' => 'articles' ]) }}" type="button" class="btn btn-outline btn-default">  Ajouter un Article</a>
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
