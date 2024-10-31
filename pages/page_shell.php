<?php
$result = array();

$domain = Qody::GetOption( 'domain' );

if( $domain && $domain != get_bloginfo('url') )
{
	$result['errors'][] = "This site's url has changed; please re-save to update Qody's Connector to maintain a connection";
	
	Qody::SetMessage( Qody::EncodeResponse( $result ) );	
}

$amazon_search_keyword = Qody::GetOption( 'amazon_search_keyword' );
$default_product_tag = Qody::GetOption( 'default_product_tag' );

$company_api_key = Qody::GetOption( 'company_api_key' );
$user_api_key = Qody::GetOption( 'user_api_key' );

$sitetracker_enabled = Qody::GetOption( 'sitetracker_enabled' );
$keywords_to_track = Qody::GetOption( 'keywords_to_track' );

$oblinker_enabled = Qody::GetOption( 'oblinker_enabled' );
$oblinker_categories = Qody::Decode( Qody::GetOption( 'oblinker_categories' ) );

$redirect_url = Qody::GetOption( 'redirect_url' );
$redirect_home = Qody::GetOption( 'redirect_home' );
$redirect_on = Qody::GetOption( 'redirect_on' );
$redirect_pages = Qody::GetOption( 'redirect_pages' );
$redirect_posts = Qody::GetOption( 'redirect_posts' );

$plugin_url = Qody::GetPluginDirectory();
?>

This plugin is no longer supported.  Please visit 
<a href="http://qody.co">http://qody.co</a> to download current & powerful feature-specific plugins.
<?php 
//require_once( QodyPages::GetCurrentPage().".php" );
?>