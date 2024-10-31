<?php
$plugin_url = Qody::GetPluginDirectory();

$redirect_url = Qody::GetOption( 'redirect_url' );
$redirect_home = Qody::GetOption( 'redirect_home' );
$redirect_on = Qody::GetOption( 'redirect_on' );
$redirect_pages = Qody::GetOption( 'redirect_pages' );
$redirect_posts = Qody::GetOption( 'redirect_posts' );
?>
<?php QodyPages::GetHeader(); ?>

<div id="wrapper">

	<?php QodyPages::GetSidebar(); ?>
	
	<div id="main_container" class="main_container container_16 clearfix ui-sortable">
		
		<?php QodyPages::GetTopNav(); ?>
		
		<div class="flat_area grid_8">
			<h2>Qody's Redirector</h2>
			<p>This tool lets Qody take your "not-so-great" visitors (aka. the ones that are leaving) and send them wherever you want.</p>
			<p>While it might not make entire conceptual sense, it does increase conversions by about 100%.*</p>
			<p>Unlike pop-ups, this redirect cannot be avoided and doesn't add add in extra steps for a user to take 
			before being sent to the desired location.  Popups require a button click; Qody's redirect only 
			requires the mouse to leave the top of the screen.</p>
			<p><small>*claim not regulated or approved by any legal entity that can sue.</small></p>
		</div>
		
		<form method="post" action="<?= Qody::GetPluginDirectory(); ?>/forms/saveRedirect.php">
		
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
					</div>
				</div>
			</div>
		
			<div class="box grid_16 tabs"> 
				<ul class="tab_header grad_colour clearfix"> 
					<li><a href="#tabs-1">Pages Settings</a></li>
					<li><a href="#tabs-2">Posts Settings</a></li>
				</ul> 
				<a href="#" class="grabber">&nbsp;</a> 
				<a href="#" class="toggle">&nbsp;</a> 
				<div class="toggle_container"> 

					<div id="tabs-1" class="block"> 
						<div class="content"> 
							<h1>Page Settings</h1> 
							<p>Here you can create optional custom redirects for specific pages.  To delete a row, clear the text field & save.</p>
							
					<?php
					if( $redirect_pages )
					{ $iter = 0;
						foreach( $redirect_pages as $key => $value )
						{ $iter++;
							if( function_exists( get_blog_post ) )
								$pageData = get_blog_post( $wpdb->blogid,$key );
							else
								$pageData = Qody::GetPostData( $key ); ?>
							<div class="flat_area grid_8">
								<strong><?= $iter; ?>) <?= $pageData->post_title; ?></strong>
								<input type="hidden" name="page_redirect_id[]" value="<?= $key; ?>" />
							</div>
							<div class="flat_area grid_8">
								<input type="text" name="page_redirect_url[]" class="full" value="<?= $value; ?>" />
							</div>
	
							<?php
							}
						} ?>
							<div class="flat_area grid_8">
								
								<div class="input_group">
									<label>Select page for a new redirect</label> 
									<select name="page_redirect_id[]">
										<option value="-1">Select page</option> 
										<?php
										$pages = Qody::GetCurrentPages();
										if( $pages )
										{
											foreach( $pages as $key => $value )
											{ ?>
										<option value="<?= $value['id']; ?>"><?= $value['title']; ?></option>
											<?php
											}
										} ?>
										
									</select>
								</div>
	
							</div>
							<div class="flat_area grid_8">
								<label>
									Enter a valid url<br />
									<small>(e.g. http://google.com)</small>
								</label>
								<input type="text" name="page_redirect_url[]" class="full" value="" />
							</div>
						</div> 
					</div>
					<div id="tabs-2" class="block"> 
						<div class="content"> 
							<h1>Post Settings</h1>
							<p>Here you can create optional custom redirects for specific posts.  To delete a row, clear the text field & save.</p>
	
							<?php
							if( $redirect_posts )
							{ $iter = 0;
								foreach( $redirect_posts as $key => $value )
								{ $iter++;
									if( function_exists( get_blog_post ) )
										$postData = get_blog_post( $wpdb->blogid,$key );
									else
										$postData = Qody::GetPostData( $key ); ?>
								<div class="flat_area grid_8">
								
									<strong><?= $iter; ?>) <?= $postData->post_title; ?></strong>
									<input type="hidden" name="post_redirect_id[]" value="<?= $key; ?>" />
								</div>
								<div class="flat_area grid_8">
									<input type="text" name="post_redirect_url[]" class="full" value="<?= $value; ?>" />
								</div>
									<?php
									}
								} ?>
								<div class="flat_area grid_8">
									<div class="input_group">
										<label>Select post for a new redirect</label> 
										<select name="post_redirect_id[]">
											<option value="-1">Select post</option> 
											<?php
											$posts = Qody::GetCurrentPosts();
											if( $posts )
											{
												foreach( $posts as $key => $value )
												{ ?>
											<option value="<?= $value['id']; ?>"><?= $value['title']; ?></option>
												<?php
												}
											} ?>
											
										</select>
									</div>
								</div>
								<div class="flat_area grid_8">
									<label>
										Enter a valid url<br />
										<small>(e.g. http://google.com)</small>
									</label>
									<input type="text" name="post_redirect_url[]" class="full" value="" />
								</div>
							</div>
						</div> 
					</div>
				</div> 
				
				<button class="button_colour"><img height="24" width="24" alt="Bended Arrow Right" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/white/bended_arrow_right.png"><span>Update & Save Redirector Settings</span></button>
			</div>			
		</form>
		
	</div>
</div>