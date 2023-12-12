<html>
    <head>
        <script type = "text/JavaScript">
            function AutoRefresh( t ) {setTimeout("location.reload(true);", t);}
        </script>

        <link rel="stylesheet" href="../resources/scoreboard.css">
    </head>

<body onload = "JavaScript:AutoRefresh(60000);">
<center>
            
<div class="spacer"></div>

<table>
    <tr>
        <td colspan="7" class="heimteam">
            <img class="heimlogo" src="../img/schermaringen.jpg">
            <h1>SC Hermaringen</h1>
        </td>
        <td class="heimteam" colspan="2">
        </td>

<?php
// Name des Gastteams aus dbGastTeam.txt auslesen
$dateiGastTeam = '../resources/dbGastTeam.txt';
$gastTeamName = file_get_contents($dateiGastTeam);

// Zahlen und Leerzeichen aus dem Namen des Gastteams entfernen, um das Logo reinzuladen
$gastTeamLogo = strtolower($gastTeamName);
$gastTeamLogo = preg_replace('/[^a-z]/', '', $gastTeamLogo);
$gastTeamLogo = "../img/$gastTeamLogo.jpg";

// Wenn das Logo nicht gespeichert ist, dann durch Deafault-Icon ersetzen
if (!file_exists($gastTeamLogo)) {
    $gastTeamLogo = "../img/default.jpg";
}

// Name und Logo der Gäste ausgeben
echo "<td colspan=\"7\" class=\"gastteam\">\n
        <img class=\"gastlogo\" src=\"$gastTeamLogo\">
        <h1>$gastTeamName</h1>
      </td>\n
    </tr>\n";
?>

    <tr>
        <th>Name</th>
        <th>S1</th>
        <th>S2</th>
        <th>S3</th>
        <th>S4</th>
        <th>Ges</th>
        <th>SP</th>
        <th>MP</th>
        <th>MP</th>
        <th>SP</th>
        <th>Ges</th>
        <th>S4</th>
        <th>S3</th>
        <th>S2</th>
        <th>S1</th>
        <th>Name</th>
    </tr>

<?php
// dbPaarungen.txt auslesen
$dateiPaarungen = '../resources/dbPaarungen.txt';
$inhaltPaarungen = file_get_contents($dateiPaarungen);

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

    // Holz-, SP- und MP-Werte auf "" setzen, wenn Paarung noch nicht gespielt ist
    if($zelle[5] == 0 && $zelle[10] == 0) {
        for ($j = 5; $j <= 10; $j++) {
            $zelle[$j] = "";
        }
    }

    // Werte aus $zelle[] zum Verständnis neue Namen zuweisen
    $heimSpieler = str_replace('/', '<br>', $zelle[0]);
    $heimSatz1 = $zelle[1];
    $heimSatz2 = $zelle[2];
    $heimSatz3 = $zelle[3];
    $heimSatz4 = $zelle[4];
    $heimHolz = $zelle[5];
    $heimSatzpunkte = $zelle[6];
    $heimMannschaftspunkte = $zelle[7];
    $gastMannschaftspunkte = $zelle[8];
    $gastSatzpunkte = $zelle[9];
    $gastHolz = $zelle[10];
    $gastSatz4 = $zelle[11];
    $gastSatz3 = $zelle[12];
    $gastSatz2 = $zelle[13];
    $gastSatz1 = $zelle[14];
    $gastSpieler = str_replace('/', '<br>', $zelle[15]);

    // bei Unendschieden oder Gewinn, den Satzwert fett markieren
    for($i = 1; $i <= 4; $i++) {
        if(${'heimSatz'.$i} > ${'gastSatz'.$i}) {
            ${'heimSatz'.$i} = "<b>${'heimSatz'.$i}</b>";
        }
        elseif(${'gastSatz'.$i} > ${'heimSatz'.$i}) {
            ${'gastSatz'.$i} = "<b>${'gastSatz'.$i}</b>";
        }
        else {
            ${'heimSatz'.$i} = "<b>${'heimSatz'.$i}</b>";
            ${'gastSatz'.$i} = "<b>${'gastSatz'.$i}</b>";
        }
    }

    // Ausgabe des Datensatzes in Tabellenzeile
    echo "<tr>\n
      <td class=\"nameheim\">$heimSpieler</td>\n
      <td class=\"satz\">$heimSatz1</td>\n
      <td class=\"satz\">$heimSatz2</td>\n
      <td class=\"satz\">$heimSatz3</td>\n
      <td class=\"satz\">$heimSatz4</td>\n
      <td class=\"gesamt\">$heimHolz</td>\n
      <td class=\"sp\">$heimSatzpunkte</td>\n
      <td class=\"mp\">$heimMannschaftspunkte</td>\n
      <td class=\"mp\">$gastMannschaftspunkte</td>\n
      <td class=\"sp\">$gastSatzpunkte</td>\n
      <td class=\"gesamt\">$gastHolz</td>\n
      <td class=\"satz\">$gastSatz4</td>\n
      <td class=\"satz\">$gastSatz3</td>\n
      <td class=\"satz\">$gastSatz2</td>\n
      <td class=\"satz\">$gastSatz1</td>\n
      <td class=\"namegast\">$gastSpieler</td>\n
    </tr>\n";
}

echo "\n</table>\n<table class=\"summentabelle\">\n<tr>\n";

// Gesamtsummen aus dbGesamt.txt auslesen
$dateiSummen = '../resources/dbGesamt.txt';
$inhaltSummen = file_get_contents($dateiSummen);

// $inhaltSummen in einzelne Summen aufteilen
$summen = explode('|', $inhaltSummen);

// Summen zum Verständnis neue Namen zuweisen
$heimTeamHolz = $summen[0];
$heimTeamSatzpunkte = $summen[1];
$heimTeamMannschaftspunkte = $summen[2];
$gastTeamMannschaftspunkte = $summen[3];
$gastTeamSatzpunkte = $summen[4];
$gastTeamHolz = $summen[5];
    
// Ausgabe der Daten in Tabellenzeile
echo "  <td class=\"gesamtsumme\">$heimTeamHolz</td>\n
        <td class=\"spsumme\">$heimTeamSatzpunkte</td>\n
        <td class=\"mpsumme\">$heimTeamMannschaftspunkte</td>\n
        <td class=\"mpsumme\">$gastTeamMannschaftspunkte</td>\n
        <td class=\"spsumme\">$gastTeamSatzpunkte</td>\n
        <td class=\"gesamtsumme\"><b>$gastTeamHolz</b></td>\n";

// Differenz und Vorzeichen aus dbDifferenz.txt auslesen
$dateiDifferenz = '../resources/dbDifferenz.txt';
$inhaltDifferenz = file_get_contents($dateiDifferenz);

// Differenz und Vorzeichen in einzelne Werte aufteilen
$differenz = explode('|', $inhaltDifferenz);

// Differenz und Vorzeichen zum Verständnis neue Namen zuweisen
$vorzHeim = $differenz[0];
$betragDifferenz = $differenz[1];
$vorzGast = $differenz[2];
    
// Differenz und Vorzeichen in Tabellenzeile ausgeben
echo "  <table class=\"differenztabelle\"><tr>\n
          <td class=\"differenz\">$vorzHeim</td>\n
          <td class=\"differenz\">$betragDifferenz</td>\n
          <td class=\"differenz\">$vorzGast</td>\n
        </tr></table>\n";
?>

    </tr>
</table>

</center>
</body>
</html>