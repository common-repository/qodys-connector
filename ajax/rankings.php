<?php
require_once( '../index.php' );

$snapshots = Qody::ConnectWithSnapshots();

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

	<div class="side_holder"> 
		<ul class="tab_sider clearfix" style="right:80%"> 
			<?php
			$char_iter = 96;
			foreach( $snapshots['data'] as $key => $value )
			{
				$char_iter++; ?>
			<li><a href="#tabs-<?= chr($char_iter); ?>"><?= $key; ?></a></li> 
			<?php
			} ?>
		</ul> 
	</div> 
	
	<?php
	$char_iter = 96;
	foreach( $snapshots['data'] as $key => $value )
	{
		$char_iter++; ?>
	<div id="tabs-<?= chr($char_iter); ?>" class="block tab_sider" style="min-height:400px; margin-left:20%;"> 
		<div class="content"> 
			
			<script id="source"> 
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
				
				var plot = $.plot($("#placeholder-<?= $char_iter; ?>"), [{ label: "Google Rank",  data: d}], options);
			});
			</script> 
			
			<div id="placeholder-<?= $char_iter; ?>" style="width:520px;height:360px;font-size:20px; font-weight:bold;"></div>
		</div>
	</div> 
	<?php
	} ?>

	 
</div>	
<?php
} ?>