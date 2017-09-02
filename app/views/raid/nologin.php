<?php
	include "../app/views/home/header.php";
?>
  
<div class="container-fluid">
<hr/>
		<div class="card card-inverse" style="background-color: #222224; border-color: #222224;">
		  <div class="card-block">
		    <h3 class="card-title"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> You are not logged in!</h3>
		    <p class="card-text">
			  <a href="<?=ROOT_DIR?>/home/login" class="btn btn-secondary">Login</a> to attend!
	        </p>
	      </div>
		</div>
	<hr/>
</div>
 
<?php
	include "../app/views/home/footer.php";
?>