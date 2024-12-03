<?php

require "rb-mysql.php";
require "config.php";

$header = "Content-Type: application/json;charset=utf-8";
ini_set('display_errors', 'On');

R::setup('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS);

$json = file_get_contents('php://input');
$data = json_decode($json);

$answer = NULL;
$status = NULL;



if (isset($data->action)) {

    header($header);

    switch ($data->action) {

        case "add_lap":

            $last_lap = R::findOne("lap", "runner_id = '".$data->runner_id."' ORDER BY timestamp DESC LIMIT 1");
            $lap = R::dispense('lap');
            // The type should be of "start", "lap", "finish"
            $lap->type = $data->type;
            // The id is the unique uuid of each runner
            $lap->runner_id = $data->runner_id;
            // The timestamp is the time when the lap was added
            $lap->timestamp = time();
            if ($last_lap && $lap->timestamp < ($last_lap->timestamp + MINIMAL_LAP_TIME)) {
                $answer = "🚨 Die Runde wurde zu früh hinzugefügt.";
                $status = 400;
                R::trash($lap);
                break;
            }
            $id = R::store($lap);
            $answer = $id;
            $status = 200;
        
            break;
        
        case "get_laps":
                
                $laps = R::find("lap", "runner_id = '".$data->runner_id."' ORDER BY timestamp ASC");
                if (!$laps) {
                    $answer = "🚨 Keine gelaufenen Runden gefunden.";
                    $status = 404;
                    break;
                }
                $answer = json_encode(R::exportAll($laps));
                $status = 200;
    
                break;
    }
}
else {
    $status = 303;
    $answer = "<!DOCTYPE html>\n<html>\n<head>\n<meta http-equiv=\"Refresh\" content=\"0; URL='https://github.com/steedalot/rundenmeister'\">\n</head>\n<body></body>\n</html>";
}

R::close();

http_response_code($status);
echo $answer;

?>