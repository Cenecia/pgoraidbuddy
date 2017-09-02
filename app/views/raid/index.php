<?php
	include "../app/views/home/header.php";
?>
<title><?=$data['raid']['pokemonName']?> raid at <?=$data['raid']['location']?></title>
<div class="container-fluid">
	<div class="text-center">
	<br/>
	<?php
		if($data['attending']){
			if($data['ready'] == 1){
	?>
		<div class="alert alert-success"><h3><i class="fa fa-thumbs-up" aria-hidden="true"></i> You are ready!</h3></div>
	<?php
			}
			else{
	?>
		<div class="alert alert-success"><h3><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> You are going to this raid!</h3></div>
	<?php
			}
	?>
		
	<?php
		}
		else{
	?>
		<div class="alert alert-info"><h3><i class="fa fa-users" aria-hidden="true"></i> You are invited to this raid!</h3></div>
	<?php
		}
	?>
	</div>
	<hr/>
	<div class="card">
		<div class="text-center">

			<h3 style="text-transform:capitalize;"><?=$data['raid']['pokemonName']?></h3>
			<img src="../public/img/pokemon/<?=$data['raid']['pokemonName']?>.png" class="img-responsive" alt="<?=$data['raid']['pokemonName']?>"/>
			<div>
				<?php
					for($i=1;$i<=$data['raid']['pokemonLevel'];$i++){
				?>
					<i class="fa fa-star" aria-hidden="true"></i>
				<?php
					}
				?>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-12">
				<p class="lead"><strong>This raid expires in <span id="hours"><?=$data['hours']?></span> : <span id="minutes"><?=$data['minutes']?></span> : <span id="seconds"><?=$data['seconds']?></span>.</strong></p>
				<?php
					if($data['raid']['guideurl']){
				?>
				<a class="btn btn-sm btn-info" href="<?=$data['raid']['guideurl']?>" target="_blank">guide</a>
				<?php
					}
				?>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-12">
				<p class="lead">INVITE URL: <?=SITE_URL.$_SERVER['REQUEST_URI']?></p>
			</div>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-12">
			<h5>Gym</h5>
			<a class="btn btn-block btn-sm btn-primary" target="_blank" href="<?=$data['locationURL']?>">
				<h4>
					<span class="badge badge-primary"><i class="fa fa-compass" aria-hidden="true"></i> <?=$data['raid']['location']?></span>
				</h4>
			</a>
			<p class="form-text text-muted text-center">
			  Google Map link may not always work.
			</p>
		</div>
	</div>

	<br/>
	<?php
		if($_SESSION['id'] || isset($_SESSION['anonid'])){
			//var_dump($_SESSION);
	?>
		<h5>
			Attendees 
			<span class="badge badge-default"><?=sizeOf($data['raid']['attendees']) + sizeOf($data['raid']['anon_attendees'])?> <span class='text-success'>(<?=$data['numReady']?>)</span></span>
			<a href="" class="btn btn-info btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i></a>
			<button id="attendeeToggle" class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
				<i id="attendeesIcon" class="fa fa-chevron-circle-down" aria-hidden="true"></i>
			</button>
			<span class="badge badge-default float-right">Avg Level: <?=$data['avgLevel']?></span>
		</h5>
		<div class="collapse" id="collapseExample">
			<ul class="list-group">
			  <?php
				foreach($data['raid']['attendees'] as $attendee){
			  ?>
				<li class="list-group-item <?=$attendee->ready ? "list-group-item-success" : ""?>">
					<span class="badge badge-default" style="background-color:#222224;">
						<img src="../public/img/teams/<?=$attendee->name?>.png" style="width:25px;" />
					</span>
					&nbsp;
					<h5>
						<span class="badge badge-default"><?=$attendee->level?></span>
						<?=$attendee->pgoname?>
					</h5>
				</li>
			  <?php	
				}
			  ?>
			</ul>
		</div>
		<br/>
		<div class="card card-inverse" style="background-color: #222224; border-color: #222224;padding:10px;">
	<?php
			if($data['attending']){
				if($data['ready'] == 1){
	?>
			<form method="POST" target="">
				<input type="hidden" id="ready" name="ready" value="0" />
				<button type="submit" class="btn btn-lg btn-warning btn-block">
					<i class="fa fa-thumbs-down" aria-hidden="true"></i>
					I'm not ready!
				</button>
			</form>
	<?php
				}
				else{
	?>
			<form method="POST" target="">
				<input type="hidden" id="ready" name="ready" value="1" />
				<button type="submit" class="btn btn-lg btn-success btn-block">
					<i class="fa fa-thumbs-up" aria-hidden="true"></i>
					I'm ready!
				</button>
			</form>
	<?php
				}
	?>
			</div>
			<br/>
			<hr/>
			<form method="POST" target="">
				<input type="hidden" id="going" name="going" value="0" />
				<button type="submit" class="btn btn-danger btn-block">
					<i class="fa fa-user-times" aria-hidden="true"></i>
					I'm Not Going!
				</button>
			</form>
	<?php
			}
			else{
	?>
			<form method="POST" target="">
				<input type="hidden" id="going" name="going" value="1" />
				<button type="submit" class="btn btn-primary btn-block">
					<i class="fa fa-user-plus" aria-hidden="true"></i>
					I'm Going!
				</button>
			</form>
	<?php
			}
		}
		else{
	?>
	<?php
		if(isset($data['error'])){
	?>
		<div class="alert alert-danger" role="alert">
		  <strong><?=$data['error']?></strong>
		</div>	
	<?php
		}
	?>
		<form method="POST" action="">
			<div class="card card-inverse" style="background-color: #222224; border-color: #222224;">
			  <div class="card-block">
				<p class="card-text">
				  <strong>You need to log in to attend this raid.</strong><br/>
				  If you have not signed up yet<br/>
				<a href="<?=ROOT_DIR?>/home/<?=$data['raid']['id']?>" class="btn btn-sm btn-primary"><i class="fa fa-user-plus" aria-hidden="true"></i> Sign up now!</a>
				</p>
				<div class="col-12">
					<fieldset>
						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="text" name="email" id="email" class="form-control" required/>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control" required/>
						</div>
					</fieldset>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Login</button>
			  </div>
			</div>
		</form>
	<?php
		}
	?>
