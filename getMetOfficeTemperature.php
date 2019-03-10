<?php

// PVOuput

$pvOutputApiKEY = "YOUR PVOUTPUT API KEY GOES HERE";			//	PVOutput API Key found in https://pvoutput.org/account.jsp					

$pvOutputSID = "YOUR PVOUTPUT SYSTEMID GOES HERE";				// 	PVOutput SystemID

$pvOutputApiURL = "https://pvoutput.org/service/r2/addstatus.jsp?";		


// Met Office	

/*

	You *Must* Register First to Obtain a Met Office API Key
 	https://www.metoffice.gov.uk/datapoint
 	
 	Met Office LocationID Can be Obtained from this URL
 	http://datapoint.metoffice.gov.uk/public/data/val/wxobs/all/json/sitelist?key=[Met Office API Key]
 	
 	Met Office API does NOT Support https. Your API 

*/			
																
$APIKey = "YOUR MET OFFICE API KEY GOES HERE";					// 	Met Office API Key

$MetOfficeBaseURL = "http://datapoint.metoffice.gov.uk/public/data/val/wxobs/all/json/";

$LocationID = "3522";											// Met Office LocationID

// ****** Do Not Change ******

date_default_timezone_set("UTC");								//	Met Office Data - UTC

// ***************************
		
$UTCHour = date("G", time());									//	Used for Offset in JSON Object

$UTCMinute = date("i", time());									

$UTCtime = date('H:i', time());

// ****** User's Timezone ******	

// $timezone_identifier = "Europe/London";

$timezone_identifier = "Australia/Perth";

// *****************************

date_default_timezone_set("$timezone_identifier");

$date = date('Ymd', time());									// Date Data -- PVOutput YYYYYMMDD

$time = date('H:i', time());									// Time Data -- PVOutput HH:MM

$MetOfficeApiURL = $MetOfficeBaseURL . $LocationID . "?res=hourly&key=" . $APIKey;

echo $MetOfficeApiURL . "\n";

// Met Office Updates Weather Records Every Hour
// Delay the API Call Long Enough for the Weather Record to be Updated

if ( $UTCMinute == "0" )
	sleep(120);

$MetOfficeJSON = file_get_contents($MetOfficeApiURL);

$j = json_decode($MetOfficeJSON, true);

$Location = $j["SiteRep"]["DV"]["Location"]["name"];

$PeriodArray = "1";

// Irregular JSON Returned Between 00:00 and 00:55 UTC

if ( $UTCHour == 0 )
	{
	$temperature = $j["SiteRep"]["DV"]["Location"]["Period"][$PeriodArray]["Rep"]["T"];
	}
else
	{
	$temperature = $j["SiteRep"]["DV"]["Location"]["Period"][$PeriodArray]["Rep"][$UTCHour]["T"];
	}

echo "UTCHour is " . $UTCHour . " and ";
echo "the temperature in " . $Location . " at " . $UTCtime . "Z [ " . $time . " ] is " . $temperature . "C.\n";

$pvOutputURL = $pvOutputApiURL
                . "key=" .  $pvOutputApiKEY
                . "&sid=" . $pvOutputSID
                . "&d=" .   $date
                . "&t=" .   $time
                . "&v5=" .	$temperature;
              
echo $pvOutputURL . "\n\n";
           
file_get_contents(trim($pvOutputURL));	

?>