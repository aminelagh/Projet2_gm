<?php
/*
Helper pour le adminController
*/


// directEmailExist($email) permet de verifier si un email exsit deja dans une table
if( !function_exists('EmailExist') )
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

// fonction permet de verifier si une valeur d'un champ exist dans une table
if( !function_exists('Exists') )
{
	function Exists($table, $field, $value)
	{
    $emails = DB::table($table)->get()->pluck($field);
    foreach( $emails as $item )
    {
      if( $item == $value )
      return true;
    }
    return false;
	}
}
