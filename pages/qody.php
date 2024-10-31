<?php QodyPages::GetHeader(); ?>
<?php
$current_wizard_step = Qody::GetCurrentWizardStep();

if( $current_wizard_step == -1 )
	$skip_wizard = true;
else
	$skip_wizard = false;

Qody::CompleteWizardStep( 1 );

$shown = 'style="display:block;"';
$current = 'class="current"';
?>

<div id="wrapper">

	<?php QodyPages::GetSidebar(); ?>
	
	<div id="main_container" class="main_container container_16 clearfix ui-sortable">
		
		<?php QodyPages::GetTopNav(); ?>
		
		<?php
		if( $skip_wizard )
		{ ?>
		<div class="flat_area grid_6">
			<img src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/qody-finger-right-250.png" />
		</div>
		
		<div class="flat_area grid_10" style="margin-top:20px;">
			<h2>Welcome to Qody's Plugin!</h2>
			<p>To begin doing crazy, awesomely <strong>automated</strong> things, check out the nav bars up top & to the right right.  
			If you don't 
			<a href="<?= QodyPages::MakeLink( 'api_login' ); ?>">login</a> 
			via your company's 
			<a target="_blank" href="http://qody.co/beta">API credentials</a>, 
			you'll have limited access due to the inability to connect to Qody's 
			<a target="_blank" href="http://qody.co">main system</a>.</p>
			<p>Free users gain access to many of Qody's so-powerful-it's-nonsense tools, so have at it.  If you're 
			a part of <strong>Qody's Elite</strong>, you'll get the full dose of Qody's nutty, show-stopping automated 
			goodness.</p>
		</div>
		<?php			
		}
		else
		{ ?>
		<style>
		.wizard .wizard_steps ul li {
			min-width: 139px !important;
		}
		</style>
		
		<div class="box grid_16"> 
			<h2 class="box_head grad_colour round_top">Quick-start Wizard</h2> 
			<div class="toggle_container wizard">		
				<div id="progressbar" class="progress_in_header"><span>Progress</span></div> 
				<div class="wizard_steps"> 
					<ul class="clearfix"> 
						<li <?php if( $current_wizard_step == 1 ) echo $current; ?>> 
							<a href="#step_1" class="clearfix"> 
								<span>1. <strong>Welcome</strong></span> 
								<small>Howdy!</small> 
							</a> 
						</li> 
						<li <?php if( $current_wizard_step == 2 ) echo $current; ?>> 
							<a href="#step_2" class="clearfix"> 
								<span>2. <strong>Enter Api Keys</strong></span> 
								<small>Advanced features</small> 
							</a> 
						</li> 
						<li <?php if( $current_wizard_step == 3 ) echo $current; ?>> 
							<a href="#step_3" class="clearfix"> 
								<span>3. <strong>Setup Site Tracking</strong></span> 
								<small>Business monitoring</small> 
							</a> 
						</li> 
						<li <?php if( $current_wizard_step == 4 ) echo $current; ?>> 
							<a href="#step_4" class="clearfix"> 
								<span>4. <strong>Pick Products</strong></span> 
								<small>Commission earning</small> 
							</a> 
						</li> 
						<li <?php if( $current_wizard_step == 5 ) echo $current; ?>> 
							<a href="#step_5" class="clearfix"> 
								<span>5. <strong>Configure Redirector</strong></span> 
								<small>Traffic efficiency</small> 
							</a> 
						</li>
					</ul>		
				</div> 
			</div> 
				<div class="block grid_16 alpha omega wizard_content" style="height:360px;"> 
					<div id="step_1" class="step" <?php if( $current_wizard_step == 1 ) echo $shown; ?>> 
						<h1>1. Welcome to Qody's Plugin!</h1> 
						<hr class="grid_16 alpha omega"> 
						
						<div class="flat_area grid_6">
							<img style="width:200px;" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/qody-finger-right-medium.png" />
						</div>
						
						<div class="flat_area grid_9" style="margin-top:10px;">

							<p>To begin doing crazy, awesomely <strong>automated</strong> things, 
							complete this quick setup wizard to pick some settings.
							The more powerful tools require api keys both from you and on 
							behalf of your company, otherwise you'll have limited access due to 
							the inability to connect with Qody's main system.</p>
							<p>Free users gain access to many of Qody's so-powerful-it's-nonsense tools, so have at it.  If you're 
							a part of <strong>Qody's Elite</strong>, you'll get the full dose of Qody's nutty, show-stopping automated 
							goodness.</p>
							
							<hr class="grid_16 alpha omega"> 
							
							<button class="next_step button_colour round_all" id="step_2"><img height="24" width="24" alt="Bended Arrow Right" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/white/bended_arrow_right.png"><span>Begin the Wizard</span></button>
						</div>
						
						

					</div> 

					<div id="step_2" class="step" <?php if( $current_wizard_step == 2 ) echo $shown; ?>> 
						<h1>2. Enter Api Keys</h1> 
						<hr class="grid_16 alpha omega"> 
						
						<div class="flat_area grid_8">
							<p>&nbsp;</p>
							<p>Please enter your <strong>Qody Api keys</strong> here.  For any of the more advanced features to be used,
							Qody must know who you are & which sets of data belong to you/your company.</p>
							<p><a target="_blank" href="http://qody.co/beta">Click here to signup and/or get your Api keys.</a></p>
						</div>
						
						<div class="box grid_8 round_all">
							<h2 class="box_head grad_colour">Api Login</h2>
							<div class="toggle_container">
								<div class="block">
									<form method="post" action="<?= Qody::GetPluginDirectory(); ?>/forms/saveApi.php">
										
										<label>Company API Key</label> 
										<input title="A tooltip" type="text" class="full" name="company_api_key" value="<?= $company_api_key; ?>"> 
										
										<label>User API Key</label> 
										<input title="A tooltip" type="text" class="full" name="user_api_key" value="<?= $user_api_key; ?>">
										
										<input type="hidden" name="return_page" value="qody" />
										<button class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/white/bended_arrow_right.png"><span>Submit & Next Step</span></button>
									</form>
								</div>
							</div>
						</div>

					</div>		
				
					<div id="step_3" class="step" <?php if( $current_wizard_step == 3 ) echo $shown; ?>> 
						<h1>3. Setup Site Tracking</h1> 
						<hr class="grid_16 alpha omega"> 
						
						<div class="box grid_8 round_all">
							<h2 class="box_head grad_colour">Site Tracker Options</h2>

							<div class="toggle_container">
								<div class="block">
									<form method="post" action="<?= Qody::GetPluginDirectory(); ?>/forms/saveSitetracker.php">
										<div class="input_group">
											<label>
												Enable Qody's SiteTracker for this site:<br />
												<small>(starts to track this site's rank in Google)</small>
											</label> 
											<select name="sitetracker_enabled" id="sitetracker_enabled">  
												<option value="disable" <?php if ($sitetracker_enabled == 'disable') echo 'selected="selected"'; ?>>disable</option>
												<option value="enable" <?php if ($sitetracker_enabled == 'enable') echo 'selected="selected"'; ?>>enable</option>
											</select> 
										</div>
										
										<label>
											Keywords to Track (max 5):<br />
											<small>(separate by commas - ex. cats, candy, fluffy things)</small>
										</label> 
										<input type="text" name="keywords_to_track" class="full" value="<?= $keywords_to_track; ?>" /><br />    
										
										<input type="hidden" name="return_page" value="qody" />
										<button class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/white/bended_arrow_right.png"><span>Submit & Next Step</span></button>											
									</form>
								</div>
							</div>
						</div>
						<div class="flat_area grid_8">
							<p>This tool lets Qody track the rank of this site for particular keywords, once per day.</p>
							<p>Not only will he tell you that day's rank, but it's change from previous days and a graphical 
							overview of it's daily progress.</p>
						</div>
							
					</div>	
					
					<div id="step_4" class="step" <?php if( $current_wizard_step == 4 ) echo $shown; ?>> 
						<h1>4. Pick Products</h1> 
						<hr class="grid_16 alpha omega"> 
						
						
						<div class="flat_area grid_8">
							<p>This tool lets Qody show affiliate products from various networks via 
							<a href="<?= get_bloginfo('url'); ?>/wp-admin/widgets.php">widgets</a>
							on your site.</p>
							<p>By displaying these keyword-specified products, you'll have a chance to gain commissions on 
							any sales referred by visitors clicking through to their sales pages.</p>
							<p>For the time being, Qody only supports the display of <strong>Amazon products</strong>, but 
							will soon incorporate Clickbank info-products, Commission Junction items, custom products, and more.</p>
						</div>
					
						<div class="box grid_8 round_all">
							<h2 class="box_head grad_colour">General Settings</h2>

							<div class="toggle_container">
								<div class="block">
									<form method="post" action="<?= Qody::GetPluginDirectory(); ?>/forms/saveProducts.php">
										<label>
											Keyword for Products<br />
											<small>(based on search results of this keyword from Amazon)</small>
										</label>
										<input type="text" name="amazon_search_keyword" class="full" value="<?= $amazon_search_keyword; ?>" />
										
										<label>
											Default Associates Tag<br />
											<small>(for affiliate commissions on sales via product clicks)</small>
										</label>
										<input type="text" name="default_product_tag" class="large" value="<?= $default_product_tag; ?>" />
										
										<input type="hidden" name="return_page" value="qody" />
										<button class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/white/bended_arrow_right.png"><span>Submit & Next Step</span></button>
									</form>
								</div>
							</div>
						</div>
						
							
					</div>	
					
					<div id="step_5" class="step" <?php if( $current_wizard_step == 5 ) echo $shown; ?>> 
						<h1>5. Configure Redirector</h1> 
						<hr class="grid_16 alpha omega"> 
						
						<form method="post" action="<?= Qody::GetPluginDirectory(); ?>/forms/saveRedirect.php">
							<div class="flat_area grid_8">
								<p>This tool lets Qody take your "not-so-great" visitors (aka. the ones that are leaving) and send them wherever you want.</p>
								<p>While it might not make entire conceptual sense, it does increase conversions by about 100%.*</p>
								<p>Popups require a button click; Qody's redirect only requires the mouse to leave the top of the screen.</p>
								<p><small>*claim not regulated or approved by any legal entity that can sue.</small></p>
								
								<p><button class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/white/bended_arrow_right.png"><span>Save & Finish Wizard</span></button></p>
							</div>
							
							<div class="box grid_8 round_all">
								<h2 class="box_head grad_colour">General Settings</h2>
								<a href="#" class="grabber">&nbsp;</a>
								<a href="#" class="toggle">&nbsp;</a>
								<div class="toggle_container">
									<div class="block">
					
										<div class="input_group">
											<label>Redirect On?</label> 
											<select name="redirect_on" id="no">  
												<option value="no" label="no" <?php if ($redirect_on == 'no') echo 'selected="selected"'; ?>>no</option>
												<option value="yes" label="yes" <?php if ($redirect_on == 'yes') echo 'selected="selected"'; ?>>yes</option>
											</select>
										</div>
										
										<label>
											Default URL<br />
											<small>(for every post & page not specified below)</small>
										</label>
										<input type="text" name="redirect_url" class="full" value="<?= $redirect_url; ?>" />
										
										<label>
											Homepage URL<br />
											<small>(for redirecting the home page)</small>
										</label>
										<input type="text" name="home_redirect_url" class="full" value="<?= $redirect_home; ?>" />
										
										<input type="hidden" name="return_page" value="qody" />										
									</div>
								</div>
							</div>

						</form> 
						
					</div>											
				</div> 
			</div> 
		</div> 
		
		<script type="text/javascript"> 
		// wizard
		$('.wizard_steps ul li a').click(function(){
		
			$('.wizard_steps ul li').removeClass('current');
			$(this).parent('li').addClass('current');
			
			var step = $(this).attr('href');
			var step_num = $(this).attr('href').replace('#step_','');
			var step_multiplyby = (100 / $(".wizard_steps > ul > li").size());
			var prog_val = (step_num*step_multiplyby);
			
			$( "#progressbar").progressbar({ value: prog_val });
			
			$('.wizard_content').children().hide();
			$('.wizard_content').children(step).fadeIn();
			
			return false;
		});
		
		$('button.next_step').click(function(){
			
			var step = $(this).attr('id');
			var hash_step = ('#'+step);
					
			var step_num = $(this).attr('id').replace('step_','');
			var step_multiplyby = (100 / $(".wizard_steps > ul > li").size());
			var prog_val = (step_num*step_multiplyby);
			
			$( "#progressbar").progressbar({ value: prog_val });
			
			$('.wizard_steps ul li').removeClass('current');
			$('a[href='+ hash_step +']').parent().addClass('current');
			
			$('.wizard_content').children().hide();
			$('.wizard_content').children(hash_step).fadeIn();
			
			return false;		
		});
		
		$(function() {
			$( "#progressbar").progressbar({ value: <?= (100/5) * $current_wizard_step; ?> });
		});
		
		</script> 
		
		<?php
		} ?>
		
	</div>
</div>