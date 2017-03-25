@extends('layouts.masters.admin')

@section('title')
Admin DashBoard
@endsection

@section('username')
Amine Laghlabi
@endsection


@section('content')
Welcome Admin
@endsection


@section('content_messages')
<li class="dropdown">  
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
					<ul class="dropdown-menu message-dropdown">
						<li class="message-footer">
							<a href="#">Read All New Messages</a>
						</li>
					</ul>
				</li>
@endsection


@section('content_alerts')
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
	<ul class="dropdown-menu alert-dropdown">
		<li><a href="#">Alert Name <span class="label label-default">Alert Badge</span></a></li>
	</ul>
</li>
@endsection


@section('content_compte')
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> @yield('nom_compte') <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li>
			<a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
		</li>
	</ul>
</li>
@endsection


@section('main')
<div class="container-fluid">
 
	<!-- Page Heading -->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Bienvenue <small>Administrateur</small></h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a></li>
					<li class="active"><i class="fa fa-file"></i> Blank Page</li>
				</ol>
		</div>
	</div>
	<!-- /.row -->

</div>
@endsection
