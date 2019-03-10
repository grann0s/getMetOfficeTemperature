# getMetOfficeTemperature
Retrieve Met Office Temperature Data &amp; Push It to PVOutput

This script is designed to be used in conjunction with a PVOutput account. Specifically the script can be used to upload the current temperature [ in degrees C ] at your location [ in the U.K. ] and add that data to your PVOuput account.

https://www.metoffice.gov.uk/datapoint

The Met Office provide free access to their data. It is a requirement though that the user first register in order obtain a Met Office API Key.

To use this script a number of items must be configured within it first:

$pvOutputApiKEY       This is the API key provided by PVOutput. You can find this API key within your PVOuput account.

$pvOutputSID          This is the ID of the actual P.V. installation. Some people may have and montitor more than ONE system.

$APIKey               This is the API key that is provided by the Met Office

$LocationID           This it the LocationID of your nearest Met Office weather station. The lis of *valid* LocationIDs can be obtained                         from the Met Office API website. 

$timezone_identifier  This is the User's Timezone and it should match the Timezone set within PVOutput.

The script should be run at regular 5 minute intervals to populate the PVOutput records without gaps. The Met Office database though only provides datapoints [ Temperature ] in one hour interval; updated on the hour. Ideally the script will be run via cron [ or similar ]

The script should be run manually *after* configuration to verify that the correct keys and identifiers have been entered. The user should verify that the data appear in their PVOutput account.

N.B. According the PVOutput *HELP* under 'Restrictions and Limitations'  

  "At least one of the values v1, v2, v3 or v4 must be present."
  
But
  
  "Temperature v5 and Extended parameters v7 to v12 can be sent without v1 to v4"
  
If the PVOutput user is a 'Donation' user.

I am a 'Donation User' so this script works for me by sending only the temperature ( v5 ) value. If you are NOT a donation user the script will not work unless: (a) You modify it to also push v1, v2 v3 or v4 OR (b) You become a Donor.

N.B. The script will pause for 120 seconds when run precisely on the hour. This is to prevent the script from trying to read the latest weather data before it is available to be written. The script also *assumes* that the clock on the computer running the script is accurate.

