<?php
namespace App\Models;
use PDO;
use App\Config;
class Transactions extends \Core\Model{
/************************************************************************/
	public static function fundAccount(){
		$conn = static::getDB();
		if(isset($_POST['btn_fund'])){
			$get_password = static::validateData($_POST['password']);
			if($_SESSION['session_pin'] == $get_password){
				$get_amount = static::validateData($_POST['amount']);
				$get_accountname = static::validateData($_POST['acct_name']);
				$get_accountno = static::validateData($_POST['acct_no']);
				$details = static::getData($conn, 'accounts_tb', 'account_no', $get_accountno);
				$balance = $get_amount + $details{0}->balance;
				$bindings = array(
					'amount' 		=>	$get_amount,
					'receiver'		=>	$get_accountname,
					'acct_number'	=> 	$get_accountno,
					'sender'		=>	'Admin',
					'type'			=>	'Credit',
					'description'	=>	'Fundings',
					'balance'		=>	$balance,
				);
				$check_authetic = static::getData($conn, 'accounts_tb', 'account_no', $get_accountno);
				if(!empty($check_authetic)){
					try {
						$result = $conn->prepare("INSERT INTO transactions_tb (sender, receiver, account_no, type, description, amount, balance) VALUES (:sender, :receiver, :acct_number, :type, :description, :amount, :balance)");
						$transaction = $result->execute($bindings);
					} catch (Exception $e) {
						return false;
					}
					try {
						$result = $conn->prepare("UPDATE accounts_tb SET balance = $balance WHERE account_no = '$get_accountno'");
						$credit = $result->execute();
					} catch (Exception $e) {
						return false;
					}
				}else{
					$stat = '<h3 class="error">Account number not available</h3>';
				}
				if(empty($transaction) && empty($credit)){
					$stat = '<h3 class="success">Payment Unsuccessful</h3>';
				}else{
					$stat = '<h3 class="success">Payment Successful</h3>';
				}
			}else{
				$stat = '<h3 class="error">Incorrect password</h3>';

			}
			return $stat;
		}
	}
/************************************************************************/
	public static function checkTransaction(){
		$conn = static::getDB();
		if(isset($_POST['btn_check'])){
			$get_account = static::validateData($_POST['acct_no']);
			$statement = static::getData($conn, 'transactions_tb', 'account_no', $get_account);
			if(empty($statement)){
				$stat = '<h3 class="error">Account number not available</h3>';
				return $stat;
			}else{
				header("Location:view?acct=$get_account");
			}
		}
	}
/************************************************************************/
	public static function getTransaction(){
		$conn = static::getDB();
		if(isset($_GET['acct'])){
			$account = $_GET['acct'];
			$details = static::getData($conn, 'transactions_tb', 'account_no', $account);
			$information = array('details' => $details, 'account' => $account);
			return $information;
		}
	}
/************************************************************************/
	public static function makeTransfer(){
		$giver_account = $_SESSION['session_account'];
		$giver_name = $_SESSION['session_fullname'];
		$stat = '';
		if(isset($_POST['btn_pay'])){
			$get_pin = static::validateData($_POST['pin']);
			if($_SESSION['session_pin'] == $get_pin){
				$_SESSION['acct_no'] = $_POST['acct_no'];
				$get_accountno = static::validateData($_POST['acct_no']);
				if($giver_account != $get_accountno){
					$_SESSION['amount'] = $_POST['amount'];
					$_SESSION['acct_name'] = $_POST['acct_name'];
					header('Location:confirm');
				}else{
					$stat = '<h3 class="error">Cannot transfer to yourself</h3>';
				}
			}else{
				$stat = '<h3 class="error">Incorrect password</h3>';
			}
		}
		if(isset($_POST['btn_recharge'])){
			$get_pin = static::validateData($_POST['pin']);
			if($_SESSION['session_pin'] == $get_pin){
				$_SESSION['amount'] = $_POST['amount'];
				$_SESSION['phone'] = $_POST['phone'];
				$_SESSION['network'] = $_POST['network'];
				header('Location:confirmrecharge');
			}else{
				$stat = '<h3 class="error">Incorrect Password</h3>';
			}
		}
		return $stat;
	}
/************************************************************************/
	public static function confirmTransfer(){
		$conn = static::getDB(); 
		$gen = rand(100000,999999);
		$giver_account = $_SESSION['session_account'];
		$giver_name = $_SESSION['session_fullname'];
		$stat = '<dt class="form-control">
					<label for="pin">Enter one time password (your otp will appear on top of your screen)</label>
					<input type="number" id="pin" name="pin" required /><span id="genPin">Generate OTP</span>
					<input type="hidden" name="gen_pin" value="'.$gen.'" />
				</dt>
				<dt class="form-control">
					<input type="submit" value="Confirm" name="btn_confirm" />
				</dt>';
		$otp = $gen;
		if(isset($_POST['btn_confirm'])){
			if($_POST['pin'] == $_POST['gen_pin']){
				$get_amount = static::validateData($_SESSION['amount']);
				$get_accountname = static::validateData($_SESSION['acct_name']);
				$raccountno = static::validateData($_SESSION['acct_no']);
				$giver = static::getData($conn, 'accounts_tb', 'account_no', $giver_account);
				if($giver{0}->balance < $get_amount){
					$stat = '<h3 class="error">Insufficient Fund</h3>';
				}else{
					$gbalance = $giver{0}->balance - $get_amount;
					$receiver = static::getData($conn, 'accounts_tb', 'account_no', $raccountno);
					$rbalance = $get_amount + $receiver{0}->balance;
					$bindings = array(
						'amount' 		=>	$get_amount,
						'receiver'		=>	$get_accountname,
						'acct_number'	=> 	$raccountno,
						'sender'		=>	$giver_name,
						'type'			=>	'Debit',
						'description'	=>	'Money transfer',
						'balance'		=>	$gbalance,
					);
					$bindings1 = array(
						'amount' 		=>	$get_amount,
						'receiver'		=>	$get_accountname,
						'acct_number'	=> 	$raccountno,
						'sender'		=>	$giver_name,
						'type'			=>	'Credit',
						'description'	=>	'Money transfer',
						'balance'		=>	$rbalance,
					);
					$check_auth = static::getData($conn, 'accounts_tb', 'account_no', $raccountno);
					if(!empty($check_auth)){
						$transaction = static::createTransaction($conn, $bindings);
						if(!empty($transaction)){
							static::creditAccount($conn, $gbalance, $giver_account);
							$transaction1 = static::createTransaction($conn, $bindings1);
							if(!empty($transaction1)){
								static::creditAccount($conn, $rbalance, $raccountno);
								$stat = '<h3 class="success">Transfer Successful!!! <img src="icons/like_big.png" /></h3><br/><h3 class="success">'.$get_accountname.' has been credited with ₦'.$get_amount.'</h3><br/><br/>';
							}
						}
					}else{
						$stat = '<h3 class="error">Account number not available</h3>';
					}
				}
			}else{
				$stat = '<h3 class="error">Incorrect OTP</h3>';
			}
		}
		$information = array('stat' => $stat, 'otp' => $otp);
		return $information;
	}
/***************************************************************************************************/
	public static function confirmRecharge(){
		$conn = static::getDB(); 
		$gen = rand(100000,999999);
		$giver_account = $_SESSION['session_account'];
		$giver_name = $_SESSION['session_fullname'];
		$stat = '<dt class="form-control">
					<label for="pin">Enter one time password (your otp will appear on top of your screen)</label>
					<input type="number" id="pin" name="pin" required /><span id="genPin">Generate OTP</span>
					<input type="hidden" name="gen_pin" value="'.$gen.'" />
				</dt>
				<dt class="form-control">
					<input type="submit" value="Confirm" name="btn_confirmrecharge" />
				</dt>';
		$otp = $gen;
		if(isset($_POST['btn_confirmrecharge'])){
			$giver_account = $_SESSION['session_account'];
			$giver_name = $_SESSION['session_fullname'];
			if($_POST['pin'] == $_POST['gen_pin']){
				$get_amount = static::validateData($_SESSION['amount']);
				$get_phone = static::validateData($_SESSION['phone']);
				$get_network = static::validateData($_SESSION['network']);
				$giver = static::getData($conn, 'accounts_tb', 'account_no', $giver_account);
				if($giver{0}->balance < $get_amount){
					$stat = '<h3 class="error">Insufficient Fund</h3>';
				}else{
					$balance = $giver{0}->balance - $get_amount;
					$bindings = array(
						'amount' 		=>	$get_amount,
						'receiver'		=>	$get_phone,
						'acct_number'	=> 	'---------',
						'sender'		=>	$giver_name,
						'type'			=>	'Debit',
						'description'	=>	'Airtime recharge',
						'balance'		=>	$balance,
					);
					$transaction = static::createTransaction($conn, $bindings);
					if(!empty($transaction)){
						static::creditAccount($conn, $balance, $giver_account);
						$stat = '<h3 class="success">Recharge Successful!!! <img src="icons/like_big.png" /></h3><br/><h3 class="success">You just made a top up of ₦'.$get_amount.' on '.$get_phone.'</h3><br/><br/>';
					}else{
						$stat = '<h3 class="error">Error</h3>';
					}
				}
			}else{
				$stat = '<h3 class="error">Incorrect OTP</h3>';
			}
		}
		$information = array('stat' => $stat, 'otp' => $otp);
		return $information;
	}
}