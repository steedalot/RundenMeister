<?php

$configFilePath = 'config.json';


if (file_exists($configFilePath)) {
    $config = json_decode(file_get_contents($configFilePath), true);
} else {
    http_response_code(500);
    echo "🚨 Konfigurationsdatei konnte nicht gefunden werden.";
    exit;
}

if ($_GET) {
    if ($_GET['key'] != $config['teacher_key']) {
        http_response_code(405);
        echo "🚨 Ungültiger Schlüssel.";
        exit;
    }
}
else {
    http_response_code(405);
    echo "🚨 Ungültige Anfrage.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="simple.min.css">
    <title>🏃‍➡️ RundenMeister</title>
</head>

<body>

    <header>
        <h1>🏃📷 RundenMeister</h1>
    </header>

    <main>
        <div id="scanner_container"></div>
        <p class="notice" id="scan_result">Code scannen</p>

    </main>
    <script src="html5-qrcode.min.js" type="text/javascript"></script>
    <script src="code.js" type="text/javascript"></script>
</body>

</html>