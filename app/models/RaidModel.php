<?php

class RaidModel extends Model
{
	public $id;
	public $location;
	public $pokemonID;
	public $pokemonName;
	public $pokemonLevel;
	public $expires;
	public $attendees;
	public $guideurl;
	public $anon_attendees;
	public $gmapsearch;
	public $startHour;
	public $startMinute;
	
	public function getPokemon()
	{
		$pdo = getPdo();
		$results = $pdo->query("SELECT * FROM pokemon")->fetchAll(PDO::FETCH_OBJ);
		foreach($results as $result){
			$pokemon[$result->level][$result->id] = $result;
		}
		return $pokemon;
	}
	
	public function createRaid($trainerID)
	{
		$pdo = getPdo();
		if(strlen($this->gmapsearch) == 0){
			$this->gmapsearch = $this->location;
		}
		try{
			$stmt = $pdo->prepare('INSERT INTO raid (location, pokemonID, expires, gmapsearch, startHour, startMinute) VALUES (?,?,?,?,?,?)');
			$stmt->execute([$this->location, $this->pokemonID, $this->expires, $this->gmapsearch, $this->startHour, $this->startMinute]);
		}
		catch(Exception $e){
			$this->error = "There was a problem creating raid. Please try again.";
			return;
		}
		$this->id = $pdo->lastInsertId();
		$stmt = $pdo->prepare('INSERT INTO trainer_raid (raidID, trainerID, ready) VALUES (?,?,0)');
		$stmt->execute([$this->id, $trainerID]);
	}
	
	public function setReady($ready,$trainerID)
	{
		$pdo = getPdo();
		$stmt = $pdo->prepare('UPDATE trainer_raid SET ready = ? WHERE raidID = ? AND trainerID = ?;');
		$stmt->execute([$ready, $this->id, $trainerID]);
	}
	
	public function attendRaid($trainerID)
	{
		$pdo = getPdo();
		$stmt = $pdo->prepare('INSERT INTO trainer_raid (raidID,trainerID,ready) VALUES (?,?,0)');
		$stmt->execute([$this->id, $trainerID]);
	}
	
	public function unAttendRaid($trainerID)
	{
		$pdo = getPdo();
		$stmt = $pdo->prepare('DELETE FROM trainer_raid WHERE raidID = ? AND trainerID = ?');
		$stmt->execute([$this->id, $trainerID]);
	}
	
	public function getRaid(){
		$pdo = getPdo();
		$result = $pdo->query("SELECT r.*, 	p.name,p.level, p.guideurl, startHour, startMinute FROM raid r JOIN pokemon p ON r.pokemonID = p.id WHERE r.id = ".$this->id)->fetch(PDO::FETCH_OBJ);
		if($result){
			$this->location = $result->location;
			$this->pokemonID  = $result->pokemonID;
			$this->expires = $result->expires;
			$this->pokemonName = $result->name;
			$this->pokemonLevel = $result->level;
			$this->guideurl = $result->guideurl;
			$this->gmapsearch = $result->gmapsearch;
			$this->startHour = $result->startHour;
			$this->startMinute = $result->startMinute;
		}
		else{
			return false;
		}
	}
	
	public function getAttendees()
	{
		$pdo = getPdo();
		$results = $pdo->query("SELECT t.id, t.pgoname, tm.name, t.level, tr.ready 
								FROM trainer_raid tr 
								JOIN trainer t ON tr.trainerID = t.id 
								JOIN team tm ON t.teamID = tm.id 
								WHERE tr.raidID = ".$this->id)->fetchAll(PDO::FETCH_OBJ);
								
		foreach($results as $result){
			$attendees[$result->id] = $result;
		}
		$this->attendees = $attendees;
		
		// $results = $pdo->query("SELECT tr.id, tr.pgoname, tm.name, tr.level, tr.ready 
								// FROM trainer_raid_anon tr 
								// JOIN team tm ON tr.teamID = tm.id 
								// WHERE tr.raidID = ".$this->id)->fetchAll(PDO::FETCH_OBJ);
								
		// foreach($results as $result){
			// $anon_attendees[$result->id] = $result;
		// }
		// $this->anon_attendees = $anon_attendees;
	}
	
	public function timeLeft()
	{
		$diff = date_diff(DateTime::createFromFormat("Y-m-d H:i:s",date("Y-m-d H:i:s")),DateTime::createFromFormat("Y-m-d H:i:s",$this->expires));
		return $diff->s + ($diff->i * 60) + ($diff->h * 60 * 60);
	}
}