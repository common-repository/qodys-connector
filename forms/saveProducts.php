<?php
require_once( '../index.php' );

$amazon_search_keyword = Qody::filter( $_POST['amazon_search_keyword'] );
$default_product_tag = Qody::filter( $_POST['default_product_tag'] );

$return_page = Qody::filter( $_POST['return_page'] );

Qody::UpdateOption( 'amazon_search_keyword', $amazon_search_keyword );
Qody::UpdateOption( 'default_product_tag', $default_product_tag );

$response = array();
$response['results'][] = 'Qody: all product settings have been saved';

if( $amazon_search_keyword )
{
	$amazon_api = new Amazon_Api();
	$items = $amazon_api->Amazon_GetAllItems();	
	
	$amazon_api->Amazon_InsertItemsToDatabase( $items );
	
	$response['results'][] = 'Qody: '.count($items['items']).' products have been processed';
}

Qody::SetMessage( $response );

Qody::CompleteWizardStep( 4 );

if( $return_page )
	$url = QodyPages::MakeLink( $return_page );
else
	$url = QodyPages::MakeLink( 'products' );

header( "Location: ".$url );
exit;
?>