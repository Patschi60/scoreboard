<?php
session_start();

// Prüfen ob Login-Daten übermittels wurden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $user = $_POST["user"];
    $pw = $_POST["pw"];

    // Login-Daten überprüfen und gegebenenfalls zu logedin.php weiterleiten
    if ($user === "sch" && $pw === "damenwahl") {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $user;
        header("Location:logedin.php");
        exit();
    }

    // bei falschen Logindaten Fehlermeldung ausgeben
    else {
        echo "  <html>\n
                <head>\n
                <link rel=\"stylesheet\" href=\"../resources/ui.css\">\n
                </head>\n
                <body>\n
                <center>\n
                <h1>Falscher Benutzer oder Passwort.</h1>\n
                <p><a href=\"../index.php\">zurück</a></p>\n
                </center>\n
                </body>\n
                </html>";
    }
}
?>