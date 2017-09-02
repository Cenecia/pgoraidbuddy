<?php

class Controller
{
	public function model($model)
	{
		require_once '../app/models/' . $model . '.php';
		return new $model;
	}
	
	public function view($view, $data = [])
	{
		require_once '../app/views/' . $view . '.php';
	}
	
	protected function createSession($trainer, $anon = false)
	{
		$this->clearSession();
		if($anon){
			$_SESSION['anonid'] = $trainer->id;
		}
		else{
			$_SESSION['id'] = $trainer->id;
		}
		$_SESSION['name'] = $trainer->pgoname;
		$_SESSION['level'] = $trainer->level;
		$_SESSION['team'] = $trainer->team;
	}
	
	protected function clearSession()
	{
		$_SESSION['anonid'] = null;
		$_SESSION['id'] = null;
		$_SESSION['name'] = null;
		$_SESSION['level'] = null;
		$_SESSION['team'] = null;
	}
}	