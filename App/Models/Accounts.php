<?php
namespace App\Models;
use PDO;
use App\Config;
class Accounts extends \Core\Model{
/************************************************************************/	
/************************************************************************/
	public static function getAll($table){
		$conn = static::getDB();
		try {
			$result = $conn->prepare("SELECT * FROM $table");
			$result->execute();
			return $result->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			return false;
		}
	}
/************************************************************************/
	public static function accountProfile(){
		$conn = static::getDB();
		$stat = '';
		if(isset($_POST['btn_update'])){
			$account = $_GET['uas_id'];
			$get_fname = static::validateData($_POST['fname']);
			$get_oname = static::validateData($_POST['oname']);
			$get_dob = $_POST['dob'];
			$get_phone = static::validateData($_POST['pnumber']);
			$get_gender = static::validateData($_POST['gender']);
			if(isset($_FILES['image'])){
				$image_name = $_FILES['image']['name'];
				$image_temp = $_FILES['image']['tmp_name'];
				$image_size = $_FILES['image']['size'];
				$image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
				$image_path = 'images/'.$image_name;
				if($image_size < 2000000){
					if($image_ext == 'jpg' || $image_ext = 'png' || $image_ext = 'gif'){
						if(move_uploaded_file($image_temp,$image_path)){
							try {
								$result = $conn->prepare("UPDATE accounts_tb SET first_name = '$get_fname', other_name = '$get_oname', dob = '$get_dob', gender = '$get_gender', image = '$image_path', phone_no = '$get_phone' WHERE id = $account");
								$result->execute();
								$stat = '<h3 class="success">Update Successful</h3>';
							} catch (Exception $e) {
								return false;
							}
						}else{
							$stat = '<h3 class="error">Image upload not successful</h3>';
						}
					}else{
						$stat = '<h3 class="error">Wrong image format</h3>';
					}
				}else{
					$stat = '<h3 class="error">Image size is too big</h3>';
				}
			}else{
				try {
					$result = $conn->prepare("UPDATE accounts_tb SET first_name = '$get_fname', other_name = '$get_oname', dob = '$get_dob', gender = '$get_gender', phone_no = '$get_phone' WHERE id = $account");
					$result->execute();
					$stat = '<h3 class="success">Update Successful</h3>';
				}catch (Exception $e) {
					return false;
				}
			}
		}
		if(isset($_GET['uas_id'])){
			$user_id = $_GET['uas_id'];
			$details = static::getData($conn, 'accounts_tb', 'id', $user_id);
			if($details{0}->gender == 'male'){
				$gender = '<input type="radio" name="gender" value="male" checked> Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  						<input type="radio" name="gender" value="female"> Female';
			}else{
				$gender = '<input type="radio" name="gender" value="male"> Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  						<input type="radio" name="gender" value="female" checked> Female';
			}
			$statements = static::getData($conn, 'transactions_tb', 'account_no', $details{0}->account_no);
			$information = array('details' => $details, 'statements' => $statements, 'user' => $user_id, 'gender' => $gender, 'stat' => $stat);
			return $information;
		}
	}
/************************************************************************/
/************************************************************************/
	public static function isLogin(){
		$conn = static::getDB();
		if(isset($_POST['btn_login'])){
			$get_phone = static::validateData($_POST['phone']);
			$get_pin = static::validateData($_POST['pin']);
			try {
				$result = $conn->prepare("SELECT * FROM users_tb WHERE phone_no = '$get_phone' AND pin = '$get_pin'");
				$result->execute();
				$log_in = $result->fetchAll(PDO::FETCH_OBJ);
			} catch (Exception $e) {
				return false;
			}
			if(!empty($log_in)){
				$_SESSION['session_access'] = $log_in{0}->role;
				$_SESSION['session_phone'] = $log_in{0}->phone_no;
				$_SESSION['session_pin'] = $log_in{0}->pin;
				if($_SESSION['session_access'] == 'admin'){
					header("Location:Admin/index");
				}else{
					$check_duplicate = static::getData($conn, 'accounts_tb', 'phone_no', $_SESSION['session_phone']);
					$_SESSION['session_account'] = $check_duplicate{0}->account_no;
					$_SESSION['session_username'] = $check_duplicate{0}->first_name;
					$_SESSION['session_fullname'] = $check_duplicate{0}->first_name .' '. $check_duplicate{0}->other_name;
					header("Location:User/index");
				}
			}else{
				$stat = '<h3 class="error">Wrong phone number or pin</h3>';
				return $stat;
			}
		}
	}
/************************************************************************/
	public static function isLoginCheck(){
		if(isset($_SESSION['session_phone'])){
			
		}else{
			$sat = $_SESSION['session_access'];
			header("Location:../Home/index");
		}
	}
/*******************************************************************************/
	public static function createAccount(){
		$conn = static::getDB();
		if(isset($_POST['btn_signup'])){
			if(isset($_FILES['image'])){
				$image_name = $_FILES['image']['name'];
				$image_temp = $_FILES['image']['tmp_name'];
				$image_size = $_FILES['image']['size'];
				$image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
				$image_path = 'images/'.$image_name;
				if($image_size < 2000000){
					if($image_ext == 'jpg' || $image_ext = 'png' || $image_ext = 'gif'){
						if(move_uploaded_file($image_temp,$image_path)){
							$image_file = $image_path;
						}else{
							$stat = '<h3 class="error">Image upload not successful</h3>';
						}
					}else{
						$stat = '<h3 class="error">Wrong image format</h3>';
					}
				}else{
					$stat = '<h3 class="error">Image size is too big</h3>';
				}
			}
			$get_fname = static::validateData($_POST['fname']);
			$get_oname = static::validateData($_POST['oname']);
			$get_dob = $_POST['dob'];
			$get_gender = static::validateData($_POST['gender']);
			$get_phone = static::validateData($_POST['pnumber']);
			$get_account = "0016".rand(100000,999999);
			$get_pin = static::validateData($_POST['pin']);
			$get_role = 'customer';
			$bindings = array(
				'fname' 		=>	$get_fname,
				'oname'			=>	$get_oname,
				'dob'			=> 	$get_dob,
				'gender'		=>	$get_gender,
				'image'			=>	$image_file,
				'phone'			=>	$get_phone,
				'account'		=>	$get_account,
				'pin'			=>	$get_pin,
			);
			$bindings1 = array(
				'phone'		=> $get_phone,
				'pin'		=> $get_pin,
				'role'		=> $get_role,
				);
			$check_dup = static::getData($conn, 'accounts_tb', 'phone_no', $get_phone);
			if(empty($check_dup)){
				try {
					$result = $conn->prepare("INSERT INTO accounts_tb (first_name, other_name, dob, gender, image, phone_no, account_no, pin) VALUES (:fname, :oname, :dob, :gender, :image, :phone, :account, :pin)");
					$create_account = $result->execute($bindings);
				} catch (Exception $e) {
					return false;
				}
				try {
					$result = $conn->prepare("INSERT INTO users_tb (phone_no, pin, role) VALUES (:phone, :pin, :role)");
					$create_user = $result->execute($bindings1);
				} catch (Exception $e) {
					return false;
				}
				if(!empty($create_user) && !empty($create_account)){
					header("Location:account?acct=$get_account");
				}
			}else{
				$stat = '<h3 class="error">Phone number already taken</h3>';
				return $stat;
			}
		}
	}
/****************************************************************************************/
	public static function accountBalance(){
		$conn = static::getDB();
		$giver_account = $_SESSION['session_account'];
		$stat = '<dt class="form-control">
					<label for="pin">Pin</label>
					<input type="password" id="pin" name="pin" />
				</dt>
				<dt class="form-control">
					<input type="submit" value="Check Balance" name="btn_balance" />
				</dt>';
		if(isset($_POST['btn_balance'])){
			$details = static::getData($conn, 'accounts_tb', 'account_no', $giver_account);
			$stat =  '<h1 class="success" style="font-size: 36px; margin-top: 50px;">Account Balance: ₦'.$details{0}->balance.' </h1>';
		}
		return $stat;
	}
/****************************************************************************************************/
	public static function accountStatement(){
		$conn = static::getDB();
		$giver_account = $_SESSION['session_account'];
		$pass = $_SESSION['session_pin'];
		$stat = '';
		$details = '';
		if(isset($_POST['btn_stat'])){
			$get_pin = static::validateData($_POST['pin']);
			if($pass == $get_pin){
				$details = static::getData($conn, 'accounts_tb', 'account_no', $giver_account);
				if(!empty($details)){
					header("Location:showstatement?acct=view");
				}
			}else{
				$stat = '<h3 class="error">Incorrect pin</h3>';
			}
		}
		if(isset($_GET['acct'])){
			$name = $_SESSION['session_fullname'];
			try {
				$result = $conn->prepare("SELECT * FROM transactions_tb WHERE (account_no = '$giver_account' AND type = 'Credit') OR (sender = '$name' AND type = 'Debit') ORDER BY id DESC" );
				$result->execute();
				$details = $result->fetchAll(PDO::FETCH_OBJ);
			} catch (Exception $e) {
				return false;
			}
		}
		$information = array('stat' => $stat, 'details' => $details);
		return $information;
	}
}