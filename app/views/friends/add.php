<?php
	include "../app/views/home/header.php";
?>
  
<div class="container-fluid">
	<hr/>
	<div class="alert alert-info">
		<div class="row">
			<div class="col-12">
				<strong>Send Friend Request</strong>
			</div>
			<div class="col-12">
				
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
			<div class="card-block">
				<div class="col-12">
					<fieldset>
						<div class="form-group">
							<label for="trainer_name">Trainer Name</label>
							<input type="text" name="trainer_name" id="trainer_name" class="form-control" required/>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
		<br/>
		<button type="submit" class="btn btn-primary btn-block">Send Friend Request</button>
	</form>
</div>
 
<?php
	include "../app/views/home/footer.php";