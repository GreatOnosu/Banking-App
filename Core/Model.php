<?php
namespace Core;
use PDO;
use App\Config;
abstract class model{
	protected static function getDB(){
		static $conn = null;
		if($conn === null){
			try{
				$dsn = 'mysql:host='. Config::DB_HOST .';dbname='. Config::DB_NAME .';charset=utf8';
				$conn = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
				return $conn;
			} catch(PDOException $e){
				echo $e->getMessage();
			}
		}
	}
/************************************************************************************************************/
	public static function validateData($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
/************************************************************************************************************/
	public static function getData($conn, $table, $id, $value){
		try {
			$result = $conn->prepare("SELECT * FROM $table WHERE $id = '$value' ORDER BY id DESC");
			$result->execute();
			return $result->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			return false;
		}
	}
/************************************************************************************************************/
	public static function createTransaction($conn, $bindings){
		try {
			$result = $conn->prepare("INSERT INTO transactions_tb (sender, receiver, account_no, type, description, amount, balance) VALUES (:sender, :receiver, :acct_number, :type, :description, :amount, :balance)");
			return $result->execute($bindings);
		} catch (Exception $e) {
			return false;
		}
	}
/************************************************************************************************************/
	public static function creditAccount($conn, $balance, $account){
	try {
		$result = $conn->prepare("UPDATE accounts_tb SET balance = $balance WHERE account_no = '$account'");
		$result->execute();
	} catch (Exception $e) {
		return false;
	}
	}
}