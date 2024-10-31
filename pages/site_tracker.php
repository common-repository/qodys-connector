<?php
$plugin_url = Qody::GetPluginDirectory();

$sitetracker_enabled = Qody::GetOption( 'sitetracker_enabled' );
$keywords_to_track = Qody::GetOption( 'keywords_to_track' );

$maxLength = 50;
$domain = get_bloginfo('url');

if( strlen( $domain ) > $maxLength )
	$domain = substr( $domain, 0, $maxLength ).'...';

$snapshots = Qody::ConnectWithSnapshots();
?>
<?php QodyPages::GetHeader(); ?>

<div id="wrapper">

	<?php QodyPages::GetSidebar(); ?>
	
	<div id="main_container" class="main_container container_16 clearfix ui-sortable">
		
		<?php QodyPages::GetTopNav(); ?>
		
		<div class="box grid_8 round_all">
			<h2 class="box_head grad_colour">Site Tracker Options</h2>
			<a href="#" class="grabber">&nbsp;</a>
			<a href="#" class="toggle">&nbsp;</a>
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
				
						<button class="button_colour"><img height="24" width="24" alt="Bended Arrow Right" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/white/bended_arrow_right.png"><span>Update & Save</span></button>
					</form>
				</div>
			</div>
		</div>
		<div class="flat_area grid_8">
			<h2>Qody's SiteTracker</h2>
			<p>This tool lets Qody track the rank of this site for particular keywords, once per day.</p>
			<p>Not only will he tell you that day's rank, but it's change from previous days and a graphical 
			overview of it's daily progress.</p>
			<p>If you don't see any data yet, make sure you a) have Qody's SiteTracker enabled, and b) are 
			ranked in the top 100 spots, as that's how far down the rankings Qody checks each day.</p>
		</div>
		
		<div class="flat_area grid_16">
			<h2>Google Rankings for <?= $domain; ?></h2>
		</div>
		
		<div class="flat_area grid_16" id="rankings_container"></div>
		
			<?php
			if( !$snapshots )
			{ ?>
			<div class="flat_area grid_16">
				<p>No rankings yet... check back within 24 hours, otherwise pick different keywords that you 
				might be ranking better for.</p>
			</div>
			<?php
			}
			else
			{ ?>

			<script>
			$ = jQuery; //undo .conflict(); 
			</script>

			<style>
			.ui-tabs .ui-tabs-hide {
				position: absolute !important;
				left: -10000px !important;
			}
			</style>
				
			<div class="box grid_16 round_all tabs">

				<ul class="tab_header indented grad_colour clearfix"> 
					<?php
					$char_iter = 96;
					foreach( $snapshots['data'] as $key => $value )
					{
						$char_iter++; ?>
					<li><a href="#tabs-<?= chr($char_iter); ?>"><?= $key; ?></a></li> 
					<?php
					} ?>
				</ul>
				<a href="#" class="grabber">&nbsp;</a> 
				<a href="#" class="toggle">&nbsp;</a> 
				<div class="toggle_container"> 
				
				<?php
				$char_iter = 96;
				foreach( $snapshots['data'] as $key => $value )
				{
					$char_iter++; ?>
					<div id="tabs-<?= chr($char_iter); ?>" class="block"> 
						<div class="content"> 
							
							<script> 
							$(document).ready(function() {
								var d = [
								<?php
								if( $value )
								{
									$iter = 0;
									foreach( $value as $key2 => $value2 )
									{
										$iter++;
										$rank = $value2['rank'];
										
										if( $rank == -1 )
											$rank = 101; ?>
								[<?= $key2; ?>000,<?= $rank; ?>]		
									<?php
									if( $iter < count( $value ) )
										echo ',';
									}
								} ?>
								];
								
								// first correct the timestamps - they are recorded as the daily
								// midnights in UTC+0100, but Flot always displays dates in UTC
								// so we have to add one hour to hit the midnights in the plot
								for (var i = 0; i < d.length; ++i)
								  d[i][0] += 60 * 60 * 1000;
							 
								// helper for returning the weekends in a period
								function weekendAreas(axes) {
									var markings = [];
									var d = new Date(axes.xaxis.min);
									// go to the first Saturday
									d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1)))
									d.setUTCSeconds(0);
									d.setUTCMinutes(0);
									d.setUTCHours(0);
									var i = d.getTime();
									do {
										// when we don't set yaxis, the rectangle automatically
										// extends to infinity upwards and downwards
										markings.push({ xaxis: { from: i, to: i + 1 * 24 * 60 * 60 * 1000 } });
										i += 2 * 24 * 60 * 60 * 1000;
									} while (i < axes.xaxis.max);
							 
									return markings;
								}
								
								var options = {
									threshold: { below: 10, color: "rgb(200, 20, 30)" },
									legend: { position: 'sw' },
									xaxis: { mode: "time", tickLength: 1 },	
									yaxis: 
									{ 
										ticks: 10,
										min: 1,
										max: 100,
										transform: function (v) { return -v; }
									},
									series: {
										lines: { show: true },
										points: { show: true }
									},	
									grid: { 
										markings: weekendAreas,
										backgroundColor: { colors: ["#fff", "#fff"] }
									}
									
								};
								
								var plot = $.plot($("#flot_chart_<?= $char_iter; ?>"), [{ label: "Google Rank",  data: d}], options);
							});
							</script> 
							
							<div id="flot_chart_<?= $char_iter; ?>" class="flot"> </div>

						</div>
					</div> 
				<?php
				} ?>
				</div>
			</div>	
			<?php
			} ?>
		</div>

	</div>
</div>

<script type='text/javascript' src='<?= $plugin_url; ?>/assets/flot/excanvas.js'></script>
<script type='text/javascript' src='<?= $plugin_url; ?>/assets/flot/jquery.flot.js'></script>
<script type='text/javascript' src='<?= $plugin_url; ?>/assets/flot/jquery.flot.resize.js'></script>
<script type='text/javascript' src='<?= $plugin_url; ?>/assets/flot/jquery.flot.pie.js'></script>

<script type="text/javascript" src="<?= $plugin_url; ?>/assets/js/adminica_charts.js"></script>