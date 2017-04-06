<html>
<head>
<script type="text/javascript" src="{{ asset('table/table_script.js') }}"></script>
</head>
<body>
<div id="wrapper">
<table align='center' cellspacing=2 cellpadding=5 id="data_table" border=1>
<tr>
<th>Name</th>
<th>Country</th>
<th>Age</th>
</tr>

<tr id="row1">
	<td id="name_row1">Ankit</td>
	<td id="country_row1">India</td>
	<td id="age_row1">20</td>
	<td>
		<input type="button" id="edit_button1" value="Edit" class="edit" onclick="edit_row('1')">
		<input type="button" id="save_button1" value="Save" class="save" onclick="save_row('1')">
		<input type="button" value="Delete" class="delete" onclick="delete_row('1')">
	</td>
</tr>


<tr>
	<td><input type="text" id="new_name"></td>
	<td><input type="text" id="new_country"></td>
	<td><input type="text" id="new_age"></td>
	<td><input type="button" class="add" onclick="add_row();" value="Add Row"></td>
</tr>

</table>

<table align="center" cellspacing="2" cellpadding="5" id="data_table" border="1">
	<tr>	<th>Name</th>	<th>Country</th>	<th>Age</th>	</tr>

	@foreach($data as $item)
	<tr id="row{{ $loop->index+1 }}">
		<td id="name_row1">Ankit {{ $loop->index+1 }}</td>
		<td id="country_row1">India</td>
		<td id="age_row1">20</td>
		<td>
			<input type="button" id="edit_button1" value="Edit" class="edit" onclick="edit_row('1')">
			<input type="button" id="save_button1" value="Save" class="save" onclick="save_row('1')">
			<input type="button" value="Delete" class="delete" onclick="delete_row('1')">
		</td>
	</tr>
	@endforeach

</table>

</div>

</body>
</html>
