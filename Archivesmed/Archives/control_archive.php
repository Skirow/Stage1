<html>

<head>


<title>TEST</title>
<STYLE>
	.vis1	{ visibility:"visible" }
	.vis2	{ visibility:"hidden" }
</STYLE>
<SCRIPT>
function window.onbeforeprint()
{
B1.className='vis2';
IM1.className='vis2';
}
function window.onafterprint()
{
B1.className='vis1';
IM1.className='vis1';
}
</SCRIPT>
</head>

<body >
<p><img ID=IM1 src="../images/titres/archives.gif" alt="Archives M&eacute;dicales"" WIDTH="421" HEIGHT="59"></p>
  <span style="font-family: trebuchet ms, arial, helvetica; font-size: 7pt;">Conception
      et r&eacute;alisation DIM CH CAHORS </span>

<?php
require ('archives_inc.php');
function control_archive($results)
	{
	echo "DEBUT\n";
	$dbd=mysql_connect("localhost","archives","archives");
     $res= mysql_select_db("archives",$dbd) ;
	$id=@mysql_query("SELECT  * FROM archive ORDER BY npp",$dbd);
	$res="";
     $i=0;
     $results=array();
     
     while($res = mysql_fetch_row($id))
     	{echo "-";
     	$NPP=str_pad ( $res[0],10 , "0", STR_PAD_LEFT);
     	if (!identitehexagone($NPP,$NOM,$PRENOM,$NOMJF,$DATENAISSANCE))
     		{echo "+";
//     		$res[2]=from_mysql_date($res[2]);
//     		array_push($results,$res);
//     		$i++;
//     		echo $i;
		}
	}
	return($i);
	}




?>
<font size="4" face="Arial">
<br><center>
<b>LISTE DES NPP ABSENT d'HEXAGONE <br>
</b></font></p>
 </center>
<?php
control_archive($results);;
echo "<pre>";
printf("|%'-10s-|%'-12s-|%'-12s-|%'-7s-|%'-7s-|%'-9s-|\n", "-","-","-","-","-","-");
printf("|% 10s |% 12s |% 12s |% 7s |% 7s |% 9s |\n", "NPP","SITUATION","DATE","TRAVEE","CASIER","EXERCICE");
printf("|%'-10s-|%'-12s-|%'-12s-|%'-7s-|%'-7s-|%'-9s-|\n", "-","-","-","-","-","-");

for ($i =0; $i < sizeof($results); $i++)
	{ 
	printf("|% 10s |% 12s |% 12s |% 7s |% 7s |% 9s |\n", $results[$i][0],$results[$i][1],$results[$i][2],$results[$i][3],$results[$i][4],$results[$i][5]);
	}
printf("|%'-10s-|%'-12s-|%'-12s-|%'-7s-|%'-7s-|%'-9s-|\n", "-","-","-","-","-","-");
echo "</pre>";
?>

<br><br><br>

<input ID=B1 TYPE="submit" NAME="Submit" VALUE="Imprimer" ONCLICK=window.print();>

</body>
</html>
