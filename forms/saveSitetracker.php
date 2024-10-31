<?php
require_once( '../index.php' );

$sitetracker_enabled = Qody::filter( $_POST['sitetracker_enabled'] );
$keywords_to_track = Qody::filter( $_POST['keywords_to_track'] );

$return_page = Qody::filter( $_POST['return_page'] );

if( $sitetracker_enabled == 'enable' && !$keywords_to_track )
{
	$response['errors'][] = "Please enter some keywords to track";
}
else if( count( explode(',', $keywords_to_track) ) > 5 )
{
	$response['errors'][] = "Only 5 keywords per site can be tracked, for now";
}
else
{
	$response = Qody::ConnectWithSiteTracker( $keywords_to_track, $sitetracker_enabled );

	if( !$response['errors'] )
	{
		Qody::UpdateOption( 'domain', get_option( 'siteurl' ) );
		Qody::UpdateOption( 'sitetracker_enabled', $sitetracker_enabled );
		Qody::UpdateOption( 'keywords_to_track', $keywords_to_track );
		
		Qody::CompleteWizardStep( 3 );
	}
}

Qody::SetMessage( $response );

if( $return_page )
	$url = QodyPages::MakeLink( $return_page );
else
	$url = QodyPages::MakeLink( 'site_tracker' );

header( "Location: ".$url );
exit;
?>