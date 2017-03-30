<table id="dataTables-example1">
    <thead>
        <tr>
            <th>Nom</th>
            <th>prenom</th>
            <th>ville</th>
            <th>email</th>
            <th>Role</th>
            <th>magasin</th>
        </tr>
    </thead>
    <tbody>

        @foreach( $data as $item)
        <tr class="odd gradeA">
            <td>{{ $item->nom }}</td>
            <td>{{ $item->prenom }}</td>
            <td>{{ $item->ville }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ getRoleName($item->id_role) }}</td>
            <td>{{ getMagasinName($item->id_magasin) }}</td>
        </tr>
        @endforeach

    </tbody>
</table>


<!-- jQuery -->
<script src="{{  asset('table/jquery.js') }}"></script>
<script src="{{  asset('table/jquery.dataTables.js') }}"></script>
<script src="{{  asset('table/dataTables.bootstrap.js') }}"></script>
<!-- next and pre -->
<!--script src="table/dataTables.responsive.js"></script-->


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example1').DataTable({
            responsive: true
        });
    });
</script>
