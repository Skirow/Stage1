<?
switch($cote) {
    case 'g':$file="t8.png";break;
    case 'd':$file="t9.png";break;
}
$img=imagecreatefrompng($file);
$r1=hexdec(substr($c1,0,2));
$g1=hexdec(substr($c1,2,2));
$b1=hexdec(substr($c1,4,2));
$r2=hexdec(substr($c2,0,2));
$g2=hexdec(substr($c2,2,2));
$b2=hexdec(substr($c2,4,2));
imagecolorset($img,0,$r1,$g1,$b1);
imagecolorset($img,1,$r2,$g2,$b2);
imagepng($img);
?>

