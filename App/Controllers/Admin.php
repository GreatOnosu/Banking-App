<?php
namespace App\Controllers;
use \Core\View;
use App\Models\Accounts;
use App\Models\Transactions;
/************************************************************************/	
/************************************************************************/	
class Admin extends \Core\Controller{
/************************************************************************/	
	protected function before(){

	}
/************************************************************************/
	public function indexAction(){
		Accounts::isLoginCheck();
		View::render('Admin/index.php');
	}
/************************************************************************/
	public function fundingsAction(){
		Accounts::isLoginCheck();
		$fundings = Transactions::fundAccount();
		View::render('Admin/fundings.php',[
			'stat'	=>	$fundings
			]);
	}
/************************************************************************/
	public function accountsAction(){
		Accounts::isLoginCheck();
		$accounts = Accounts::getAll('accounts_tb');
		View::render('Admin/accounts.php',[
			'accounts'	=>	$accounts
			]);
	}
/************************************************************************/
	public function accountprofileAction(){
		Accounts::isLoginCheck();
		$information = Accounts::accountProfile();
		View::render('Admin/profile_accounts.php',[
			'details'	 =>	$information{'details'},
			'statements' => $information{'statements'},
			'user' 		 => $information{'user'},
			'stat'		 => $information{'stat'}
			]);
	}
/************************************************************************/
	public function editprofileAction(){
		Accounts::isLoginCheck();
		$information = Accounts::accountProfile();
		View::render('Admin/edit_profile.php',[
			'details'	 =>	$information{'details'},
			'statements' => $information{'statements'},
			'user' 		 => $information{'user'},
			'gender'	 => $information{'gender'},
			'stat'		 => $information{'stat'}
			]);
	}
/************************************************************************/
	public function searchAction(){
		Accounts::isLoginCheck();
		$stat = Transactions::checkTransaction();
		View::render('Admin/search_statement.php',[
			'stat'	 =>	$stat
			]);
	}
/************************************************************************/
	public function viewAction(){
		Accounts::isLoginCheck();
		$information = Transactions::getTransaction();
		View::render('Admin/view_statement.php',[
			'details'	 =>	$information{'details'},
			'account'	 => $information{'account'}
			]);
	}
/************************************************************************/	
	protected function after(){

	}
}