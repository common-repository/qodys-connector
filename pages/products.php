<?php
$plugin_url = Qody::GetPluginDirectory();

$amazon_search_keyword = Qody::GetOption( 'amazon_search_keyword' );
$default_product_tag = Qody::GetOption( 'default_product_tag' );
?>
<?php QodyPages::GetHeader(); ?>

<div id="wrapper">

	<?php QodyPages::GetSidebar(); ?>
	
	<div id="main_container" class="main_container container_16 clearfix ui-sortable">
		
		<?php QodyPages::GetTopNav(); ?>
		
		<div class="flat_area grid_8">
			<h2>Qody's Product Display</h2>
			<p>This tool lets Qody show affiliate products from various networks via 
			<a href="<?= get_bloginfo('url'); ?>/wp-admin/widgets.php">widgets</a>
			on your site.</p>
			<p>By displaying these keyword-specified products, you'll have a chance to gain commissions on 
			any sales referred by visitors clicking through to their sales pages.</p>
			<p>For the time being, Qody only supports the display of <strong>Amazon products</strong>, but 
			will soon incorporate Clickbank info-products, Commission Junction items, custom products, and more.</p>
		</div>
		
		<form method="post" action="<?= Qody::GetPluginDirectory(); ?>/forms/saveProducts.php">
		
			<div class="box grid_8 round_all">
				<h2 class="box_head grad_colour">General Settings</h2>
				<a href="#" class="grabber">&nbsp;</a>
				<a href="#" class="toggle">&nbsp;</a>
				<div class="toggle_container">
					<div class="block">
	
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
						
						<button class="button_colour"><img height="24" width="24" alt="Bended Arrow Right" src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/white/bended_arrow_right.png"><span>Update & Save Product Settings</span></button>
					</div>
				</div>
			</div>
		</form>
		
	</div>
</div>
