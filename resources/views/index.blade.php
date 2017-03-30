@extends('layouts.main_master')

@section('title') Accueil @endsection

@section('styles')
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/sb-admin.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
@endsection

@section('main_content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Blank Page <small>Subheading</small></h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a></li>
            <li class="active"><i class="fa fa-file"></i> Blank Page</li>
        </ol>
    </div>
</div>
<!-- /.row -->
@endsection


@section('menu_1')
<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.html">SB Admin</a>
			</div>

			<!-- Top Menu Items -->
			<ul class="nav navbar-right top-nav">

				<!-- Messages -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
					<ul class="dropdown-menu message-dropdown">
						<li class="message-preview">
							<a href="#">
								<div class="media">
									<span class="pull-left"><img class="media-object" src="http://placehold.it/50x50" alt=""></span>
									<div class="media-body">
										<h5 class="media-heading"><strong>John Smith</strong></h5>
										<p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
										<p>Lorem ipsum dolor sit amet, consectetur...</p>
									</div>
								</div>
							</a>
						</li>
						<li class="message-footer">
							<a href="#">Read All New Messages</a>
						</li>
					</ul>
				</li>

				<!-- Alerts -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
					<ul class="dropdown-menu alert-dropdown">
						<li><a href="#">Alert Name <span class="label label-default">Alert Badge</span></a></li>
						<li class="divider"></li>
						<li><a href="#">View All</a></li>
					</ul>
				</li>

				<!-- Profile -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#"><i class="fa fa-fw fa-user"></i> Profile</a></li>
						<li><a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a></li>
						<li><a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a></li>
						<li class="divider"></li>
            <li><a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
					</ul>
				</li>
			</ul>
			<!-- end Top Menu Items -->
@endsection

@section('menu_2')
<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">

    <li><a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>

    <li><a href="bootstrap-elements.html"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a></li>

    <li><a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a></li>

    <li><a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown niv 1<i class="fa fa-fw fa-caret-down"></i></a>
      <ul id="demo" class="collapse">
        <li><a href="#">Item 1</a></li>
        <li><a href="#">Item 2</a></li>

        <li><a href="javascript:;" data-toggle="collapse" data-target="#demo2"><i class="fa fa-fw fa-arrows-v"></i> Dropdown niv 2 <i class="fa fa-fw fa-caret-down"></i></a>
          <ul id="demo2" class="collapse">
            <li><a href="#">Dropdown Item</a></li>
            <li><a href="#">Dropdown Item</a></li>
          </ul>
        </li>
      </ul>
    </li>

    <li class="active">
      <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
    </li>
  </ul>
</div>
<!-- /.navbar-collapse -->
@endsection
