<?php
	include 'header.php';
	$teamLogo = "";
	switch($_SESSION['team']){
		case 1:
			$teamLogo = "../public/img/teams/Instinct.png";
			break;
		case 2:
			$teamLogo = "../public/img/teams/Mystic.png";
			break;
		case 3:
			$teamLogo = "../public/img/teams/Valor.png";
			break;
	}
?>
<title>PGO Raid Buddy - Pokemon Go Raid Coordination Tool</title>
<div class="container-fluid">
	<br/>
	<div class="row">
		<div class="col-10 col-offset-1">
			<div class="row">
				<div class="col-12">
					<img src="<?=$teamLogo?>" style="height:80px;width:80px;" class="img-fluid float-left rounded teamIcon" alt="Responsive image" data-teamID="1">
						<div>
							<h2><?=$_SESSION['name']?></h2>
							<h3>Level: <?=$_SESSION['level']?><a href="<?=ROOT_DIR?>/home/updateLevel" class="btn btn-sm btn-secondary" alt="update level"><i class="fa fa-level-up" aria-hidden="true"></i></a></h3>
						</div>
				</div> 
			</div>
		</div>
	</div>
<?php
	if(isset($data['activeRaids']) && sizeof($data['activeRaids']) > 0){
?>
	<hr/>
	<p class="lead">Your Active Raids</p>
	<ul class="list-group">
<?php
		foreach($data['activeRaids'] as $raid){
?>
		<a class="list-group-item list-group-item-info" href="<?=ROOT_DIR?>/raid/<?=$raid->id?>">
			<?=$raid->name?> at <?=$raid->location?>
		</a>
<?php
		}
?>
	</ul>
<?php
	}
?>
<?php
	if(isset($data['friendRaids']) && sizeof($data['friendRaids']) > 0){
?>
	<hr/>
	<p class="lead">Friend Raids</p>
	<ul class="list-group">
<?php
		foreach($data['friendRaids'] as $raid){
?>
		<a class="list-group-item list-group-item-info" href="<?=ROOT_DIR?>/raid/<?=$raid->id?>">
			<?=$raid->name?> at <?=$raid->location?>
		</a>
<?php
		}
?>
	</ul>
<?php
	}
?>
	<hr/>
	<a href="<?=ROOT_DIR?>/raid/create" class="btn btn-primary btn-block"><i class="fa fa-star-o" aria-hidden="true"></i> Create Raid</a>
	<hr/>
	<a href="<?=ROOT_DIR?>/friends/" class="btn btn-primary btn-block">
		<i class="fa fa-users" aria-hidden="true"></i> Friends
<?php
	if($data['friendRequestCount'] > 0){
?>
		<span class="badge badge-pill" style="background-color:#343a40;"><?=$data['friendRequestCount']?></span>
<?php
	}
?>
	</a>
	<a href="<?=ROOT_DIR?>/home/resetPassword" class="btn btn-info btn-block"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Reset Password</a>
	<a href="<?=ROOT_DIR?>/home/logout" class="btn btn-secondary btn-block"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
</div>
 
<?php
	include 'footer.php';
	