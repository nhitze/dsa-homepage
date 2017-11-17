<HTML>
<?php
$Domain=eregi_replace(".*\.([a-z0-9\-]*)\.([a-z]*)$","\\1.\\2",getenv("SERVER_NAME"));
?>

<HEAD>
   <TITLE> Gästebuch - Einträge der Domain <?php echo "$Domain"; ?></TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<P><FONT SIZE="-1" FACE="verdana,arial"><B> Gästebuch - Einträge der Domain <?php echo "$Domain"; ?></p>
<p><A HREF="#bottom">Eintrag hinzufügen</A></B></P>
<P><!-- This is where the message database is loaded -->
<?php
  if (file_exists("gaestebuch.html") && ( $error!=1 )) {
    include("gaestebuch.html");
  }
?>
<!-- End messages -->

<!-- This is the form to add messages -->
<HR NOSHADE SIZE=1>
<A NAME="bottom"></A><P><FONT SIZE="-1" FACE="verdana,arial" COLOR="#000078"><B>Eintrag hinzufügen</B></FONT><FONT SIZE="-1" FACE="verdana,arial">
<FORM ACTION="gaestebuch.php" METHOD=POST>
   <P><FONT SIZE="-1" FACE="verdana,arial">Name:<BR><INPUT TYPE=text NAME=name VALUE="<?php echo $name; ?>" SIZE=40><BR>
   Email:<BR><INPUT TYPE=text NAME=email VALUE="<?php echo $email; ?>" SIZE=40><BR>
   Ihre Nachricht:<BR><TEXTAREA NAME=comments ROWS=10 COLS=60 WRAP=virtual><?php echo $comments; ?></TEXTAREA></FONT></P>
   
   <P><FONT SIZE="-1" FACE="verdana,arial"><INPUT TYPE=submit NAME=gb VALUE="Eintragen"></FONT>
</FORM></FONT></P>

<P ALIGN=right><FONT SIZE="-1" FACE="verdana,arial"></FONT><A HREF="#top"><FONT SIZE="-1" FACE="verdana,arial">top</FONT></A></P>
</BODY>
</HTML>
