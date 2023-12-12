<?php
// Gastmanschaft auslesen und in $gastteam speichern
if (isset($_POST["gastteam"]) && !preg_match('/[$<>!?=;]/', $_POST["gastteam"])) {
    $gastTeamName = $_POST["gastteam"];
}
else {
    $gastTeamName = "Zeichenfehler";
}

// Namen der Gastmannschaft in dbGastTeam.txt (über)schreiben
$inhalt0 = "$gastTeamName";
$datei0 = fopen("../resources/dbGastTeam.txt", "a");
ftruncate($datei0, 0);
fwrite($datei0, $inhalt0);
fclose($datei0);

// Einzelergebnisse berechnen
// Schleife beginnen und für jede Paarung wiederholen ($i = Nummer der Paarung)
for ($i = 1; $i <= 6; $i++) {
    
    // Namen der Heimspieler auslesen und in $heimSpieler[] speichern
    if (isset($_POST["heim{$i}name"]) && !preg_match('/[$<>!?=;]/', $_POST["heim{$i}name"])) {
        $heimSpieler[$i] = $_POST["heim{$i}name"];
    }
    else {
        $heimSpieler[$i] = "Zeichenfehler";
    }

    // Namen der Gastspieler auslesen und in $gastSpieler[] speichern
    if (isset($_POST["gast{$i}name"]) && !preg_match('/[$<>!?=;]/', $_POST["gast{$i}name"])) {
        $gastSpieler[$i] = $_POST["gast{$i}name"];
    }
    else {
        $gastSpieler[$i] = "Zeichenfehler";
    }

    // Werte der einzelnen Sätze auslesen und in $heimSatz[][] bzw. $gastSatz[][] speichern ($j = Nummer des Satzes)
    for ($j = 1; $j <= 4; $j++) {
        if (isset($_POST["heim{$i}satz{$j}"])) {
            $heimSatz[$i][$j] = $_POST["heim{$i}satz{$j}"]; // Satz des Heimspielers
        }
        if (!is_numeric($heimSatz[$i][$j])) {
            $heimSatz[$i][$j] = 0; // Falls die Eingabe keine Zahl ist, durch 0 ersetzen
        }
        if (isset($_POST["gast{$i}satz{$j}"])) {
            $gastSatz[$i][$j] = $_POST["gast{$i}satz{$j}"]; // Satz des Gastspielers
        }
        if (!is_numeric($gastSatz[$i][$j])) {
            $gastSatz[$i][$j] = 0; // Falls die Eingabe keine Zahl ist, durch 0 ersetzen
        }
    }

    // Gesamtholz pro Spieler berechnen und in $heimHolz[] bzw. $gastHolz[] speichern
    if (isset($heimSatz[$i][1])) {
        $heimHolz[$i] = array_sum($heimSatz[$i]);
    }
    if (isset($gastSatz[$i][1])) {
        $gastHolz[$i] = array_sum($gastSatz[$i]);
    }

    // Satzpunkte der Paarung berechnen und in $heimSatzpunkte[] bzw. $gastSatzpunkte[] speichern
    $heimSatzpunkte[$i] = 0;
    $gastSatzpunkte[$i] = 0;
    for ($j = 1; $j <= 4; $j++) {
        if ($heimSatz[$i][$j] > 0 || $gastSatz[$i][$j] > 0) {
            if ($heimSatz[$i][$j] > $gastSatz[$i][$j]) {$heimSatzpunkte[$i]++;}
            if ($heimSatz[$i][$j] < $gastSatz[$i][$j]) {$gastSatzpunkte[$i]++;}
            if ($heimSatz[$i][$j] == $gastSatz[$i][$j]) {$heimSatzpunkte[$i] += 0.5; $gastSatzpunkte[$i] += 0.5;}
        }
    }

    // Mannschaftspunkte der Paarung berechnen und in $heimMannschaftspunkte[] bzw. $gastMannschaftspunkte[] speichern
    $heimMannschaftspunkte[$i] = 0;
    $gastMannschaftspunkte[$i] = 0;
    if ($heimHolz[$i] > 0 || $gastHolz[$i] > 0) {
        if ($heimSatzpunkte[$i] == $gastSatzpunkte[$i]) { // Prüfen ob Satzpunkte gleich sind und dann Holzzahl vergleichen
            if ($heimHolz[$i] > $gastHolz[$i]) {$heimMannschaftspunkte[$i]++;} // Heim gewinnt
            if ($heimHolz[$i] < $gastHolz[$i]) {$gastMannschaftspunkte[$i]++;} // Gast gewinnt
            if ($heimHolz[$i] == $gastHolz[$i]) {$heimMannschaftspunkte[$i] += 0.5; $gastMannschaftspunkte[$i] += 0.5;} // Unendschieden
        }
        else {
            if ($heimSatzpunkte[$i] > $gastSatzpunkte[$i]) {$heimMannschaftspunkte[$i]++;} // Heim gewinnt
            if ($heimSatzpunkte[$i] < $gastSatzpunkte[$i]) {$gastMannschaftspunkte[$i]++;} // Gast gewinnt
        }
    }
}

