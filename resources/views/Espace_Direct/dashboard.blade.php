@extends('layouts.main_master')

@section('title') Espace Direct @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('js/jquery.js') }}"></script>
    <script src="{{  asset('js/bootstrap.js') }}"></script>
@endsection

@section('main_content')
    <!-- container-fluid -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Espace Direction<small> Bienvenue</small></h1>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a></li>
                    <li class="action"><i class="fa fa-file"></i> Blank Page</li>
                    <li class=""><i class="fa fa-file"></i> Blank Page</li>
                    <li class="active"><i class="fa fa-folder"></i> Blank Page</li>
                    <li class="active"><i class="fa fa-backward"></i> Blank Page</li>
                    <li class="active"><i class="fa fa-vk"></i> Blank Page</li>
                </ol>

                <img width="100%" height="100%" src="images/golf.jpg"/>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection


@section('menu_1')
    @include('Espace_Direct._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Direct._nav_menu_2')
@endsection
