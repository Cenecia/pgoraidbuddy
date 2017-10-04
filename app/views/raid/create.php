<?php
	include "../app/views/home/header.php";
?>
<title>Create a New Raid</title>
<div class="container-fluid">
	<hr/>
	<div class="alert alert-info">
		<div class="row">
			<div class="col-12">
				<strong><i class="fa fa-star-o" aria-hidden="true"></i> Create a new raid.</strong>
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
							<label for="location">Google Map Search (optional)</label> <span id="gmap_tooltip" data-toggle="tooltip" data-placement="top" title="What to search in google maps to locate the gym. If left blank, the gym name will be used by default."><i class="fa fa-question-circle-o" aria-hidden="true"></i></span>
							<input type="text" name="gmap" id="gmap" class="form-control" />
						</div>
						<div class="form-group">
							<label for="expires">Suggested Start Time</label>
							<div class="row">
								<div class="col-5 col-sm-3">
									<select id="start_hour" name="start_hour" class="form-control" required />
									<?php
										for ($x = 1; $x <= 12; $x++) {
											echo "<option value='$x'>$x</option>";
										}
									?>
									</select>
								</div>
								<div class="col-1 col-sm-3">
									:
								</div>
								<div class="col-5 col-sm-3">
									<select name="start_minute" id="start_minute" class="form-control" required>
									<?php
										for ($x = 0; $x <= 59; $x++) {
											echo "<option value='$x'>".sprintf("%02d",$x)."</option>";
										}
									?>
									</select>
								</div>
							</div>
							<input type="checkbox" id="unknown" name="unknown" /><label for="unknown">&nbsp;Unknown</label>
						</div>
						<div class="form-group">
							<label for="expires">Raid Expires in</label>
							<div class="row">
								<div class="col-5 col-sm-3">
									<select id="hour" name="hour" class="form-control" required />
										<option value="0">0</option>
										<option value="1">1</option>
									</select>
									<small id="hourText" class="form-text text-center">hours</small>
								</div>
								<div class="col-1 col-sm-3">
									:
								</div>
								<div class="col-5 col-sm-3">
									<select name="minute" id="minute" class="form-control" required>
									<?php
										for ($x = 59; $x >= 0; $x--) {
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
		$("#unknown").on("change", function(){
			if($(this)[0].checked){
				$("#start_hour").attr("disabled",true);
				$("#start_minute").attr("disabled",true);
			}
			else{
				$("#start_hour").attr("disabled",false);
				$("#start_minute").attr("disabled",false);
			}
		});
		$('#gmap_tooltip').tooltip();
	});
 </script>