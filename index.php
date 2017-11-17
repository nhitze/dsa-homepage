<?php
  echo("<html>\n");
  echo("<head>\n");
  echo("<title>DSA - Zauber</title>\n");
  echo("<link rel='stylesheet' href='css/dsa-style.css' type='text/css'>\n");
  echo("</head>\n");
  echo("<body>\n\n");

  if($link=='detail')
   {
    $db = mysql_connect("mainframe","root","");
    mysql_select_db("dsa");
    $res = mysql_query("SELECT zauber.*, herkunft.herkunft, typ.typ
      FROM zauber, herkunft, typ
       WHERE zauber.id = '$id'
        AND zauber.hkid = herkunft.id
        AND zauber.tid = typ.id");
    $num = mysql_num_rows($res);

    while ($row=mysql_fetch_row($res))
     {
      $t  = $row[11];

      $s = $row[3];
      $p = $row[4];
      $k = $row[5];
      $rw = $row[6];
      $zd = $row[7];
      $d = $row[8];
      $b = $row[9];

      echo ("<form action='index.php' method='post'>\n");

      echo ("<table class='detail' cellspacing='0' cellpadding='0' align='center'>\n");
      echo (" <tr>\n");
      echo ("  <td>\n");

      echo ("<table width='100%'>\n");
      echo (" <tr>\n");
      echo ("  <td class='input' align='center'>$t</td>\n");
      echo (" </tr>\n");
      echo ("</table>\n");

      echo ("<table width='100%' cellspacing='2' cellpadding='0' align='center'>\n");
      echo (" <tr>\n");
      echo ("  <td>Spruch</td>\n");
      echo ("  <td>Probe</td>\n");
      echo ("  <td align='center'>Kosten</td>\n");
      echo ("  <td align='center'>Reichweite</td>\n");
      echo ("  <td align='center'>Zauberdauer</td>\n");
      echo ("  <td align='center'>Dauer</td>\n");
      echo (" </tr>\n");
      echo (" <tr>\n");
      echo ("  <td class='zauber'>$s</td>\n");
      echo ("  <td class='zauber' align='center'>$p</td>\n");
      echo ("  <td class='zauber' align='center'>$k</td>\n");
      echo ("  <td class='zauber' align='center'>$rw</td>\n");
      echo ("  <td class='zauber' align='center'>$zd</td>\n");
      echo ("  <td class='zauber' align='center'>$d</td>\n");
      echo (" </tr>\n");
      echo ("</table>\n");

      echo ("<table width='100%' cellspacing='0' align='center'>\n");
      echo (" <tr>\n");
      echo ("  <td class='zauber' align='center'>$b</td>\n");
      echo (" </tr>\n");
      echo ("</table>\n");

      echo ("  </td>\n");
      echo (" </tr>\n");
      echo ("</table>\n");

      echo ("</form>\n");
     }
   }

if($link=='')
 {
  $proseite = 30;
  $start=$page * $proseite;
  $ende = $start + $proseite;

    $db = mysql_connect("mainframe","root","");
    mysql_select_db("dsa");
  $result = mysql_query("SELECT * FROM zauber");

  $zeilen = mysql_num_rows($result);
  $seiten = floor($zeilen/$proseite);

  $res = mysql_query("
   SELECT zauber.*, herkunft.herkunft, typ.typ
    FROM zauber, herkunft, typ
     WHERE zauber.tid = typ.id
      AND zauber.hkid = herkunft.id
       AND zauber.tid = typ. id
     ORDER BY zauber.tid ASC
     LIMIT $start,$proseite");

  $num = mysql_num_rows($res);

  if ($ende>zeilen)
   {
    $ende = $zeilen;
   }

   if($num < 1)
    {
     echo ("<table align='center'>");
     echo (" <tr>");
     echo ("  <td>");
     echo ("Es sind keine Datens&auml;tze verf&uuml;gbar.");
     echo ("  </td>");
     echo (" </tr>");
     echo ("</table>");
    }
   else
    {
     echo ("<table cellspacing='2' align='center'>\n");
     echo ("    <tr>\n");
     echo ("     <td>Typ</td>");
     echo ("     <td>Spruch</td>\n");
     echo ("     <td width='5'>&nbsp;</td>\n");
     echo ("     <td>Herkunft</td>\n");
     echo ("     <td></td>\n");
     echo ("    </tr>\n");

     while ($row=mysql_fetch_row($res))
      {
       $id = $row[0];
       $s = $row[3];
       $hk = $row[10];
       $t = $row[11];

       echo ("    <tr>\n");
       echo ("     <td class='feld'></td>\n");
       echo ("     <td class='feld'>\n");
       echo ("      <a href='index.php?link=detail&id=$id'>$s</a>\n");
       echo ("     </td>\n");
       echo ("     <td width='5'>&nbsp;</td>\n");
       echo ("     <td class='feld'>$hk</td>\n");
       echo ("    </tr>\n");
      }

      if ($page>0)
       {
        $i=$page-1;
        echo ("<a href=\"index.php?page=$i\">&lt;previous</a>");
       }

      for($i=0; $i<=$seiten; $i++)
       {
        if ($i==$page)
         {
          echo ($i."&nbsp;");
         }
        else
         {
          echo ("<a href=\"index.php?page=$i\">$i</a>&nbsp;");
         }
       }

      if ($page<$seiten)
       {
        $i=$page+1;
        echo ("<a href=\"index.php?page=$i\">next&gt;</a>");
       }
    }
  }

  echo("</body>\n");
  echo("</html>\n");
?>