<?php
class QodyPages
{
	static function LoadMenu()
	{
		$page_title = "Qody";
		$menu_title = "Qody";
		$capability = "manage_options";
		$menu_slug = "qody";
		$function = "qody_page_shell";
		$icon_url = "https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/qody-icon.png";
		$position = 1;
		
		if( $GLOBALS['menu'] )
		{
			foreach( $GLOBALS['menu'] as $key => $value )
			{
				if( strtolower($value[0]) == 'dashboard' )
				{
					$position = $key+1;
					break;
				}
			}
		}
		
		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		
		$parent_slug = 'qody';
		$page_title = "Extra page";
		$menu_title = "Extra Page";
		$capability = "manage_options";
		$menu_slug = 'qody_extra';
		$function = "qody_page_sitetracker";
		//add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
	}
	
	static function GetCurrentPage()
	{
		$the_page = $_GET['pg'];
		
		if( !$the_page )
			$the_page = 'qody';
		
		return $the_page;
	}

	static function GetHeader()
	{
		$plugin_url = Qody::GetPluginDirectory(); ?>
	<link rel="stylesheet" type="text/css" href="<?= $plugin_url; ?>/assets/css/all.css" media="screen"> 
		
	<link rel="stylesheet" type="text/css" href="<?= $plugin_url; ?>/assets/css/switcher.css" media="screen"> 
	
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]--> 
	<!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]--> 
	
	<!-- Load JQuery -->		
	<script type="text/javascript" src="https://qody.s3.amazonaws.com/connector_plugin/assets/js/jquery.min.js"></script> 
	
	<!-- Load JQuery UI --> 
	<script type="text/javascript" src="https://qody.s3.amazonaws.com/connector_plugin/assets/js/jquery-ui.min.js"></script> 
	
	<!-- Load Interface Plugins --> 
	<script type="text/javascript" src="https://qody.s3.amazonaws.com/connector_plugin/assets/js/jquery.uniform.js"></script> 
	<script type="text/javascript" src="https://qody.s3.amazonaws.com/connector_plugin/assets/js/jquery.iphoneui.js"></script> 
	<script type="text/javascript" src="https://qody.s3.amazonaws.com/connector_plugin/assets/js/jquery.ui.totop.js"></script> 
	
	<!-- This file configures the various jQuery plugins for Adminica. Contains links to help pages for each plugin. --> 
	<script type="text/javascript" src="https://qody.s3.amazonaws.com/connector_plugin/assets/js/adminica_ui.js"></script>
	<?php		
	}
	
	static function MakeLink( $page )
	{
		return get_bloginfo('url').'/wp-admin/admin.php?page=qody&pg='.$page;
	}
	
	static function GetSidebar()
	{
		$plugin_url = Qody::GetPluginDirectory(); ?>
	<div id="sidebar">
		<div class="cog">+</div>
		<?php
		if( QodyPages::GetCurrentPage() != 'qody' )
		{ ?>
		<a href="admin.php?page=qody" class="logo">
			<span>Qody</span></a>
		<?php
		} ?>
		<div class="user_box round_all clearfix">
			<img src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/qody-guest.png" width="55" alt="Profile Pic">
			<div class="user_links">
				<h2>Free User</h2>
				<h3><a class="text_shadow" href="#">Guest</a></h3>
				<ul>
					<li><a target="_blank" href="http://qody.co/beta">api keys</a><span class="divider">|</span></li>
					<li><a href="<?= QodyPages::MakeLink( 'api_login' ); ?>">login</a></li>
				</ul>
			</div>
		</div>
		<!-- #user_box -->
		
		<ul id="side_links" class="text_shadow">
			<li><a href="http://qody.co/blog"><img src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/grey/book_large.png"/>Qody's Blog</a>
			<li><a href="http://facebook.com/Qody.co"><img src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/grey/facebook.png"/>Qody's Fanpage</a></li>
			<li><a href="http://twitter.com/QodysAutomation"><img src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/grey/twitter.png"/>Qody's Twitter</a></li>
			<li><a href="https://plus.google.com/103434391887961438753"><img src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/grey/chrome.png"/>John's Google+</a></li>
		</ul>
	
	</div>
	<!-- #sidebar -->
	<?php
	}
	
	static function GetTopNav()
	{
		$fields = array();
		
		$item = array();
		$item['slug'] = 'qody';
		$item['name'] = 'Dashboard';
		$item['icon'] = 'laptop.png';
		$item['href'] = QodyPages::MakeLink( $item['slug'] );
		$fields[] = $item;
		
		$item = array();
		$item['slug'] = 'redirector';
		$item['name'] = 'Redirector';
		$item['icon'] = 'bended_arrow_up.png';
		$item['href'] = QodyPages::MakeLink( $item['slug'] );
		$fields[] = $item;
		
		$item = array();
		$item['slug'] = 'site_tracker';
		$item['name'] = 'Site Tracker';
		$item['icon'] = 'graph.png';
		$item['href'] = QodyPages::MakeLink( $item['slug'] );
		$fields[] = $item;
		
		$item = array();
		$item['slug'] = 'ob_linker';
		$item['name'] = 'Linker';
		$item['icon'] = 'link.png';
		$item['href'] = QodyPages::MakeLink( $item['slug'] );
		//$fields[] = $item;
		
		$item = array();
		$item['slug'] = 'products';
		$item['name'] = 'Products';
		$item['icon'] = 'price_tags.png';
		$item['href'] = QodyPages::MakeLink( $item['slug'] );
		$fields[] = $item;
		
		$item = array();
		$item['slug'] = 'api_login';
		$item['name'] = 'API Login';
		$item['icon'] = 'locked_2.png';
		$item['href'] = QodyPages::MakeLink( $item['slug'] );
		$fields[] = $item;

		$item = array();
		$item['slug'] = 'feedback';
		$item['name'] = 'Feedback';
		$item['icon'] = 'facebook_like.png';
		$item['alert'] = 'new!';
		$item['href'] = QodyPages::MakeLink( $item['slug'] );
		$fields[] = $item; ?>
	<div id="nav_top" class="clearfix round_top">
		<ul class="clearfix">
			
			<?php
			$current_page = QodyPages::GetCurrentPage();
			
			if( $fields )
			{
				foreach( $fields as $key => $value )
				{
					$selected = '';
					$icon_color = 'grey';
					
					if( $current_page == $value['slug'] )
					{
						$selected = 'current';
						$icon_color = 'white';
					}

					if( $value['alert'] )
						$alert = '<span class="alert badge alert_blue">'.$value['alert'].'</span>';
					else
						$alert = ''; ?>
			<li class="<?= $selected; ?>">
				<a href="<?= $value['href']; ?>"><img src="https://qody.s3.amazonaws.com/connector_plugin/assets/images/icons/<?= $icon_color; ?>/<?= $value['icon']; ?>"><?= $value['name']; ?></a>
				<?= $alert; ?>
			</li>
				<?php
				}
			} ?>

		</ul>
	</div>
	<!-- #nav_top -->
		<?php
		Qody::DisplayMessages();
	}
}
?>