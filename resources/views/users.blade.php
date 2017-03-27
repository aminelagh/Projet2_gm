
filter:
<a href="/test/?id_role=1">Admin</a><br/>
<a href="/test/?id_role=3">Magas</a><br/>
<a href="/test/?id_role=2">Direct</a><br/>
<a href="/test/?id_role=4">Vend</a><br/>
<a href="/test/">Reset</a><br/>

<table border='1' cellspacing="0" cellpadding='5'>
  <tr>
    <th>id</th>
    <th>nom</th>
    <th>prenom</th>
    <th>ville</th>
    <th>email</th>
    <th>role</th>
  </tr>

  @foreach( $data as $item )
  <tr>
    <th>{{ $item->id_user }}</th>
    <th>{{ $item->nom }}</th>
    <th>{{ $item->prenom }}</th>
    <th>{{ $item->ville }}</th>
    <th>{{ $item->email }}</th>
    <th>{{ getRoleName($item->id_role) }}</th>
  </tr>
  @endforeach
</table>

 {!! $data->links() !!} 
