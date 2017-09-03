<?php
	include "../app/views/home/header.php";
?>
  
<div class="container-fluid">
	<hr/>
	<div class="alert alert-info">
		<div class="row">
			<div class="col-12">
				<strong>Create a new raid.</strong>
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
							<label for="location">Gym Name</label>
							<input type="text" name="location" id="location" class="form-control" required/>
						</div>
						<div class="form-group">
							<label for="location">Google Map Search (optional)</label>
							<input type="text" name="gmap" id="gmap" class="form-control" />
						</div>
						<div class="form-group">
							<label for="expires">Expires in</label>
							<div class="row">
								<div class="col-5 col-sm-3">
									<select id="hour" name="hour" class="form-control" required />
										<option value="1">1</option>
										<option value="0">0</option>
									</select>
									<small id="hourText" class="form-text text-center">hours</small>
								</div>
								<div class="col-1 col-sm-3">
									:
								</div>
								<div class="col-5 col-sm-3">
									<select name="minute" id="minute" class="form-control">
									<?php
										for ($x = 0; $x <= 59; $x++) {
											echo "<option value='$x'>".sprintf("%02d",$x)."</option>";
										}
									?>
									</select>
									<small id="minuteText" class="form-text text-center">minutes</small>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="pokemon">Pokémon</label>
							<input type="hidden" name="pokemon" id="pokemon" required/>
							<div>
								<?php
									for($tier = 5; $tier > 0; $tier--){
								?>
									<p class="lead">
										<?php
											for($star = 1; $star <= $tier; $star++){
										?>
											<i class="fa fa-star" aria-hidden="true"></i>
										<?php
											}
										?>
									</p>
								<?php
										foreach($data['pokemon'][$tier] as $pokemon){
								?>
										<img src="../public/img/pokemon/<?=$pokemon->name?>.png" class="col-3 teamIcon" alt="<?=$pokemon->name?>" data-pokemonID="<?=$pokemon->id?>">
								<?php
										}
								}
								?>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
		<br/>
		<button type="submit" class="btn btn-primary btn-block">Create Raid</button>
	</form>
</div>
 
<?php
	include "../app/views/home/footer.php";
?>
<script type="text/javascript">
	$(document).ready(function () {
		$(".teamIcon").on("click", function(){
			$(".teamIcon").each(function(){
				$(this).removeClass("img-thumbnail");
			});
			$(this).addClass("img-thumbnail");
			$("#pokemon").val($(this).attr("data-pokemonID"));
		});
	});
 </script>