@extends('layouts.main_master')

@section('title') Creation de promotions @endsection

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
                if (title != "") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "numero" || title == "code") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "Designation") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "Taille") {
                    $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "Couleur") {
                    $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                } else {
                }
            });


            var table = $('#example').DataTable({
                //"scrollY": "50px",
                //"scrollX": true,
                "searching": true,
                "paging": true,
                //"autoWidth": true,
                "info": true,
                stateSave: false,


                "columnDefs": [
                    {"width": "2%", "targets": 0},//#
                    {"width": "5%", "targets": 1},//numero
                    {"width": "7%", "targets": 2},//code
                    {"width": "3%", "targets": 4},//taille
                    {"width": "6%", "targets": 5},//couleur
                    {"width": "6%", "targets": 6},//sexe
                    {"width": "5%", "targets": 7},//pr
                    {"width": "5%", "targets": 8},//pr
                    {"width": "10%", "targets": 9}//autre
                ]
            });

            $('a.toggle-vis').on('click', function (e) {
                e.preventDefault();
                var column = table.column($(this).attr('data-column'));
                column.visible(!column.visible());
            });

            table.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
        });

        //script pour le popover detail
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        });
    </script>

@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="page-header">Création de promotions</h1>

            {{-- **************Alerts************** --}}
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
        {{-- **************endAlerts************** --}}

        <!-- Row 1 -->
            <div class="row">
                <div class="table-responsive">
                    <div class="col-lg-12">
                        {{-- *************** form ***************** --}}
                        <form role="form" method="post"
                              action="{{ Route('direct.submitAdd',[ 'p_table' => 'promotions' ]) }}">
                            {{ csrf_field() }}
                            <table id="example" class="table table-striped table-bordered table-hover">
                                <thead bgcolor="#DBDAD8">
                                <tr>
                                    <th width="1%">#</th>
                                    <th>Categorie</th>
                                    <th>Fournisseur</th>
                                    <th>Article</th>
                                    <th>Magasin</th>
                                    <th width="5%">Prix de vente</th>
                                    <th width="2%">Taux</th>
                                    <th width="2%">Date debut</th>
                                    <th width="2%">Date fin</th>
                                    <th width="2%">Autres</th>
                                </tr>
                                </thead>
                                <tfoot bgcolor="#DBDAD8">
                                <tr>
                                    <th></th>
                                    <th>Categorie</th>
                                    <th>Fournisseur</th>
                                    <th>Article</th>
                                    <th></th>
                                    <th>Prix de vente</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach( $articles as $item )
                                    <tr>
                                        <input type="hidden" name="id_article[{{ $loop->index+1 }}]"
                                               value="{{ $item->id_article }}">
                                        <!--input type="hidden" name="designation_c[{{ $loop->index+1 }}]"
                                               value="{{ $item->designation_c }}"/-->

                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $item->designation_c }}</td>
                                        <td>{{ getChamp('categories', 'id_categorie', $item->id_categorie, 'libelle') }}</td>
                                        <td>{{ getChamp('fournisseurs', 'id_fournisseur', $item->id_fournisseur, 'libelle') }}</td>
                                        <td>
                                            <select class="form-control" name="id_magasin[{{ $loop->index+1 }}]">
                                                <option value="0" selected>Aucun</option>
                                                @if( !$magasins->isEmpty() )
                                                    @foreach( $magasins as $magasin )
                                                        <option value="{{ $magasin->id_magasin }}" >{{ $magasin->id_magasin }}-{{ $magasin->libelle }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>{{ $item->prix_vente }}</td>
                                        <td><input type="number" min="0" patern=".##" placeholder="Taux"
                                                   name="taux[{{ $loop->index+1 }}]"></td>
                                        <td><input type="date" name="date_debut[{{ $loop->index+1 }}]"
                                                   value="{{ 'old(date_debut[$loop->index+1])' }}"></td>
                                        <td><input type="date" name="date_fin[{{ $loop->index+1 }}]"
                                                   value="{{ old('date_fin[$loop->index+1]') }}"></td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#modal{{ $loop->index+1 }}">Detail
                                            </button>
                                        </td>

                                        {{-- Modal (pour afficher les details de chaque article) --}}
                                        <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
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
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Fermer
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- fin Modal (pour afficher les details de chaque article) --}}

                                    </tr>
                                @endforeach
                                </tbody>
                                <tr>
                                    <td colspan="10" align="center">
                                        <button formtarget="_blank" data-toggle="popover" data-placement="top"
                                                data-trigger="hover" title="Valider l'ajout"
                                                data-content="Cliquez ici pour valider la création des promotions sur l'ensemble des articles choisi"
                                                type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        {{-- *************** end form ***************** --}}
                    </div>
                </div>
            </div>
            <!-- end row 1 -->


        </div>
    </div>
    <!-- /.row -->
@endsection

@section('menu_1') @include('Espace_Direct._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Direct._nav_menu_2') @endsection
