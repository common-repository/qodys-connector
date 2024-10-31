<?php
class Amazon_Api
{
	public $public_key = "AKIAI3DOR66MKLGFXMWQ";
	public $private_key = "CVFUBC5rT9S1wXEb462oBecMfEMNw1JJ1X0/H4hd";
	
	//countries with a local Amazon
	public $Alocale = array(
	  'ca' => 'Canada' ,  // (since 2005-01-21)
	  'de' => 'Germany',
	  'fr' => 'France' ,  // (since 2005-01-21)
	  'jp' => 'Japan'  ,
	  'uk' => 'UK'     ,
	  'us' => 'USA'    ,
	);
	//You can remove or disable the local Amazon's here that you don't want to support.
	
	//servers per country
	public $Aserver = array(
	  'ca' => array(
		'ext' => 'ca'                      ,  //Canadian normal server
		'nor' => 'http://www.amazon.ca'    ,  //Canadian normal server
		'xml' => 'http://xml.amazon.com'   ,  //Canadian xml server
	  ),
	  'de' => array(
		'ext' => 'de'                      ,  //German normal server
		'nor' => 'http://www.amazon.de'    ,  //German normal server
		'xml' => 'http://xml-eu.amazon.com',  //German xml server
	  ),
	  'fr' => array(
		'ext' => 'fr'                      ,  //French normal server
		'nor' => 'http://www.amazon.fr'    ,  //French normal server
		'xml' => 'http://xml-eu.amazon.com',  //French xml server
	  ),
	  'jp' => array(
		'ext' => 'jp'                      ,  //Japanese normal server, not co.jp!
		'nor' => 'http://www.amazon.co.jp' ,  //Japanese normal server
		'xml' => 'http://xml.amazon.com'   ,  //Japanese xml server
	  ),
	  'uk' => array(
		'ext' => 'co.uk'                   ,  //UK normal server
		'nor' => 'http://www.amazon.co.uk' ,  //UK normal server
		'xml' => 'http://xml-eu.amazon.com',  //UK xml server
	  ),
	  'us' => array(
		'ext' => 'com'                     ,  //USA normal server
		'nor' => 'http://www.amazon.com'   ,  //USA normal server
		'xml' => 'http://xml.amazon.com'   ,  //USA xml server
	  ),
	);
	
