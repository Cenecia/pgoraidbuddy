<?php
  include 'header.php';
 ?>
 
 
<div class="container-fluid">
	<hr/>
	<div class="alert alert-info" role="alert">
	  Provide your current password to reset your password.
	</div>
	<?php
		if(isset($data['error'])){
	?>
	<div class="alert alert-danger" role="alert">
	  <?=$data['error']?>
	</div>	
	<?php
		}
	?>
	<form class="form-signin" method="post" action="">
		<div class="form-group">
			<label for="inputPassword" class="col-12 col-md-auto">Old Password</label>
			<div class="col-12">
				<input type="password" id="oldPassword" name="oldPassword" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label for="newPassword" class="col-12 col-md-auto">New Password</label>
			<div class="col-12">
				<input type="password" id="newPassword" name="newPassword" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label for="confirmPassword" class="col-12 col-md-auto">Confirm New Password</label>
			<div class="col-12">
				<input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
			</div>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
	</form>
</div>
 
 <?php
	include 'footer.php';