// Spielernamen und berechnete Werte in dbPaarungen.txt (über)schreiben
for ($i = 1; $i <= 6; $i++) {
    $paarung[$i] = "".$heimSpieler[$i]."|".$heimSatz[$i][1]."|".$heimSatz[$i][2]."|".$heimSatz[$i][3]."|".$heimSatz[$i][4]."|".$heimHolz[$i]."|".$heimSatzpunkte[$i]."|".$heimMannschaftspunkte[$i]."|".$gastMannschaftspunkte[$i]."|".$gastSatzpunkte[$i]."|".$gastHolz[$i]."|".$gastSatz[$i][4]."|".$gastSatz[$i][3]."|".$gastSatz[$i][2]."|".$gastSatz[$i][1]."|".$gastSpieler[$i]."";
}
$inhalt1 = "".$paarung[1]."\n".$paarung[2]."\n".$paarung[3]."\n".$paarung[4]."\n".$paarung[5]."\n".$paarung[6]."";
$datei1 = fopen("../resources/dbPaarungen.txt", "a");
ftruncate($datei1, 0);
fwrite($datei1, $inhalt1);
fclose($datei1);

// Gesamtsummen der Teams ausrechnen und in $heimTeam*/$gastTeam* speichern
$heimTeamHolz = array_sum($heimHolz);
$heimTeamSatzpunkte = array_sum($heimSatzpunkte);
$heimTeamMannschaftspunkte = array_sum($heimMannschaftspunkte);
$gastTeamHolz = array_sum($gastHolz);
$gastTeamSatzpunkte = array_sum($gastSatzpunkte);
$gastTeamMannschaftspunkte = array_sum($gastMannschaftspunkte);

// Zwei Mannschaftspunkte für Gesamtkegel addieren
if ($heimTeamHolz > 0 || $gastTeamHolz > 0) {
    if ($heimTeamHolz > $gastTeamHolz) {$heimTeamMannschaftspunkte += 2;}
    if ($heimTeamHolz < $gastTeamHolz) {$gastTeamMannschaftspunkte += 2;}
    if ($heimTeamHolz == $gastTeamHolz) {$heimTeamMannschaftspunkte++; $gastTeamMannschaftspunkte++;}
}

// Gesammtsummen in dbGesamt.txt (über)schreiben
$inhalt2 = "$heimTeamHolz|$heimTeamSatzpunkte|$heimTeamMannschaftspunkte|$gastTeamMannschaftspunkte|$gastTeamSatzpunkte|$gastTeamHolz";
$datei2 = fopen("../resources/dbGesamt.txt", "a");
ftruncate($datei2, 0);
fwrite($datei2, $inhalt2);
fclose($datei2);

// Differenz berechnen und in $holzDifferenz speichern
$holzDifferenz = abs($heimTeamHolz - $gastTeamHolz);
if ($holzDifferenz == 0) {$holzDifferenz = "";}

// Vorzeichen generieren und in $heimVorzeichen  bzw. $gastVorzeichen speichern
$heimVorzeichen = "";
$gastVorzeichen = "";
if ($heimTeamHolz > $gastTeamHolz) {$heimVorzeichen = "&plus;"; $gastVorzeichen = "&minus;";}
if ($heimTeamHolz < $gastTeamHolz) {$heimVorzeichen = "&minus;"; $gastVorzeichen = "&plus;";}

// Differenz und Vorzeichen in dbDifferenz.txt (über)schreiben
$inhalt3 = "$heimVorzeichen|$holzDifferenz|$gastVorzeichen";
$datei3 = fopen("../resources/dbDifferenz.txt", "a");
ftruncate($datei3, 0);
fwrite($datei3, $inhalt3);
fclose($datei3);

// Weiterleiten zur Eingabemaske
header("Location:logedin.php");
exit();
?>