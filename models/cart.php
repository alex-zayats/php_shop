<?php
include_once ("../views/functions.php");

$action = getIdFromUrl (); // with parameters
if (stripos ( $action, "?" ) !== FALSE)
	$action = substr ( $action, 0, stripos ( $action, "?" ) ); // without parameters

class Cart {
	protected static $instance;
	static function getInstance() {
		return (self::$instance === null) ? self::$instance = new self () : self::$instance;
	}
	function putCookie() {
		header ( "Location:" . $_SERVER ['HTTP_REFERER'] );
		if (isset ( $_GET ['id'] ) & isset ( $_GET ['count'] )) {
			$id = intval ( $_GET ['id'] );
			$count = intval ( $_GET ['count'] );
			setcookie ( "goods[$id]", $count, time () + 60 * 60 * 24 * 30, "/" ); // 30 дней
		}
	}
	function getAllCookies() {
		$result = $keys = $values = array ();
		if (isset ( $_COOKIE ['goods'] )) {
			foreach ( $_COOKIE ['goods'] as $id => $count ) {
				$id = htmlspecialchars ( $id );
				$count = htmlspecialchars ( $count );
				array_push ( $keys, $id );
				array_push ( $values, $count );
			}
			$result = array_combine ( $keys, $values );
		}
		return $result;
	}
	function deleteCookie($id) {
		$id = intval ( $id );
		setcookie ( "goods[$id]", "", time () - 1, "/" );
	}
	function deleteAllCookies() {
		if (isset ( $_COOKIE ['goods'] )) {
			foreach ( $_COOKIE ['goods'] as $id => $value ) {
				setcookie ( "goods[$id]", "", time () - 1, "/" );
			}
		}
	}
	function IsCookie($id) {
		if (isset ( $_COOKIE ['goods'] [$id] ))
			return TRUE;
		else
			return FALSE;
	}
}
switch ($action) {
	case "add" :
		Cart::getInstance ()->putCookie ();
		break;
	case "remove" :
		header ( "Location:" . PATHSITE . "/cart" );
		Cart::getInstance ()->deleteCookie ( $_GET ['id'] );
		break;
	case "removeAll" :
		header ( "Location:" . PATHSITE . "/cart" );
		Cart::getInstance ()->deleteAllCookies ();
		break;
	default :
		break;
}
