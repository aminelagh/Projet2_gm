@extends('layouts.main_master')

@section('title') Marque: {{ $data->libelle }} @endsection

@section('main_content')

    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Marque</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des Articles</li>
                    <li class="breadcrumb-item"><a href="{{ route('magas.lister',['p_table' => 'marques' ]) }}">Liste
                            des marques</a></li>
                    <li class="breadcrumb-item active">{{ $data->libelle  }}</li>
                </ol>

                @include('layouts.alerts')

                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <!-- debut panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading" align="center">
                                <h2>{{ $data->libelle }}</h2>
                            </div>

                            <!-- debut panel body -->
                            <div class="panel-body">
                                <table class="table table-hover" border="0" cellspacing="0" cellpadding="5">

                                    <tr>
                                        <td>Marque</td>
                                        <th>{{ $data->libelle }} </th>
                                    </tr>
                                    <tr>
                                        <td>Date de creation</td>
                                        <th>{{ getDateHelper($data->created_at) }}
                                            a {{ getTimeHelper($data->created_at) }}   </th>
                                    </tr>

                                    <tr>
                                        <td>nombre d'articles de la marque</td>
                                        <th>
                                            {{ App\Models\Article::whereIdMarque($data->id_marque)->count() }}
                                        </th>
                                    </tr>

                                    <tr>
                                        <td>Date de derniere modification</td>
                                        <th>{{ getDateHelper($data->updated_at) }}
                                            a {{ getTimeHelper($data->updated_at) }}     </th>
                                    </tr>

                                </table>

                                @if( strlen($data->description) > 0 )
                                    <div class="page-header">
                                        <h3>Description</h3>
                                    </div>
                                    <div class="well">
                                        <p>{{ $data->description }}</p>
                                    </div>
                                @endif


                                <div class="row" align="center">
                                    <a href="{{ Route('magas.delete',['p_table' => 'marques', 'p_id' => $data->id_marque ]) }}"
                                       onclick="return confirm('Êtes-vous sure de vouloir effacer la marque: {{ $data->libelle }} ?')"
                                       type="button" class="btn btn-outline btn-danger"
                                            {!! setPopOver("","Supprimer la marque") !!}>Supprimer </a>
                                    <a href="{{ Route('magas.update',['p_table' => 'marques', 'p_id' => $data->id_marque ]) }}"
                                       type="button" class="btn btn-outline btn-info"
                                            {!! setPopOver("","Modifier la marque") !!}> Modifier </a>

                                </div>

                            </div>
                            <!-- fin panel body -->

                        </div>
                        <!-- fin panel -->
                    </div>
                    <div class="col-lg-1"></div>
                </div>

                @if( !$articles->isEmpty() )
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading" align="center"><h3>Articles</h3></div>
                                <br>

                                <div class="table-responsive">
                                    <div class="col-lg-12">
                                        <div class="breadcrumb">
                                            Afficher/Masquer:
                                            <a class="toggle-vis" data-column="1">Réference</a> -
                                            <a class="toggle-vis" data-column="2">Code</a> -
                                            <a class="toggle-vis" data-column="3">Designation</a> -
                                            <a class="toggle-vis" data-column="4">Taille</a> -
                                            <a class="toggle-vis" data-column="5">Couleur</a> -
                                            <a class="toggle-vis" data-column="6">Sexe</a> -
                                            <a class="toggle-vis" data-column="7">Prix d'achat</a> -
                                            <a class="toggle-vis" data-column="8">Prix de vente</a>
                                        </div>

                                        <table id="tableArticles"
                                               class="table table-striped table-bordered table-hover">
                                            <thead bgcolor="#DBDAD8">
                                            <tr>
                                                <th> #</th>
                                                <th><i class="fa fa-fw fa-sort"></i> Réference</th>
                                                <th><i class="fa fa-fw fa-sort"></i> Code</th>
                                                <th><i class="fa fa-fw fa-sort"></i> Designation</th>
                                                <th><i class="fa fa-fw fa-sort"></i> Taille</th>
                                                <th><i class="fa fa-fw fa-sort"></i> Couleur</th>
                                                <th><i class="fa fa-fw fa-sort"></i> Sexe</th>
                                                <th><i class="fa fa-fw fa-sort"></i> Prix d'achat (HT)</th>
                                                <th><i class="fa fa-fw fa-sort"></i> Prix de vente (TTC)</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tfoot bgcolor="#DBDAD8">
                                            <tr>
                                                <th></th>
                                                <th>Réference</th>
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
                                            @foreach( $articles as $item )
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td align="right">{{ $item->num_article }}</td>
                                                    <td align="right">{{ $item->code_barre }}</td>
                                                    <td>@if( $item->image != null) <img src="{{ $item->image }}"
                                                                                        width="50px">@endif {{ $item->designation_c }}
                                                    </td>
                                                    <td>{{ $item->taille }}</td>
                                                    <td>{{ $item->couleur }}</td>
                                                    <td>{{ $item->sexe }}</td>
                                                    <td align="right">{{ $item->prix_achat }} DH</td>
                                                    <td align="right">{!! \App\Models\Article::getPrix_TTC($item->prix_vente) !!}
                                                        DH
                                                    </td>
                                                    <td>
                                                        <div class="btn-group pull-right">
                                                            <button type="button"
                                                                    class="btn green btn-sm btn-outline dropdown-toggle"
                                                                    data-toggle="dropdown">
                                                                <span {!! setPopOver("","Clisuez ici pour afficher les actions") !!}>Actions</span>
                                                                <i class="fa fa-angle-down"></i>
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu">
                                                                <li>
                                                                    <a href="{{ Route('magas.info',['p_table' => 'articles', 'p_id'=> $item->id_article ]) }}"
                                                                            {!! setPopOver("","Afficher plus de detail") !!}><i
                                                                                class="glyphicon glyphicon-eye-open"></i>
                                                                        Plus de detail</a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ Route('magas.update',['p_table' => 'articles', 'p_id' => $item->id_article ]) }}"
                                                                            {!! setPopOver("","Modifier") !!}><i
                                                                                class="glyphicon glyphicon-pencil"></i>
                                                                        Modifier</a>
                                                                </li>
                                                                <li>
                                                                    <a onclick="return confirm('Êtes-vous sure de vouloir effacer l\'article: {{ $item->designation_c }} ?')"
                                                                       href="{{ Route('magas.delete',['p_table' => 'articles' , 'p_id' => $item->id_article ]) }}"
                                                                            {!! setPopOver("","Effacer l'article") !!}><i
                                                                                class="glyphicon glyphicon-trash"></i>
                                                                        Effacer</a>
                                                                </li>
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a data-toggle="modal"
                                                                       data-target="#modal{{ $loop->index+1 }}"><i
                                                                                class="glyphicon glyphicon-info-sign"
                                                                                aria-hidden="false"></i> Info-Bull</a>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                    </td>

                                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                                    <div class="modal fade" id="modal{{ $loop->index+1 }}"
                                                         role="dialog">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">
                                                                        &times;
                                                                    </button>
                                                                    <h4 class="modal-title">{{ $item->designation_c }}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><b>numero</b> {{ $item->num_article }}</p>
                                                                    <p><b>code a barres</b> {{ $item->code_barre }}
                                                                    </p>
                                                                    <p><b>Taille</b> {{ $item->taille }}</p>
                                                                    <p><b>Couleur</b> {{ $item->couleur }}</p>
                                                                    <p><b>sexe</b> {{ $item->sexe }}</p>
                                                                    <p><b>Prix d'achat</b></p>
                                                                    <p>{{ number_format($item->prix_achat, 2) }} DH
                                                                        HT, {{ number_format($item->prix_achat+$item->prix_achat*0.2, 2) }}
                                                                        Dhs TTC </p>
                                                                    <p><b>Prix de vente</b></p>
                                                                    <p>{{ number_format($item->prix_vente, 2) }} DH
                                                                        HT, {{ number_format($item->prix_vente+$item->prix_vente*0.2, 2) }}
                                                                        DH TTC </p>
                                                                    <p>{{ $item->designation_l }}</p>

                                                                    @if( $item->image != null) <img
                                                                            src="{{ $item->image }}"
                                                                            width="150px">@endif
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
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection

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
            $('#tableArticles tfoot th').each(function () {
                var title = $(this).text();
                if (title == "numero" || title == "code") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Designation") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Taille") {
                    $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Couleur" || title == "Sexe") {
                    $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                }
                if (title != "") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
            });

            var table = $('#tableArticles').DataTable({
                //"scrollY": "50px",
                //"scrollX": true,
                "searching": true,
                "paging": true,
                //"autoWidth": true,
                "info": true,
                stateSave: false,
                "columnDefs": [
                    {"width": "02%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                    {"width": "05%", "targets": 1, "type": "string", "visible": false},
                    {"width": "07%", "targets": 2, "type": "string", "visible": false},
                    {"width": "03%", "targets": 4, "type": "string", "visible": false},
                    {"width": "06%", "targets": 5, "type": "string", "visible": false},
                    {"width": "06%", "targets": 6, "type": "string", "visible": false},
                    {"width": "05%", "targets": 7, "type": "num-fmt", "visible": true},
                    {"width": "05%", "targets": 8, "type": "num-fmt", "visible": true},
                    {"width": "10%", "targets": 9, "type": "string", "visible": true, "searchable": false}
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
    </script>
@endsection