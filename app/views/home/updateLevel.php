<?php
	include 'header.php';
?>

<title>Update Your Player Level</title>
<div class="container-fluid">
	<hr/>
	<div class="row">
		<div class="col-12">
			<div class="alert alert-info">
				<strong>Update Trainer Level</strong>
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
						<label for="level">Level</label>
						<select name="level" id="level" class="form-control">
						<?php
							for ($x = 40; $x >= 1; $x--) {
								echo "<option ".($x == $data['level'] ? "selected" : "")." value='$x'>$x</option>";
							}
						?>
						</select>						
					</div>
				</fieldset>
			</div>
		</div>
		<br/>
		<button type="submit" class="btn btn-primary btn-block">Update</button>
	</form>
</div>
 
 <?php
	include 'footer.php';