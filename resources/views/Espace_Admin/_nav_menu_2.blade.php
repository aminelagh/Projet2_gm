<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">

    <li><a href="{{ Route('admin.home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>

    <li><a href="{{ Route('admin.addUser') }}"><i class="fa fa-fw fa-desktop"></i> Ajouter User</a></li>

    <li><a href="{{ Route('admin.lister') }}"><i class="fa fa-fw fa-wrench"></i> Liste User <span class="badge">{{ App\Models\User::count() }} </span> </a></li>

    <li><a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown niv 1<i class="fa fa-fw fa-caret-down"></i></a>
      <ul id="demo" class="collapse">
        <li><a href="{{ Route('admin.home') }}">Item 1</a></li>
        <li><a href="{{ Route('admin.home') }}">Item 2</a></li>

        <li><a href="javascript:;" data-toggle="collapse" data-target="#demo2"><i class="fa fa-fw fa-arrows-v"></i> Dropdown niv 2 <i class="fa fa-fw fa-caret-down"></i></a>
          <ul id="demo2" class="collapse">
            <li><a href="{{ Route('admin.home') }}">Dropdown Item</a></li>
            <li><a href="{{ Route('admin.home') }}">Dropdown Item</a></li>
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
