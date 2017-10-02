<?php
require_once 'config.php';

class Home extends Controller 
{
	public function index($id = 0)
	{
		$trainer = $this->model('Trainer');
		$data = array();
		if($_SESSION['id']){
			$trainer->id = $_SESSION['id'];
			$data['activeRaids'] = array();
			$data['activeRaids'] = $trainer->getActiveRaids();
			$friendRequests = $trainer->getUnconfirmedFriends();
			$data['friendRaids'] = $trainer->getFriendsRaids();
			$data['friendRequestCount'] = sizeof($friendRequests);
			$this->view('home/index', $data);
		}
		else{
			if(isset($_POST['trainer_name'])){
				$trainer->pgoname = filter_var(trim($_POST['trainer_name']), FILTER_SANITIZE_STRING);
				$trainer->email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
				$trainer->level = filter_var($_POST['trainer_level'], FILTER_VALIDATE_INT);
				$trainer->team = filter_var($_POST['team'], FILTER_VALIDATE_INT);
				if($trainer->checkIfExists()){
					$data['error'] = "That trainer name or email is already signed up!";
					$data['trainer'] = (array)$trainer;
				}
				else{
					$password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
					$confirmpw = filter_var(trim($_POST['confirm_password']), FILTER_SANITIZE_STRING);
					$trainer->createTrainer($password, $confirmpw);
					if($trainer->error){
						$data['error'] = $trainer->error;
						$data['trainer'] = (array)$trainer;
					}
					else{
						$this->createSession($trainer);
						$raidID = filter_var($id, FILTER_VALIDATE_INT);
						if($id && $id != 0){
							header("Location: ".ROOT_DIR."/raid/$raidID");
						}
						else{
							header("Location: ".ROOT_DIR."/home/index");
						}
					}
				}
			}
			$this->view('home/register', $data);
		}
	}
	
	public function login()
	{
		if($_SESSION['id']){
			header("Location: ".ROOT_DIR."/home/index");
		}
		$data = array();
		if(isset($_POST['email'])){
			$trainer = $this->model('Trainer');
			$trainer->email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
			$trainer->password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
			if($trainer->checkLogin()){
				$this->createSession($trainer);
				header("Location: ".ROOT_DIR."/home/index");
			}
			else{
				$data['error'] = "Login failed.";
			}
		}
		$this->view('home/login', $data);
	}
	
	public function about()
	{
		$this->view('home/about');
	}
	
	public function privacy()
	{
		$this->view('home/privacy');
	}
	
	public function logout()
	{
		$this->clearSession();
		header("Location: ".ROOT_DIR."/home/login");
	}
	
	public function resetPassword()
	{
		if(!$_SESSION['id']){
			header('Location: '.ROOT_DIR.'/home/');
		}
		
		if(isset($_POST['newPassword'])){
			$trainer = $this->model('Trainer');
			$trainer->password = filter_var(trim($_POST['oldPassword']), FILTER_SANITIZE_STRING);
			$newPassword = filter_var(trim($_POST['newPassword']), FILTER_SANITIZE_STRING);
			$confirmPassword = filter_var(trim($_POST['confirmPassword']), FILTER_SANITIZE_STRING);
			
			if($newPassword == $confirmPassword){
				$trainer->id = $_SESSION['id'];
				$result = $trainer->updatePassword($newPassword,$confirmPassword);
				
				if($result == 1){
					$this->view('home/changePasswordSuccess');
					return;
				}
				else{
					$data['error'] = $result;
					$this->view('home/resetPassword', $data);
				}
			}
			else{
				$data['error'] = "New Password did not match Confirm New Password";
				$this->view('home/resetPassword', $data);
			}
		}

		$this->view('home/resetPassword');
	}
	
	public function updateLevel()
	{
		if(!$_SESSION['id']){
			header('Location: '.ROOT_DIR.'/home/');
		}
		$data = array();
		if(isset($_POST['level'])){
			$trainer = $this->model('Trainer');
			$trainer->id = $_SESSION['id'];
			$trainer->level = filter_var($_POST['level'], FILTER_VALIDATE_INT);
			$trainer->updateLevel();
			
			if($this->error){
				$data['error'] = $this->error;
			}
			else{
				$_SESSION['level'] = $trainer->level;
				header('Location: '.ROOT_DIR.'/home/');
			}
		}
		$data['level'] = $_SESSION['level'];
		$this->view('home/updateLevel', $data);
	}
	
	public function forgotPassword()
	{
		if($_SESSION['id']){
			header('Location: '.ROOT_DIR.'/home/');
		}
		if(isset($_POST['email'])){
			$trainer = $this->model('Trainer');
			$trainer->email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
			$trainer->pgoname = filter_var(trim($_POST['trainer_name']), FILTER_SANITIZE_STRING);
			$trainer->resetPassword();
			if($trainer->error){
				$data['error'] = $trainer->error;
				$this->view('home/forgotPassword', $data);
			}
			else{
				$this->view('home/forgotPasswordSuccess', $data);
			}
		}else{
			$this->view('home/forgotPassword');
		}
	}
}