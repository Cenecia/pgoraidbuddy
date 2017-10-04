<?php
	include 'header.php';
?>
<title>PGO Raid Buddy - Pokemon Go Raid Coordination Tool</title>
<div class="container-fluid">
	<hr/>
	<div class="alert alert-info">
		<div class="row">
			<div class="col-12">
				<p class="lead">
					<strong>PGO Raid Buddy is a tool that helps coordinate raid events in Pokemon GO.</strong>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="lead">
					Sign up below to get started!
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<a href="<?=ROOT_DIR?>/home/login" class="btn btn-primary btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i> Already signed up? Log in here!</a>
			</div>
		</div>
	</div>
	<p class="lead text-danger">All fields are required *</p>
	<?php
		if(isset($data['error'])){
	?>
		<div class="alert alert-danger" role="alert">
		  <strong><?=$data['error']?></strong>
		</div>	
	<?php
		}
	?>
	<form method="post" action="">
		<div class="card card-inverse" style="background-color: #222224; border-color: #222224;">
			<div class="card-block">
				<div class="col-12">
					<fieldset>
						<div class="form-group">
							<label for="email">Email Address</label> <span id="email_tooltip" data-toggle="tooltip" data-placement="right" title="Your email address is required for if you ever need to change your password. It is not visible to other users and we will not send you spam email."><i class="fa fa-question-circle-o" aria-hidden="true"></i></span>

							<input type="text" name="email" id="email" class="form-control" value="<?=isset($data['trainer']['email']) ? $data['trainer']['email'] : ""?>" required/>
						</div>
						<div class="form-group">
							<label for="trainer_name">Pokemon GO Trainer Name</label>
							<input type="text" name="trainer_name" id="trainer_name" class="form-control" value="<?=isset($data['trainer']['pgoname']) ? $data['trainer']['pgoname'] : ""?>" required/>
						</div>
						<div class="form-group">
							<label for="trainer_level">Trainer Level</label>
							<select name="trainer_level" id="trainer_level" class="form-control">
							<?php
								for ($x = 40; $x >= 1; $x--) {
									echo "<option value='$x' ".(isset($data['trainer']['level']) && $data['trainer']['level'] == $x ? "selected" : "").">$x</option>";
								}
							?>
							</select>
						</div>
						<div class="form-group">
							<label for="team">Team</label> 
							<span id="label_1" class="team_label <?=(!isset($data['trainer']['team']) || $data['trainer']['team'] == 1 ? "" : "d-none")?>">Instinct</span>
							<span id="label_2" class="team_label <?=(isset($data['trainer']['team']) && $data['trainer']['team'] == 2 ? "" : "d-none")?>">Mystic</span>
							<span id="label_3" class="team_label <?=(isset($data['trainer']['team']) && $data['trainer']['team'] == 3 ? "" : "d-none")?>">Valor</span>
							<input type="hidden" name="team" id="team" value="<?=isset($data['trainer']['team']) ? $data['trainer']['team'] : "1"?>" required/>
							<div>
								<img src="<?=ROOT_DIR?>/public/img/teams/Instinct.png" class="img-fluid col-3 teamIcon <?=(!isset($data['trainer']['team']) || $data['trainer']['team'] == 1 ? "img-thumbnail" : "")?>" alt="Responsive image" data-teamID="1" />
								<img src="<?=ROOT_DIR?>/public/img/teams/Mystic.png" class="img-fluid col-3 teamIcon <?=(isset($data['trainer']['team']) && $data['trainer']['team'] == 2 ? "img-thumbnail" : "")?>" alt="Responsive image" data-teamID="2" />
								<img src="<?=ROOT_DIR?>/public/img/teams/Valor.png" class="img-fluid col-3 teamIcon <?=(isset($data['trainer']['team']) && $data['trainer']['team'] == 3 ? "img-thumbnail" : "")?>" alt="Responsive image" data-teamID="3" />
							</div>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control" required/>
						</div>
						<div class="form-group">
							<label for="confirm_password">Confirm Password</label>
							<input type="password" name="confirm_password" id="confirm_password" class="form-control" required/>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
		<br/>
		<button type="submit" class="btn btn-primary btn-block">Sign Up!</button>
	</form>
</div>
 
<?php
	include 'footer.php';
?>
<script type="text/javascript">
	$(document).ready(function () {
		$(".teamIcon").on("click", function(){
			$(".teamIcon").each(function(){
				$(this).removeClass("img-thumbnail");
			});
			$(".team_label").each(function(){
				$(this).addClass("d-none");
			});
			$(this).addClass("img-thumbnail");
			$("#team").val($(this).attr("data-teamID"));
			$("#label_"+$(this).attr("data-teamID")).removeClass("d-none");
		});
		$('#email_tooltip').tooltip();
	});
 </script>