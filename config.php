<?php
ini_set("display_errors", 0);
$config = array(
	'charset' => 'utf8',	
		
    /** database */
	'db' => array(	
		'host' => 'localhost',
		'user' => 'root',
		'pass' => '',
		'db'   => 'diplom5',
		
		'character_set_client'  => 'utf8',
		'character_set_results' => 'utf8',
		'collation_connection'  => 'utf8_general_ci'
	),
	
	/** template */
	'thm' => 'themes/public/theme.tpl.php',
	'tpl' => array(
	    'helpers'   => '../templates/helpers',	    
	    'templates' => '../templates'
	),
	
	'email' => 'info@yabucks.com',
	
	'pager' => array(
	    'onpage'     => 10,
	    'neighbours' => 5
	),
	
	'extuid' => array(
	    'ext_from1' => 22501,
	    'ext_to1'   => 25000,
	    'ext_from2' => 20001,
	    'ext_to2'   => 22500,
	)
	
	
);
?>