<?php

require "rb-mysql.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    switch ($data["action"]) {
        case "test":
            $db = R::setup("mysql:host=" . $data["load"]["db_host"] . ";dbname=" . $data["load"]["db_name"], $data["load"]["db_user"], $data["load"]["db_password"]);
            if (R::testConnection()) {
                http_response_code(200);
                echo "👍 Verbindung erfolgreich.";
            } else {
                http_response_code(500);
                echo "🚨 Verbindung fehlgeschlagen.";
            }
            break;
    }
}
else {
    http_response_code(405);
    echo "🚨 Ungültige Anfrage.";
    exit;
}

?>