<?php
require_once 'config.php';

class Raid extends Controller 
{
	public function create()
	{
		//echo date_default_timezone_get();
		if(!$_SESSION['id']){
			header("Location: ".ROOT_DIR."/home/index");
		}
		$data = array();
		$raid = $this->model("RaidModel");
		if(isset($_POST['pokemon'])){
			$raid->location = filter_var(trim($_POST['location']), FILTER_SANITIZE_STRING);
			$raid->gmapsearch = filter_var(trim($_POST['gmap']), FILTER_SANITIZE_STRING);
			$raid->pokemonID = filter_var($_POST['pokemon'], FILTER_VALIDATE_INT);
			$minutes = filter_var($_POST['minute'], FILTER_VALIDATE_INT);
			$hours = filter_var($_POST['hour'], FILTER_VALIDATE_INT);
			$raid->startHour = null;
			$raid->startMinute = null;
			if(!isset($_POST['unknown'])){
				$raid->startMinute = filter_var($_POST['start_minute'], FILTER_VALIDATE_INT);
				$raid->startHour = filter_var($_POST['start_hour'], FILTER_VALIDATE_INT);
			}
			
			$minutes += $hours * 60;
			if($minutes > 300 || $minutes <= 0){
				$data['error'] = "Invalid  expire time.";
			}
			else{
				$date = DateTime::createFromFormat("Y-m-d H:i:s",date("Y-m-d H:i:s"));
				$expireDate = $date->add(new DateInterval('PT' . $minutes . 'M'));
				$raid->expires = $expireDate->format('Y-m-d H:i:s');
				$raid->createRaid($_SESSION['id']);
				if($raid->error){
					$data['error'] = $raid->error;
				}
				else{
					header("Location: ".ROOT_DIR."/raid/".$raid->id);	
				}
			}
		}
		$pokemon = $raid->getPokemon();
		$data['pokemon'] = $pokemon;
		$this->view('raid/create', $data);
	}
	
	public function getServerTime()
	{
		echo date("Y/m/d h:i:s");
	}
	
	public function index($id)
	{
		$data = array();
		if(isset($_POST['email'])){
			$trainer = $this->model('Trainer');
			$trainer->email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
			$trainer->password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
			if($trainer->checkLogin()){
				$this->createSession($trainer);
			}
			else{
				$data['error'] = "login failed.";
			}
		}
		// if(isset($_POST['trainer_name']) && !isset($_SESSION['anonid'])){
			// echo "hi"; die;
			// $trainer = $this->model('Trainer');
			// $trainer->pgoname = filter_var(trim($_POST['trainer_name']), FILTER_SANITIZE_STRING);
			// $trainer->level = filter_var(trim($_POST['trainer_level']), FILTER_VALIDATE_INT);
			// $trainer->team = filter_var(trim($_POST['team']), FILTER_VALIDATE_INT);
			// $trainer->anonTrainerRaid(filter_var($id, FILTER_VALIDATE_INT));
			// if($trainer->error){
				// echo $trainer->error;
				// die;
			// }
			// else{
				// $this->createSession($trainer, true);
			// }
			// // if($trainer->checkLogin()){
				// // $this->createSession($trainer);
			// // }
			// // else{
				// // $data['error'] = "Login failed.";
			// // }
		// }
		$raid = $this->model('RaidModel');
		$raid->id = filter_var($id, FILTER_VALIDATE_INT);
		if(isset($_POST['ready'])){
			$ready = $_POST['ready'] == 1 ? 1 : 0;
			$raid->setReady($ready,$_SESSION['id']);
			header("Location: ".ROOT_DIR."/raid/".$raid->id);
		}
		elseif(isset($_POST['going'])){
			if($_POST['going'] == 1){
				$raid->attendRaid($_SESSION['id']);
			}
			else{
				$raid->unAttendRaid($_SESSION['id']);
			}
			header("Location: ".ROOT_DIR."/raid/".$raid->id);
		}
		$raid->getRaid();
		$now = date("Y-m-d H:i:s");
		if(strtotime($now)>strtotime($raid->expires)){
			$this->view('raid/expired', $data);
		}
		else{
			if($_SESSION['id'] || isset($_SESSION['anonid'])){
				$raid->getAttendees();
				if($_SESSION['id']){
					$data['attending'] = isset($raid->attendees[$_SESSION['id']]);
					$data['numReady'] = 0;
					$totalLevel = 0;
					foreach($raid->attendees as $attendee){
						if($attendee->ready == 1){
							$data['numReady']++;
						}
						$totalLevel+=$attendee->level;
					}
					$data['avgLevel'] = round($totalLevel / sizeof($raid->attendees),1);
					// foreach($raid->anon_attendees as $anon_attendee){
						// if($anon_attendee->ready == 1){
							// $data['numReady']++;
						// }
					// }
					if($data['attending']){
						if($_SESSION['id']){
							$data['ready'] = $raid->attendees[$_SESSION['id']]->ready;
						}
						// else{
							// $data['ready'] = $raid->anon_attendees[$_SESSION['anonid']]->ready;
						// }
					}
				}
				else{
					// $data['attending'] = isset($raid->anon_attendees[$_SESSION['anonid']]);
				}
				
			}
			else{
				// $data['attending'] = isset($raid->anon_attendees[$_SESSION['anonid']]);
				$data['attending'] = false;
			}			
			$data['raid'] = (array)$raid;
			$secondsLeft = $raid->timeLeft();
			$data['seconds'] = sprintf("%02d",$secondsLeft % 60);
			$data['minutes'] = ($secondsLeft - $data['seconds']) / 60;
			$data['hours'] = floor($data['minutes'] / 60);
			$data['minutes'] = sprintf("%02d", $data['minutes'] % 60);
			$data['locationURL'] = "https://www.google.com/maps/search/?api=1&query=".$this->formatMapStr($raid->gmapsearch);
			$this->view('raid/index', $data);
		}
	}
	
	private function formatMapStr($location)
	{
		$formatted = $location;
		$formatted = str_replace('%',"%25",$formatted);
		$formatted = str_replace(" ","%20",$formatted);
		$formatted = str_replace('"',"%22",$formatted);
		$formatted = str_replace('<',"%3C",$formatted);
		$formatted = str_replace('>',"%3E",$formatted);
		$formatted = str_replace('#',"%23",$formatted);
		$formatted = str_replace('|',"%7C",$formatted);
		return $formatted;
	}
}