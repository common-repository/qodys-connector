<?php
require_once( '../index.php' );

$redirectUrl = Qody::filter( $_POST['redirect_url'] );
$on = Qody::filter( $_POST['redirect_on'] );

$return_page = Qody::filter( $_POST['return_page'] );

$postRedirects = array();
if( $_POST['post_redirect_id'] )
{
	foreach( $_POST['post_redirect_id'] as $key => $value )
	{
		if( $value == -1 )
			continue;
		
		if( !trim( $_POST['post_redirect_url'][ $key ] ) )
			continue;
			
		$postRedirects[ $value ] = $_POST['post_redirect_url'][ $key ];
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
			
		$pageRedirects[ $value ] = $_POST['page_redirect_url'][ $key ];
	}
}

$homeRedirect = trim(mysql_real_escape_string( $_POST['home_redirect_url'] ));

Qody::UpdateOption( 'redirect_url', $redirectUrl );
Qody::UpdateOption( 'redirect_on', $on );
Qody::UpdateOption( 'redirect_home', $homeRedirect );
Qody::UpdateOption( 'redirect_posts', $postRedirects );
Qody::UpdateOption( 'redirect_pages', $pageRedirects );
//update_option( 'wpto_posts', '' );
//update_option( 'wpto_pages', '' );

$response = array();
$response['results'][] = 'Qody: all redirector settings have been saved';

Qody::SetMessage( $response );

Qody::CompleteWizardStep( 5 );

if( $return_page )
	$url = QodyPages::MakeLink( $return_page );
else
	$url = QodyPages::MakeLink( 'redirector' );

header( "Location: ".$url );
exit;
?>