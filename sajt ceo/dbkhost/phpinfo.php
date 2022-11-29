<?php 

$lines = file_get_contents("tmp_files/1403279420-SAMP-64a2489a68.cfg"); 
					$pattern = "/^.*\bport\b.*$/m";
					$matches = array();
					preg_match($pattern, $lines, $matches);
					$matche = $matches[0];
					$matche = str_replace("port ", "", $matche);
			print_r( $matche);
?> 