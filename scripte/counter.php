<?php
error_reporting(255);
// Hinweise zur Counter-Konfiguration
// ==================================
//
// Aufruf mit :
//       counter.php?style=x [erlaubte Werte fuer x: 0-13]
// oder :
//       $style = 5;
//       include ("scripte/counter.php");
//
//  bei eigenen Grafiken:
//  Bildern muessen im Format x-y.typ vorliegen
//  wobei
//  x den Countertyp angibt welcher in der Variablen $style definiert ist.
//  y die Ziffer [0-9]
//
//  $url_to_images gibt die URL (http://xxxxxxx) zu dem Verzeichnis der
//  Grafiken an und ist standardmaeßig fuer die KONTENT-Grafiken gesetzt
// --------------------------------------------------------------------------


// ###################### Konfiguration ###############################

// Datei in welcher der
// Counterstand gespeichert wird
// -------------------------------
$counterfile = "counter.txt";

// Style welcher gewaehlt wird
// wenn kein Style angegeben wurde
// -------------------------------
$defaultstyle = 0 ;

// IP-Sperre
// 1 - counter wird nur aktualisiert wenn
//     der Aufruf von einer anderen IP-Adresse erfolgt.
// 0 - counter wird immer aktualisiert ( IP-Sperre aus )
// -----------------------------------------------------
$ipsperre = 1;


// ###################### Konfiguration ENDE ##########################

// AB HIER bitte nichts mehr aendern solange Sie sich
// nicht ueber die Folgen im Klaren sind
// -----------------------------------------------------------------------------------
$Domain=eregi_replace(".*\.([a-z0-9\-]*)\.([a-z]*)$","\\1.\\2",getenv("SERVER_NAME"));
$url_to_images="http://$Domain/.kontent/counter-images";


$ip = getenv("REMOTE_ADDR");
// Counter lesen
// ==============
if (! file_exists($counterfile)) {
  if($datei=fopen($counterfile,"w")) {
    flock($datei, 2);
    $output = "1:".$ip.": ";
    fwrite($datei, $output);
    flock($datei, 3);
    fclose($datei);
    chmod ($counterfile,0664);
  } else {
    echo "Konnte Counterdatei nicht anlegen";
  }
}

if (file_exists($counterfile)) {
  if ($datei=fopen($counterfile,"r+")) {
    flock($datei, 2);
    $count = fread($datei, filesize($counterfile));
    list($count,$old_ip,$dummy) = split(":", $count);
    $counter = $count;
    $ip = trim($ip);
    $old_ip = trim($old_ip);
    if ( (isset($ipsperre) && $ipsperre == 0 ) || $ip != $old_ip ) {
      $count ++;
    }
    $output = $count.":".$ip.": ";
    fseek($datei, 0);
    fwrite($datei, $output);
    flock($datei, 3);
    fclose($datei);

    // sicherheitshalber / am Ende vom Pfad entfernen
    $url_to_images=ereg_replace("/$","",$url_to_images);

    if ( ! isset($style) || $style < 0 || $style > 13 ) {
      $style = $defaultstyle;
    }

    $stellen=strlen($counter);
    // Ausgabe des Counters
    // =====================
    for ($anzahl=0; $anzahl < $stellen; $anzahl++) {
      $image="$style-".substr($counter,$anzahl,1).".gif";
      echo "<img src=\"$url_to_images/$image\" border=\"0\" alt=\"counter\">";
    }
  } else {
    echo "Konnte Counterdatei nicht öffnen";
  }
}
?>
