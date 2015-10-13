<?php

DEFINE(USER, "root");
DEFINE(PASS, "root");
DEFINE(PATHSITE, "http://localhost/iba");
class Model
{
	function deleteData($table, $id){
	
		try {
			$dbh = new PDO('mysql:host=localhost;dbname=iba', USER, PASS);
			$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'DELETE from '.$table.' WHERE id=:id';
			$sth = $dbh->prepare($zapros);
	
			$sth->bindParam(':id', $id);
				
			$sth->execute();
			$dbh = null;
		}
		catch(PDOException $e) {
			echo "Error occurred: ".$e->getMessage();
		}
	}
}