	//product categories per country server
	//source for this array: kit3_1/AmazonWebServices/API%20Guide/using_international_data.htm
	//they are kept in the order of that list
	public $Amode = array(
	  'us' => array(
		'books'           => 'books'                   ,
		'music'           => 'popular music'           ,
		'classical'       => 'classical music'         ,
		'dvd'             => 'DVD'                     ,
		'vhs'             => 'video movies'            ,
		'electronics'     => 'electronics'             ,
		'kitchen'         => 'kitchen and housewares'  ,
		'restaurants'     => 'Restaurants'             ,
		'software'        => 'software'                ,
		'videogames'      => 'computer and video games',
		'magazines'       => 'magazines'               ,
		'toys'            => 'toys and games'          ,
		'photo'           => 'camera and photo'        ,
		'baby'            => 'baby'                    ,
		'garden'          => 'outdoor living'          ,
		'pc-hardware'     => 'computers'               ,
		'tools'           => 'tools and hardware'      ,
		'hpc'             => 'Health and personal care',  //20050412: new, suggested by DvH
		'gourmet'         => 'Gourmet'                 ,  //20050412: new, suggested by DvH
	  ),
	  'uk' => array(
		'books-uk'        => 'books'                   ,
		'music'           => 'popular music'           ,
		'classical'       => 'classical music'         ,
		'dvd-uk'          => 'DVD'                     ,
		'vhs-uk'          => 'video movies'            ,
		'electronics-uk'  => 'electronics'             ,
		'kitchen-uk'      => 'kitchen and housewares'  ,
		'software-uk'     => 'software'                ,
		'video-games-uk'  => 'computer and video games',
		'toys-uk'         => 'toys and games'          ,
	  ),
	  'de' => array(
		'books-de'        => 'books'                   ,
		'pop-music-de'    => 'popular music'           ,
		'classical-de'    => 'classical music'         ,
		'dvd-de'          => 'DVD'                     ,
		'vhs-de'          => 'video movies'            ,
		'ce-de'           => 'electronics and foto'    ,
		'kitchen-de'      => 'kitchen and housewares'  ,
		'software-de'     => 'software'                ,
		'video-games-de'  => 'computer and video games',
		'magazines-de'    => 'Magazines'               ,
		'books-de-intl-us'=> 'USA books'               ,
	  ),
	  'jp' => array(
		'books-jp'        => 'books'                   ,
		'music-jp'        => 'music'                   ,
		'classical-jp'    => 'classical music'         ,
		'dvd-jp'          => 'DVD'                     ,
		'vhs-jp'          => 'video movies'            ,
		'electronics-jp'  => 'electronics'             ,
		'software-jp'     => 'software'                ,
		'videogames-jp'   => 'computer and video games',
		'books-us'        => 'USA books'               ,
	  ),
	  'fr' => array(
		'blended'         => 'Tous les produits'        ,
		'books-fr'        => 'Livres en fran&ccedil;ais',
		'books-fr-intl-us'=> 'livres en anglais'        ,
		'music-fr'        => 'Pop, V.F., Jazz...'       ,
		'classical-fr'    => 'Musique classique'        ,
		'dvd-fr'          => 'DVD'                      ,
		'vhs-fr'          => 'Vid&eacute;o'             ,
		'sw-vg-fr'        => 'Logiciels et consommables',
		'video-games-fr'  => 'Jeux vid&eacute;o'        ,
	  ),
	);
	
	//search types
	//see for example kit3_1/AmazonWebServices/API%20Guide/index.html
	public $Asearchtype = array(
	  'ActorSearch'        => 'Actor/Actress'  ,
	  'ArtistSearch'       => 'Artist/Musician',
	  'AsinSearch'         => 'ASIN/ISBN'      ,  //give an ASIN as the search string
	  'AuthorSearch'       => 'Author'         ,
	  'BlendedSearch'      => 'Blended'        ,  //this will search in several categories (modes)
	  'BrowseNodeSearch'   => 'Browse node'    ,
	  'DirectorSearch'     => 'Director'       ,
	  'ExchangeSearch'     => 'Exchange'       ,
	  'KeywordSearch'      => 'Keyword'        ,
	  'ListmaniaSearch'    => 'Listmania'      ,
	  'ManufacturerSearch' => 'Manufacturer'   ,
	  'MarketplaceSearch'  => 'Marketplace'    ,
	  'PowerSearch'        => 'Power'          ,
	  'SellerSearch'       => 'Seller'         ,
	  'SimilaritySearch'   => 'Similarity'     ,
	  'TextStreamSearch'   => 'TextStream'     ,  //will search inside of books?
	  'UpcSearch'          => 'UPC'            ,
	  'WishlistSearch'     => 'Wishlist'       ,
	);
	//or is this also locale dependend?
	//Yes, a lot of search types are only valid on the USA locale.
	//A lot of search types only work on certain categories (modes).
	
	//search types
	public $Asearchtype_restaurant = array(
	  'American'  => 'American',
	  'Bulgarian' => 'Bulgarian',
	  'Chinese'   => 'Chinese',
	  'Danish'    => 'Danish',
	  'English'   => 'English',
	  'French'    => 'French',
	  'Italian'   => 'Italian',
	);
	//or is this also locale dependend?
	//Yes, a lot of search types are only valid on the USA locale.
	//A lot of search types only work on certain categories (modes).
	
	//error messages
	//and how to handle them
	public $Aerror = array(
	  'There are no exact matches for the search.'=>'print',
	);
	
	function Amazon_InsertItemsToDatabase( $data )
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "amazon_items";
		
