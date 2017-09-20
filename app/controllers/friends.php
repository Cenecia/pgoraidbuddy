<?php
require_once 'config.php';

class Friends extends Controller 
{
	public function add()
	{
		if(!$_SESSION['id']){
			header("Location: ".ROOT_DIR."/home/index");
		}
		$data = array();
		if(isset($_POST['trainer_name'])){
			$trainer = $this->model('Trainer');
			$trainer->id = $_SESSION['id'];
			$friendTrainerName = filter_var(trim($_POST['trainer_name']), FILTER_SANITIZE_STRING);
			$trainer->sendFriendRequest($friendTrainerName);
			if($trainer->error){
				$data['error'] = $trainer->error;
			}
			else{
				header("Location: ".ROOT_DIR."/friends/index");
			}
		}
		$this->view('friends/add', $data);
	}
	
	public function confirm($id)
	{
		if(!$_SESSION['id']){
			header("Location: ".ROOT_DIR."/home/index");
		}
		$data = array();
		$trainer = $this->model('Trainer');
		$trainer->id = $_SESSION['id'];
		$trainer->confirmFriend($id);
		header("Location: ".ROOT_DIR."/friends/index");
	}

	public function deleteFriend($id)
	{
		if(!$_SESSION['id']){
			header("Location: ".ROOT_DIR."/home/index");
		}
		$data = array();
		$trainer = $this->model('Trainer');
		$trainer->id = $_SESSION['id'];
		$trainer->deleteFriend($id);
		//echo "added";die;
		header("Location: ".ROOT_DIR."/friends/index");
	}
	
	public function index()
	{
		if(!$_SESSION['id']){
			header("Location: ".ROOT_DIR."/home/index");
		}
		$trainer = $this->model('Trainer');
		$trainer->id = $_SESSION['id'];
		$data['friends'] = $trainer->getFriendList();
		$data['unconfirmedFriends'] = $trainer->getUnconfirmedFriends();
		$data['pendingFriends'] = $trainer->getPendingFriends();
		$this->view('friends/index', $data);
	}
}