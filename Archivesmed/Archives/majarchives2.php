<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<script type="text/javascript">
	<!--
		function majdate()
		{
		today          = new Date();
		ladate           = today.getDate();
		if (ladate < 10) ladate = '0' + ladate
		month          = today.getMonth()+1;
		if (month < 10) month = '0' + month
		year           = today.getFullYear();
		ladate = ladate + '/' + month + '/' + year;
		document.forms[0].DATE.value = ladate;
		}
	// -->
	</script>
<title>ARCHIVES MEDICALES</title>
</head>

<body bgcolor="#E2E2E2">
<?php
require ('archives_inc.php');
$dbd=mysql_connect("localhost","archives","archives");
$res= mysql_select_db("archives",$dbd) ;
$message="";

$NOM="";
$PRENOM="";
$DATENAISSANCE="";
$NOMJF="";
//echo "B1 : $B1 $action ";
if ($action == 'submitted') 
     {
     //     echo "SELECT  * FROM archive where NPP=$NPP";
     if (!(identitehexagone($NPP,$NOM,$PRENOM,$NOMJF,$DATENAISSANCE) or identite($NPP,$NOM,$PRENOM,$NOMJF,$DATENAISSANCE)))
    		{
    		$message="NPP INCONNU ...";
          $SITUATION="";
          $DATE="";
          $TRAVEE="";
          $CASIER="";
          $EXERCICE="";
    		}
    		else
    		{;

     	$id=@mysql_query("SELECT  * FROM archive where NPP=$NPP",$dbd);
     	if (@$B1=="Enregistrer") /* On a cliqué sur Enregistrer */
               {
          //   echo "nb enregistrements : " . mysql_num_rows($id);
               $mysqldate=to_mysql_date($DATE);
               if (mysql_num_rows($id)!=1) 
                    { /* le NPP n'existe pas dans la base archive on le crée - il faudrait vérifier qu'il existe dans ta table identité */
                //  echo "INSERT INTO archive  ($NPP,'$SITUATION','$mysqldate','$TRAVEE','$CASIER','$EXERCICE')" ;
                    $id=mysql_query("INSERT INTO archive  (npp,situation,datemouvement,travee,casier,exercice) values ($NPP,'$SITUATION','$mysqldate','$TRAVEE','$CASIER','$EXERCICE')",$dbd)or die("erreur INSERT");             
                    $message="Le dossier a été créé";
                    }
               else
                    { /* le NPP existe dans la base archive - maj de l'enregistrement */
          //        echo "UPDATE  archive  SET situation= '$SITUATION',datemouvement=$mysqldate,travee='$TRAVEE',casier='$CASIER',exercice='$EXERCICE' WHERE npp=$NPP ";
                    $id=@mysql_query("UPDATE  archive  SET situation= '$SITUATION', datemouvement='$mysqldate', travee='$TRAVEE',casier='$CASIER',exercice='$EXERCICE' WHERE npp=$NPP ",$dbd)or die ("erreur maj archive");
                    $message="Le dossier a été mis à jour";
                    }
               }
          else /* On a saisie un NPP */
               {
               $res = mysql_fetch_array($id);
               $SITUATION=$res[1];
               $DATE=from_mysql_date($res[2]);
               $TRAVEE=$res[3];
               $CASIER=$res[4];
               $EXERCICE=$res[5];
               if (!is_array($res)) $message="Dossier inconnu aux archives" ; else $message="";
               }
     	}
     }
else
     {
     $NPP="";
     $SITUATION="";
     $DATE="";
     $TRAVEE="";
     $CASIER="";
     $EXERCICE="";
     }
		
?>

<p align="center"><img src="/images/titres/archives.gif" alt="Archives médicales" ></p>
<font size ="2" face="Arial"> <a href="/Archives/selectarchives.html">Liste de dossiers</a></font><img src="/newanime.gif" alt="nouveau">
<?
if ((strlen($NPP)>1)&&($action == 'submitted')&&(((identitehexagone($NPP,$NOM,$PRENOM,$NOMJF,$DATENAISSANCE) or identite($NPP,$NOM,$PRENOM,$NOMJF,$DATENAISSANCE)))))
     {print "<br><font size =\"2\" face=\"Arial\"> <a href=\"/Archives/imp_archives.php?NPP=".$NPP."&NOM=".$NOM."&PRENOM=".$PRENOM."\">Etiquette du dossier</a></font><img src=\"/newanime.gif\" alt=\"etiquettes\">";
     }

