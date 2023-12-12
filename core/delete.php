<?php
// Name des Gastteams mit "Gastmannschaft" überschreiben
$inhalt0 = "Gäste";
$datei0 = fopen("../resources/dbGastTeam.txt", "a");
ftruncate($datei0, 0);
fwrite($datei0, $inhalt0);
fclose($datei0);

// Namen der Spieler mit "" und Sätze mit 0 überschreiben
$inhalt1 = "|0|0|0|0|0|0|0|0|0|0|0|0|0|0|\n|0|0|0|0|0|0|0|0|0|0|0|0|0|0|\n|0|0|0|0|0|0|0|0|0|0|0|0|0|0|\n|0|0|0|0|0|0|0|0|0|0|0|0|0|0|\n|0|0|0|0|0|0|0|0|0|0|0|0|0|0|\n|0|0|0|0|0|0|0|0|0|0|0|0|0|0|";
$datei1 = fopen("../resources/dbPaarungen.txt", "a");
ftruncate($datei1, 0);
fwrite($datei1, $inhalt1);
fclose($datei1);

// Gesamtsummen mit 0 überschreiben
$inhalt2 = "0|0|0|0|0|0";
$datei2 = fopen("../resources/dbGesamt.txt", "a");
ftruncate($datei2, 0);
fwrite($datei2, $inhalt2);
fclose($datei2);

// Differenz und Vorzeichen mit "" überschreiben
$inhalt3 = "||";
$datei3 = fopen("../resources/dbDifferenz.txt", "a");
ftruncate($datei3, 0);
fwrite($datei3, $inhalt3);
fclose($datei3);

// Weiterleiten zur Eingabemaske
header("Location:logedin.php");
exit();
?>