<?php

use App\Helpers\Validation;
use App\Helpers\Tools;

if( count( Validation::errors() ) ){  

	print '<div class="alert alert-danger">';

	print '<ul class="list-unstyled">';

		foreach( Validation::errors() as $error ) {

				print '<li style="font-size: 16px;"><i class="fa fa-times"></i> '.$error.'</li>';

		}

	print '</ul></div>';
	
	unset( $_SESSION[SESSION.'errors'] );

 }
 
 if( count( Tools::flashes() ) ){  

	print '<div class="alert alert-success">';

	print '<ul class="list-unstyled">';

		foreach( Tools::flashes() as $flash ) {

				print '<li style="font-size: 16px;">'.$flash.' <i class="fa fa-check"></i></li>';

		}

	print '</ul></div>';
	
	unset( $_SESSION[SESSION.'flash'] );

 }