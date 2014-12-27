<?php
/*
Template Name: Contact
*/
?>
<?php get_header(); ?>
<div id="page" class="page c-sec">
	<div id="main-body" class="main-body">
		<div class="padding">
			<div class="title">Contact Us For A Free Consultation</div>
			<div class="title-border"></div>
			<div>
				<div class="box-1">
				<div class="padding body">Contact us to schedule a free 30-minute consultation.  We'll talk about your needs and how we can help you.  You have nothing to lose.</div>
				</div>

				<div class="box-2">
					<div class="body">
						<h6>Contact Info:</h6>	
						<div>50 W Market st.
						</br>
						     Harrisonburg, VA 22801
						</br>
						     P: 540.391.0503
						</br>
						     E: labs@chie.do
						</div>			
					</div>
				</div>
				<div class="box-3">
					<div class="body">
						<h6>Office Hours:</h6>
						<div>Mon: 9-5 Tues: 9-5 Wed: 9-5 Fri: 9-5 Sat: Close Sun: Close</div>					
					</div>
				</div>
			</div>
			<div class="clear"></div>

			<div class="contact-form">
				<div class="padding">
					<div class="left-box">
						<div class="form-wrapper">
							<form>
							<div class="form-body">
								<ul>
									<li id="field1"><label class="field-label"></label>
									<div class="input-container">
									<input id="field1" type="text" placeholder="What's your name? *"></input>
									</div>
									</li>
									<li id="field2"><label class="field-label"></label>
									<div class="input-container">
									<input id="field2" type="text" placeholder="What's your phone number?"></input>
									</div>
									</li>
									<li id="field3"><label class="field-label"></label>
									<div class="input-container">
									<input id="field3" type="text" placeholder="What's your email address? *"></input>
									</div>
									</li>
									<li id="field4"><label></label>
									<div class="input-container">
									<textarea id="field4" class="textarea medium" name="field4" cols="50" rows=" 10" tabindex="4" placeholder="Please describe your project. *"></textarea>
									</div>
									</li>
								</ul>
							</div>
							<div class="form-footer">
								<input id="submit-button" class="submit-button" type="submit" value="Submit"></input>						
							</div>
							</form>
						</div>
					</div>
					<div class="right-box">
						<div id="map-canvas" class="map-canvas" style="background-color: rgb(229,227,223); overflow: hidden; position: relative;">
						
						</div>
					</div>			

				</div>
			<div class="clear"></div>
			</div>	
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-VGn8cQwVILW6FOCkBvRvne31wzDznI&sensor=true" type="text/javascript"</script>		
			<script type="text/javascript" src="https://maps.gstatic.com/maps-api-v3/api/js/17/14a/main.js"></script>
			<script type="text/javascript">
				
				function initialize() {
				  var myLatlng = new google.maps.LatLng(38.449681,-78.870061);
				  var mapOptions = {
				    zoom: 15,
				      center: myLatlng,
				      mapTypeId: google.maps.MapTypeId.ROADMAP
				  }
				  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

				  var marker = new google.maps.Marker({
				    position: myLatlng,
				      map: map,
				      title: 'Chiedo Labs'
				  });
				}

				google.maps.event.addDomListener(window, 'load', initialize);

			</script>
		</div>
	</div>
</div>
<?php get_footer(); ?>

