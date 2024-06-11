<?php

$configFilePath = 'config.json';


if (file_exists($configFilePath)) {
    $config = json_decode(file_get_contents($configFilePath), true);
} else {
    http_response_code(500);
    echo "🚨 Konfigurationsdatei konnte nicht gefunden werden.";
    exit;
}

$_REQUEST = json_decode(file_get_contents('php://input'), true);
if ($_REQUEST) {
    if ($_REQUEST['key'] != $config['admin_key']) {
        http_response_code(405);
        echo "🚨 Ungültiger Schlüssel.";
        exit;
    }
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
                <input type="password" name="db_pass">
            </p>
            <p>
                <label>Email-Adresse des Administrators</label>
                <input type="email" name="admin_email" value="<?php echo $config['admin_email']; ?>">
            </p>
            <p>
                <label>Schlüssel des Administrators</label>
                <input type="text" name="admin_pass" value="<?php echo $config['admin_key']; ?>">
            <button type="submit" id="submit_button">Testen</button>
            <button type="submit" id="save_button">Speichern</button>
        </form>
    </main>

</body>