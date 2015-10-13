<?php
require_once '../core/model.php';
include_once ("../views/functions.php");

$action = getIdFromUrl (); // with parameters
if (stripos ( $action, "?" ) !== FALSE)
	$action = substr ( $action, 0, stripos ( $action, "?" ) ); // without parameters
class Users extends Model {
	public $id, $login, $email, $password, $is_admin, $name, $surname, $address, $phone;
	// function newUser($id, $login, $email, $pass, $is_admin, $name, $surname, $address, $phone) {
	// if ($id == "")
	// $this->id = null;
	// else
	// $this->id = $id;
	// $this->login = $login;
	// $this->email = $email;
	// $this->pass = md5 ( $pass );
	// $this->is_admin = $is_admin;
	// $this->name = $name;
	// $this->surname = $surname;
	// $this->address = $address;
	// $this->phone = $phone;
	// }
	function getData() {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM users';
			
			$sth = $dbh->prepare ( $zapros );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			
			$result = $sth->fetchAll ();
			$dbh = null;
			return $result;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function saveData($login, $email, $pass, $is_admin, $name, $surname, $address, $phone) {
		$pass = md5 ( $pass );
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'INSERT INTO users (id, login, email, password, is_admin, name, surname, address, phone) VALUES (null, :login, :email, :pass, :is_admin, :name, :surname, :address, :phone)';
			$sth = $dbh->prepare ( $zapros );
			
			$data = array (
					'login' => $login,
					'email' => $email,
					'pass' => $pass,
					'is_admin' => $is_admin,
					'name' => $name,
					'surname' => $surname,
					'address' => $address,
					'phone' => $phone 
			);
			
			$sth->execute ( $data );
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function getUser($id) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM users WHERE id=:id';
			
			$sth = $dbh->prepare ( $zapros );
			
			$sth->bindParam ( ':id', $id );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_INTO, $this );
			
			$sth->fetch ();
			
			// foreach ($result as $propName => $propValue) //если не работает FETCH_INTO
			// {
			// $this->{$propName} = $propValue;
			// }
			
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function updateUser($id, $login, $email, $pass, $is_admin, $name, $surname, $address, $phone) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'UPDATE users SET login = :login, email = :email, password = :pass, is_admin = :is_admin, name = :name, surname = :surname, address = :address, phone = :phone WHERE id = :id';
			$sth = $dbh->prepare ( $zapros );
			
			$data = array (
					'login' => $login,
					'email' => $email,
					'pass' => $pass,
					'is_admin' => $is_admin,
					'name' => $name,
					'surname' => $surname,
					'address' => $address,
					'phone' => $phone,
					'id' => $id 
			);
			
			$sth->execute ( $data );
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function loginUser($login, $pass) {
		$pass = md5 ( $pass );
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM users WHERE login=:login AND password=:pass AND is_admin=0';
			
			$sth = $dbh->prepare ( $zapros );
			
			$sth->bindParam ( ':login', $login );
			$sth->bindParam ( ':pass', $pass );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			
			if ($sth->rowCount () > 0) {
				session_start ();
				
				while ( $row = $sth->fetch () ) {
					$_SESSION ['id_user'] = $row ['id'];
				}
				header ( "Location: " . PATHSITE );
			} else {
				$GLOBALS ['title'] = "Ошибка авторизации";
				include_once '../views/header.php';
				echo "<p align='center'>К сожалению, указан неверный логин или пароль. Проверьте введенные данные.<br>";
				// echo "<a href='".$_SERVER ['HTTP_REFERER']."'>Вернуться</a></p>";
				include_once '../views/footer.php';
			}
			
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function logoutUser() {
		session_start ();
		if (isset ( $_SESSION ['id_user'] ))
			unset ( $_SESSION ['id_user'] );
		header ( "Location: " . PATHSITE );
	}
	function loginAdmin($login, $pass) {
		$pass = md5 ( $pass );
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM users WHERE login=:login AND password=:pass AND is_admin=1';
			
			$sth = $dbh->prepare ( $zapros );
			
			$sth->bindParam ( ':login', $login );
			$sth->bindParam ( ':pass', $pass );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			
			if ($sth->rowCount () > 0) {
				session_start ();
				
				while ( $row = $sth->fetch () ) {
					$_SESSION ['id_admin'] = $row ['id'];
				}
				header ( "Location: " . PATHSITE . "/admin-goods" );
			} else {
				include_once '../views/admin-header.php';
				echo "<p align='center'>К сожалению, вы не авторизированы. Проверьте введенные данные.<br>";
				// echo "<a href='".$_SERVER ['HTTP_REFERER']."'>Вернуться</a></p>";
				include_once '../views/login-admin.php';
				include_once '../views/footer.php';
			}
			
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function logoutAdmin() {
		session_start ();
		if (isset ( $_SESSION ['id_admin'] ))
			unset ( $_SESSION ['id_admin'] );
		header ( "Location: " . PATHSITE );
	}
	function resetPass($login, $email) {
	}
}
switch ($action) {
	case "login" :
		$user = new Users ();
		$user->loginUser ( $_POST ['login'], $_POST ['pass'] );
		break;
	case "logout" :
		$user = new Users ();
		$user->logoutUser ();
		break;
	case "login-admin" :
		$user = new Users ();
		$user->loginAdmin ( $_POST ['login'], $_POST ['pass'] );
		break;
	case "logout-admin" :
		$user = new Users ();
		$user->logoutAdmin ();
		break;
	case "add" :
		$user = new Users ();
		if(isset($_POST['is_admin'])) $is_admin=1; else $is_admin=0;
		$user->saveData ( $_POST ['reg_login'], $_POST ['email_addr'], $_POST ['reg_password'], $is_admin, $_POST ['name'], $_POST ['surname'], $_POST ['address'], $_POST ['mob_phone'] );
		header ( "Location: " . PATHSITE . "/admin-users" );
		break;
	case "register" :
		$user = new Users ();
		$user->saveData ( $_POST ['reg_login'], $_POST ['email_addr'], $_POST ['reg_password'], 0, $_POST ['name'], $_POST ['surname'], $_POST ['address'], $_POST ['mob_phone'] );
		header ( "Location: " . PATHSITE );
		break;
	case "remove" :
		$good = new Users();
		$good->deleteData("users", $_POST['id_user']);
		header ( "Location: " . PATHSITE . "/admin-users" );
		break;
	case "update" :
		if ($_POST ['reg_password'] == "")  //если пароль пуст, то не меняем его
			$pass = $_POST ['md5_old_password'];
		else
			$pass = md5 ( $_POST ['reg_password'] );
		$user = new Users ();
		$user->updateUser ( $_POST ['id_user'], $_POST ['reg_login'], $_POST ['email_addr'], $pass, $_POST ['is_admin'], $_POST ['name'], $_POST ['surname'], $_POST ['address'], $_POST ['mob_phone'] );
		header ( "Location: " . $_SERVER ['HTTP_REFERER'] );
		break;
	default :
		break;
}
