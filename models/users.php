<?php
require_once '../core/model.php';

class users extends Model {
	public $id, $login, $email, $pass, $is_admin, $name, $surname, $address;
	function newuser($id, $login, $email, $pass, $is_admin, $name, $surname, $address) {
		if ($id == "")
			$this->id = null;
		else
			$this->id = $id;
		$this->login = $login;
		$this->email = $email;
		if ($pass == "")
			$this->id = null;
		else
			$this->pass = md5 ( $pass );
		$this->is_admin = $is_admin;
		$this->name = $name;
		$this->surname = $surname;
		$this->address = $address;
	}
	function getData() {
		$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS);
		
		$zapros = 'SELECT * FROM users';
		
		foreach ( $dbh->query ( $zapros ) as $row ) {
			// print_r($row);
		}
		
		$dbh = null;
		return null;
	}
	function saveData($login, $email, $pass, $is_admin, $name, $surname, $address) {
		$pass = md5 ( $pass );
		
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS);
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'INSERT INTO users (id, login, email, password, is_admin, name, surname, address) VALUES (null, :login, :email, :pass, :is_admin, :name, :surname, :address)';
			$sth = $dbh->prepare ( $zapros );
			
			$data = array (
					'login' => $login,
					'email' => $email,
					'pass' => $pass,
					'is_admin' => $is_admin,
					'name' => $name,
					'surname' => $surname,
					'address' => $address 
			);
			
			$sth->execute ( $data );
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function getuser($id) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS);
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM users WHERE id=:id';
			
			$sth = $dbh->prepare ( $zapros );
			
			$sth->bindParam(':id', $id);
			
			$sth->execute ();
			
			$sth->setFetchMode(PDO::FETCH_ASSOC);
				
			while ( $row = $sth->fetch () ) {
				echo $row ['name'] . "\n";
				echo $row ['surname'] . "\n";
			}
			
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function updateuser($id, $login, $email, $is_admin, $name, $surname, $address) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS);
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'UPDATE users SET login = :login, email = :email, is_admin = :is_admin, name = :name, surname = :surname, address = :address WHERE id = :id';
			$sth = $dbh->prepare ( $zapros );
			
			$data = array (
					'login' => $login,
					'email' => $email,
					'is_admin' => $is_admin,
					'name' => $name,
					'surname' => $surname,
					'address' => $address,
					'id' => $id 
			);
			
			$sth->execute ( $data );
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function resetPass($login, $email) {
	}
}
