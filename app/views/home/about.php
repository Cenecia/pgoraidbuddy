<?php
  include 'header.php';
?>
 
 
<div class="container">
	<hr/>
	<div class="card card-inverse" style="background-color: #222224; border-color: #222224;">
	  <div class="card-block">
		<h3 class="card-title">About PGO Raid Buddy</h3>
		<p class="card-text">A project by <a href="http://chrismcbride.ca" target="_blank">Chris McBride</a></p>
		<p class="card-text">Version 0.1.1</p>
		<p class="card-text">
			PGO Raid Buddy helps players coordinate raids in <a href="https://www.pokemongolive.com/en/" target="_blank">Pokemon GO.</a><br/>
			<br/>
			How it works:<br/>
			<a href="<?=ROOT_DIR?>/home">Sign up</a> with the application to get started.<br/>
			<br/>
			Users who are signed in to the application can create raids that they see at nearby gyms.<br/>
			<br/>
			When a raid is created it will have a Share URL that can be shared to other users for them to verify they are going to that raid.<br/>
			<br/>
			Once a user has indicated they are going to a raid they can also indicate they are 'ready'or they can back out of the raid by clicking "I'm Not Going".<br/>
			<br/>
			You can see how many attendees are attending a raid by the number beside the word "Attendees". The green number in brackets beside it is the number of those attendees who are "Ready".
		</p>
	  </div>
	</div>
	<hr/>
	<div class="card card-inverse" style="background-color: #222224; border-color: #222224;">
	  <div class="card-block">
		<h3 class="card-title">Future Features</h3>
		<p class="card-text">
			The following features are planned or in development:
			<ol>
				<li>Live update the raid screen so you don't have to refresh the page to see people who are attending</li>
				<li>
					Add friendlist by in-game name
					<ul>
						<li>Be able to see when people on your friend list are attending raids that haven't expired</li>
					</ul>
				</li>
				<li>Add a "I will be there in X minutes" feature</li>
				<li>
					Add a "raid admin" feature (default to creator of raid)
					<ul>
						<li>Add ability for raid admin to specify a raid start time as well as a "GO IN NOW" button to tell people to enter the raid lobby</li>
					</ul>
				</li>
				<li>Attend raid without creating account</li>
				<li>Create raid without creating account</li>
				<li>Raid notifications via SMS or email</li>
			</ol>
		</p>
	  </div>
	</div>
</div>
 
 <?php
	include 'footer.php';