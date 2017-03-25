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



// retourn le nom ou libelle d un id
if( !function_exists('getMagasinName') )
{
	function getMagasinName($id_magasin)
	{
		return DB::table('magasins')->where('id_magasin',$id_magasin)->pluck('libelle')->first() ;
	}

}

if( !function_exists('getRoleName') )
{
	function getRoleName($id_role)
	{
		return DB::table('roles')->where('id_role',$id_role)->pluck('libelle')->first() ;
	}

}
