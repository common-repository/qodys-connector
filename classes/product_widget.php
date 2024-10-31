<?php
add_action( 'widgets_init', 'example_load_widgets' );

function example_load_widgets()
{
	register_widget( 'Qody_Product_Widget' );
}

add_action('wp_print_styles', 'AddProductStylesheet');

/*
 * Enqueue style-file, if it exists.
 */

function AddProductStylesheet()
{
	$myStyleUrl = WP_PLUGIN_URL . '/qodys-connector/assets/css/products.css';
	$myStyleFile = WP_PLUGIN_DIR . '/qodys-connector/assets/css/products.css';
	if ( file_exists($myStyleFile) ) {
		wp_register_style('myStyleSheets', $myStyleUrl);
		wp_enqueue_style( 'myStyleSheets');
	}
}
	
class Qody_Product_Widget extends WP_Widget
{
	/**
	 * Widget setup.
	 */
	function Qody_Product_Widget() {
		/* Widget settings. */
		$widget_ops = array();
		$widget_ops['classname'] = 'qody-products';
		$widget_ops['description'] = 'Use this widget to display affiliate products on your site.';
		
		/* Widget control settings. */
		$control_ops = array();
		$control_ops['width'] = '100%';
		$control_ops['height'] = 350;
		//$control_ops['id_base'] = 'qody-products';

		/* Create the widget. */
		$this->WP_Widget( 'qody-products', "Qody's Product Display", $widget_ops, $control_ops );
	}

	
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance )
	{
		//ItemDebug( $args );
		//ItemDebug( $instance );
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		
		$type = $instance['type'];
		$name = $instance['name'];
		$aaid = $instance['tag'];
		
		$product_size = $instance['product_size'];
		
		if( !$aaid )
			$aaid = Qody::GetOption('default_product_tag');
		
		$keyword = Qody::GetOption('amazon_search_keyword');
		
		$product_count = $instance['product_count'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		if( $type == 'best_sellers' )
			$products = Qody_Products::Amazon_GetBestSellers( $keyword );
		else if( $type == 'random' )
			$products = Qody_Products::Amazon_GetRandom( $keyword );
		else if( $type == 'best_sellers_brand_list' )
			$products = Qody_Products::Amazon_GetCompanies( $keyword, $product_count );
			
		if( !$products )
		{
			echo $after_widget;
			return;
		}
		
		$iter = 0;
		$clear = '<div style="clear:both;"></div>';
		?>
		<div id="product-theme-1">
			<div class="listing">
				<ul>
		<?php
		
		switch( $product_size )
		{
			case 'small':
				$container_width = 100;
				$image_width = 50;
				break;
				
			case 'medium':
				$container_width = 200;
				$image_width = 100;
				break;
				
			case 'large':
				$container_width = 300;
				$image_width = 150;
				break;
				
			default:
				$container_width = 200;
				$image_width = 100;
				break;
				
		}
		
		//Qody::ItemDebug( $instance );
		foreach( $products as $key => $value )
		{
			$iter++;
			
			if( $iter > $product_count )
				break;
			//Qody::ItemDebug( $value );
			
			
			$name = $value['name'];
			$link = $value['url'];
			$link = str_replace( 'qody-20', $aaid, $link );
			
			$img = $value['data']['image_medium'];
			
			$usedPrice = $value['data']['price_new_lowest_formatted'];
			$price = $newPrice = $value['data']['price_used_lowest_formatted'];
			//Qody::ItemDebug($instance);
			if( $usedPrice )
				$price = $usedPrice;
			
			if( $instance['type'] != 'best_sellers_brand_list' )
			{ ?>
					<li style="width:<?= $container_width; ?>px;">
						<table>
							<tr>
								<td valign="middle" style="vertical-align:middle;">
									<div style="text-align:center;">
										<a href="<?= $link; ?>" class="thumb">
											<img style="max-width:<?= $image_width; ?>px;" src="<?= $img; ?>" alt="">
										</a>
									</div>
								</td>
								<td valign="middle" style="vertical-align:middle;">
									<a style="width:100%;" href="<?= $link; ?>" class="title"><?= $name; ?></a>
									
									<div style="clear:both;"></div>
									<p style="width:100%;" class="colr bold price"><?= $price; ?></p>
								</td>
							</tr>
						</table>
						
						<div style="clear:both;"></div>
					</li>
				<?php
				}
				else
				{ ?>
					<li style="margin-bottom:0px;">
						<a href="<?= $link; ?>" class="title" style="text-align:left;"><?= $name; ?></a>
					</li>
				<?php							
				}
			} ?>
				</ul>
			</div>
		</div>
		
		<div style="clear:both;"></div>
		<?php
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );

		/* No need to strip tags for sex and show_sex. */
		$instance['type'] = $new_instance['type'];
		$instance['tag'] = $new_instance['tag'];
		$instance['product_count'] = $new_instance['product_count'];
		$instance['product_size'] = $new_instance['product_size'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance )
	{
		/* Set up some default widget settings. */
		$defaults = array();
		$defaults['title'] = 'Suggested Items';
		$defaults['type'] = 'best_sellers';
		$defaults['product_count'] = 4;
		$defaults['tag'] = Qody::GetOption( 'default_product_tag' );
		$defaults['display_direction'] = 'verticle';
		$defaults['product_size'] = 'medium';

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e('Title:', 'hybrid'); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:96%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'tag' ); ?>">
				<?php _e('aaid:', 'hybrid'); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'tag' ); ?>" name="<?php echo $this->get_field_name( 'tag' ); ?>" value="<?php echo $instance['tag']; ?>" style="width:46%;" />
		</p>
		
		<!-- Type: Select Box -->
		
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>">
				What to Show:
			</label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat" style="width:100%;">
				<option value="best_sellers" <?php if ( 'best_sellers' == $instance['type'] ) echo 'selected="selected"'; ?>>Best Selling Products</option>
				<option value="best_sellers_brand_list" <?php if ( 'best_sellers_brand_list' == $instance['type'] ) echo 'selected="selected"'; ?>>Best Selling Brand List</option>
				<option value="random" <?php if ( 'random' == $instance['type'] ) echo 'selected="selected"'; ?>>Random Products</option>
			</select>
		</p>
		<p>
			<label>Product Size:</label>
			<table style="width:96%;">
				<tr>
					<td align="center">	
						<label><input value="small" class="radio" type="radio" <?php checked( $instance['product_size'], 'small' ); ?> name="<?php echo $this->get_field_name( 'product_size' ); ?>" /> Small</label>
           			</td>
					<td align="center">
						<label><input value="medium" class="radio" type="radio" <?php checked( $instance['product_size'], 'medium' ); ?> name="<?php echo $this->get_field_name( 'product_size' ); ?>" /> Medium</label>
            		</td>
					<td align="center">
						<label><input value="large" class="radio" type="radio" <?php checked( $instance['product_size'], 'large' ); ?> name="<?php echo $this->get_field_name( 'product_size' ); ?>" /> Large</label>
					</td>
				</tr>
			</table>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'product_count' ); ?>">
				<?php _e('How Many Items?:', 'everniche-products'); ?>
			</label>
			<select style="width:50px;" id="<?php echo $this->get_field_id( 'product_count' ); ?>" name="<?php echo $this->get_field_name( 'product_count' ); ?>" class="widefat">
				<?php
						for( $i = 1; $i <= 20; $i++ )
						{
							?>
				<option value="<?= $i; ?>" <?php if ( $i == $instance['product_count'] ) echo 'selected="selected"'; ?>>
				<?= $i; ?>
				</option>
				<?php
		
						} ?>
			</select>
		</p>
<?php
	}
}
?>