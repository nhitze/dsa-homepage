<?php
error_reporting(21); 
$Domain=eregi_replace(".*\.([a-z0-9\-]*)\.([a-z]*)$","\\1.\\2.\\3.",getenv("SERVER_NAME"));

// ======================================================================================
//                                 Konfigurations-Teil
// ======================================================================================

$gbFile = "gaestebuch.html"; // Location of link database file
$gbPage = "gaestebuch-add.php";  // Link page file
$allowHTML = 0;	// To allow HTML in site description 1 = Yes, 0 = No
$notify = 1; // Would you like to be notified when a link is added? 1 = yes, 0 = No
$my_email = "webmaster@$Domain"; // Enter your email address
$subject = "Example Issues List Entry"; // Enter the subject of the notification email

// ======================================================================================
//                                 Ende des Konfigurations-Teil
// ======================================================================================


if ($gb=="Eintragen") {
  $error='';
  if ( $comments=='' || $name=='' || $email=='') {
    echo "<p><font color=\"Red\">Bitte füllen Sie alle Felder vollständig aus !</font></p>";
    $error=1;
  } else {
    $page = $gbFile;
    if ($allowHTML == 0) {
      $name = ereg_replace("<","&lt;",$name);
      $name = ereg_replace(">","&gt;",$name);
      $email = ereg_replace("<","&lt;",$email);
      $email = ereg_replace(">","&gt;",$email);
      $url = ereg_replace("<","&lt;",$url);
      $url = ereg_replace(">","&gt;",$url);
      $urltitle = ereg_replace("<","&lt;",$urltitle);
      $urltitle = ereg_replace(">","&gt;",$urltitle);
      $referral = ereg_replace("<","&lt;",$referral);
      $referral = ereg_replace(">","&gt;",$referral);
      $comments = ereg_replace("<","&lt;",$comments);
      $comments = ereg_replace(">","&gt;",$comments);
    }

    $filename = $gbFile;
    $fd = fopen( $filename, "r" );
    $current = fread( $fd, filesize( $filename ) );
    fclose( $fd );

    $comments = ereg_replace("\n","<BR>",$comments);

    $fileMessage = "<HR NOSHADE SIZE=1>\n";
    $fileMessage .= "<P><b>Name: </b>$name\n";
    $fileMessage .= "<br><b>Datum:</b> ";
    $fileMessage .= (date(" l Y-m-d H:i:s"));
    $fileMessage .= "<br><b>Email: </b><a href=\"mailto:$email\">$email</a>\n";
    $fileMessage .= "<br><b>Nachricht:</b>\n";
    $fileMessage .= "<br>$comments\n";
    $fileMessage .= "$current\n";

    if (file_exists("$page")) {
      $cartFile = fopen("$page","w+");
      fputs($cartFile,$fileMessage);
      fclose($cartFile);
    } else {
      $cartFile = fopen("$page","w");
      fputs($cartFile,$fileMessage);
      chmod ($page, 0664);
      fclose($cartFile);
    }

    if ($notify == 1) {
      $comments = ereg_replace("<BR>","\n",$comments);
      mail("$my_email", "Example Issues List Entry", "Name : $name Email : $email Note: $comments\n", "From: gaestebuch@$Domain\n");
      
      $comments='';
      $name='';
      $email='';
    }
  }
}

include($gbPage);
?>
