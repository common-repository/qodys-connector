<?php
$plugin_url = Qody::GetPluginDirectory();

$company_api_key = Qody::GetOption( 'company_api_key' );
$user_api_key = Qody::GetOption( 'user_api_key' );
?>
<?php QodyPages::GetHeader(); ?>

<div id="wrapper">

	<?php QodyPages::GetSidebar(); ?>
	
	<div id="main_container" class="main_container container_16 clearfix ui-sortable">
		
		<?php QodyPages::GetTopNav(); ?>
		
		<div class="flat_area grid_8">
			<p>&nbsp;</p>
			<p>Please enter your <strong>Qody API keys</strong> here.  For any of the more advanced features to be used,
			Qody must know who you are & which sets of data belong to you/your company.</p>
			<p>If you haven't done so already, you can signup for <strong>free</strong> at 
			<a target="_blank" href="http://qody.co">Qody.co</a>, 
			then navigate to your 
			<a target="_blank" href="http://qody.co/beta">management options</a> 
			to see your api keys.</p>
		</div>
		
		<div class="box grid_8 round_all">
			<h2 class="box_head grad_colour">Api Login</h2>
			<a href="#" class="grabber">&nbsp;</a>
			<a href="#" class="toggle">&nbsp;</a>
			<div class="toggle_container">
				<div class="block">
					<form method="post" action="<?= Qody::GetPluginDirectory(); ?>/forms/saveApi.php">
						
						<label>Company API Key</label> 
						<input title="A tooltip" type="text" class="full" name="company_api_key" value="<?= $company_api_key; ?>"> 
						
						<label>User API Key</label> 
						<input title="A tooltip" type="text" class="full" name="user_api_key" value="<?= $user_api_key; ?>">
				
						<button class="button_colour"><img height="24" width="24" alt="Bended Arrow Right" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/white/bended_arrow_right.png"><span>Submit</span></button>
					</form>
				</div>
			</div>
		</div>

		
	</div>
</div>
