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
<meta charset=\"utf-8\">\n
<meta name=\"google\" value=\"notranslate\">\n
<link rel=\"stylesheet\" href=\"../resources/ui.css\">\n
<link rel=\"icon\" type=\"image/x-icon\" href=\" /icon/favicon.ico\">
</head>\n
<body>\n
        <center>\n
            <form method=\"post\" action=\"save.php\"><label>\n
            <table>\n
                <tr>\n
                    <th colspan=\"5\">SC Hermaringen</th>\n
                    <th class=\"trenner\" rowspan=\"9\"></th>\n
                    <th colspan=\"5\">\n";

// Name des Gastteams auslesen
$dateiGast = '../resources/dbGastTeam.txt';
$gastTeamName = file_get_contents($dateiGast);

// Name des Gastteams ausgeben
echo "<input tabindex=\"1\" class=\"name\" type=\"text\" name=\"gastteam\" value=\"$gastTeamName\"></th></tr>";

// Überschriften der Tabelle
echo "  <tr class=\"kopf\">\n
            <td>Name</td>\n
            <td>S1</td>\n
            <td>S2</td>\n
            <td>S3</td>\n
            <td>S4</td>\n
            <td>S4</td>\n
            <td>S3</td>\n
            <td>S2</td>\n
            <td>S1</td>\n
            <td>Name</td>\n
            </tr>\n";

// dbPaarungen.txt auslesen
$dateiPaarungen = '../resources/dbPaarungen.txt';
$inhaltPaarungen = file_get_contents($dateiPaarungen);
$zähler = 0;

// $inhaltPaarungen in Zeilen(Paarungen) aufteilen
$paarungen = explode("\n", $inhaltPaarungen);

// Schleife für jede Paarung wiederholen
foreach($paarungen as $paarung) {

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

    $zähler++;
    $paarwert;
    if ($zähler == 1 or $zähler == 2) {$paarwert = 1;}
    if ($zähler == 3 or $zähler == 4) {$paarwert = 2;}
    if ($zähler == 5 or $zähler == 6) {$paarwert = 3;}  

    // Ausgabe des Datensatzes in Tabellenzeile
    echo "  <tr>\n
        <td><input tabindex=\"11".$zähler."\" class=\"name\" type=\"text\" name=\"heim".$zähler."name\" value=\"$heimSpieler\"></td>\n
        <td><input tabindex=\"3".$paarwert."1\" class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"heim".$zähler."satz1\" value=\"$heimSatz1\"></td>\n
        <td><input tabindex=\"3".$paarwert."3\" class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"heim".$zähler."satz2\" value=\"$heimSatz2\"></td>\n
        <td><input tabindex=\"3".$paarwert."5\" class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"heim".$zähler."satz3\" value=\"$heimSatz3\"></td>\n
        <td><input tabindex=\"3".$paarwert."7\" class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"heim".$zähler."satz4\" value=\"$heimSatz4\"></td>\n
        <td><input tabindex=\"3".$paarwert."8\" class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"gast".$zähler."satz4\" value=\"$gastSatz4\"></td>\n
        <td><input tabindex=\"3".$paarwert."6\" class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"gast".$zähler."satz3\" value=\"$gastSatz3\"></td>\n
        <td><input tabindex=\"3".$paarwert."4\" class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"gast".$zähler."satz2\" value=\"$gastSatz2\"></td>\n
        <td><input tabindex=\"3".$paarwert."2\" class=\"satz\" type=\"text\" pattern=\"[0-9]*\" name=\"gast".$zähler."satz1\" value=\"$gastSatz1\"></td>\n
        <td><input tabindex=\"22".$zähler."\" class=\"name\" type=\"text\" name=\"gast".$zähler."name\" value=\"$gastSpieler\"></td>\n
    </tr>";
}

// Rest der Tabelle ausgeben und Hilfetext inkludieren
echo "
<tr>
    <th colspan=\"11\" style=\"text-align:left;\">
        <input class=\"speichern\" type=\"submit\" value=\"speichern\" style=\"float:left;margin-right:10px;\">
        <a href=\"delete.php\" onclick=\"return confirm('Sicher, dass du alle Eingaben löschen möchtest?')\"><input class=\"speichern\" type=\"button\" value=\"löschen\"></a>
        <a href=\"print.php\"><input class=\"speichern\" type=\"button\" value=\"drucken\"></a>
        <div class=\"hilfeicon\"><img src=\"../icon/hilfe.png\">";
        include ('../resources/hilfe.php');
        echo "</div>
    </th>
</tr>

        </table>
        </form>
        </label>
</center>
</body>

</html>";
?>

  <script>
    // Beim Start der Seite, das Scoreboard in anderem Tab starten
    window.onload = function() {
      var neuerTab = window.open('scoreboard.php', 'Scoreboard');
    };
  </script>