<?php
  if(!isset($_SESSION['id'])){
    $_SESSION['id'] = false;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=ROOT_DIR?>/public/css/style.css" />
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<link rel="shortcut icon" href="<?=ROOT_DIR?>/public/img/favicon.ico" type="image/x-icon">
  </head>
  <body>
	<div class="content">
		<div id="navbar">
			<p class="lead">
				<a id="appIcon" href="<?=ROOT_DIR?>/home/"><i class="fa fa-2x fa-gg-circle" aria-hidden="true"></i></a> <strong><span class="align-top" style="color:#f0f0f0;">PGO Raid Buddy</span> <span class="badge badge-default align-top">beta</span></strong>
			</p>
		</div>