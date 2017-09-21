<?php
	include "../app/views/home/header.php";

	$instinctLogo = "../public/img/teams/Instinct.png";
	$mysticLogo = "../public/img/teams/Mystic.png";
	$valorLogo = "../public/img/teams/Valor.png";
?>
  
<div class="container-fluid">
	<br/>
	<a href="<?=ROOT_DIR?>/friends/add" class="btn btn-primary btn-block">Send Friend Request</a>
<?php
	if(sizeof($data['unconfirmedFriends']) > 0){
?>
	<hr/>
	<h3>Friend Requests</h3>
	<ul class="list-group">
<?php
		foreach($data['unconfirmedFriends'] as $friend){
?>
		<li class="list-group-item list-group-item-warning">
			<div class="col-12">
				&nbsp;<?=$friend->pgoname?>
				<div class="float-right">
					<a href="<?=ROOT_DIR?>/friends/confirm/<?=$friend->id?>" class="btn btn-success btn-sm"><i class="fa fa-check" aria-hidden="true"></i></a>
					&nbsp;<a href="<?=ROOT_DIR?>/friends/deleteFriend/<?=$friend->id?>" class="btn btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></a>				
				</div>
			</div>
		</li>
<?php
		}
?>
	</ul>
<?php
	}
	if(sizeof($data['pendingFriends']) > 0){
?>
	<hr/>
	<h3>Pending Friend Requests</h3>
	<ul class="list-group">
<?php
		foreach($data['pendingFriends'] as $friend){
?>
		<li class="list-group-item list-group-item-info">
			<div class="col-12">
				&nbsp;<?=$friend->pgoname?>
				<div class="float-right">
					<a href="<?=ROOT_DIR?>/friends/deleteFriend/<?=$friend->id?>" class="btn btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></a>				
				</div>
			</div>
		</li>
<?php
		}
?>
	</ul>
<?php
	}
	if(sizeof($data['friends']) > 0){
?>
	<hr/>
	<h3>Friendslist</h3>
	<ul class="list-group">
<?php
		foreach($data['friends'] as $friend){
?>
		<li class="list-group-item">
			<div class="col-12">
				<?=$friend->pgoname?>
				<a href="<?=ROOT_DIR?>/friends/deleteFriend/<?=$friend->id?>" class="float-right btn btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
		</li>
<?php
		}
?>
	</ul>
<?php
	}
?>
</div>
 
<?php
	include "../app/views/home/footer.php";
	