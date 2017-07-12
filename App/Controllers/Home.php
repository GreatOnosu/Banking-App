<?php
namespace App\Controllers;
use \Core\View;
use App\Models\Accounts;
/************************************************************************/	
class Home extends \Core\Controller{
/************************************************************************/	

/************************************************************************/	
	protected function before(){

	}
/************************************************************************/
	public function indexAction(){
		$login = Accounts::isLogin();
		View::render('Home/index.php', [
			'stat' => $login
			]);
	}
	public function signupAction(){
		$create = Accounts::createAccount();
		View::render('Home/signup.php', [
			'stat'	=>	$create
			]);
	}
	public function accountAction(){
		if(isset($_GET['acct'])){
			$acct_no = $_GET['acct'];
		}
		View::render('Home/account.php', [
			'acct_no' => $acct_no
			]);
	}
	public function logoutAction(){
		View::render('Home/logout.php');
	}
/************************************************************************/	
	protected function after(){

	}
}