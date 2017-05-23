<?
$img=imagecreate($taille,20);
$blanc=imagecolorallocate($img,255,255,255);
imagecolortransparent($img,$blanc);
$imgtete=imagecreatefrompng("classeur.png");
$blanctete=imagecolorallocate($img,255,255,255);
$noir=imagecolorallocate($img,0,0,0);
imagecolortransparent($imgtete,$blanctete);
$blanc2=imagecolorallocate($img,254,255,255);
imagecopy($img,$imgtete,0,0,0,0,9,20);
imagecopy($img,$imgtete,$taille-9,0,9,0,9,20);
$gris=imagecolorallocate($img,128,128,128);
$r1=hexdec(substr($c1,0,2));
$g1=hexdec(substr($c1,2,2));
$b1=hexdec(substr($c1,4,2));
$r2=hexdec(substr($c2,0,2));
$g2=hexdec(substr($c2,2,2));
$b2=hexdec(substr($c2,4,2));
$r3=hexdec(substr($c3,0,2));
$g3=hexdec(substr($c3,2,2));
$b3=hexdec(substr($c3,4,2));
$couleur=imagecolorallocate($img,$r3,$g3,$b3);
imagefilledrectangle($img,9,0,$taille-9,20,$couleur);

for($i=0;$i<imagecolorstotal($img);$i++)
{
  $col=ImageColorsForIndex($img,$i);
  $ri=$col['red'];$gi=$col['green'];$bi=$col['blue'];
  if (($col['red']==$col['green'])&&($col['red']==$col['blue']))
  {
    $r=ceil($r3*($col['red']/255));if ($r>255) {$r=255;}if ($r<0) {$r=0;}
    $g=ceil($g3*($col['green']/255));if ($g>255) {$g=255;}if ($g<0) {$g=0;}
    $b=ceil($b3*($col['blue']/255));if ($b>255) {$b=255;}if ($b<0) {$b=0;}
//    echo "$i | $ri $gi $bi | $r $g $b | $r3 $g3 $b3<br>";
    imagecolorset($img,$i,$r,$g,$b);
  }
}
// taille de la police 9 en local, 12 chez nfrance
imageTTFText($img,12,0,9,15,$blanc2,"VERDANAB.TTF",stripslashes($texte));
imagepng($img);
?>
