<div class="contact-form">
	<div class="panel panel-default">
		<div class="panel-body">					
			<form name="contactform" id="commentForm" method="post" action="?page=contact&action=dosend" class="form-horizontal" role="form">		

				<div class="form-group">
						<input type="text" class="form-control short" id="inputName" name="inputName" placeholder="Your Name" value="@@NAME@@">
				</div>
				<div class="form-group">
						<input type="text" class="form-control short" id="inputEmail" name="inputEmail" placeholder="Your Email" value="@@EMAIL@@">
				</div>
				<div class="form-group">
						<input type="text" class="form-control short" id="inputCompany" name="inputCompany" placeholder="Your Company" value="@@COMPANY@@">
				</div>
				<div class="form-group">							
						<input type="text" class="form-control short" id="inputPhone" name="inputPhone" placeholder="Phone Number" value="@@PHONENUM@@">
				</div>

             	<div class="form-group">				
					<select class="form-control" id="inputSelect" name="inputSelect" placeholder="Your message...">
                        <option value="1">QuikID Solutions</option>
						<option value=“2”>QuickSafe Solutions</option>
                        <option value=“3”>Becoming Partner</option>
                        <option value=“4”>Other</option>
                    </select>
				</div>
				<div class="form-group">
						<textarea class="form-control" rows="4" id="inputMessage" name="inputMessage" placeholder="Your message...">@@MESSAGE@@</textarea>
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
						<button type="submit" class="btn btn-primary btn-lg btn-block">
							Send Message
						</button>
				</div>

             
			</form><!-- form end -->
			
		</div><!-- panel-body end -->
	</div><!-- panel-default end -->
</div><!-- container end -->

