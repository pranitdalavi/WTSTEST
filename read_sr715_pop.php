<?php

$directories = array('product-images');

foreach($directories as $dir){

		$files = scandir($dir);

		foreach( $files as $file ){

			if( strlen($file) > 2 && $file != '.htaccess' ){			
				
				$results[$dir][] = $file.'::'.filemtime($dir.'/'.$file);
			
			}

		}

}

print json_encode($results);