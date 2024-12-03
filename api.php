<?php

require "rb-mysql.php";

$configFilePath = 'config.json';


if (file_exists($configFilePath)) {
    $config = json_decode(file_get_contents($configFilePath), true);
} else {
    http_response_code(500);
    echo "🚨 Konfigurationsdatei konnte nicht gefunden werden.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    if ($data["key"] != $config["admin_key"]) {
        http_response_code(405);
        echo "🚨 Ungültiger Schlüssel.";
        exit;
    }
    
    elseif (!isset($data["action"])) {
        http_response_code(405);
        echo "🚨 Ungültige Anfrage.";
        exit;
    }
    
    else {
    
        switch ($data["action"]) {
            
            case "config_test":
                $db = R::setup("mysql:host=" . $data["data"]["db_host"] . ";dbname=" . $data["data"]["db_name"], $data["data"]["db_user"], $data["data"]["db_password"]);
                if (R::testConnection()) {
                    R::close();
                    http_response_code(200);
                    echo "👍 Verbindung erfolgreich.";
                } else {
                    http_response_code(500);
                    echo "🚨 Verbindung fehlgeschlagen.";
                }
                break;
            
            case "config_save":
                $config = json_decode(file_get_contents($configFilePath), true);
                $config["db_host"] = $data["data"]["db_host"];
                $config["db_name"] = $data["data"]["db_name"];
                $config["db_user"] = $data["data"]["db_user"];
                $config["db_password"] = $data["data"]["db_password"];
                $config["teacher_key"] = $data["data"]["teacher_key"];
                $config["admin_key"] = $data["data"]["admin_key"];
                $config["admin_email"] = $data["data"]["admin_email"];
                $file_written = file_put_contents($configFilePath, json_encode($config));
                if (!$file_written) {
                    http_response_code(500);
                    echo "🚨 Konfiguration konnte nicht gespeichert werden.";
                    exit;
                } else {
                    http_response_code(200);
                    echo "👍 Konfiguration gespeichert.";
                }
                break;
        }
    }
}

else {
    http_response_code(405);
    echo "🚨 Ungültige Anfrage.";
    exit;
}

?>