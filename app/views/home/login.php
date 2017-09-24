<?php
	include 'header.php';
?>

<title>PGO Raid Buddy - Pokemon Go Raid Coordination Tool</title>
<div class="container-fluid">
	<hr/>
	<div class="row">
		<div class="col-12">
			<div class="alert alert-info">
				<strong>Log in to PGO Raid Buddy</strong><br/>
				If you have not signed up yet<br/>
				<a href="<?=ROOT_DIR?>/home/" class="btn btn-sm btn-primary"><i class="fa fa-user-plus" aria-hidden="true"></i> Sign up now!</a>
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
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" required/>
					</div>
				</fieldset>
			</div>
		</div>
		<br/>
		<button type="submit" class="btn btn-primary btn-block">Login</button>
		<br/>
		<a href="<?=ROOT_DIR?>/home/forgotPassword" class="btn btn-secondary btn-sm float-right" style="color:#222224;">Forgot Password</a>
	</form>
</div>
 
 <?php
	include 'footer.php';