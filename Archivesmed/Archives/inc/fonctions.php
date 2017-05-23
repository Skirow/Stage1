<?php
function DateInXDays($X,$FromDate)
{
    if($FromDate=='')
        $MyDate = explode('-',date('Y-m-d'));
    else
        $MyDate = explode('-',$FromDate);

    $XDate = getdate(mktime(0,0,0,$MyDate[1],$MyDate[2]+$X,$MyDate[0]));
    //return $XDate;
    return($XDate['year'].'-'.sprintf('%02d', $XDate['mon']).'-'.sprintf('%02d', $XDate['mday']));
}
function NbJours($debut, $fin) {

  $tDeb = explode("-", $debut);
  $tFin = explode("-", $fin);

  $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) - mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);

  return(($diff / 86400)+1);

}
function AfficheOS($os) {

 if ($os== 'Multiprocessor Free') {$os="Windows XP";}
 if ($os== 'Uniprocessor Free') {$os="Windows 2000";}
  return ($os);
}
function sauve_liste($liste)
{
    global $soft,$liste3;
    bd_connect();
    // On selectionne l'id du profil dans la table veille
    //$sql="SELECT id FROM veille WHERE num='$num';";
    //list($id_veille)=@mysql_fetch_row(@mysql_query($sql));
    // Fin de la selection
    $sql0="DELETE FROM software WHERE logiciel='$soft'"; // On efface une eventuelle liste existante
    //echo $sql0;
    $res0=mysql_query($sql0);
    // boucle de sauvegarde de la liste
    for ($i=0;$i<count($liste);$i++) {

        //selectionner du nom de machine
        $sql1="SELECT pc_name from micros where pc_inv='$liste[$i]'";
        $res=mysql_query($sql1);
        $res2=mysql_result($res,0);

        $sql="INSERT INTO software (pc_num,pc_name,logiciel,id_fournisseur) VALUES ('$liste[$i]','$res2','$soft','$liste3');";

        $err=@mysql_query($sql);
       //echo "[ $sql ]<br>";
    }
    // Fin de la boucle
//    echo $sql;
}
function sauve_fournisseur()
{
    global $soft,$liste3;
    bd_connect();
    // On selectionne l'id du profil dans la table veille

    $sql0="UPDATE software SET id_fournisseur='$liste3' WHERE (logiciel='$soft');"; // On maj les fournisseurs pour toutes les machines
    $res0=@mysql_query($sql0);
    //echo $sql0;
}
function sauve_listef($liste)
{
    global $id_fournisseur;
    bd_connect();
    $sql0="DELETE FROM fournisseurs WHERE id_fournisseur='$id_fournisseur'"; // On efface une eventuelle liste existante
    //echo $sql0;
    $res0=mysql_query($sql0);
    // boucle de sauvegarde de la liste
    for ($i=0;$i<count($liste);$i++) {

        //selectionner du nom de machine
        $sql1="SELECT pc_name from micros where pc_inv='$liste[$i]'";
        $res=mysql_query($sql1);
        $res2=mysql_result($res,0);
        //echo "[ $sql1 ]<br>";
        if ($id_fournisseur!==""){
        }
        else
        {
        $sql="SELECT MAX(id_fournisseur) from liste_fournisseurs";
        $res=mysql_query($sql);
        $id_f=mysql_result($res,0)+1;
        }
        $sql="INSERT INTO fournisseurs (pc_num,pc_name,id_fournisseur) VALUES ('$liste[$i]','$res2','$id_f');";
        $err=@mysql_query($sql);
        echo "[ $sql ]<br>";

    }
    // Fin de la boucle
//    echo $sql;
}
function sauve_fournisseurf()
{
    global $id_fournisseur,$fournisseur,$adresse,$ville,$code_postal,$telentreprise,$email,$contact1,$tel1,$email1,$contact2,$tel2,$email2,$contact3,$tel3,$email3,$contact4,$tel4,$email4,$contact5,$tel5,$email5;
    bd_connect();
    if ($id_fournisseur!==""){
        $sql0="UPDATE liste_fournisseurs SET nom='$fournisseur',adresse='$adresse',ville='$ville',code_postal='$code_postal',telentreprise='$telentreprise',email='$email',nomcontact1='$contact1',tel1='$tel1',email1='$email1',nomcontact2='$contact2',tel2='$tel2',email2='$email2',nomcontact3='$contact3',tel3='$tel3',email3='$email3',nomcontact4='$contact4',tel4='$tel4',email4='$email4',nomcontact5='$contact5',tel5='$tel5',email5='$email5' WHERE (id_fournisseur='$id_fournisseur');"; // On maj les fournisseurs pour toutes les machines
    }
    else
    {
        $sql="SELECT MAX(id_fournisseur) from liste_fournisseurs";
        $res=mysql_query($sql);
        $id_f=mysql_result($res,0)+1;
        //echo $id_f;
        $sql0="INSERT INTO liste_fournisseurs VALUES( '$id_f','$fournisseur','$adresse','$ville','$code_postal','$telentreprise','$email','$contact1','$tel1','$email1','$contact2','$tel2','$email2','$contact3','$tel3','$email3','$contact4','$tel4','$email4','$contact5','$tel5','$email5');"; // On maj les fournisseurs pour toutes les machines
    }
    $res0=@mysql_query($sql0);
    echo $sql0;
}


?>
