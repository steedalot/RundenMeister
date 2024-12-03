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
    if ($_GET['key'] != $config['admin_key']) {
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
    <title>🏃‍➡️ RundenMeister | Administration</title>
</head>

<body>

    <header>
        <h1>🏃‍➡️ RundenMeister | Administration</h1>
    </header>

    <main>
        <p class="notice">🔒 Einstellungen, die Sie hier vornehmen, werden die Funktion von RundenMeister beeinflussen.</p>
        
        <form>
            <p>
                <label>Host der Datenbank</label>
                <input type="text" name="db_host" value="<?php echo $config['db_host']; ?>">
            </p>
            <p>
                <label>Name der Datenbank</label>
                <input type="text" name="db_name" value="<?php echo $config['db_name']; ?>">
            <p>
                <label>Benutzername der Datenbank</label>
                <input type="text" name="db_user" value="<?php echo $config['db_user']; ?>">
            </p>
            <p>
                <label>Passwort der Datenbank</label>
                <input type="password" name="db_password">
            </p>
            <p>
                <label>Email-Adresse des Administrators</label>
                <input type="email" name="admin_email" value="<?php echo $config['admin_email']; ?>">
            </p>
            <p>
                <label>Schlüssel für den Zugriff auf diese Seite</label>
                <input type="text" name="admin_key" value="<?php echo $config['admin_key']; ?>">
            </p>
            <p>
                <label>Schlüssel für den Lehrerzugriff</label>
                <input type="text" name="teacher_key" value="<?php echo $config['teacher_key']; ?>">
            </p>
            <button id="test_button">Testen</button>
            <button id="save_button">Speichern</button>
        </form>
    </main>

    <script>const SCOPE = "admin";</script>
    <script>const ADMINKEY = "<?php echo $_GET['key']; ?>";</script>
    <script src="code.js"></script>
</body>