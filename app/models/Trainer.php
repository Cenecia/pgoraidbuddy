<?php

class Trainer extends Model
{
	public $id;
	public $pgoname;
	public $password;
	public $pwsalt;
	public $level;
	public $email;
	public $team;
	
	public function checkIfExists()
	{
		$pdo = getPdo();
		$userid = $pdo->query("SELECT id FROM trainer WHERE pgoname = '".$this->pgoname."' OR email = '".$this->email."'")->fetch(PDO::FETCH_COLUMN);
		if($userid) {
			return true;
		}
		return false;
	}
	
	private function verifyTrainerEmail()
	{
		$pdo = getPdo();
		$userid = $pdo->query("SELECT id FROM trainer WHERE pgoname = '".$this->pgoname."' AND email = '".$this->email."'")->fetch(PDO::FETCH_COLUMN);
		if($userid) {
			$this->id = $userid;
			return true;
		}
		return false;
	}
	
	public function createTrainer($password, $confirmpw)
	{
		if(!$this->email){
			return "Invalid email address";
		}
		if($password != $confirmpw){
			return "Passwords do not match.";
		}
		if(strlen($password) < 4 || strlen($password) > 40){
			return "Password must be between 4 and 40 characters.";
		}
		$this->pwsalt = password_hash($_SERVER['HTTP_USER_AGENT'], PASSWORD_DEFAULT);
		$this->password = password_hash($this->pwsalt.$password, PASSWORD_DEFAULT);
		$pdo = getPdo();
		if($this->level < 1 || $this->level > 40){
			return "Trainer level must be between 1 and 40";
		}
		if(strlen($this->pgoname) < 4 || strlen($this->pgoname) > 15){
			return "Trainer name must be between 4 and 15 characters.";
		}
		try{
			$stmt = $pdo->prepare('INSERT INTO trainer (pgoname, password, pwsalt, level, email, teamID) VALUES (?,?,?,?,?,?)');
			$stmt->execute([$this->pgoname, $this->password, $this->pwsalt, $this->level, $this->email, $this->team]);
		}
		catch(Exception $e){
			$this->error = "There was a problem registering. Please try again.";
			return;
		}
		$this->id = $pdo->lastInsertId();
		$headers = "From: noreply@pgoraidbuddy.com";
		$to = $this->email;
		$subj = "Thanks for signing up to PGO Raid Buddy!";
		$msg = "Thanks for signing up to PGO Raid Buddy - the app that helps you coordinate raids in Pokemon GO. 
This email is just to confirm that your account was created successfully. 
Thanks for using PGO Raid Buddy and good luck in your raids!";
		
		mail($to,$subj,$msg,$headers);
	}
	
	public function checkLogin()
	{
		$pdo = getPdo();
		$result = $pdo->query("SELECT * FROM trainer WHERE email = '".$this->email."'")->fetch(PDO::FETCH_OBJ);
		if(password_verify($result->pwsalt.$this->password, $result->password)){
			$this->id = $result->id;
			$this->pgoname = $result->pgoname;
			$this->level = $result->level;
			$this->team = $result->teamID;
			return true;
		}
		return false;
	}
	
	public function updatePassword($password, $confirmpw)
	{
		$pdo = getPdo();
		if($password != $confirmpw){
			return "Passwords do not match.";
		}
		if(strlen($password) < 4 || strlen($password) > 40){
			return "Password must be between 4 and 40 characters.";
		}
		$result = $pdo->query("SELECT * FROM trainer WHERE id = ".$this->id)->fetch(PDO::FETCH_OBJ);
		if(!password_verify($result->pwsalt.$this->password, $result->password)){
			return "Existing password is incorrect.";
		}
		$this->pwsalt = password_hash($_SERVER['HTTP_USER_AGENT'], PASSWORD_DEFAULT);
		$this->password = password_hash($this->pwsalt.$password, PASSWORD_DEFAULT);
		$stmt = $pdo->prepare('UPDATE trainer SET password = ?, pwsalt = ? WHERE id = ?');
		$stmt->execute([$this->password, $this->pwsalt, $this->id]); 
		$error = $pdo->errorInfo();
		if($error[0] != 0){
			return "There was a problem. Please try again.";
		}
		return 1;
	}
	
	public function updateLevel()
	{
		$pdo = getPdo();
		if($this->level < 1 || $this->level > 40){
			$this->error = "Trainer level must be between 1 and 40";
		}
		$stmt = $pdo->prepare('UPDATE trainer SET level = ? WHERE id = ?');
		$stmt->execute([$this->level, $this->id]);
		$error = $pdo->errorInfo();
		if($error[0] != 0){
			$this->error = "There was a problem. Please try again.";
		}
	}
	
	public function resetPassword()
	{
		$pdo = getPdo();
		
		if($this->verifyTrainerEmail()){
			$newpw = $this->getguid();
			$this->pwsalt = password_hash($_SERVER['HTTP_USER_AGENT'], PASSWORD_DEFAULT);
			$this->password = password_hash($this->pwsalt.$newpw, PASSWORD_DEFAULT);
			$stmt = $pdo->prepare('UPDATE trainer SET password = ?, pwsalt = ? WHERE id = ?');
			$stmt->execute([$this->password, $this->pwsalt, $this->id]);
			$headers = "From: noreply@pgoraidbuddy.com";
			$to = $this->email;
			$subj = "PGO Raid Buddy Password Reset";
			$msg = "Your password in PGO Raid Buddy has been reset. See your new password below.
New Password: $newpw 
After you log in with this new password, you can reset it to a different one by clicking Reset Password on the screen after you log in.";
			mail($to,$subj,$msg,$headers);
		}
		else{
			$this->error = "The email did not match that trainer name.";
		}
	}
	
	public function anonTrainerRaid($raid)
	{
		$pdo = getPdo();
		if($this->level < 1 || $this->level > 40){
			$this->error = "Trainer level must be between 1 and 40";
			return;
		}
		if(strlen($this->pgoname) < 4 || strlen($this->pgoname) > 15){
			$this->error = "Trainer name must be between 4 and 15 characters.";
			return;
		}
		try{
			$stmt = $pdo->prepare('INSERT INTO trainer_raid_anon (pgoname, level, teamID, raidID) VALUES (?,?,?,?)');
			$stmt->execute([$this->pgoname, $this->level, $this->team, $raid]);
		}
		catch(Exception $e){
			$this->error = "There was a problem. Please try again.";
			return;
		}
		$this->id = $pdo->lastInsertId();
	}
	
	public function getActiveRaids()
	{
		$pdo = getPdo();
		$expires = date("Y-m-d H:i:s");
		//var_dump($expires);die;
		$stmt = $pdo->prepare("SELECT r.*, p.name
							   FROM raid r 
							   JOIN trainer_raid tr ON r.id = tr.raidID 
							   JOIN pokemon p ON r.pokemonID = p.ID
							   WHERE r.expires > ?
							   AND tr.trainerID = ?");
		$stmt->execute([$expires, $this->id]);
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		//var_dump($result);die;	
		return $result;
	}
	
    private function getguid()
    {
      // OSX/Linux
      if (function_exists('openssl_random_pseudo_bytes') === true) {
          $data = openssl_random_pseudo_bytes(16);
          $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
          $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
          return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
      }
    }
}