?>
<form  method="POST" action="majarchives2.php">
  <div align="center">
    <center><font face="Arial">
    <TABLE bgcolor="#0000FF" BORDER="5" CELLSPACING="0" CELLSPADDING="15"><TR VALIGN=CENTER ALIGN=CENTER><TD VALIGN=CENTER ALIGN=CENTER>
    <table BGCOLOR="#B7DBFF" BORDERCOLOR="#FFFFFF"  BORDER="1"  CELLSPACING="0" CELLSPADDING="14" width="401" height="273">
      <tr >
        <td width="151" height="26"><font face="Arial">NPP&nbsp;</font></td>
        <td width="234" height="26"><input type="text" name="NPP" size="20" id="fp1" onblur="form.submit(); " value= "<?php echo $NPP?>" ></td>
      </tr>
      <tr >
        <td width="151" height="27"> <font face="Arial">Nom&nbsp;</font> </td>
        <td width="234" height="27"> <?php echo $NOM ?> </td>
      </tr>
      <tr>
        <td width="151" height="27"><font face="Arial">Pr&eacute;nom&nbsp;</font></td>
        <td width="234" height="27"><?php echo $PRENOM ?></td>
      </tr>
      <tr>
        <td width="151" height="27"><font face="Arial">Nom jeune fille&nbsp;</font></td>
        <td width="234" height="27"><?php echo $NOMJF ?></td>
      </tr>
      <tr>
        <td width="151" height="27"><font face="Arial">Date de naissance&nbsp;</font> </td>
        <td width="234" height="27"><?php echo $DATENAISSANCE ?></td>
      </tr>
      <tr>
        <td width="151" height="27"><label for="fp2"><font face="Arial">Situation&nbsp;</font> </label></td>
        <td width="234" height="27"><input type="text" name="SITUATION" size="10" id="fp2" onchange="majdate();"  value= "<?php echo $SITUATION ?>" ></td>
      </tr>
      <tr>
        <td width="151" height="24"><label for="fp3"><font face="Arial">Date&nbsp;</font> </label></td>
        <td width="234" height="24"><input type="text" name="DATE" size="10" id="fp3" value= "<?php echo $DATE ?>" ></td>
      </tr>
      <tr>
        <td width="151" height="29"><label for="fp4"><font face="Arial">Travée/Service&nbsp;</font> </label></td>
        <td width="234" height="29"><input type="text" name="TRAVEE" size="30" id="fp4" value= "<?php echo $TRAVEE ?>" ></td>
      </tr>
      <tr>
        <td width="151" height="29"><label for="fp5"><font face="Arial">Casier&nbsp;</font> </label></td>
        <td width="234" height="29"><input type="text" name="CASIER" size="20" id="fp5" value= "<?php echo $CASIER ?>" ></td>
      </tr>
      <tr>
        <td width="151" height="24"><label for="fp6"><font face="Arial">Exercice
          </font> </label></td>
        <td width="234" height="24"><input type="text" name="EXERCICE" size="7" id="fp6" value= "<?php echo $EXERCICE ?>" ></td>
      </tr>
      <tr>
        <td  height="30" colspan=2>  <font face="Arial"><b> <?php echo $message ?> </b></font> </td>
        
      </tr>
    </table>
    </TD><TR><TABLE>
    </font>
    </center>
  </div>
<br>
   <p> <input type="reset" value="Rétablir" name="B1">
      <input type="submit" value="Rechercher" name="B1">
   <input type="submit" value="Enregistrer" name="B1">
</p>

 
   <input type="hidden" name="action" value="submitted">
   <input type="hidden" name="NOM"  value= "<?php echo $NOM ?>" >
   <input type="hidden" name="PRENOM"  value= "<?php echo $PRENOM ?>"
   <input type="hidden" name="DATENAISSANCE"  value= "<?php echo $DATENAISSANCE ?>" >
</form>


</body>
</html>
