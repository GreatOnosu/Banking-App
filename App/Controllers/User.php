<?php
namespace App\Controllers;
use \Core\View;
/************************************************************************/
use App\Models\Accounts;
use App\Models\Transactions;
/************************************************************************/
class User extends \Core\Controller{
/************************************************************************/	
	protected function before(){

	}
/************************************************************************/
	public function indexAction(){
		Accounts::isLoginCheck();
		View::render('User/index.php', [
			'user'	=>	$_SESSION['session_username']	
			]);
	}
/************************************************************************/
	public function transferAction(){
		Accounts::isLoginCheck();
		$stat = Transactions::makeTransfer();
		View::render('User/transfers.php', [
			'stat'	=>	$stat
			]);
	}
/************************************************************************/
	public function confirmAction(){
		Accounts::isLoginCheck();
		$info = Transactions::confirmTransfer();
		View::render('User/confirm.php', [
			'stat'	=>	$info{'stat'},
			'otp' 	=>	$info{'otp'}
			]);
	}
/************************************************************************/	
/************************************************************************/
	public function rechargeAction(){
		Accounts::isLoginCheck();
		$stat = Transactions::makeTransfer();
		View::render('User/recharge.php', [
			'stat'	=>	$stat
			]);
	}
/************************************************************************/
	public function confirmrechargeAction(){
		Accounts::isLoginCheck();
		$info = Transactions::confirmRecharge();
		View::render('User/confirm_recharge.php', [
			'stat'	=>	$info{'stat'},
			'otp' 	=>	$info{'otp'}
			]);
	}
/*********************************************************************************/
	public function balanceAction(){
		Accounts::isLoginCheck();
		$stat = Accounts::accountBalance();
		View::render('User/balance.php', [
			'stat'	=>	$stat
			]);
	}
/*********************************************************************************/
	public function statementAction(){
		Accounts::isLoginCheck();
		$info = Accounts::accountStatement();
		View::render('User/statement.php', [
			'stat'	=>	$info{'stat'}
			]);
	}
/*********************************************************************************/
	public function showstatementAction(){
		Accounts::isLoginCheck();
		$info = Accounts::accountStatement();
		View::render('User/show_statement.php', [
			'details'	=>	$info{'details'}
			]);
	}
/************************************************************************/	
	protected function after(){

	}
}