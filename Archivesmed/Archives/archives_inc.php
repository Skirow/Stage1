<?php
function from_mysql_date($date)
        {
        if ($date!="" )
                return(substr($date,8,2) ."/".  substr($date,5,2). "/" . substr($date , 0,4));
        else
                return("");
        }

function to_mysql_date($date)
        {
        if ($date=="" ) return ("");
        if (strpos($date,"/"))
          {
          if (strlen($date)==10)
                {
                return(substr($date,6,4) ."-".  substr($date,3,2). "-" . substr($date , 0,2));
                }
          else
                {
                return("20" . substr($date,6,2) ."-".  substr($date,3,2). "-" . substr($date , 0,2));   
                }
          }
        else
          {
          if (strlen($date)==8)
                {
                return(substr($date,4,4) ."-".  substr($date,2,2). "-" . substr($date , 0,2));
                }
          else
                {
                return("20" . substr($date,4,2) ."-".  substr($date,2,2). "-" . substr($date , 0,2));   
                }

          }
        }               
function identite($npp,&$nom,&$prenom,&$nomjf,&$datenaissance)

     {
     
     $dbd=mysql_connect("localhost","archives","archives");
     $res= mysql_select_db("archives",$dbd) ;
     $id=@mysql_query("SELECT * FROM identite where NPP=$npp",$dbd);
     if (mysql_num_rows($id)==0)
          {
          $nom="";$prenom="";$nomjf="";$datenaissance="";
          return FALSE;
          }
     else
          {
          $row= @mysql_fetch_array($id);
          $nom=$row["nom"];
          $prenom=$row["prenom"];
          $nomjf=$row["nomjf"];
          $datenaissance=from_mysql_date($row["datenaissance"]);
          return TRUE;
          }
     }

function identitehexagone_hrpat($npp,&$nom,&$prenom,&$nomjf,&$datenaissance)
     {
    
        $dbd=oci_connect("ghp01", "ghp01","hexa");
        $npp = str_pad($npp,10,"0",STR_PAD_LEFT);
        $stmt = oci_parse($dbd,"SELECT  PATNOM,PATPRE,PATNJF, TO_CHAR(PATNAISD, 'DD/MM/YYYY') AS NAISD FROM HRPAT where PATNUM=$npp");
        oci_execute($stmt);
        $nrows = oci_fetch_all($stmt,$results);
     if ($nrows==0) 
          {
          $nom="";$prenom="";$nomjf="";$datenaissance="";
          return FALSE;
          }
     else
          {       
          $nom=$results['PATNOM'][0];
          $prenom=$results['PATPRE'][0];
          $nomjf=$results['PATNJF'][0];
          $datenaissance=$results['NAISD'][0];
          $datenaissance=$datenaissance;
          return TRUE;
          }
     }
function identitehexagone($npp,&$nom,&$prenom,&$nomjf,&$datenaissance)
     {

        $dbd=oci_connect("HX01", "HX01","hexa");
        $npp = str_pad($npp,10,"0",STR_PAD_LEFT);
        $stmt = oci_parse($dbd,"SELECT  SIPNOM,SIPPREN,PATNJF, TO_CHAR(PATNAISD, 'DD/MM/YYYY') AS NAISD FROM HVIPAT where PATNUM=$npp");
        oci_execute($stmt);
        $nrows = oci_fetch_all($stmt,$results);
     if ($nrows==0)
          {
          $nom="";$prenom="";$nomjf="";$datenaissance="";
          return FALSE;
          }
     else
          {
          $nom=$results['SIPNOM'][0];
          $prenom=$results['SIPPREN'][0];
          $nomjf=$results['PATNJF'][0];
          $datenaissance=$results['NAISD'][0];
          $datenaissance=$datenaissance;
          return TRUE;
          }
     }

function identitehexagone_trace($npp,&$nom,&$prenom,&$nomjf,&$datenaissance,&$modification,&$nouveaunpp)
     {    
        $dbd=oci_connect("hx01", "hx01","hexa");
        $npp = str_pad($npp,10,"0",STR_PAD_LEFT);
        $stmt = oci_parse($dbd,"SELECT  SIPNOM AS PATNOM,SIPPREN AS PATPRE, PATNJF, TO_CHAR(PATNAISD, 'DD/MM/YYYY') AS NAISD, PTRAOP AS MODIFICATION,PATNUMF FROM HVITRA where PATNUMT=$npp AND PTRAOP IN ('S','F')");
        oci_execute($stmt);
        $nrows = oci_fetch_all($stmt,$results);
     if ($nrows==0) 
          {
          $nom="";$prenom="";$nomjf="";$datenaissance="";
          return FALSE;
          }
     else
          { 
          $nom=$results['PATNOM'][0];
          $prenom=$results['PATPRE'][0];
          $nomjf=$results['PATNJF'][0];
          $datenaissance=$results['NAISD'][0];
          $datenaissance=$datenaissance;
          $modification=$results['MODIFICATION'][0];
          $nouveaunpp=$results['PATNUMF'][0];
          return TRUE;
          }
     }

