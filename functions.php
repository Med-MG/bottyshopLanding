<?php 

require __DIR__ . '/vendor/autoload.php';

if(isset($_POST['submit'])){
    //making a connection to the api
    $client = new \Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');
    $service = new Google_Service_Sheets($client);
    $spreadsheetId = "16pb91svUhhy2cq2UG6NMs9xhV7eWzWtIfNAXxlw2xgQ";
    //making a connection to the api

    $phone = trim($_POST['phone']);
    $fullName= trim($_POST['fullname']);
    $city= trim($_POST['city']);
    $address= trim($_POST['address']);
   


    //getting the last inserted row id
    $range = "cahier!A1:D";
    $response = $service->spreadsheets_values->get($spreadsheetId,$range);
    $values = $response->getValues();
    if (empty($values)) {
        $inc = 1;
    } else {
        // $mask = "%10s %-10s %s\n";
        $id = end($values)[0];
        $inc = $id + 1;
    }



    $range = "cahier!A1:D";
    $values = [
        [$inc, $fullName,  $phone,$city, $address],
    ];

    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);

    $params = [
        'valueInputOption' => 'RAW'
    ];

    $insert = [
        "insertDataOption" => "INSERT_ROWS"
    ];

    $result = $service->spreadsheets_values->append(
        $spreadsheetId,
        $range,
        $body,
        $params,
        $insert
    );

    header('location: index.php?order');
}


function showpixles(){
    //making a connection to the api
    $client = new \Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');
    $service = new Google_Service_Sheets($client);
    $spreadsheetId = "1VPDLAmNXI50q2PkGBG9bPdVhyl17q9ahDIQv2VFawEM";

    //getting the last inserted row id
    $rangepix = "biohair!T2:U";
    $response = $service->spreadsheets_values->get($spreadsheetId,$rangepix);
    $values = $response->getValues();
    if (empty($values)) {
        print "No data found.\n";
    } else {
        foreach ($values as $row) {
            // Print columns A and E, which correspond to indices 0 and 4.
        echo  $row[0];
        }
    }
}
// $response = $service->spreadsheets_values->get($spreadsheetId, $range);
// $values = $response->getValues();

// if (empty($values)) {
//     print "No data found.\n";
// } else {
//     $mask = "%10s %-10s %s\n";
//     foreach ($values as $row) {
//         // Print columns A and E, which correspond to indices 0 and 4.
//        echo  sprintf($mask, $row[2], $row[1], $row[0]);
//     }
// }





?>