		if( !$data || !isset($data['items']) )
			return;
			
		$items = array_values($data['items']);
		$keyword = Qody::MakeSlug( $data['keyword'] );
		
		if( $items )
		{
			$ids = array();
			$query = mysql_query( "SELECT * FROM $table_name" );
			
			if( $query )
			{ 
				while( $nextItem = mysql_fetch_array( $query ) )
				{ 
					$ids[] = $nextItem['asin'];
				}
			}
	
			foreach( $items as $key => $value )
			{
				$fields['asin'] = $value['ASIN'];
				
				if( $ids )
				{
					if( in_array( $fields['asin'], $ids ) )
						continue;
				}
				if( !is_array( $value ) )
					continue;
				
				$fields['keyword'] = $keyword;
				$fields['detail_page_url'] = $value['DetailPageURL'];
				$fields['sales_rank'] = $value['SalesRank'];
				
				$fields['image_small'] = $value['SmallImage']['URL'];
				$fields['image_medium'] = $value['MediumImage']['URL'];
				$fields['image_large'] = $value['LargeImage']['URL'];
				
				$fields['binding'] = $value['ItemAttributes']['Binding'];
				$fields['brand'] = $value['ItemAttributes']['Brand'];
				$fields['color'] = $value['ItemAttributes']['Color'];
				$fields['ean'] = $value['ItemAttributes']['EAN'];
				$fields['label'] = $value['ItemAttributes']['Label'];
				$fields['price_list_amount'] = $value['ItemAttributes']['ListPrice']['Amount'];
				$fields['price_list_formatted'] = $value['ItemAttributes']['ListPrice']['FormattedPrice'];
				$fields['manufacturer'] = $value['ItemAttributes']['Manufacturer'];
				$fields['product_group'] = $value['ItemAttributes']['ProductGroup'];
				$fields['publisher'] = $value['ItemAttributes']['Publisher'];
				$fields['studio'] = $value['ItemAttributes']['Studio'];
				$fields['title'] = $value['ItemAttributes']['Title'];
				$fields['upc'] = $value['ItemAttributes']['UPC'];
				
				$fields['price_new_lowest_amount'] = $value['OfferSummary']['LowestNewPrice']['Amount'];
				$fields['price_new_lowest_formatted'] = $value['OfferSummary']['LowestNewPrice']['FormattedPrice'];
				$fields['price_used_lowest_amount'] = $value['OfferSummary']['LowestUsedPrice']['Amount'];
				$fields['price_used_lowest_formatted'] = $value['OfferSummary']['LowestUsedPrice']['FormattedPrice'];
				$fields['available_new'] = $value['OfferSummary']['TotalNew'];
				$fields['available_used'] = $value['OfferSummary']['TotalUsed'];

				Qody::InsertToDatabase( $fields, $table_name );
			}		
		}
	}
	
	/*function GetSiteAmazonSearchLink()
	{
		$aaid = GetAnAAid();
		$keyword = strtolower( get_bloginfo('name') );
		
		return 'http://www.amazon.com/gp/redirect.html?ie=UTF8&location=http%3A%2F%2Fwww.amazon.com%2Fs%3Fie%3DUTF8%26x%3D0%26ref_%3Dnb_sb_noss%26y%3D0%26field-keywords%3D'.htmlentities( $keyword ).'%26url%3Dsearch-alias%253Daps&tag='.$aaid.'&linkCode=ur2&camp=1789&creative=390957';
	}*/
	
	function GetAnAAid()
	{
		$aaid = 'qody-20';
		
		return $aaid;
	}
	
	function Amazon_GetAllItems()
	{
		$itemList = array();
		
		$loopIter = 0;
		$maxPages = 5;
		
		$itemIter = 0;

		$startingPage = Qody::GetOption( 'last_amazon_product_page' );
	
		if( !$startingPage )
			$startingPage = 1;
			
		$aa_id = $this->GetAnAAid();

		while( $loopIter < $maxPages )
		{
			$defaults = array();
			$defaults['language'] = 'en'; //what language to render the page in
			$defaults['locale'] = 'us'; //which server's products? available: ca,de,fr,jp,uk,us
			$defaults['affiliateID'] = $aa_id;

			//use which servers?
			$norserver = $this->Aserver[ $defaults['locale'] ]['nor'];
			$xmlserver = $this->Aserver[ $defaults['locale'] ]['xml'];

			$params = $this->GetAmazonParameters();
			
			$itemList['keyword'] = $params['Keywords'];
			
			$parameters = array();
			$parameters['Service'] = 'AWSECommerceService';
			$parameters['Condition'] = 'All';
			$parameters['Operation'] = 'ItemSearch';
			$parameters['AssociateTag'] = $defaults['affiliateID'];
			$parameters['ItemPage'] = $startingPage + $loopIter;
			$parameters['ResponseGroup'] = 'Large';

			//Qody::ItemDebug( $params );
			$parameters = array_merge( $parameters, $params );
	
			//this will create the filename for the cache file
			//it should only contain non-static search parameters and not static data for your site
			$ext = $this->Aserver[ $defaults['locale'] ]['ext'];  //extension of server, see data.php
	
			ksort($parameters);
	
			$filecontents = $this->aws_signed_request($ext,$parameters,$this->public_key,$this->private_key);  //20090804: sign the request

			if( $filecontents )
				$data = Qody::xmlstr_to_array( $filecontents );

			if( $data )
			{
				foreach( $data['Items'] as $key => $value )
				{
					switch( $key )
					{
						case 'Request':
							break;
							
						case 'TotalResults':
							break;
							
						case 'TotalPages':
							$totalPages = $value;
							break;
							
						case 'Item':
							foreach( $value as $itemKey => $itemValue )
							{
								$itemList['items'][] = $itemValue;
								$itemIter++;
							}
							break;
							
						default:
							
					}
				}
			}

			$loopIter++;
		}

		$lastPage = $startingPage + $loopIter;

		if( $lastPage >= $totalPages || $lastPage >= $maxPages )
			$lastPage = '1';
		
		Qody::UpdateOption( 'last_amazon_product_page', $lastPage );
		
		return $itemList;
		
	}
	
	function GetAmazonParameters()
	{
		$fields = array();
		$fields['SearchIndex'] = 'All';
		$fields['Keywords'] = Qody::GetOption( 'amazon_search_keyword' );
		
		if( !$fields['Keywords'] )
			$fields['Keywords'] = 'cats';
		
		return $fields;
	}
	
	function aws_signed_request($region, $params, $public_key, $private_key)
	{
	
		// some paramters
		$method = "GET";
		$host = "ecs.amazonaws.".$region;
		$uri = "/onca/xml";
		
		// additional parameters
		$params["Service"] = "AWSECommerceService";
		$params["AWSAccessKeyId"] = $public_key;
		// GMT timestamp
		$params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z");
		$params["Version"] = "2009-03-31";
		// API version
		
		// sort the parameters
		ksort($params);
		
		// create the canonicalized query
		$canonicalized_query = array();
		foreach ($params as $param=>$value)
		{
			$param = str_replace("%7E", "~", rawurlencode($param));
			$value = str_replace("%7E", "~", rawurlencode($value));
			$canonicalized_query[] = $param."=".$value;
		}
		
		
		$canonicalized_query = implode("&", $canonicalized_query);
	
	
		// create the string to sign
		$string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
		
		// calculate HMAC with SHA256 and base64-encoding
		$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $private_key, True));
		
		// encode the signature for the request
		$signature = str_replace("%7E", "~", rawurlencode($signature));
		
		// create request
		$request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;
	
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	 
		$xml_response = curl_exec($ch);
		//echo $xml_response;
	 
		if ($xml_response === False)
		{
			return False;
		}
		else
		{
			return $xml_response;
		}
	}
}
?>