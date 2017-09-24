<?php
	include 'header.php';
?>

<title>PGO Raid Buddy - Pokemon Go Raid Coordination Tool</title>
<div class="container-fluid">
	<hr/>
	<div class="row">
		<div class="col-12">
			<div class="alert alert-info">
				<strong>Forgot Password</strong><br/>
				Enter your email and trainer name, and PGO Raid Buddy will email a new password to you.
			</div>
		</div>
	</div>
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
			<div class="col-12">
				<fieldset>
					<div class="form-group">
						<label for="email">Email Address</label>
						<input type="text" name="email" id="email" class="form-control" required/>
					</div>
					<div class="form-group">
						<label for="trainer_name">PGO Trainer Name</label>
						<input type="input" name="trainer_name" id="trainer_name" class="form-control" required/>
					</div>
				</fieldset>
			</div>
		</div>
		<br/>
		<button type="submit" class="btn btn-primary btn-block">Reset Password</button>
	</form>
</div>
 
 <?php
	include 'footer.php';