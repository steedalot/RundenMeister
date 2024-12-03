function flashBackground(color) {
    // Speichern Sie die ursprüngliche Hintergrundfarbe
    let originalBG = document.body.style.backgroundColor;

    // Ändern Sie die Hintergrundfarbe
    document.body.style.backgroundColor = color;

    // Setzen Sie die Hintergrundfarbe nach 500 Millisekunden zurück
    setTimeout(function() {
        document.body.style.backgroundColor = originalBG;
    }, 500);
}

function onScanSuccess(decodedText, decodedResult) {
    // handle the scanned code as you like, for example:
    flashBackground("green");
    document.getElementById("scan_result").textContent = "Letzter Scan: " + decodedText;
    html5QrcodeScanner.pause();
    setTimeout(() => html5QrcodeScanner.resume(), 3000);

}

function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
    // for example:
    
}

if (SCOPE == "input") {
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "scanner_container",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
}




if (SCOPE == "admin") {

    document.getElementById("test_button").addEventListener("click", function(event) {
        event.preventDefault();
        fetch("api.php", {
            method: "POST",
            body: JSON.stringify({
                "action": "config_test",
                "key": ADMINKEY,
                "data": {
                    "db_host": document.getElementsByName("db_host")[0].value,
                    "db_user": document.getElementsByName("db_user")[0].value,
                    "db_password": document.getElementsByName("db_password")[0].value,
                    "db_name": document.getElementsByName("db_name")[0].value
                }
            }),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            if (response.status === 200) {
                flashBackground("green");
                console.log(response.text());
            } else {
                flashBackground("red");
                console.log(response.text());
            }
        });
    });

    document.getElementById("save_button").addEventListener("click", function(event) {
        event.preventDefault();
        fetch("api.php", {
            method: "POST",
            body: JSON.stringify({
                "action": "config_save",
                "key": ADMINKEY,
                "data": {
                    "db_host": document.getElementsByName("db_host")[0].value,
                    "db_user": document.getElementsByName("db_user")[0].value,
                    "db_password": document.getElementsByName("db_password")[0].value,
                    "db_name": document.getElementsByName("db_name")[0].value,
                    "admin_key": document.getElementsByName("admin_key")[0].value,
                    "teacher_key": document.getElementsByName("teacher_key")[0].value,
                    "admin_email": document.getElementsByName("admin_email")[0].value
                }
            }),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            if (response.status === 200) {
                flashBackground("green");
                console.log(response.text());
            } else {
                flashBackground("red");
                console.log(response.text());
            }
        });
    });

}

