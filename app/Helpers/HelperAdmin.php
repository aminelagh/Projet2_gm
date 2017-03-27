<?php
/*
Helper pour le adminController
*/


// directEmailExist($email) permet de verifier si un email exsit deja dans une table
if( !function_exists('sayHello') )
{
	function EmailExist($email,$table)
	{
    $emails = DB::table($table)->get()->pluck('email');
    foreach( $emails as $item )
    {
      if( $item == $email )
      return true;
    }
    return false;
	}
}



// retourn le libelle d'un magasin
if( !function_exists('getMagasinName') )
{
	function getMagasinName($id)
	{
		return DB::table('magasins')->where('id_magasin',$id)->pluck('libelle')->first();
	}
}

//retourne le libelle d'un role
if( !function_exists('getRoleName') )
{
	function getRoleName($id)
	{
		return DB::table('roles')->where('id_role',$id)->pluck('libelle')->first();
	}
}

//retourne le libelle d'une categorie
if( !function_exists('getCategorieName') )
{
	function getCategorieName($id)
	{
		$result = DB::table('categories')->where('id_categorie',$id)->pluck('libelle')->first();
		return $result == null ? '<i>not set</i>' : $result;
	}
}

//retourne le libelle d'un Fournisseur
if( !function_exists('getFournisseurName') )
{
	function getFournisseurName($id)
	{
		$result = DB::table('fournisseurs')->where('id_fournisseur',$id)->pluck('libelle')->first();
		return $result == null ? '<i>not set</i>' : $result;
	}
}

//returns Gender
if( !function_exists('getSexeName') )
{
	function getSexeName($value)
	{
		switch ($value) {
			case 'h': return 'Homme'; break;
			case 'f': return 'Femme'; break;
			default:  return '-'; 		break;
		}
	}
}

//test if is Color
if( !function_exists('isColor') )
{
	function isColor($value)
	{
		return substr($value,0,1) == '#' ? true : false;
	}
}
