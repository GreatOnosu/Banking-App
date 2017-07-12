<?php
function getData($conn, $table, $id, $value){
	try {
		$result = $conn->prepare("SELECT * FROM $table WHERE $id = '$value'");
		$result->execute();
		return $result->fetchAll(PDO::FETCH_OBJ);
	} catch (Exception $e) {
		return false;
	}
}
if(isset($_POST['acct_no'])){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "eagle_flight";
	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }
	catch(PDOException $e)
	    {
	    echo "Connection failed: " . $e->getMessage();
	    }
	$get_account = $_POST['acct_no'];
	$account = getData($conn, 'accounts_tb', 'account_no', $get_account);
	if(empty($account)){
		echo "No Match";
	}else{
		echo $account{0}->first_name .' '. $account{0}->other_name;
	}
}
?>