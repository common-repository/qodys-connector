<?php
$plugin_url = Qody::GetPluginDirectory();
?>
<?php QodyPages::GetHeader(); ?>

<div id="wrapper">

	<?php QodyPages::GetSidebar(); ?>
	
	<div id="main_container" class="main_container container_16 clearfix ui-sortable">
		
		<?php QodyPages::GetTopNav(); ?>
		
		<div class="flat_area grid_16">
			<h2>Plugin Feedback</h2>
		</div>
		
		<div class="flat_area grid_6">
			<p>Please feel free to leave any feedback, criticizms, feature ideas, complains or praises - 
			they are all helpful.  The worst thing you can do in using this plugin 
			(besides abusing the redirector) is to never tell me how to improve it for you : )</p>
		</div>
		<div class="flat_area grid_10">
			<script type="text/javascript" charset="utf-8">
				var is_ssl = ("https:" == document.location.protocol);
				var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
				document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
			</script>

			<script type="text/javascript" charset="utf-8">
				var feedback_widget_options = {};

				feedback_widget_options.display = "inline";  
				feedback_widget_options.company = "qody";


				feedback_widget_options.style = "idea";

				var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
			</script>
		</div>		
	</div>
</div>
