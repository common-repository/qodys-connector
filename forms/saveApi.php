<?php
require_once( '../index.php' );

$company_api_key = Qody::filter( $_POST['company_api_key'] );
$user_api_key = Qody::filter( $_POST['user_api_key'] );

$current_company_api_key = Qody::GetOption( 'company_api_key' );
$current_user_api_key = Qody::GetOption( 'user_api_key' );

$return_page = Qody::filter( $_POST['return_page'] );

if( !$company_api_key )
{
	$response['errors'][] = "Please enter a company api key";
}
else if( !$user_api_key )
{
	$response['errors'][] = "Please enter a user api key";
}
else
{
	//if( $company_api_key != $current_company_api_key || $user_api_key != $current_user_api_key )
	Qody::UpdateOption( 'company_api_key', $company_api_key );
	Qody::UpdateOption( 'user_api_key', $user_api_key );
	
	$fields = array();
	$fields['action'] = "check_api_keys";
	$fields['company_api_key'] = $company_api_key;
	$fields['user_api_key'] = $user_api_key;
	
	$response = Qody::SendCommand( $fields );
	
	$decoded = Qody::DecodeResponse( $response );

	if( count( $decoded['errors'] ) == 0 )
		Qody::CompleteWizardStep( 2 );
}

Qody::SetMessage( $response );

if( $return_page )
	$url = QodyPages::MakeLink( $return_page );
else
	$url = QodyPages::MakeLink( 'api_login' );

header( "Location: ".$url );
exit;
?>