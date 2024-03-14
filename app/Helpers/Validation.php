<?php

namespace App\Helpers;

class Validation
{

    public static function required($field, $string){
	
	if( $string == '' ){
	
		$field = str_replace('_id', ' ', $field);
		$field = str_replace('_', ' ', $field);
		return 'The '.$field.' field is required.';
	
	}

    }


    public static function min($field, $string, $min_value){

	$string_length = strlen($string);

		if( $string_length < $min_value ){
		
			$field = str_replace('_', ' ', $field);
		
			return 'The '.$field.' field is minimum '.$min_value.' characters.';
		
		}

    }


    public static function max($field, $string, $max_value){

	$string_length = strlen($string);

		if( $string_length > $max_value ){
		
			$field = str_replace('_', ' ', $field);
		
			return 'The '.$field.' field is maximum '.$max_value.' characters.';
		
		}

    }


    public static function unique($field, $string, $table){
    
	if($table == 'users'){

			$query = Db::conn()->prepare( ' SELECT * FROM `'.$table.'` WHERE `'.$field.'` =  ? AND password IS NOT NULL AND deleted_at IS NULL ' );

			$query->execute(array($string));

				if( $query->rowcount() > 0 ){
				
					$field = str_replace('_', ' ', $field);
				
					$field_type = $field == 'email' ? 'address' : 'field';
				
					return 'The '.$field.' '.$field_type.' already exists. Please <a href="login.php">login</a> to your account';
				
				}
		
	} else {

			$extra = '';
			
			if(isset($_GET['id'])){ $extra = " AND id != ? "; }
	
			$query = Db::conn()->prepare( ' SELECT * FROM `'.$table.'` WHERE `'.$field.'` =  ? '.$extra.' AND deleted_at IS NULL ' );
			
			if( !isset($_GET['id']) ){
			
				$query->execute(array($string));
			
			} else {
			
				$query->execute(array($string, $_GET['id']));
				
			}

				if( $query->rowcount() > 0 ){
				
					$field = str_replace('_', ' ', $field);
				
					return 'The '.$field.' field already exists.';
				
				}
	
	
	}

    }
    

    public static function exists($field, $string, $table){

	if( !self::unique($field, $string, $table) ){
	
		$field = str_replace('_', ' ', $field);
	
		return 'The '.$field.' is not in our database.';
	
	}
		
    }


    public static function isSame($field, $string, $otherField){

	if( $string !== $_POST[$otherField] ){
	
	$field = str_replace('_', ' ', $field);
	$otherField = str_replace('_', ' ', $otherField);
	
		return 'The '.$field.' and the '.$otherField.' field did not match.';
	
	}
		
    }
			
			
    public static function errors(){

	$errors = array();
	
	if(isset($_SESSION[SESSION.'errors']) && !empty($_SESSION[SESSION.'errors'])){
	
		foreach( $_SESSION[SESSION.'errors'] as $error ){ 

			$errors[] = $error;					
		
		}				
	
	}

	return $errors;

    }


}
