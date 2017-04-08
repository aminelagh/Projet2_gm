

  {{ csrf_field() }}


	       <table class="table table-bordered table-hover table-striped" id="dataTables-example">

           <thead>
             <tr><th width="2%"> # </th><th width="25%">Article</th><th>Prix (HT)</th><th>Prix (TTC)</th><th width="10%">Autres</th></tr>
           </thead>

           <tbody>
             @if ( isset( $articles ) )
             @if( $articles->isEmpty() )
             <tr><td colspan="5" align="center">Aucun Article</td></tr>
             @else
             @foreach( $articles as $item )
             <tr class="odd gradeA" align="center">
               <td>{{ $loop->index+1 }}</td>
               <td>{{ $item->designation_c }}</td>

               <td>{{ $item->prix }}</td>
               <td>{{ ($item->prix)*1.2 }}</td>
               <td>
                 <form role="form" method="post"  action="{{ Route('direct.submitAdd',['param' => 'stock']) }}" name="form{{ $loop->index+1 }}">

                   <input type="number" min="0" step="1" name="quantite" placeholder="Quantite">

                 </form>
               </td>
             </tr>
             @endforeach
             @endif
             @endif
           </tbody>

           </table>
           <input type="submit" >



<script src="{{  asset('js/jquery.js') }}"></script>
<script src="{{  asset('js/bootstrap.js') }}"></script>

<script src="{{  asset('table/jquery.js') }}"></script>
<script src="{{  asset('table/jquery.dataTables.js') }}"></script>
<script src="{{  asset('table/dataTables.bootstrap.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