</div>
 
<?php
	include "../app/views/home/footer.php";
?>
<script type="text/javascript">
	var raidTime = new Date("<?=$data['raid']['expires']?>");
	$(document).ready(function () {
		$("#attendeeToggle").on("click", function(){
			if($("#attendeesIcon").hasClass("fa-chevron-circle-down")){
				$("#attendeesIcon").removeClass("fa-chevron-circle-down");
				$("#attendeesIcon").addClass("fa-chevron-circle-up");
			}
			else{
				$("#attendeesIcon").removeClass("fa-chevron-circle-up");
				$("#attendeesIcon").addClass("fa-chevron-circle-down");
			}
		});
		$(".teamIcon").on("click", function(){
			$(".teamIcon").each(function(){
				$(this).removeClass("img-thumbnail");
			});
			$(this).addClass("img-thumbnail");
			$("#team").val($(this).attr("data-teamID"));
		});
		// Update the count down every 1 second
		var x = setInterval(function() {
			$.ajax({url: "<?=SITE_URL?><?=ROOT_DIR?>/raid/getServerTime", success: function(result){	
				var serverTime = new Date(result);
				var diff = raidTime - serverTime;
				var diffDate = new Date(diff);
				var currentHours = $("#hours").html();
				var diffMinute = diffDate.getMinutes();
				var diffSecond = diffDate.getSeconds();
				if(currentHours >= 0 && diffMinute >= 0 && diffSecond >= 0){
					$("#seconds").html(pad(diffSecond));
					$("#minutes").html(pad(diffMinute));
					if(diffMinute == 59 && diffSecond == 59){
						currentHours--;
						$("#hours").html(currentHours);
					}
				}
			}});
		}, 1000);
		
	});
	function pad(n) {
		return (n < 10) ? ("0" + n) : n;
	}
 </script>