<section id="quikid_beta">
	<div class="container">
		<div class="row">
			
			<h1 class="text-center">Download QuikID<sup>TM</sup> Evaluation Release</h1>
			<h4 class="text-center">For more on how to install and use QuikID<sup>TM</sup>, visit our <a href="http://www.fusionpipe.com/quikid_howto">"How To" Page</a></h4>
			
			<div class="col-md-offset-4 col-md-4 col-sm-offset-2 col-sm-8">				
				<div id="download-state" style="display:none;">
					<h4>Requesting....</h4>
				</div>

				<div class="quik_down input-group" id="download-form">
					<input type="hidden" name="dqid-windowsversion" id="dqid-windowsversion" value="<?php echo $quikid_windows_version?>"/>
					<input type="hidden" name="dqid-androidversion" id="dqid-androidversion" value="<?php echo $quikid_android_version?>"/>
				<?php
				$usrId = 0;
				$usr = "";  
				if(isset($_COOKIE['fp_usr'])){
					$usrId = (int) $_COOKIE['fp_usr'];
					if ($usrId > 0){
						$usr =  MarketingUserNameWithId($usrId);
					}
				}
				if (strlen($usr) < 1){
				?>
					<input class="down_text" name="dfname" id="dfname" type="text" placeholder="Your full name" required/>
					<input class="down_text" name="demail" id="demail" type="email" placeholder="Email address" required/>
					<input class="down_text" name="dcompany" id="dcompany" type="text" placeholder="Company name (optional)"/>
					<input type="text" class="down_text" name="dphone" id="dphone" type="text" placeholder="Phone number (optional)">
					<input type="hidden" name="dusr" id="dusr" value="0"/>
				</div>
			
				<?php
				} else {
				?>
				<input type="hidden" name="dusr" id="dusr" value="<?php echo $usrId ?>/">
				<div class="welbackMsg">
					<h3 class="welcomeBack">Welcome back, <?php echo $usr; ?>!</h3>
					<a class="notYou" href="javascript:document.cookie='fp_usr='; location.reload();">Not you?</a>
				</div>	
			
			
				
				<?php
				}
				?>
				<p class="formDes">By downloading the QuikID<sup>TM</sup> Evaluation Release, you agree to be bound by the <a href="http://www.fusionpipe.com/eula">terms and conditions of use</a></p>
			<div class="platformDown">
				<div class="text-center col-md-12 col-sm-12">
					<div id="download-state" style="display:none;">
						<h4>Requesting....</h4>
					</div>
					
					<img class="downImg" src="/media/img/quikid_windowsdown.png">
					<button type="button" class="btn orangeBtn orangeSmall" id="download_btn_windows">Download Windows Installer</button>
					<p>v.<span id='quikid_windows_version'><?php echo $quikid_windows_version?></span></p>
					<!--<a href="http://@@http_host@@/quikid_beta_download">Sign up for a beta tester</a>-->
				</div><!--col end-->

				<div class="text-center col-md-12 col-sm-12">
					<div id="download-state" style="display:none;">
						<h4>Requesting....</h4>
					</div>
					
					<img class="downImg" src="/media/img/quikid_androiddown.png">
					<button type="button" class="btn orangeBtn orangeSmall" id="download_btn_android">Download Android Package</button>
					<p>v.<span id='quikid_android_version'><?php echo $quikid_android_version?></span></p>
					<!--<a href="http://@@http_host@@/quikid_beta_download">Sign up for a beta tester</a>-->
				</div><!--col end-->
			
			</div><!--col end-->
			
		</div><!--row end-->
	</div><!--container end-->
</section>
