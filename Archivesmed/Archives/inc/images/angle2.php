<?
switch($cote) {
    case 'hg':$file="hg.png";break;
    case 'hd':$file="hd.png";break;
    case 'bg':$file="bg.png";break;
    case 'bd':$file="bd.png";break;
    case 'ch':$file="d0.png";break;
    case 'cb':$file="d1.png";break;
    case 'cg':$file="t2.png";break;
    case 'cd':$file="t3.png";break;
}
$img=imagecreatefrompng($file);
$r1=hexdec(substr($c1,0,2));
$g1=hexdec(substr($c1,2,2));
$b1=hexdec(substr($c1,4,2));
$r2=hexdec(substr($c2,0,2));
$g2=hexdec(substr($c2,2,2));
$b2=hexdec(substr($c2,4,2));
$r3=hexdec(substr($c3,0,2));
$g3=hexdec(substr($c3,2,2));
$b3=hexdec(substr($c3,4,2));
imagecolorset($img,1,$r1,$g1,$b1);
imagecolorset($img,2,$r2,$g2,$b2);
imagecolorset($img,0,$r3,$g3,$b3);
imagepng($img);
?>

