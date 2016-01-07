<div class="contact-main">
  <div class="container contact-box">
  		<div class="col-sm-4 col-md-4 dept">
			<i class="fa fa-globe fa-2x"></i><br>
			<strong>Sales</strong><br>
			<div class="contact-info">
				<a href="tel://1-778-331-7488">+1 778 331 7488</a><br>
				<a href="mailto:sales@fusionpipe.com">sales@fusionpipe.com</a><br>
			</div>
	  	</div>
	  	<div class="col-sm-4 col-md-4 dept">
	  		<i class="fa fa-newspaper-o fa-2x"></i><br>
			<strong>Marketing</strong><br>
			<div class="contact-info">
				<a href="tel://1-778-373-5716">+1 778 373 5716</a><br>
				<a href="mailto:marketing@fusionpipe.com">marketing@fusionpipe.com</a><br>
			</div>
	  	</div>
	  	<div class="col-sm-4 col-md-4 dept">
	  		<i class="fa fa-road fa-2x"></i><br>
			<strong>Careers</strong><br>
				<div class="contact-info">
				<a href="mailto:careers@fusionpipe.com">careers@fusionpipe.com</a>
			</div>
	  	</div>
  </div><!--container end-->
</div><!--contact header div end-->

<!---------------------------------------------------------------------------------------------------->

<section id="contact">
	<div class="container">	
		<h1 class="title text-center">Contact Us</h1>
		<div class="error col-md-offset-1 col-md-6" id="contactStatus"></div>
		<div class="row">
			<div class="col-md-offset-1 col-md-6">
				<div class="contact-form">
					<div class="panel panel-default">
						<div class="panel-body">					
							<form name="contactform" id="commentForm" method="post" action="?page=contact&action=dosend" class="form-horizontal" role="form">		

								<div class="form-group">
									<input type="text" class="form-control short" id="inputName" name="inputName" placeholder="Your Name" value="">
								</div>
								<div class="form-group">
									<input type="text" class="form-control short" id="inputEmail" name="inputEmail" placeholder="Your Email" value="">
								</div>
								<div class="form-group">
									<input type="text" class="form-control short" id="inputCompany" name="inputCompany" placeholder="Your Company" value="">
								</div>
								<div class="form-group">							
									<input type="text" class="form-control short" id="inputPhone" name="inputPhone" placeholder="Phone Number" value="">
								</div>

             					<div class="form-group">				
									<select class="form-control" id="inputSelect" name="inputSelect" placeholder="Your message...">
										@INTERESTS@
                    				</select>
								</div>
							<div class="form-group">
								<textarea class="form-control" rows="4" id="inputMessage" name="inputMessage" placeholder="Your message..."></textarea>
							</div>
							<div class="form-group">
								<div class="checkbox">
					  			<label>	
									<input type="checkbox" name="cadv" id="cadv" checked>Yes, I am interested in receiving information about new products etc.
					  			</label>
							</div>	
						</div>
						@CAPTCHA@
						<div class="form-group">
							<button type="button" id="contact_btn" class="btn btn-primary btn-lg btn-block">
								Send Message
							</button>
						</div>
					</form><!-- form end -->
			
				</div><!-- panel-body end -->
			</div><!-- panel-default end -->
				</div><!-- container end -->
			
			
			
			
			</div><!--col end-->

			<div class="col-md-4">		
				<div class="map-text-box">				
					<div class="com-location">
						<p class="sTitle">FusionPipe Software HQ<br> | Wavefront AC</p>
						<address>
						1400 - 1055 West Hastings Street<br>
						Vancouver, BC V6E 2E9<br>
						</address>
						<a href="tel://1-778-328-6427">+1 778 328 6427</a><br>
						<a href="mailto:info@fusionpipe.com">info@fusionpipe.com</a><br>
					</div>
					
					<!--<div class="com-location">
						<p class="sTitle">Silicon Valley | NestGSV</p>
						<address>
						425 Broadway Street<br>
						Redwood City, CA 94063
						</address>
					</div>-->
					
					<div class="com-location">							
						<p class="sTitle">EMEA office</p>
						<a href="tel://353-892-216-014">+353 892 216 014</a><br>
						<address>
						6 The Crescent, Harbour Heights<br>
						Passage West, Co Cork<br>
						Ireland
						</address>
					</div>

				</div><!--map text box end-->
			</div><!--col end-->
		</div><!--row end-->		
	</div><!--container end-->				
</section><!--section end-->




