<?php
require_once( '../index.php' );

if( $_POST['check_api'] == 1 )
{
	Qody::ProcessApiKey();
	$url = QodyPages::MakeLink( 'api_login' );
}
if( $_POST['options_update'] )
{
	
	Qody::ProcessConnectionSettings();
	Qody::ProcessOblinkerSettings();
	Qody::ProcessRedirectionSettings();
}

if( !$url )
	$url = Qody::GetPreviousPage();

header( "Location: ".$url );
exit;
?>