// Recherche des NPP qui ont été fusionnés avec un npp
// $npp NPP du patient
// $nppfusion : npp fusionnés
function identitehexagone_fusion($npp,&$nom,&$prenom,&$nomjf,&$datenaissance,&$nppfusion)
     {    
        $dbd=oci_connect("hx01", "hx01","hexa");
        $npp = str_pad($npp,10,"0",STR_PAD_LEFT);
        $stmt = oci_parse($dbd,"SELECT  SIPNOM AS PATNOM,SIPPREN AS PATPRE, PATNJF, TO_CHAR(PATNAISD, 'DD/MM/YYYY') AS NAISD, PTRAOP AS MODIFICATION,PATNUMT FROM HVITRA where PATNUMF=$npp AND PTRAOP = 'F'");
        oci_execute($stmt);
        $nrows = oci_fetch_all($stmt,$results);
     if ($nrows==0) 
          { 
          $nom="";$prenom="";$nomjf="";$datenaissance="";
          return FALSE;
          }
     else
          { 
          $nom=$results['PATNOM'][0];
          $prenom=$results['PATPRE'][0];
          $nomjf=$results['PATNJF'][0];
          $datenaissance=$results['NAISD'][0];
          $datenaissance=$datenaissance;
//          $modification=$results['MODIFICATION'][0];
          $nppfusion=$results['PATNUMT'][0];
          return TRUE;
          }
     }


function cherchenpphexagone_hrpat($nom,$prenom,$nomjf,$datenaissance,$sexe,$results)
     {
     $nom=strtoupper($nom);
     $prenom=strtoupper($prenom);
     $nomjf=strtoupper($nomjf);
     $sexe=strtoupper($sexe);
     $and = FALSE;
     $dbd=oci_connect("ghp01", "ghp01","hexa");
     $stmt1= "SELECT  PATNUM, PATNOM,PATPRE, decode(PATNJF,NULL,' ',PATNJF), TO_CHAR(PATNAISD, 'DD/MM/YYYY') AS NAISD , PATSEX FROM HRPAT where ";
     if ($nom != "")
           {
            $stmt1 .= "PATNOM LIKE '$nom%' ";
            $and= TRUE;
            };
        if ($prenom != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "PATPRE LIKE '$prenom%' ";
                $and = TRUE;
                };
        if ($nomjf != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "PATNJF LIKE '$nomjf%' ";
                $and = TRUE;
                };
        if ($datenaissance != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "NAISD = $datenaissance ";
                $and = TRUE;
                };
        if ($sexe != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "PATSEX = '$sexe' ";
                $and = TRUE;
                };
        $stmt = oci_parse($dbd,$stmt1);
        oci_execute($stmt);
        $nrows=0;
        $results=array();//OCIFetchInto
        while (oci_fetch_row($stmt, $row, OCI_NUM)) {
                        array_push($results,$row);
                        $nrows++;
                        }
//      $nrows = OCIFetchStatement($stmt,$results);
        return($nrows!=0);
        }
function cherchenpphexagone($nom,$prenom,$nomjf,$datenaissance,$sexe,$results)
     {
     $nom=strtoupper($nom);
     $prenom=strtoupper($prenom);
     $nomjf=strtoupper($nomjf);
     $sexe=strtoupper($sexe);
     $and = FALSE;
     $dbd=oci_connect("hx01", "hx01","hexa");
     $stmt1= "SELECT  PATNUM, SIPNOM,SIPPREN, decode(PATNJF,NULL,' ',PATNJF), TO_CHAR(PATNAISD, 'DD/MM/YYYY') AS NAISD , PATSEX FROM HVIPAT where ";
     if ($nom != "")
           {
            $stmt1 .= "SIPNOM LIKE '$nom%' ";
            $and= TRUE;
            };
        if ($prenom != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "SIPPREN LIKE '$prenom%' ";
                $and = TRUE;
                };
        if ($nomjf != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "PATNJF LIKE '$nomjf%' ";
                $and = TRUE;
                };
        if ($datenaissance != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "NAISD = $datenaissance ";
                $and = TRUE;
                };
        if ($sexe != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "PATSEX = '$sexe' ";
                $and = TRUE;
                };
        $stmt = oci_parse($dbd,$stmt1);
        oci_execute($stmt);
        $nrows=0;
        $results=array();
        while (oci_fetch_row($stmt, $row, OCI_NUM)) {
                        array_push($results,$row);
                        $nrows++;
                        }
//      $nrows = OCIFetchStatement($stmt,$results);
        return($nrows!=0);
        }
