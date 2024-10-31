<?php
global $qody_db_version;
$qody_db_version = "1.0";

add_action('plugins_loaded', 'Qody_Products::DatabaseSetup');

//Qody_Products::Deactivate();
Qody_Products::HandleCron();

//for( $i = 0; $i < 50; $i++ )
//{
//$timestamp = wp_next_scheduled( 'hourly_amazon_cron' );
//wp_unschedule_event($timestamp, 'hourly_amazon_cron' );
//}


class Qody_Products
{
	static function HandleCron()
	{
		return;
		
		$slug = 'hourly_amazon_cron';
		
		if( !wp_next_scheduled( $slug ) )
		{
			wp_schedule_event( time(), 'hourly', $slug );
		}
		
		add_action( $slug, 'Qody_Products::DoCron');

		register_deactivation_hook(__FILE__, 'Qody_Products::Deactivate');
	}
	
	static function ResetCron()
	{
		$slug = 'hourly_amazon_cron';
		
		$timestamp = wp_next_scheduled( 'hourly_amazon_cron' );
		
		if( $timestamp )
		{
			wp_unschedule_event($timestamp, 'hourly_amazon_cron' );
		}
		
		if( !wp_next_scheduled( $slug ) )
		{
			wp_schedule_event( time(), 'hourly', $slug );
		}
	}
	
	static function DoCron()
	{
		$amazon_api = new Amazon_Api();
		
		$items = $amazon_api->Amazon_GetAllItems();

		$amazon_api->Amazon_InsertItemsToDatabase( $items );
	}

	static function Deactivate()
	{
		wp_clear_scheduled_hook( Qody_Products::$cron_slug );
	}
	
	static function DatabaseSetup()
	{
		global $wpdb;
		global $qody_db_version;
		
		$table_name = $wpdb->prefix . "amazon_items";
		
		$result = mysql_query
		( 
			'CREATE TABLE IF NOT EXISTS '.$table_name.' (
			id int(11) NOT NULL AUTO_INCREMENT,
			keyword varchar(255) NOT NULL,
			asin varchar(255) NOT NULL,
			detail_page_url text NOT NULL,
			sales_rank int(20) NOT NULL,
			image_small text NOT NULL,
			image_medium text NOT NULL,
			image_large text NOT NULL,
			binding text NOT NULL,
			brand text NOT NULL,
			color text NOT NULL,
			ean varchar(255) NOT NULL,
			label text NOT NULL,
			price_list_amount int(11) NOT NULL,
			price_list_formatted varchar(255) NOT NULL,
			manufacturer text NOT NULL,
			product_group varchar(255) NOT NULL,
			publisher text NOT NULL,
			studio text NOT NULL,
			title text NOT NULL,
			upc varchar(255) NOT NULL,
			price_new_lowest_amount int(11) NOT NULL,
			price_new_lowest_formatted varchar(255) NOT NULL,
			price_used_lowest_amount int(11) NOT NULL,
			price_used_lowest_formatted varchar(255) NOT NULL,
			available_new int(11) NOT NULL,
			available_used int(11) NOT NULL,
			PRIMARY KEY (id)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1809 ;'
		);

		add_option("qody_db_version", $qody_db_version);
	}
	
	static function Amazon_GetRandom( $keyword )
	{
		global $wpdb;
		
		$table_name = $wpdb->prefix . "amazon_items";
		$keyword = Qody::MakeSlug( $keyword );
		
		$query = mysql_query( "SELECT * FROM $table_name WHERE keyword = '$keyword' ORDER BY RAND()" );
		
		if( $query )
		{
			while( $nextItem = mysql_fetch_array( $query ) )
			{
				$item = array();
				$item['url'] = $nextItem['detail_page_url'];
				$item['name'] = $nextItem['title'];
				$item['data'] = $nextItem;
				
				$theList[] = $item;
			}
			
			return $theList;
		}
	}
	
	static function Amazon_GetCompanies( $keyword, $numCompanies = '6' )
	{
		global $wpdb;
		
		$table_name = $wpdb->prefix . "amazon_items";
		$keyword = Qody::MakeSlug( $keyword );
		
		$logic = 'bulk';
		$companyList = array();
		$productCounter = array();
		
		$query = mysql_query( "SELECT * FROM $table_name WHERE keyword = '$keyword' ORDER BY sales_rank DESC" );
		
		if( Qody::IsValidQuery( $query ) )
		{	
			while( $nextItem = mysql_fetch_array( $query ) )
			{
				$brand = $nextItem['label'];
				
				if( strlen( trim( $brand ) ) <= 2 )
					continue;
					
				$productCounter[ $brand ]++;
			}
		}
		
		asort( $productCounter );
		$productCounter = array_reverse( $productCounter );
		
		$results = array_splice( $productCounter, 0, $numCompanies );

		if( $results )
		{
			$theList = array();
			
			foreach( $results as $key => $value )
			{
				$item = array();
				$item['name'] = $key.' ('.$value.')';
				$item['url'] = 'http://www.amazon.com/gp/redirect.html?ie=UTF8&location=http%3A%2F%2Fwww.amazon.com%2Fs%3Fie%3DUTF8%26x%3D0%26ref_%3Dnb_sb_noss%26y%3D0%26field-keywords%3D'.htmlentities( $key ).'%26url%3Dsearch-alias%253Daps&tag='.$aaid.'&linkCode=ur2&camp=1789&creative=390957';
				$theList[] = $item;
			}
		}

		return $theList;
	}
	
	static function Amazon_GetBestSellers( $keyword )
	{
		global $wpdb;
		
		$table_name = $wpdb->prefix . "amazon_items";
		$keyword = Qody::MakeSlug( $keyword );
		
		$query = mysql_query( "SELECT * FROM $table_name WHERE keyword = '$keyword' ORDER BY sales_rank DESC" );
		
		if( $query )
		{
			while( $nextItem = mysql_fetch_array( $query ) )
			{
				$item = array();
				$item['url'] = $nextItem['detail_page_url'];
				$item['name'] = $nextItem['title'];
				$item['data'] = $nextItem;
				
				$theList[] = $item;
			}
			
			return $theList;
		}
	}
}
?>