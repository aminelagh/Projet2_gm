@extends('layouts.main_master')

@section('title') Liste des ventes  @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" size="10" class="form-control" placeholder="Rechercher par ' + title + '" />');
            });
            // DataTable
            var table = $('#example').DataTable();
            // Apply the search
            table.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
        });
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        });
    </script>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Liste des ventes du magasin</h1>

                {{-- **************Alerts**************  --}}
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        {{-- Debut Alerts --}}
                        @if (session('alert_success'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_success') !!}
                            </div>
                        @endif

                        @if (session('alert_info'))
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_info') !!}
                            </div>
                        @endif

                        @if (session('alert_warning'))
                            <div class="alert alert-warning alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_warning') !!}
                            </div>
                        @endif

                        @if (session('alert_danger'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button> {!! session('alert_danger') !!}
                            </div>
                        @endif
                        {{-- Fin Alerts --}}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                {{-- **************endAlerts**************  --}}

                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="example">
                            <thead bgcolor="#DBDAD8">
                            <tr>
                                <th> #</th>
                                <th>Date de vente</th>
                                <th>Total Articles vendus</th>
                                <th>Mode de paiement</th>
                                <th>Autres</th>
                            </tr>
                            </thead>

                            <tfoot bgcolor="#DBDAD8">
                            <tr>
                                <th></th>
                                <th>Date de vente</th>
                                <th>Total Articles vendus</th>
                                <th>Mode de paiement</th>
                                <th></th>
                            </tr>
                            </tfoot>

                            <tbody>
                            @if( $data->isEmpty() )
                                <tr>
                                    <td colspan="6">Aucune vente</td>
                                </tr>
                            @else
                                @foreach( $data as $item )
                                    <tr class="odd gradeA">
                                        <td align="right">{{ $loop->index+1 }}</td>
                                        <td align="right">{{ getDateHelper($item->created_at) }} </td>
                                        <td align="right">{{App\Models\Trans_Article::where(['id_transaction'=> $item->id_transaction ])->count()}}</td>
                                        <td>{{ getChamp('mode_paiements','id_mode',getChamp('paiements', 'id_paiement', $item->id_paiement, 'id_mode') , 'libelle') }}</td>
                                        <td>
                                            <a href="{{ Route('vendeur.details',['p_id' => $item->id_transaction  ]) }}"
                                               title="detail"><i class="glyphicon glyphicon-eye-open"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- row -->
                <div class="row" align="center">
                    <a onclick="return alert('Printing ....')" type="button" class="btn btn-outline btn-default"><i
                                class="fa fa-file-pdf-o" aria-hidden="true"> Imprimer </i></a>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('menu_1')
    @include('Espace_Vend._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Vend._nav_menu_2')
@endsection
