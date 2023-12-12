<?php
// Prüfen ob der User eingeloggt ist
session_start();
if (!isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] !== true) {
    header("Location:../index.php");
    exit();
}

// Head-Bereich der HTML-Datei und Kopf der Tabelle ausgeben
echo "  <html>\n
<head>\n
<title>Scoreboard</title>\n
<meta charset=\"utf-8\">\n
<meta name=\"google\" value=\"notranslate\">\n
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no\">\n
<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\n
<meta name=\"mobile-web-app-capable\" content=\"yes\">\n
<meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black\">\n

<link rel=\"apple-touch-icon\" href=\"../icon/apple-icon-144x144.png\"/>\n
<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"../icon/apple-icon-72x72.png\"/>\n
<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"../icon/apple-icon-114x114.png\"/>\n
<link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"../icon/apple-icon-144x144.png\"/>\n

<link rel=\"stylesheet\" href=\"../resources/mobile.css\">\n
</head>\n
<body>\n
        <center>\n
            <h1>Scoreboard</h1>\n
            <form method=\"post\" action=\"save.php\"><label>\n";


// Name des Gastteams auslesen
$dateiGast = '../resources/dbGastTeam.txt';
$gastTeamName = file_get_contents($dateiGast);

// Name des Gastteams ausgeben
echo "  <table>\n
    <tr>\n
    <td><h2>Gastmannschaft:</h2></td>\n
    </tr>\n
    <tr>\n
        <td><input class=\"name\" type=\"text\" name=\"gastteam\" value=\"$gastTeamName\"></td>\n
    </tr>\n
  </table>\n";

// dbPaarungen.txt auslesen
$dateiPaarungen = '../resources/dbPaarungen.txt';
$inhaltPaarungen = file_get_contents($dateiPaarungen);
$zähler = 0;

// $inhaltPaarungen in Zeilen(Paarungen) aufteilen
$paarungen = explode("\n", $inhaltPaarungen);

// Schleife für jede Paarung wiederholen
foreach($paarungen as $paarung) {
    $zähler++;

    // Paarungsdaten in einzelne Zellen aufteilen
    $zelle = explode("|", $paarung);
    
    // Satz-Werte auf "" setzen, wenn Satz noch nicht gespielt
    for ($jHeim = 1, $jGast = 11; $jHeim <= 4, $jGast <= 14; $jHeim++, $jGast++) {
        if($zelle[$jHeim] == 0) {
            $zelle[$jHeim] = "";
        }
        if($zelle[$jGast] == 0) {
            $zelle[$jGast] = "";
        }
    }

    // Werte aus $zelle[] zum Verständnis neue Namen zuweisen
    $heimSpieler = $zelle[0];
    $heimSatz1 = $zelle[1];
    $heimSatz2 = $zelle[2];
    $heimSatz3 = $zelle[3];
    $heimSatz4 = $zelle[4];
    $gastSatz4 = $zelle[11];
    $gastSatz3 = $zelle[12];
    $gastSatz2 = $zelle[13];
    $gastSatz1 = $zelle[14];
    $gastSpieler = $zelle[15];

    // Ausgabe der Paarungswerte je Paarung in einer Tabelle
    echo "  <table>\n
        <tr>\n
            <td colspan=\"4\"><h2>Paarung $zähler</h2></td>\n
        </tr>\n
        <tr>\n
            <td colspan=\"4\"><input class=\"name\" type=\"text\" name=\"heim".$zähler."name\" value=\"$heimSpieler\"></td>\n
        </tr>\n
        <tr>\n
            <td><input class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"heim".$zähler."satz1\" value=\"$heimSatz1\"></td>\n
            <td><input class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"heim".$zähler."satz2\" value=\"$heimSatz2\"></td>\n
            <td><input class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"heim".$zähler."satz3\" value=\"$heimSatz3\"></td>\n
            <td><input class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"heim".$zähler."satz4\" value=\"$heimSatz4\"></td>\n
        </tr>\n
        <tr>\n
            <td colspan=\"4\"><input class=\"name\" type=\"text\" name=\"gast".$zähler."name\" value=\"$gastSpieler\"></td>\n
        </tr>\n
        <tr>\n
            <td><input class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"gast".$zähler."satz1\" value=\"$gastSatz1\"></td>\n
            <td><input class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"gast".$zähler."satz2\" value=\"$gastSatz2\"></td>\n
            <td><input class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"gast".$zähler."satz3\" value=\"$gastSatz3\"></td>\n
            <td><input class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"gast".$zähler."satz4\" value=\"$gastSatz4\"></td>\n
        </tr>\n
        <tr>\n
        </tr>\n
        </table>\n";
}

// Buttons ausgeben
echo "  <table class=\"buttons\">\n
    <tr>\n
        <td>\n
            <input class=\"speichern\" type=\"submit\" value=\"speichern\">\n
            <a href=\"load.php\"><input class=\"speichern\" type=\"button\" value=\"laden\"></a>\n
            <a href=\"delete.php\"><input class=\"speichern\" type=\"button\" value=\"löschen\"></a>\n
        </td>\n
    </tr>\n
</table>\n

        </form>
        </label>     
                
        <div style=\"height:75px;\"></div>
    </center>
    </body>
</html>";
?>