function cherchenpparchive($nom,$prenom,$nomjf,$datenaissance,$sexe,$results)
     {
     $nom=strtoupper($nom);
     $prenom=strtoupper($prenom);
     $nomjf=strtoupper($nomjf);
     $sexe=strtoupper($sexe);
        $and = FALSE;
        $datenaissance=to_mysql_date($datenaissance);
        $dbd=mysql_connect("localhost","archives","archives");
        $res= mysql_select_db("archives",$dbd) ;
        $stmt1= "SELECT npp, nom, prenom,nomjf, datenaissance , ' ' FROM identite where ";
        if ($nom != "")
                {
                 $stmt1 .= "nom LIKE '$nom%' ";
                 $and= TRUE;
                  };
        if ($prenom != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "prenom LIKE '$prenom%' ";
                $and = TRUE;
                };
        if ($nomjf != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "nomjf LIKE '$nomjf%' ";
                $and = TRUE;
                };
        if ($datenaissance != "")
                {
                if ($and) { $stmt1 .= "AND "; }
                $stmt1 .= "datenaissance = $datenaissance ";
                $and = TRUE;            
                };
//      if ($sexe != "")
//              {
//              if ($and) { $stmt1 .= "AND "; }
//              $stmt1 .= "PATSEX = '$sexe' ";
//              $and = TRUE;
//              };
     $id=@mysql_query($stmt1,$dbd);
     $results=array();
     $i=0;
     while($res = mysql_fetch_row($id))
        {
        $res[0]=str_pad($res[0],10,"0",STR_PAD_LEFT);
        $res[4]=from_mysql_date($res[4]);
        array_push($results,$res);
        $i++;
                }
        return($i!=0);
        }
function union_identite($result1,$result2,$result3)
        {
        $result3=$result1;
        $result4=$result2;

        for ($i=0; $i < sizeof(current($result2));$i++)
                {
                $id2=$result2[$i];
                $trouve=0;
                foreach ($result1 as $id1)
                        {
                        if ($id1[0]==$id2[0])
                                {
                                $trouve=1       ;
                                break;
                                }
                        }
                if ($trouve>0)
                        {
                   //     array_splice($result4,$i,1);
                        }
                }
        $result3=array_merge($result1,$result4);
//      $result3=array_merge($result1,$result2);
        }

function print_table2 ($results)        
        {
        $nrows=sizeof(current($results));
        print "<TABLE BORDER=\"1\">\n";
        for ( $i = 0; $i < $nrows; $i++ ) {
                reset($results);
                print "<TR>\n";
                while ( $column = each($results) ) {   
                        $data = $column['value'];
                        print "<TD>$data[$i]</TD>\n";
                        }
                print "</TR>\n";
                }
        print "</TABLE>\n";
        }
function print_table ($results) 
        {
        $nrows=sizeof(current($results));
        print "<pre><TABLE BORDER=\"1\">\n";
        foreach ($results as $row)
                {
                print "<TR>\n";
                foreach  ( $row as $data) {   
                        print "<TD>$data</TD>\n";
                        }
                print "</TR>\n";
                }
        print "</TABLE></pre>\n";
        }

function print_select2($results)
        {
        $nrows=sizeof(current($results));
        print "<pre><select name=\"NPP\" size=\"1\"> \n";
        for ( $i = 0; $i < $nrows; $i++ ) {
                reset($results);
                print "<option>\n";
                while ( $column = each($results) ) {   
                        $data =$column['value'];
                        
                        print str_pad($data[$i],20) ." |\n";
                        }
                print "</option>\n";
                }
        print "</select></pre>\n";
        }
function print_select($results)
        {
        $nrows=sizeof(current($results));
        print " <br><select style=\"font-family: Courier New;\"  name=\"NPP\" size=\"1\"> \n";
        foreach ($results as $row)              {
                print "<option>\n";
               // foreach  ( $row as $data) {   
               //         print (str_replace(" ","&nbsp;",str_pad($data,10))) ." |\n";
               //         }               
                print (str_replace(" ","&nbsp;",str_pad($row[0],10))) ." |";
                print (str_replace(" ","&nbsp;",str_pad($row[1],15))) ." |";
                print (str_replace(" ","&nbsp;",str_pad($row[2],10))) ." |";
                print (str_replace(" ","&nbsp;",str_pad($row[3],10))) ." |";
                print (str_replace(" ","&nbsp;",str_pad($row[4],10))) ." |";
                print (str_replace(" ","&nbsp;",str_pad($row[5],2))) ;
                print " </option>\n";
                }
        print "</select>\n";
        }

function select_archives($datedebut,$datefin,$situation,$service,$exercice,$results)
        {
        $datedebut=to_mysql_date($datedebut);   
        $datefin=to_mysql_date($datefin);
        $dbd=mysql_connect("localhost","root","");
        $res=mysql_select_db("archives",$dbd) ;
        if ($datedebut == "") { $clause =""; } else {$clause= " AND datemouvement >='$datedebut' ";}
        if ($datefin == "")   { $clause .=""; } else {$clause .= " AND datemouvement <='$datefin' ";}
        if ($service == "")   { $clause .=""; } else {$clause .= " AND TRAVEE ='$service' ";}
        if ($exercice == "")  { $clause .=""; } else {$clause .= " AND EXERCICE ='$exercice' ";}
      $id=@mysql_query("SELECT  npp, situation , datemouvement, travee, casier, exercice FROM archive where situation='$situation' " . $clause . " ORDER BY NPP",$dbd);
     $res="";
     $i=0;
     $results=array();
     while($res = mysql_fetch_row($id))
        {
        $res[2]=from_mysql_date($res[2]);
        array_push($results,$res);
        $i++;
                }
        return($i);
        }
        

        
?>
