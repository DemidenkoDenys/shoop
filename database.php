<?php

	define('MYSQL_SERVER', 'localhost');
	define('MYSQL_USER', 'demide9j_shoop');
	define('MYSQL_PASSWORD', '147147');
	define('MYSQL_DB', 'demide9j_shoop');

	function db_connect(){
		$link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB)
		or die("Error: ".mysqli_error($link));
		if(!mysqli_set_charset($link, "utf8")){
			printf("Error: ".mysqli_error($link));
		}
		return $link;
	}

?>