<?
error_reporting( 1 );
//$PHP_SELF = $_SERVER[ 'PHP_SELF' ];
$callBack = $_REQUEST[ 'callBack' ];
$languageID = $_REQUEST['languageID'];
$labelsEng = array();
$labelsChi = array();
$labelsKor = array();
//English Labels
$labelsEng['resize'] = "Resize";
$labelsEng['scale'] = "Scale";
$labelsEng['newwidth'] = "New width";
$labelsEng['newheight'] = "New height";
$labelsEng['apply'] = "APPLY";
$labelsEng["or"] = "OR";
$labelsEng['close'] = 'CLOSE';
$labelsEng['done'] = 'Done';
$labelsEng['title'] = "Image Modify Toolbars";
$labelsEng['cropping'] = "Cropping";
$labelsEng['left'] = "Left";
$labelsEng['top'] = "Top";
$labelsEng['right'] = "Right";
$labelsEng["bottom"] = "Bottom";
$labelsEng["resizeInstr"] = "Set the new scale by percentage or specify the new width or height then click 'apply'.";
$labelsEng["croppingInstr"] = "To crop the image, either enter the new values manuall in the input boxes or click and drag the two triangles to specify which part of the picture to keep, then click 'apply'.<br><br><b>If the picture doesn't crop immediately after moving the triangles, double-click the triangles before clicking apply.</b>";
$labelsEng["mainInstr"] = "main instructions";
//Chinese Labels
$labelsChi['resize'] = "&#37325; &#35843; &#23610; &#23544;";
$labelsChi['scale'] = "&#23610; &#24230";
$labelsChi['newwidth'] = "&#26032; &#30340; &#23485;  &#24230;";
$labelsChi['newheight'] = "&#26032; &#30340; &#39640; &#24230;";
$labelsChi['apply'] = "&#24212; &#29992;";
$labelsChi['or'] = '&#25110;';
$labelsChi['close'] = '&#20851;&#38381;';
$labelsChi['done'] = '&#23436; &#25104;';
$labelsChi['title'] = "&#26356; &#25913; &#30456; &#29255; &#30340; &#24037; &#20855;";
$labelsChi['cropping'] = "&#20462; &#21098;";
$labelsChi['left'] = "&#24038;";
$labelsChi['top'] = "&#19978;";
$labelsChi['right'] = "&#21491;";
$labelsChi["bottom"] = "&#20302; &#37096;";
$labelsChi["resizeInstr"] = "&#23450; &#19979; &#26032; &#30340; &#23610; &#24230; &#26159;&#29992;&#30334; &#20998; &#29575; &#25110; &#25351; &#23450; &#26032; &#30340; &#23485; &#24230; &#25110; &#39640; &#24230; &#28982; &#21518; &#25353;'
&#24212; &#29992;'";
$labelsChi["croppingInstr"] = "&#20462; &#21098; &#29031; &#29255;&#65292; &#21487; &#20197; &#25226; &#26032; &#30340; &#20215; &#20540; &#25351; &#21335; &#25918;  &#20837; &#36755; &#20837; &#31665; &#25110; &#25353; &#21644; &#25289; &#36825;
&#20004; &#20010; &#19977; &#35282; &#24418; &#21040; &#25351; &#23450; &#30340; &#37027; &#19968; &#37096; &#20998; &#30340; &#29031; &#29255; &#35201; &#25910;  &#30528;&#65292; &#28982; &#21518; &#25353; ' &#24212; &#29992;<br><br><b>
 &#22914; &#26524; &#22312; &#31227; &#21160; &#19977; &#35282; &#24418; &#21518; &#29031; &#29255; &#24182; &#27809; &#26377; &#39532; &#19978; &#30340; &#20462; &#21098;&#65292; &#22312; &#25353; &#24212; &#29992; &#20043;
&#21069; &#20808; &#21452; &#25353; &#19977; &#35282; &#24418;&#12290;</b>";
$labelsChi["mainInstr"] = "main instructions";
//Korean Labels
$labelsKor['or'] = '&#50500;&#45768;&#47732;';
$labelsKor['resize'] = "&#53356;&#44592; &#51312;&#51221;";
$labelsKor['scale'] = "&#53356;&#44592; &#48708;&#50984;";
$labelsKor['newwidth'] = "&#49352; &#44032;&#47196; &#44600;&#51060;";
$labelsKor['newheight'] = "&#49352; &#49464;&#47196; &#44600;&#51060;";
$labelsKor['apply'] = "&#51201;&#50857;";
$labelsKor['close'] = '&#45803;&#44592;';
$labelsKor['done'] = '&#47560;&#52840;';
$labelsKor['title'] = "&#49324;&#51652; &#49688;&#51221; &#46020;&#44396; &#49345;&#51088;";
$labelsKor['cropping'] = "&#51096;&#46972;&#45236;&#44592;";
$labelsKor['left'] = "&#50812;&#51901;";
$labelsKor['top'] = "&#50948;&#51901;";
$labelsKor['right'] = "&#50724;&#47480;&#51901;";
$labelsKor["bottom"] = "&#50500;&#47000;&#51901;";
$labelsKor["resizeInstr"] = "&#49352;&#47196;&#50868; &#48708;&#50984;&#51060;&#45208; &#44032;&#47196;/&#49464;&#47196; &#44600;&#51060;&#47484; &#51221;&#54620; &#45796;&#51020; '&#51201;&#50857;'&#51012; &#53364;&#47533;&#54616;&#49464;&#50836;.";
$labelsKor["croppingInstr"] = "&#48512;&#48516; &#51096;&#46972;&#45236;&#44592;&#47484; &#54616;&#47140;&#47732; &#49352;&#47196;&#50868; &#44600;&#51060;&#47484; &#51221;&#54644; &#45347;&#44144;&#45208; &#46160; &#49340;&#44033;&#54805;&#51012; &#53364;&#47533;&#54644;&#49436; &#46300;&#47000;&#44536;&#54616;&#50668; &#50612;&#45712; &#48512;&#48516;&#47564; &#49324;&#50857;&#54616;&#44256; &#49910;&#51008;&#51648; &#51221;&#54620; &#54980; '&#51201;&#50857;'&#51012; &#53364;&#47533;&#54616;&#49464;&#50836;.<br><br>
<b>
&#47564;&#50557; &#49340;&#44033;&#54805;&#46308;&#51012; &#50734;&#44220;&#45716;&#45936;&#46020; &#48520;&#54596;&#50836;&#54620; &#48512;&#48516;&#51060; &#51096;&#46972;&#51648;&#51648; &#50506;&#50520;&#45796;&#47732; '&#51201;&#50857;'&#51012; &#53364;&#47533;&#54616;&#44592; &#51204;&#50640; &#49340;&#44033;&#54805;&#50640; &#45908;&#48660; &#53364;&#47533; &#54616;&#49464;&#50836;.</b>";
$labelsKor["mainInstr"] = "main instructions";
//print("languageID = " . $languageID);
switch($languageID) {
    case 1;
        //print("english");
        $labels = $labelsEng;
        break;
    case 2;
        //print("chinese");
        $labels = $labelsChi;
        break;
    case 3;
        //print("korean");
        $labels = $labelsKor;
        break;
    default:
        //print("english by default");
        $labels = $labelsEng;
        break;
}

/******************************************************************************
****************** TRUECOLOR FULL 1.3 - A web interface to PHP GD2 ************
********************** (c) Paul Barends - ALLAYERS.COM 2003 *******************
**************************** VERSION 1.3 - 15/10/2004**************************
*******************************************************************************
*******************************************************************************
************ DHTML core functions (c) Thomas Brattli DHTMLCentral 2001 ********
**************** Base64 image functions thanks to php.holtsmark.no ************
*******************************************************************************

You are free to use this script for pivate, non-commercial us as long as you do
not remove any author information or the link to the TrueColor page.
Please refer to the license information on Allayers.com for commercial use.
URL:   http://truecolor.allayers.com
email: truecolor@allayers.com

*******************************************************************************/
// registered globals = off support, decomment when necessary

//if(is_array($_GET)) { while (list ($key, $val) = each ($_GET)) { $$key=$val; } }
//if(is_array($_POST)) { while (list ($key, $val) = each ($_POST)) { $$key=$val; } }

/////////////////////////CONFIG//////////////////////////////

// script relative dir from root
DEFINE(SCRIPTRELPATH,"path-from-root2script");

// set this to whatever subdir you make
// image subdir
DEFINE(IMG_DIR,"images/");

// truetype fonts subdir, replace 'ttf' by your
DEFINE(FNT_DIR,"ttf/");

// max size of image for setpixel functions
DEFINE(MAX_SQUARE,2500000);
// default max upload filesize 1.5 MB default
DEFINE(MAX_UPLOAD,1500000);

// max script exec time
set_time_limit(40);
// max memory usage for larger images, defaults 8 MB in most PHP installations
ini_set("memory_limit", "16M");

///////////////////////// images ////////////////////////////

if ($action=="preview" && $fontfile){
  $image = new imagetext($fontfile,$fontsize,$fontcolor,$text,$fontangle);
  $image->preview();
  exit();
  }

if ($action=="colorreader"){
  if (!$filename)
    echo "<html><head><script language=\"JavaScript1.2\">var curcol=''</script></head><body><form name=\"frameform\"><input type=\"text\" name=\"currentcolor\"></form></body></html>";
  else
    echo outputColorAt($posx,$posy,$dir,$filename);
  exit();
  }

// image calls
if ($img=="left"){cornerleft();exit;}
if ($img=="right"){cornerright();exit;}
if ($img=="logo"){logo();exit;}
if ($img=="pixpos"){pixpos();exit;}

/////////////////////////////////////////////////////////////

// message strings
$GLOBALS["message_2large"] = "Image size is too large for this function! Please resize the image or increase the maximum size in the configuration.";
$GLOBALS["message_rmdir_failed"] = "Removal of this directory failed. It might still contain files or not be writable.";
$GLOBALS["message_supported"] = "Editing supported";
$GLOBALS["message_not_supported"] = "Editing is NOT supported";
$GLOBALS["message_no_file"]= "No file selected";
$GLOBALS["message_dir_up"] = " Up one level";
$GLOBALS["function_not_available"] = "* Truecolor Functions NOT available *<BR />";
$GLOBALS["message_no_exif"] = "EXIF data not available";
$GLOBALS["message_no_rotate"] = "Rotate function not available";

////////////////////////IMAGE TEXT CLASS//////////////////////////

class imagetext{
      var $handle;
      var $dx;
      var $dy;

      function imagetext($fontfile, $fontsize, $fontcolor, $textstr, $angle=0, $bgcolor=""){
          $text=stripslashes($textstr);
          // font color
          $r = hexdec(substr($fontcolor, 0, 2));
          $g = hexdec(substr($fontcolor, 2, 2));
          $b = hexdec(substr($fontcolor, 4, 2));
          // bg color
          if ($bgcolor && $fontcolor!=$bgcolor){
            $rb = hexdec(substr($bgcolor, 0, 2));
            $gb = hexdec(substr($bgcolor, 2, 2));
            $bb = hexdec(substr($bgcolor, 4, 2));
            }else{
              $r>128?$rb=0:$rb=255;
              $g>128?$gb=0:$gb=255;
              $b>128?$bb=0:$bb=255;
              }
          //$fontsize = $fontsize/96*72;

          $size = imagettfbbox($fontsize,$angle,$fontfile,$text);
          $factor = $fontsize/2;
          $this->dx = $factor + max($size[2], $size[4]) - min($size[0], $size[6]); // extreme x values
          $this->dy = $factor + max($size[1], $size[3]) - min($size[5], $size[7]); // extreme y values

          $this->handle = imagecreate($this->dx,$this->dy);
          $transcolor = ImageColorAllocate ($this->handle, $rb, $gb, $bb);
          imagefill($this->handle,0,0,$transcolor);
          $textcolor = ImageColorAllocate($this->handle, $r, $g, $b);
          $offsety = $this->dy-($factor);
          $offsetx = $factor/2+($factor*$angle)/60;

          ImageTTFText($this->handle, $fontsize, $angle, $offsetx, $offsety, $textcolor, $fontfile, $text);
          imagecolortransparent($this->handle, $transcolor);
          }

      function preview(){
          header("Content-type: image/png");
          imagepng($this->handle);
          }

      }

////////////////////////MAIN IMAGE CLASS//////////////////////////

class imageobject{

         var $handle;
         var $type="jpg";
         var $height=0;
         var $width=0;
         var $string;// for img height/width tags
         var $square;
         // output message
         var $message;
         // previous file
         var $previous;
         // current
         var $directory;
         var $filename;
         //output
         var $resample=false;
         var $quality="80";
         var $output="jpg";// alternatives png8 or png
         var $transparent; // only if output=png8
         // textobject
         var $previewobject;

         //constructor
         function imageobject($directory,$filename,$type="jpg")
                  {
                  $this->directory = $directory;
                  $this->filename = $filename;
                  $this->type = $type;
                  if (file_exists($directory.$filename)){
                                      $this->filesize = ceil(filesize($directory.$filename)/1024);
                                      $size = GetImageSize($directory.$filename);
                                      if ($size) $this->handle = $this->getHandle($directory.$filename,$size[2]);
                                      $this->width = $size[0];
                                      $this->height = $size[1];
                                      $this->string = $size[3];
                                      $this->square = $size[0]*$size[1];

                                      if ($this->handle)
                                         $this->message = $GLOBALS["message_supported"];
                                      else
                                         $this->message = $GLOBALS["message_not_supported"];

                                      }
                  }// constructor

         // private methods
        function getHandle($name,&$type)
        {
           switch ($type){
              case 1:
              $im = imagecreatefromgif($name);
              $this->type= "gif";
              break;
              case 2:
              $im = imagecreatefromjpeg($name);
              break;
              case 3:
              $im = imagecreatefrompng($name);
              $this->type= "png";
              break;
                      }
           return $im;
        }

        function uniqueName()
        {
          // AI Update
          // NOTE:
          // For our purposes, we want the changes to be live (ie we don't 
          // give them the ability to store multiple files and choose which
          // one to edit).  So this routine just returns the name of the 
          // original file.
          /*
          $add="";
          $fileparts = split("\.",$this->filename);
          $nonchr = array("__","0","1","2","3","4","5","6","7","8","9");
          $desc = str_replace($nonchr,"",$fileparts[0]);
          $name = $desc."__".date("YmdHms");
          // if exists add incremented number
          if (file_exists($this->directory.$name.".".$this->type)){
            $add = 1;
            while(file_exists($this->directory.$name.$add.".".$this->type)) $add++;
            }
          return $imgnew.$name.$add.".".$this->type;
          */
          return $this->filename;
        }

        function createUnique($imgnew)
        {
           $this->type = substr($this->output,0,3);

           $unique_str = $this->uniqueName();
           switch ($this->type){
              case "png":
                   imagepng($imgnew,$this->directory.$unique_str);
              break;
              default:
                   imagejpeg($imgnew,$this->directory.$unique_str,$this->quality);
              break;
              }

           imagedestroy($this->handle);
           $newobject = new imageobject($this->directory,$unique_str,$this->type);
           return $newobject;
        }

        function createImage($new_w,$new_h)
        {
           if (function_exists("imagecreatetruecolor") && $this->output!="png8"){
             return imagecreatetruecolor($new_w,$new_h);
             }else{
                return imagecreate($new_w,$new_h);
                }
        }

        function copyhandle(&$dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)
        {

         if ($this->output=="png8" && $this->type="jpg"){
            imagecopyresized($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
            $this->resample==true;
            }

         if (function_exists("imagecopyresampled") && $this->resample==true)
            imagecopyresampled($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
         else
            imagecopy($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);

        }

        function copycreatehandle(&$src_im, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)
        {

          $dst_im = $this->createImage($dst_w,$dst_h);

          $this->copyhandle($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

          return $dst_im;
        }

        function valore($n1,$n2,$hue)

        {
           if($hue>=360) $hue = $hue-360;
           if($hue<0) $hue = $hue+360;

           if($hue>=240) $result = $n1;
           if($hue<240) $result = $n1+($n2-$n1)*(240-$hue)/60;
           if($hue<180) $result = $n2;
           if($hue<60) $result = $n1+($n2-$n1)*$hue/60;

           return($result);
         }

         function rgb2hls($r,$g,$b)
         {

           $c1 = $r/255;
           $c2 = $g/255;
           $c3 = $b/255;

           $kmin = min($c1,$c2,$c3);
           $kmax = max($c1,$c2,$c3);

           $l = ($kmax+$kmin)/2;

           if($kmax == $kmin){
             $s=0;
             $h=0;
           } else {

             if($l<=0.5) $s = ($kmax-$kmin)/($kmax+$kmin);
             else $s = ($kmax-$kmin)/(2-$kmax-$kmin);

             $delta = $kmax-$kmin;
             if($kmax==$c1) $h = ($c2-$c3)/$delta;
             if($kmax==$c2) $h = 2+($c3-$c1)/$delta;
             if($kmax==$c3) $h = 4+($c1-$c2)/$delta;

             $h = $h*60;

             if($h<0) $h = $h+360;
           }

           $out->h = $h;
           $out->s = $s;
           $out->l = $l;

           return($out);
           }


         function hls2rgb($h,$l,$s)
         {

           if($l<=0.5) $m2 = $l*(1+$s);
           else $m2 = $l+$s*(1-$l);

           $m1 = 2*$l-$m2;

           $c1 = $this->valore($m1,$m2,$h+120);
           $c2 = $this->valore($m1,$m2,$h);
           $c3 = $this->valore($m1,$m2,$h-120);

           if ($s==0 && $h==0){
             $c1 = $l;
             $c2 = $l;
             $c3 = $l;
           }
           $r = round($c1*255);
           $g = round($c2*255);
           $b = round($c3*255);

           $out->r = $r;
           $out->g = $g;
           $out->b = $b;

           return($out);
           }

        function saveAlpha(&$handle)
        {
         ImageAlphaBlending($handle, true);
         imagesavealpha($handle,false);
         imagesavealpha($handle,true);
        }

        function getHexColor($xpos,$ypos)
        {
              $color = imagecolorat($this->handle, $xpos, $ypos);
              $colorrgb = imagecolorsforindex($this->handle,$color);

              if ($colorrgb["red"]>0)$hred = dechex($colorrgb["red"]); else $hred = "00";
              if (strlen($hred)<2)$hred = "0".$hred;

              if ($colorrgb["green"]>0)$hgreen = dechex($colorrgb["green"]); else $hgreen = "00";
              if (strlen($hgreen)<2)$hgreen = "0".$hgreen;

              if ($colorrgb["blue"]>0)$hblue = dechex($colorrgb["blue"]); else $hblue = "00";
              if (strlen($hblue)<2)$hblue = "0".$hblue;

              return strtoupper($hred.$hgreen.$hblue);
        }
        // public methods
        function rotateImage($degrees)
        {
           if (function_exists("imagerotate")){

             if ($degrees == 180){
              $dst_img = @imagerotate($this->handle, $degrees, 0);
                 }else{
                  $width = $this->width;
                  $height = $this->height;
                  if ($width > $height)
                      $size = $width;
                      else
                      $size = $height;
                  $dst_img = $this->createImage($size, $size);
                  $this->copyhandle($dst_img, $this->handle, 0, 0, 0, 0, $width, $height,$width, $height);
                  $dst_img  = @imagerotate($dst_img, $degrees, 0);
                  $this->handle = $dst_img;
                  $dst_img = $this->createImage($height, $width);
                  if ((($degrees == 90) && ($width > $height)) || (($degrees == 270) && ($width < $height)))
                         $this->copyhandle($dst_img, $this->handle, 0, 0, 0, 0, $size, $size, $size, $size);
                  if ((($degrees == 270) && ($width > $height)) || (($degrees == 90) && ($width < $height)))
                         $this->copyhandle($dst_img, $this->handle, 0, 0, $size - $height, $size - $width, $size, $size, $size, $size);
                  }

             return $this->createUnique($dst_img);

            }else{
             $this->message = $GLOBALS["message_no_rotate"];
             }

        }

        function resizeImage($scale,$newwidth=0,$newheight=0)
        {
           $new_w = $this->width;
           $new_h = $this->height;
           $aspect_ratio = (int) $new_h / $new_w;
           if ($scale) $new_w = $new_w * $scale;
           if ($newwidth>0) $new_w = $newwidth;
           if ($newheight>0){
                $new_h = $newheight;
                $new_w = (int) $new_h / $aspect_ratio;
                }else{
                   $new_h = abs($new_w * $aspect_ratio);
                   }
           $dst_img = $this->copycreatehandle($this->handle, 0, 0, 0, 0, $new_w, $new_h, $this->width,$this->height);

           return $this->createUnique($dst_img);
        }

        function createTransparent($x,$y)
        {
          $this->resample = false;
          $temp = $this->copycreatehandle($this->handle, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height);

          $rgb = imagecolorat($temp,$x,$y);

          if ($this->output=="png8"){
            imagecolortransparent($temp, $rgb);
            }else{
             imagecolorexactalpha($temp, $rgb["red"], $rgb["green"], $rgb["blue"], 127);
             }
          return $this->createUnique($temp);
        }

        function cropImage($top,$right,$bottom,$left)
        {
           $new_w = $right - $left;
           $new_h = $bottom - $top;

           $dst_img = $this->copycreatehandle($this->handle, 0, 0, $left, $top, $new_w, $new_h, $new_w, $new_h);
           return $this->createUnique($dst_img);
        }

        function mirrorImage()
        {
           $imgnew = $this->createImage($this->width,$this->height);
           // horizontal
           for ($i=0;$i<$this->height;$i++){
                 // vertical
                 for ($j=0;$j<$this->width;$j++){
                    $color = imagecolorat($this->handle, $j, $i);
                    imagesetpixel($imgnew,$this->width-$j-1,$i,$color);
                    }
                 }
            return $this->createUnique($imgnew);
         }

         function changeColor($hue=0,$sat=0,$lum=0,$red=0,$green=0,$blue=0)
         {
           $imgnew = $this->createImage($this->width,$this->height);
           // horizontal
           for ($i=0;$i<$this->width;$i++){
                 // vertical
                 for ($j=0;$j<$this->height;$j++){
                    $color = imagecolorat($this->handle, $i, $j);
                    $rgb = imagecolorsforindex($this->handle, $color);
                    $hls = $this->rgb2hls($rgb["red"],$rgb["green"],$rgb["blue"]);
                    $hls->h += $hue * $hls->h;
                    $hls->l += $lum * $hls->l;
                    $hls->s += $sat * $hls->s;
                    if ($hls->h > 255)$hls->h = 255;
                    if ($hls->h < 0)$hls->h = 0;
                    if ($hls->l > 1)$hls->l = 1;
                    if ($hls->l < 0)$hls->l = 0;
                    if ($hls->s > 1)$hls->s = 1;
                    if ($hls->s < 0)$hls->s = 0;
                    $rgb = $this->hls2rgb($hls->h,$hls->l,$hls->s);

                    $rgb->r += $red * $rgb->r;
                    $rgb->g += $green * $rgb->g;
                    $rgb->b += $blue * $rgb->b;

                    if ($rgb->r > 255)$rgb->r = 255;
                    if ($rgb->r < 0)$rgb->r = 0;
                    if ($rgb->g > 255)$rgb->g = 255;
                    if ($rgb->g < 0)$rgb->g = 0;
                    if ($rgb->b > 255)$rgb->b = 255;
                    if ($rgb->b < 0)$rgb->b = 0;

                    $newcol = imagecolorresolve($imgnew, $rgb->r, $rgb->g, $rgb->b);
                    imagesetpixel($imgnew,$i,$j,$newcol);
                    }
                 }
              return $this->createUnique($imgnew);
            }

           function writeText($xpos=0, $ypos=0, $textstring, $fontsize, $truetype, $fontcolor, $fontangle)
           {
              $fontbgcolor= $this->getHexColor($xpos,$ypos);
              $textimage = new imagetext($truetype,$fontsize,$fontcolor,$textstring,$fontangle,$fontbgcolor);
              $this->saveAlpha($this->handle);
              $this->copyhandle($this->handle, $textimage->handle, $xpos, $ypos, 0, 0, $textimage->dx, $textimage->dy,$textimage->dx, $textimage->dy);

              return $this->createUnique($this->handle);
           }

           function mergeImage($dir, $srcimage, $srcx, $srcy, $opacity=100)
           {
              $newimage = new imageobject($dir, $srcimage);
              $this->saveAlpha($this->handle);
              if ($opacity<100)
                @ImageCopyMerge($this->handle,$newimage->handle,$srcx,$srcy,0,0,$newimage->width,$newimage->height,$opacity);
              else
                $this->copyhandle($this->handle,$newimage->handle,$srcx,$srcy,0,0,$newimage->width,$newimage->height,$newimage->width,$newimage->height);

              return $this->createUnique($this->handle);
           }

           function mergeColor($color,$opacity)
           {
              $newimage = ImageCreate($this->width,$this->height);
              $r = hexdec(substr($color, 0, 2));
              $g = hexdec(substr($color, 2, 2));
              $b = hexdec(substr($color, 4, 2));
              $mergecolor = ImageColorAllocate($newimage, $r, $g, $b);
              ImageCopyMerge($this->handle,$newimage,0,0,0,0,$this->width,$this->height,$opacity);
              return $this->createUnique($this->handle);
           }

           function gammaCorrect($gamma)
           {
              imagegammacorrect($this->handle, 1.0, $gamma);
              return $this->createUnique($this->handle);
           }

   }// class



// PAGE INIT
if (!$action) $action="open";
if (!$img_dir) $img_dir = IMG_DIR;
$replace = array("\'","\"","\#","\&","[","]");

// SWITCH ACTIONS
if ($remoteimage && $remoteimage!="http://"){

  $split = split("/",$remoteimage);
  $newname = $split[sizeof($split)-1];

  if (@copy($remoteimage,$img_dir.$newname)) $newimage = $newname;


 }elseif ($uploadedfile){

   $newname = str_replace($replace,"",$uploadedfile_name);
   if (@copy($uploadedfile,$img_dir.$newname)) $newimage = $newname;

   }else{
     if ($newimage){
         if (strpos($newimage,"]")){
             if (strpos($newimage,".."))
                 $img_dir = prevdir($img_dir);
                 else
                 $img_dir = $img_dir.str_replace(array("[","]"),"",$newimage)."/";
             unset($newimage);
             }
         if ($renamedfile && file_exists($img_dir.$newimage)){
             $renamedfile = str_replace($replace,"",$renamedfile);
             rename($img_dir.$newimage,$img_dir.$renamedfile.".".$origfiletype);
             $newimage = $renamedfile.".".$origfiletype;
             }
         if ($action=="delete" && file_exists($img_dir.$newimage)){
            unlink($img_dir.$newimage);
            unset($newimage);
            }
         if ($action=="createdir" && $newdirectory){
             if (mkdir($img_dir."/".$newdirectory,0775)) $img_dir = $img_dir."/".$newdirectory;
             }
         if ($action=="copy" && $copydir){
             if (copy($img_dir.$newimage,$copydir.$newimage)) $img_dir = $copydir;
             }
         if ($action=="deldir" && $copydir){
             if (rmdir($copydir)){
                if ($copydir==$img_dir) $img_dir = IMG_DIR;
                }else{
                   $message = $GLOBALS["message_rmdir_failed"];
                   }
             }
         if ($cleanup) $newimage = cleanupTemp($img_dir, $newimage);
         }
      }//upload

   if ($newimage){
      $info = new imageobject($img_dir,$newimage);
      if ($quality) $info->quality = $quality;
      if ($output) $info->output = $output;
      if ($resample) $info->resample = $resample;

      if ($info->handle){
          if ($currentcolor)
           $info = $info->createTransparent($pixxpos,$pixypos);
          if ($tocrop == 'true')
           $info = $info->cropImage($offset_top,$offset_right,$offset_bottom,$offset_left);
          if ($rescale || $newsize){
              if ($widthheight=="width")
               $info = $info->resizeImage($rescale,$newsize,0);
               else
               $info = $info->resizeImage($rescale,0,$newsize);
              }
          if ($angle) $info = $info->rotateImage($angle);
          if ($mergecolor && $coloropacity) $info = $info->mergeColor($mergecolor,$coloropacity);
          if ($mergefile && $imageopacity) $info = $info->mergeImage($img_dir, $mergefile, $imgxpos, $imgypos, $imageopacity);
          if ($textstring) $info = $info->writeText($textxpos, $textypos, $textstring, $fontsize, $truetype, $fontcolor, $fontangle);
          if ($mirror) $info = $info->mirrorImage();
          if ($gamma) $info = $info->gammaCorrect($gamma);
          if ($hue || $sat || $lum || $red || $green || $blue)
              if ($info->square < MAX_SQUARE)
                $info = $info->changeColor($hue,$sat,$lum,$red,$green,$blue);
              else $message = $GLOBALS["message_2large"];
          }// handle
      }//   newimage


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Allayers TrueColor - The Easy Image Editor for the Web</title>
   <meta http-equiv="Cache-Control" content="no-cache">
   <meta http-equiv="Pragma" content="no-cache">
   <meta http-equiv="expires" content="0">
    <script language="JavaScript1.2">
    //Browsercheck (needed) ***************
    function lib_bwcheck(){
      this.ver=navigator.appVersion
      this.agent=navigator.userAgent
      this.dom=document.getElementById?1:0
      this.opera5=this.agent.indexOf("Opera 5")>-1
      this.ie5=(this.ver.indexOf("MSIE 5")>-1 && this.dom && !this.opera5)?1:0;
      this.ie6=(this.ver.indexOf("MSIE 6")>-1 && this.dom && !this.opera5)?1:0;
      this.ie4=(document.all && !this.dom && !this.opera5)?1:0;
      this.ie=this.ie4||this.ie5||this.ie6
      this.mac=this.agent.indexOf("Mac")>-1
      this.ns6=(this.dom && parseInt(this.ver) >= 5) ?1:0;
      this.ns4=(document.layers && !this.dom)?1:0;
      this.bw=(this.ie6||this.ie5||this.ie4||this.ns4||this.ns6||this.opera5)
      return this
    }
    bw=new lib_bwcheck() //Browsercheck object

    //Debug function ******************
    function lib_message(txt){alert(txt); return false}

    //Lib objects  ********************
    function lib_obj(obj,nest){
      if(!bw.bw) return lib_message('Old browser')
      nest=(!nest) ? "":'document.'+nest+'.'
      this.evnt=bw.dom? document.getElementById(obj):
        bw.ie4?document.all[obj]:bw.ns4?eval(nest+"document.layers." +obj):0;
      if(!this.evnt) return lib_message('The layer does not exist ('+obj+')'
        +'- \nIf your using Netscape please check the nesting of your tags!')
      this.css=bw.dom||bw.ie4?this.evnt.style:this.evnt;
      this.ref=bw.dom||bw.ie4?document:this.css.document;
      this.x=parseInt(this.css.left)||this.css.pixelLeft||this.evnt.offsetLeft||0;
      this.y=parseInt(this.css.top)||this.css.pixelTop||this.evnt.offsetTop||0
      this.w=this.evnt.offsetWidth||this.css.clip.width||
        this.ref.width||this.css.pixelWidth||0;
      this.h=this.evnt.offsetHeight||this.css.clip.height||
        this.ref.height||this.css.pixelHeight||0
      this.c=0 //Clip values
      if((bw.dom || bw.ie4) && this.css.clip) {
      this.c=this.css.clip; this.c=this.c.slice(5,this.c.length-1);
      this.c=this.c.split(' ');
      for(var i=0;i<4;i++){this.c[i]=parseInt(this.c[i])}
      }
      this.ct=this.css.clip.top||this.c[0]||0;
      this.cr=this.css.clip.right||this.c[1]||this.w||0
      this.cb=this.css.clip.bottom||this.c[2]||this.h||0;
      this.cl=this.css.clip.left||this.c[3]||0
      this.obj = obj + "Object"; eval(this.obj + "=this")
      return this
    }

    //Moving object to **************
    lib_obj.prototype.moveIt = function(x,y){
      this.x=x;this.y=y; this.css.left=x;this.css.top=y
    }

    //Moving object by ***************
    lib_obj.prototype.moveBy = function(x,y){
      this.css.left=this.x+=x; this.css.top=this.y+=y
    }

    //Showing object ************
    lib_obj.prototype.showIt = function(){this.css.visibility="visible"}

    //Hiding object **********
    lib_obj.prototype.hideIt = function(){this.css.visibility="hidden"}

    //Changing backgroundcolor ***************
    lib_obj.prototype.bg = function(color){
        if(bw.opera) this.css.background=color
        else if(bw.dom || bw.ie4) this.css.backgroundColor=color
        else if(bw.ns4) this.css.bgColor=color
    }

    //Writing content to object ***
    lib_obj.prototype.writeIt = function(text,startHTML,endHTML){
        if(bw.ns4){
        if(!startHTML){startHTML=""; endHTML=""}
          this.ref.open("text/html");
        this.ref.write(startHTML+text+endHTML);
        this.ref.close()
        }else this.evnt.innerHTML=text
    }

    //Clipping object to ******
    lib_obj.prototype.clipTo = function(t,r,b,l,setwidth){
      this.ct=t; this.cr=r; this.cb=b; this.cl=l
      if(bw.ns4){
        this.css.clip.top=t;this.css.clip.right=r
        this.css.clip.bottom=b;this.css.clip.left=l
      }else{
        if(t<0)t=0;if(r<0)r=0;if(b<0)b=0;if(b<0)b=0
        this.css.clip="rect("+t+","+r+","+b+","+l+")";
        if(setwidth){this.css.pixelWidth=this.css.width=r;
        this.css.pixelHeight=this.css.height=b}
      }
    }

    //Clipping object by ******
    lib_obj.prototype.clipBy = function(t,r,b,l,setwidth){
      this.clipTo(this.ct+t,this.cr+r,this.cb+b,this.cl+l,setwidth)
    }

    //Clip animation ************
    lib_obj.prototype.clipIt = function(t,r,b,l,step,fn,wh){
      tstep=Math.max(Math.max(Math.abs((t-this.ct)/step),Math.abs((r-this.cr)/step)),
        Math.max(Math.abs((b-this.cb)/step),Math.abs((l-this.cl)/step)))
      if(!this.clipactive){
        this.clipactive=true; if(!wh) wh=0; if(!fn) fn=0
        this.clip(t,r,b,l,(t-this.ct)/tstep,(r-this.cr)/tstep,
          (b-this.cb)/tstep,(l-this.cl)/tstep,tstep,0, fn,wh)
      }
    }
    lib_obj.prototype.clip = function(t,r,b,l,ts,rs,bs,ls,tstep,astep,fn,wh){
      if(astep<tstep){
        if(wh) eval(wh);
        astep++
        this.clipBy(ts,rs,bs,ls,1);
        setTimeout(this.obj+".clip("+t+","+r+","+b+","+l+","+ts+","+rs+","
          +bs+","+ls+","+tstep+","+astep+",'"+fn+"','"+wh+"')",50)
      }else{
        this.clipactive=false; this.clipTo(t,r,b,l,1);
        if(fn) eval(fn)
      }
    }

    //Slide animation ***********
    lib_obj.prototype.slideIt = function(endx,endy,inc,speed,fn,wh){
      if(!this.slideactive){
        var distx = endx - this.x;
        var disty = endy - this.y
        var num = Math.sqrt(Math.pow(distx,2)+Math.pow(disty,2))/inc
        var dx = distx/num; var dy = disty/num
        this.slideactive = 1;
        if(!wh) wh=0; if(!fn) fn=0
        this.slide(dx,dy,endx,endy,speed,fn,wh)
        }
    }
    lib_obj.prototype.slide = function(dx,dy,endx,endy,speed,fn,wh) {
      if(this.slideactive&&
      (Math.floor(Math.abs(dx))<Math.floor(Math.abs(endx-this.x))||
        Math.floor(Math.abs(dy))<Math.floor(Math.abs(endy-this.y)))){
        this.moveBy(dx,dy);
        if(wh) eval(wh)
        setTimeout(this.obj+".slide("+dx+","+dy+","+endx+","+endy+","+speed+",'"
        +fn+"','"+wh+"')",speed)
      }else{
        this.slideactive = 0;
        this.moveIt(endx,endy);
        if(fn) eval(fn)
      }
    }

    //Circle animation ****************
    lib_obj.prototype.circleIt = function(rad,ainc,a,enda,xc,yc,speed,fn) {
      if((Math.abs(ainc)<Math.abs(enda-a))) {
        a += ainc
        var x = xc + rad*Math.cos(a*Math.PI/180)
        var y = yc - rad*Math.sin(a*Math.PI/180)
        this.moveIt(x,y)
        setTimeout(this.obj+".circleIt("+rad+","+ainc+","+a+","+enda+","
          +xc+","+yc+","+speed+",'"+fn+"')",speed)
      }else if(fn&&fn!="undefined") eval(fn)
    }

    //Document size object ********
    function lib_doc_size(){
      this.x=0;this.x2=bw.ie && document.body.offsetWidth-20||innerWidth||0;
      this.y=0;this.y2=bw.ie && document.body.offsetHeight-5||innerHeight||0;
      if(!this.x2||!this.y2) return message('Document has no width or height')
      this.x50=this.x2/2;this.y50=this.y2/2;
      return this;
    }

    //Drag drop functions start *******************
    dd_is_active=0; dd_obj=0; dd_mobj=0
    function lib_dd(){
      dd_is_active=1
      if(bw.ns4){
        document.captureEvents(Event.MOUSEMOVE|Event.MOUSEDOWN|Event.MOUSEUP)
      }
      document.onmousemove=lib_dd_move;
      document.onmousedown=lib_dd_down
      document.onmouseup=lib_dd_up
    }
    lib_obj.prototype.dragdrop = function(obj){
      if(!dd_is_active) lib_dd()
      this.evnt.onmouseover=new Function("lib_dd_over("+this.obj+")")
      this.evnt.onmouseout=new Function("dd_mobj=0")
      if(obj) this.ddobj=obj
    }
    lib_obj.prototype.nodragdrop = function(){
      this.evnt.onmouseover=""; this.evnt.onmouseout=""
      dd_obj=0; dd_mobj=0
    }
    //Drag drop event functions
    function lib_dd_over(obj){dd_mobj=obj}
    function lib_dd_up(e){dd_obj=0}

    function lib_dd_down(e){ //Mousedown

    if(dd_mobj){
        x=(bw.ns4 || bw.ns6)?e.pageX:event.x||event.clientX
        y=(bw.ns4 || bw.ns6)?e.pageY:event.y||event.clientY

        dd_obj=dd_mobj
        dd_obj.clX=x-dd_obj.x
        dd_obj.clY=y-dd_obj.y
        }

    }
    function lib_dd_move(e,y,rresize){ //Mousemove
      x=(bw.ns4 || bw.ns6)?e.pageX:event.x||event.clientX
      y=(bw.ns4 || bw.ns6)?e.pageY:event.y||event.clientY
      if(dd_obj){
        nx=x-dd_obj.clX; ny=y-dd_obj.clY
        if(dd_obj.ddobj) dd_obj.ddobj.moveIt(nx,ny)
        else dd_obj.moveIt(nx,ny)
      }
      if(!bw.ns4) return false
    }
    //Drag drop functions end *************

    <? if ($info->handle) {?>
    function resetClip(){
      newleft = (screen.width - <?=$info->width?>)/2;
      if (newleft<0)newleft = 0;
      objimg.moveIt(newleft,100);
      objsecond.moveIt(newleft,100);
      objpreview.moveIt(newleft,100);
      objpixpos.moveIt(newleft,100);
      objimg.clipTo(0,<?=$info->width?>,<?=$info->height?>,0,1);
      objlefttop.moveIt(newleft-2,97);
      objrightbottom.moveIt(newleft+<?=$info->width?>-23,100+<?=$info->height?>-23);
      document.mainform.clipval.value = "";
      }
    <? } ?>
    function libinit(){
      page=new lib_doc_size();
      objopen=new lib_obj('opendiv');
      objopen.dragdrop();
      <? if ($info->handle) {?>
      objrotate=new lib_obj('rotatediv');
      objrotate.dragdrop();
      objresize=new lib_obj('resizediv');
      objresize.dragdrop();
      objoption=new lib_obj('optiondiv');
      objoption.dragdrop();
      objcolor=new lib_obj('colordiv');
      objcolor.dragdrop();
      objmisc=new lib_obj('miscdiv');
      objmisc.dragdrop();
      objmerge=new lib_obj('mergediv');
      objmerge.dragdrop();
      objtool=new lib_obj('tooldiv');
      objtool.dragdrop();
      objclip=new lib_obj('clipdiv');
      objclip.dragdrop();
      objinfo=new lib_obj('infodiv');
      objinfo.dragdrop();
      objtrans=new lib_obj('transdiv');
      objtrans.dragdrop();
      objtext=new lib_obj('textdiv');
      objtext.dragdrop();
      objpreview=new lib_obj('previewdiv');
      objpreview.dragdrop();
      objpixpos=new lib_obj('pixposdiv');
      objpixpos.dragdrop();

      objsecond=new lib_obj('seconddiv');
      objsecond.dragdrop();

      objlefttop=new lib_obj('lefttopdiv');
      objlefttop.dragdrop();

      objrightbottom=new lib_obj('rightbottomdiv');
      objrightbottom.dragdrop();

      objimg=new lib_obj('imgdiv');
      objtool.showIt();

      resetClip();
      <? } ?>
    }

    function getElement(id){
      if (document.all){
        element = document.all[id];
        }else{
           element = document.getElementById(id);
           }
      return element;
      }

    function showClipped(){
    objimg.clipTo(objlefttop.y-objimg.y+3, objrightbottom.x-objimg.x+23 , objrightbottom.y-objimg.y+23, objlefttop.x-objimg.x+2,1);
    document.mainform.clipval.value = objimg.ct + ',' + objimg.cr + ',' + objimg.cb + ',' + objimg.cl;
    document.mainform.offset_top.value = objimg.ct;
    document.mainform.offset_left.value = objimg.cl;
    document.mainform.offset_bottom.value = objimg.cb;
    document.mainform.offset_right.value = objimg.cr;
    document.mainform.tocrop.value = true;
    }

    function hideClipped(){
    document.mainform.offset_top.value = 0;
    document.mainform.offset_left.value = 0;
    document.mainform.offset_bottom.value = objimg.h;
    document.mainform.offset_right.value = objimg.w;
    document.mainform.tocrop.value = true;
    }

    function showCorners(show){
    if (show){
        objlefttop.showIt();
        objrightbottom.showIt();
        showClipped();
       }else{
        objlefttop.hideIt();
        objrightbottom.hideIt();
        hideClipped();
        resetClip();

        }
    }

    var first=true;
    function showTextPreview(show){
    if (show){
       objpreview.showIt();
       if (first==true) first=false;
       }else{
        objpreview.hideIt();
       }
    }

    function setTextPreviewXY(){
       document.mainform.textxpos.value = objpreview.x - objimg.x;
       document.mainform.textypos.value = objpreview.y - objimg.y;
    }

    function setImageXY(){
       document.mainform.imgxpos.value = objsecond.x - objimg.x;
       document.mainform.imgypos.value = objsecond.y - objimg.y;
    }

    function setPixposXY(x,y){
       document.mainform.pixxpos.value = x;
       document.mainform.pixypos.value = y;

    }

    function showTextPreviewImage(textinput){
      if (textinput.value){
        fontcolor = document.mainform.fontcolor.value;
        fontsize = document.mainform.fontsize.value;
        fontfile = document.mainform.truetype.value;
        fontangle = document.mainform.fontangle.value;
        url = "?action=preview&fontcolor="
                    + fontcolor + "&fontsize=" + fontsize + "&fontfile=" + fontfile
                    + "&text=" + textinput.value
                    + "&fontangle=" + fontangle;
        getElement('previewimage').src = url;
        showTextPreview(true);
        }
    }

    function showSecond(){
    sel = document.mainform.mergefile.value;
    if (sel){
      secondimg = getElement('secondimage');
      secondimg.src = '<?=$img_dir?>' + sel;
      objsecond.showIt();
      }else{
        objsecond.hideIt();
        }
    }

    function startTrans(){
      objpixpos.showIt();
      }

    function getFrame(){
      iframe = document.colorreader;
      if (!iframe) iframe = window.frames["colorreader"];
      return iframe;
      }

    function readFrameData(){
      iframe = getFrame();
      color = iframe.curcol;
      if (!color) $color = iframe.document.frameform.currentcolor.value;
      if (color){
         document.mainform.currentcolor.value = color;
         getElement('samplespan').style.backgroundColor = "#" + color;
         }
    }

    function stopTrans(){
      if (getElement('pixposdiv').style.visibility=='visible'){
        iframe = getFrame();
        x = objpixpos.x-objimg.x+15;
        y = objpixpos.y-objimg.y+15;
        url = "<?=$PHP_SELF?>?action=colorreader&dir=<?=$info->directory?>&filename=<?=$info->filename?>&posx=" + x + "&posy=" + y;
        iframe.location.href = url;
        setTimeout("readFrameData()",250);
        setPixposXY(x,y);
        }
    }

    </script>

    <style>
    BODY{
    color : Black;
    font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size : 9pt;
    text-align : left;
    background : #D6D3CE;
    }
    TABLE.white {
    border-style: solid;
    border-color: black;
    border-width: 1px;
    background-color : White;
    }
    TH{
    font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size : 8pt;
    border-style: solid;
    border-color: black;
    border-width: 1px;
    background-color: #F9C05E;
    color : White;
    cursor:move;
    }
    TD{
    font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size : 8pt;
    }
    TD.large {
    font-size:10pt;
    }
    TD.small {
    color: navy;
    font-size: 8pt;
    font-family:Arial, Helvetica, sans-serif;
    }
    TD.white {
    color : #FFFFFF;
    font-size : 8pt;
    }
    .bordered{
    border-style: solid;
    border-color: black;
    border-width: 1px;
    width:60px;
    }
    H3{
    font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
    text-align : center;
    font-style : normal;
    font-size : 9pt;
    }
    a{
    font-weight : bold;
    text-decoration: none;
    color:#000A59;
    font-family : "verdana", "sans-serif";
    font-size : 8pt;
    }
    a:hover{
    font-weight : bold;
    text-decoration: underline;
    color: #CC0000;
    }
    input, select, button,textarea{
    border-width: 1px;
    font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-style : normal;
    font-size : 8pt;
    border-color : Black;
    }
    #tooldiv{
    position:absolute;
    right:10px;
    top:10px;
    z-Index:9999;
    visibility:hidden;
    }
    #infodiv{
    position:absolute;
    right:10px;
    top:270px;
    z-Index:10;
    visibility:hidden;
    }
    #opendiv{
    position:absolute;
    left:10px;
    top:10px;
    z-Index:9;
    <? if ($info->handle) echo "visibility:hidden;"; ?>
    }
    #optiondiv{
    position:absolute;
    right:10px;
    top:385px;
    z-Index:50;
    visibility:hidden;
    }
    #miscdiv{
    position:absolute;
    left:10px;
    top:50px;
    z-Index:20;
    visibility:hidden;
    }
    #resizediv{
    position:absolute;
    left:340px;
    top:190px;
    z-Index:40;
    visibility:hidden;
    }
    #rotatediv{
    position:absolute;
    left:340px;
    top:240px;
    z-Index:30;
    visibility:hidden;
    }
    #colordiv{
    position:absolute;
    left:10px;
    top:200px;
    z-Index:60;
    visibility:hidden;
    }
    #mergediv{
    position:absolute;
    left:10px;
    top:330px;
    z-Index:65;
    visibility:hidden;
    }
    #clipdiv{
    position:absolute;
    left:0px;
    top:300px;
    z-Index:70;
    visibility:hidden;
    }
    #textdiv{
    position:absolute;
    left:10px;
    top:370px;
    z-Index:80;
    visibility:hidden;
    }
    #transdiv{
    position:absolute;
    left:30px;
    top:350px;
    z-Index:90;
    visibility:hidden;
    }
    #previewdiv{
    position:absolute;
    left:0px;
    top:100px;
    cursor:move;
    z-index:3;
    visibility:hidden;
    }
    #lefttopdiv{
    position:absolute;
    background-image:url(<?=$PHP_SELF?>?img=left);
    left:0px;
    top:100px;
    height:25px;
    width:25px;
    z-index:8;
    cursor:move;
    visibility:hidden;
    }
    #rightbottomdiv{
    position:absolute;
    background-image:url(<?=$PHP_SELF?>?img=right);
    left:0px;
    top:225px;
    height:25px;
    width:25px;
    z-index:9;
    cursor:move;
    visibility:hidden;
    }
    #imgdiv{
    position:absolute;
    left:500px;
    top:500px;
    width:<?=$info->width?>px;
    height:<?=$info->height?>px;
    text-align:center;
    z-index:0;
    <? if (!$info->handle) echo "visibility:hidden;\n";?>
    }
    #colorreader{
    display:none;
    }
    #pixposdiv{
    position:absolute;
    left:0px;
    top:0px;
    width:30px;
    height:30px;
    visibility:hidden;
    cursor:move;
    background-image:url(<?=$PHP_SELF?>?img=pixpos);
    z-index:2;
    }
    #seconddiv{
    position:absolute;
    top:100px;
    visibility:hidden;
    cursor:move;
    z-index:1;
    }
    #samplespan{
    width:100%;
    height:100%;
    }
    </style>

</head>

<body onload="libinit()">

<form name="mainform" method="POST" enctype="multipart/form-data">

<input type="hidden" name="clipval" value="">
<input type="hidden" name="img_dir" value="<?=$img_dir?>">
<input type="hidden" name="callBack" value="<?=$callBack?>">
<div id="opendiv">
<table cellspacing="2" cellpadding="2" class="white">

  <th colspan="<?if($info->handle) echo "2"; else echo "3";?>">Open - Upload - Copy File</th>

  <?if($info->handle){?>
   <th>
   <A href="#" onclick="objopen.hideIt();return false;">CLOSE</A>
   </th>
  <?}?>

  <tr>
   <td align="right">
   Open
   </td>

   <td>
   <select id="newimage" name="newimage">
   <?=getFiles($img_dir,$info->filename);
   ?>
   </select>
   </td>

   <td></td>

   </tr>

   <tr>

   <td align="right">
   Copy remote
   </td>

   <td>
     <input type="text" size="48" name="remoteimage" value="http://">
   </td>

   <td></td>

   </tr>

   <tr>

   <td align="right">
    Upload
   </td>

   <td>
     <input type="file" name="uploadedfile" size="40">
     <input type="hidden" name="MAX_FILE_SIZE" value="<?=MAX_UPLOAD?>">
   </td>

   <td align="center">
     <input type="submit" value=" APPLY ">
   </td>

  </tr>
</table>

</div>

<div id="tooldiv">
<table border="0" width="200px" cellspacing="2" cellpadding="2" class="white">
     <tr>
     <td align="center">
      <A class="small" target="_blank" href="http://truecolor.allayers.com">
      <img border="0" align="absmiddle" src="<?=$PHP_SELF?>?img=logo">
      </a>
     </td>
     </tr>
<?
if (false) {
?>
     <th>
       File Management Toolbars
     </th>

     <tr>
           <td align="center"><A href="#" onclick="objopen.showIt();return false;">Open - Copy - Upload</a></td>
     </tr>

     <tr>
           <td align="center"><A href="#" onclick="objmisc.showIt();return false;">Rename - Copy - Delete</a></td>
     </tr>

     <tr>
           <td align="center"><A href="#" onclick="objinfo.showIt();return false;">File Properties</a></td>
     </tr>
<?
} // end if(false)
?>

<? if ($info->handle){?>
<?
if (false) {
?>
     <tr>
           <td align="center"><A href="#" onclick="objoption.showIt();return false;">Output options</a></td>
     </tr>
<?
} // end if (false)
?>

     <th>
       <? echo $labels['title']; //Image Modify Toolbars 
       ?>
     </th>
      <tr>
           <td align="center"><A href="#" onclick="objresize.showIt();return false;"><? //Resize - Scale
           echo $labels['resize'] . " - " . $labels['scale'];
           ?></a></td>
      </tr>
      <tr>
           <td align="center"><A href="#" onclick="showCorners(true);objclip.showIt();return false;">
           <? //Cropping
           echo $labels['cropping'];
           ?>
           </a></td>
      </tr>
      <tr>
           <td align="center"><A href="#" onclick="javascript:window.opener.location='<? echo unEncodeCallBack($callBack); ?>';window.close()">[<? //Done
           echo $labels['done'];
           //echo unEncodeCallBack($callBack); 
           ?>]</a></td>
      </tr>
<?
if (false) {
?>
      <tr>
           <td align="center"><A href="#" onclick="objrotate.showIt();return false;">Rotate - Mirror</a></td>
      </tr>

      <tr>
           <td align="center"><A href="#" onclick="objtext.showIt();return false;">Insert Text</a></td>
      </tr>
      <tr>
           <td align="center"><A href="#" onclick="objcolor.showIt();return false;">Modify Colors</a></td>
      </tr>
      <tr>
           <td align="center"><A href="#" onclick="objmerge.showIt();return false;">Merge Image</a></td>
      </tr>
<?
} // end if (false)
?>
<?}?>
</table>
</div>

<div id="rotatediv">
<table border="0" cellspacing="2" cellpadding="2" class="white">
  <th colspan="2">
    Rotate
  </th>
  <th>
   <A href="#" onclick="objrotate.hideIt();return false;">CLOSE</a>
  </th>
  <tr>
    <td>
      <select name="angle">
      <option value="" selected>Rotate
      <option value="90">Left (-90&#176;)
      <option value="180">Flip (180&#176;)
      <option value="270">Right (+90&#176;)
      </select>
   </td>
   <td>
    <input valign="bottom" type="checkbox" name="mirror" value="true">
      Mirror
    </td>

   <td><input type="submit" value=" APPLY "></td>
   </tr>

</table>
</div>

<div id="resizediv">
<table border="0" cellspacing="2" cellpadding="2" class="white" width="400">
  <th colspan="4">
    <? //Resize
    echo $labels['resize'];
    ?>
  </th>
  <th>
   <A href="#" onclick="objresize.hideIt();return false;"><? echo $labels['close']; ?></a>
  </th>
     <tr>
     <td colspan="5">
    <? echo $labels['resizeInstr']; ?>
    </td>
  </tr>

  <tr>
   <td>
       <select name="rescale">
       <option value=""><? //Scale
       echo $labels['scale'];
       ?>
       <?=writeScales(10,200,100);?>
       </option>
       </select>
   </td>
   <td>
     <? echo $labels['or']; ?>
   </td>
   <td>
       <select name="widthheight">
       <option value="width">
       <?    //New width
       echo $labels['newwidth'];
       ?>
       <option value="height"><? //New height
       echo $labels['newheight'];
       ?>
       </option>
       </select>
   </td>
   <td>
       <input type="text" size="3" name="newsize"> px
   </td>

   <td><input type="submit" value="<? echo $labels['apply']; ?>"></td>

   </tr>


</table>
</div>

<div id="optiondiv">
<table border="0" cellspacing="2" cellpadding="2" class="white">
  <th colspan="2">
   Output
  </th>
  <th>
   <A href="#" onclick="objoption.hideIt();return false;">CLOSE</a>
  </th>

  <tr>
    <td>
       <input type="radio" name="output" value="jpg" checked> JPEG
    </td>

    <td>
        <select id="quality" name="quality">
        <option value="" selected>JPEG Quality
        <?=writeScales(10,100);?>
        </select>
    </td>

    <td></td>

  </tr>

  <tr>
    <td>
      <input type="radio" name="output" value="png24"> PNG 24
    </td>

  </tr>

  <tr>

   <td>
      <input type="radio" name="output" value="png8"> PNG 8
   </td>

   <td>
       <a id="translink" name="translink" href="#" onclick="objtrans.showIt();startTrans();return false;">Set transparency</a>
   </td>

   <td></td>

  </tr>


  <tr>

    <td colspan="2">
        Resample output image <input name="resample" type="checkbox" value="true" checked>
    </td>

    <td></td>

  </tr>

  </table>

</div>

<div id="transdiv">
  <table border="0" cellspacing="2" cellpadding="2" class="white">
    <th colspan="2">
      Find Color
    </th>
    <th>
     <A href="#" onclick="objpixpos.hideIt();objtrans.hideIt();return false;">CLOSE</a>
    </th>

    <tr>
      <td colspan="2" class="bordered" align="center"><a href="#" onclick="stopTrans();">Drag Cursor & Click Here</a></td>
      <td></td>
    </tr>

    <tr>
      <td>Current color #<input type="text" id="currentcolor" name="currentcolor"" size="6"></td>
      <td class="bordered"><div id="samplespan">&nbsp;</div></td>
      <td><input type="submit" value=" APPLY "></td>
    </tr></table>
    <input type="hidden" name="pixxpos"><input type="hidden" name="pixypos">
</div>

<div id="colordiv">
<table cellspacing="2" cellpadding="2" class="white">
    <th colspan="4">
     Color correction
    </th>
    <th>
     <A href="#" onclick="javascript:objcolor.hideIt();return false;">CLOSE</a>
    </th>

   <tr>
     <td><input type="radio" name="colorinput" checked></td>
     <td colspan="3">
       <select name="gamma">
        <option value="" selected>Gamma correction
         <?=writeGammaScales();?>
       </select>
     </td>
     <td></td>

   </tr>

   <tr>
    <td rowspan="3"><input type="radio" name="colorinput"></td>
    <td>
       <select name="hue">
        <option value="" selected>Hue
       <?=writeScales(-100,100,100,true)?>
       </select>
   </td>

   <td>
       <select name="sat">
        <option value="" selected>Saturation
         <?=writeScales(-100,100,100,true);?>
       </select>
   </td>

   <td>
       <select name="lum">
        <option value="" selected>Luminosity
         <?=writeScales(-100,100,100,true);?>
       </select>
   </td>

   <td>
   </td>

   </tr>

   <tr>

     <td>
       <select name="red">
        <option value="" selected>Red
       <?=writeScales(-100,100,100,true)?>
       </select>
     </td>

     <td>
       <select name="green">
        <option value="" selected>Green
         <?=writeScales(-100,100,100,true);?>
       </select>
     </td>

     <td>
       <select name="blue">
        <option value="" selected>Blue
         <?=writeScales(-100,100,100,true);?>
       </select>
     </td>

     <td></td>
   </tr>

   <tr>
     <td colspan="3" class="small">Grayscale = -100% Saturation</td></td></td>
   </tr>

   <tr>
     <td rowspan="2"><input type="radio" name="colorinput"></td>
     <td colspan="2">
       <select name="mergecolor">
       <option value="">Colorize</option>
       <?=getNamedColors()?>
       </select>
     </td>

     <td>
     <select name="coloropacity">
       <option value="">Opacity</option>
       <?=writeScales(1,99)?>
       </select>
     </td>
     <td><input type="submit" value=" APPLY "></td>
   </tr>

   </table>
</div>

<div id="miscdiv">
<table cellspacing="2" cellpadding="2" class="white">
   <th colspan="3">
    File management
   </th>
   <th>
     <A href="#" onclick="objmisc.hideIt();return false;">CLOSE</a>
   </th>

   <tr>
    <td><input type="radio" name="action" value="" checked></td>
   <td>
    Rename to
   </td>

   <td>
     <input type="text" size="25" name="renamedfile">.<?=$info->type ?>
     <input type="hidden" name="origfiletype" value="<?=$info->type ?>">
   </td>
   <td></td>
   </tr>

  <tr>
    <td><input type="radio" name="action" value="delete"></td>
   <td>
    Delete this file
   </td>
   <td>
     <input type="checkbox" name="cleanup" value="true">
     Erase all temporary files
   </td>
   <td></td>
  </tr>

 <tr>
    <td><input type="radio" name="action" value="copy"></td>
   <td>
    Copy to
   </td>

   <td>
     <select name="copydir">
     <?=getSubDirs(IMG_DIR,$img_dir)?>
     </select>
   </td>
   <td></td>
  </tr>

   <tr>
   <td><input type="radio" name="action" value="deldir"></td>
   <td colspan="3">Delete selected directory</td>
   </tr>

   <tr>
   <td><input type="radio" name="action" value="createdir"></td>
   <td colspan="2">
    Create new subdirectory
    <input type="text" size="15" name="newdirectory">
   </td>
   <td><input type="submit" value=" APPLY "></td>
   </tr>

</table>
</div>

<div id="clipdiv">
<table cellspacing="2" cellpadding="2" class="white" width="300">
   <th colspan="4">
   <?
    //Cropping
    echo $labels['cropping'];
    ?>
   </th>
   <th>
     <A href="#" onclick="showCorners(false);objclip.hideIt();return false;"><? echo $labels['close']; ?></a>
   </th>
   
    <tr>
    <td colspan="6">
    <? echo $labels['croppingInstr']; ?>
    </td>
    </tr>
   <tr>
    <td><? echo $labels['left']; ?></td><td><input name="offset_left" type="text" value="0" size="2"> px</td>
    <td><? echo $labels['top']; ?></td><td><input name="offset_top" type="text" value="0" size="2"> px</td>
    <td><input type="hidden" name="tocrop"></td>
   </tr>
   <tr>
     <td><? echo $labels['right']; ?></td><td><input name="offset_right" type="text" value="<?=$info->width?>" size="2"> px</td>
     <td><? echo $labels['bottom']; ?></td><td><input name="offset_bottom" type="text" value="<?=$info->height?>" size="2"> px</td>
     <td><input type="submit" value="<? echo $labels['apply']; ?>"></td>
   </tr>

</table>
</div>

<div id="mergediv">
<table cellspacing="2" cellpadding="2" class="white">
   <th colspan="2">
    Merge Image
   </th>
   <th>
     <A href="#" onclick="showCorners(false);objmerge.hideIt();return false;">CLOSE</a>
   </th>

   <tr>

    <td colspan="2">
       <select id="mergefile" name="mergefile" onchange="showSecond()">
       <option value="">Image</option>
       <?=getMergeFiles($img_dir,$info->filename)?>
       </select>
       <input type="hidden" name="imgxpos">
       <input type="hidden" name="imgypos">
    </td>
    <td></td>

   </tr>
   <tr>

    <td>Opacity</td>
    <td>
       <select name="imageopacity">
       <option value="100">Full = 100%</option>
       <?=writeScales(1,99)?>
       </select></td>
    </td>

    <td><input type="submit" value=" APPLY "></td>
   </tr>

</table>
</div>


<div id="textdiv">
<table cellspacing="2" cellpadding="2" class="white">
   <th colspan="4">
    Text
   </th>
   <th>
     <A href="#" onclick="objpreview.hideIt();objtext.hideIt();return false;">CLOSE</a>
   </th>

   <tr>
      <td>Text</td>

      <td colspan="3">
        <input size="40" type="text" name="textstring" onkeyup="showTextPreviewImage(this);">
        <input type="hidden" name="textxpos">
        <input type="hidden" name="textypos">
      </td>
   </tr>

   <tr>

   <td>Font</td>

   <td>
     <select name="truetype" onchange="showTextPreviewImage(document.mainform.textstring)">
     <?=getTrueTypes()?>
     </select>
   </td>

   <td>Size</td>

   <td>
     <select id="fontsize" name="fontsize" onchange="showTextPreviewImage(document.mainform.textstring)">
      <?=writeOptions(12,200,40)?>

     </select> px
   </td>
    <td></td>

   </tr>

   <tr>
     <td>Font color</td>
     <td colspan="3">
     <select id="fontcolor" name="fontcolor" onchange="showTextPreviewImage(document.mainform.textstring)">
      <?=getNamedColors("black");?>
     </select>
     </td>
     <td></td>
   </tr>

   <tr>
     <td>Angle</td>
     <td colspan="3">
     <select id="fontangle" name="fontangle" onchange="showTextPreviewImage(document.mainform.textstring)">
       <?=writeOptions(0,90,0)?>
     </select>
     degrees
     </td>
     <td> <input type="submit" value=" APPLY "></td>
   </tr>


</table>
</div>

<div id="previewdiv" onclick="setTextPreviewXY()">
  <img name="previewimage" id="previewimage">
</div>

</form>

<div id="infodiv">
  <table class="white">
  <th colspan="4">
   File information
  </th>
  <th>
    <A href="#" onclick="objinfo.hideIt();return false;">CLOSE</a>
  </th>

  <tr>
    <td>Current directory: </td>
    <td colspan="3"><b><?=$img_dir?></b></td>
    <td></td>
  </tr>

  <tr>
    <td>Filename: </td>
    <td colspan="3"><b><?=$info->filename?></b></td>
    <td></td>
  </tr>

  <tr>
    <td>Filesize: </td>
    <td><b><?=$info->filesize?> kB</b></td>
    <td>Status: </td>
    <td><b><?=$info->message?></b></td>
    <td></td>
  </tr>

  <tr>

    <td>Width: </td>
    <td><b><?=$info->width;?> px</b></td>
    <td>Height: </td>
    <td><b><?=$info->height;?> px</b></td>
    <td></td>
  </tr>

  <tr>

    <td>Exif Data: </td>
    <td colspan="4">
    <?
    echo readExif($img_dir,$info->filename);
    ?>
    </td>

    <td></td>

  </tr>

  </table>

</div>

<div id="lefttopdiv" onclick="showClipped();return false;">
</div>

<div id="rightbottomdiv" onclick="showClipped();return false;">
</div>

<div id="pixposdiv"></div>

<? if ($message){ ?>
<BR /><h3><?=$message?></h3>
<? } ?>

<div id="imgdiv"> 
<? if ($info->handle){ ?>
<IMG src="<?=$info->directory.$info->filename?>" <?=$info->string; ?> align="left">
<? } ?>

</div>


<div id="seconddiv" onclick="setImageXY()"><img name="secondimage" id="secondimage"></div>

<iframe id="colorreader" name="colorreader" src="?action=colorreader"></iframe>

<? if (!$info){ ?>
    <table align="right" class="white"><tr>
      <td align="center">Welcome to</td>
      <td title="Allayers Software & Solutions">
       <A class="small" target="_blank" href="http://truecolor.allayers.com">
       <img border="0" align="absmiddle" src="<?=$PHP_SELF?>?img=logo">
      </a>
      </td>
      <td align="center">1.3</td>
      </tr>
    </table>
<? } ?>

</body>
</html>


<?

function getNamedColors($color=""){

?>
        <option value="F0F8FF" style="background-color:#F0F8FF;">Aliceblue
        <option value="FAEBD7" style="background-color:#FAEBD7;">Antiquewhite
        <option value="00FFFF" style="background-color:#00FFFF;">Aqua
        <option value="7FFFD4" style="background-color:#7FFFD4;">Aquamarine
        <option value="F0FFFF" style="background-color:#F0FFFF;">Azure
        <option value="F5F5DC" style="background-color:#F5F5DC;">Beige
        <option value="FFE4C4" style="background-color:#FFE4C4;">Bisque
        <option value="000000" style="background-color:black;color:white;" <? if ($color=="black") echo "selected"; ?>>Black
        <option value="FFEBCD" style="background-color:#FFEBCD;">Blanchedalmond
        <option value="0000FF" style="background-color:#0000FF;color:white;">Blue
        <option value="8A2BE2" style="background-color:#8A2BE2;">Blueviolet
        <option value="A52A2A" style="background-color:#A52A2A;">Brown
        <option value="DEB887" style="background-color:#DEB887;">Burlywood
        <option value="5F9EA0" style="background-color:#5F9EA0;">Cadetblue
        <option value="7FFF00" style="background-color:#7FFF00;">Chartreuse
        <option value="D2691E" style="background-color:#D2691E;">Chocolate
        <option value="FF7F50" style="background-color:#FF7F50;">Coral
        <option value="6495ED" style="background-color:#6495ED;">Cornflowerblue
        <option value="FFF8DC" style="background-color:#FFF8DC;">Cornsilk
        <option value="DC143C" style="background-color:#DC143C;">Crimson
        <option value="00FFFF" style="background-color:#00FFFF;">Cyan
        <option value="00008B" style="background-color:#00008B;color:white;">Darkblue
        <option value="008B8B" style="background-color:#008B8B;">Darkcyan
        <option value="B8860B" style="background-color:#B8860B;">Darkgoldenrod
        <option value="A9A9A9" style="background-color:#A9A9A9;">Darkgray
        <option value="006400" style="background-color:#006400;">Darkgreen
        <option value="BDB76B" style="background-color:#BDB76B;">Darkkhaki
        <option value="8B008B" style="background-color:#8B008B;">Darkmagenta
        <option value="556B2F" style="background-color:#556B2F;">Darkolivegreen
        <option value="FF8C00" style="background-color:#FF8C00;">Darkorange
        <option value="9932CC" style="background-color:#9932CC;">Darkorchid
        <option value="8B0000" style="background-color:#8B0000;">Darkred
        <option value="E9967A" style="background-color:#E9967A;">Darksalmon
        <option value="8FBC8F" style="background-color:#8FBC8F;">Darkseagreen
        <option value="483D8B" style="background-color:#483D8B;">Darkslateblue
        <option value="2F4F4F" style="background-color:#2F4F4F;">Darkslategray
        <option value="00CED1" style="background-color:#00CED1;">Darkturquoise
        <option value="9400D3" style="background-color:#9400D3;">Darkviolet
        <option value="FF1493" style="background-color:#FF1493;">Deeppink
        <option value="00BFFF" style="background-color:#00BFFF;">Deepskyblue
        <option value="696969" style="background-color:#696969;">Dimgray
        <option value="1E90FF" style="background-color:#1E90FF;">Dodgerblue
        <option value="B22222" style="background-color:#B22222;">Firebrick
        <option value="FFFAF0" style="background-color:#FFFAF0;">Floralwhite
        <option value="228B22" style="background-color:#228B22;">Forestgreen
        <option value="FF00FF" style="background-color:#FF00FF;">Fuchsia
        <option value="DCDCDC" style="background-color:#DCDCDC;">Gainsboro
        <option value="F8F8FF" style="background-color:#F8F8FF;">Ghostwhite
        <option value="FFD700" style="background-color:#FFD700;">Gold
        <option value="DAA520" style="background-color:#DAA520;">Goldenrod
        <option value="808080" style="background-color:#808080;">Gray
        <option value="008000" style="background-color:#008000;">Green
        <option value="ADFF2F" style="background-color:#ADFF2F;">Greenyellow
        <option value="F0FFF0" style="background-color:#F0FFF0;">Honeydew
        <option value="FF69B4" style="background-color:#FF69B4;" <? if ($color=="pink") echo "selected"; ?>>Hotpink
        <option value="CD5C5C" style="background-color:#CD5C5C;">Indianred
        <option value="4B0082" style="background-color:#4B0082;">Indigo
        <option value="FFFFF0" style="background-color:#FFFFF0;">Ivory
        <option value="F0E68C" style="background-color:#F0E68C;">Khaki
        <option value="E6E6FA" style="background-color:#E6E6FA;">Lavender
        <option value="FFF0F5" style="background-color:#FFF0F5;">Lavenderblush
        <option value="7CFC00" style="background-color:#7CFC00;">Lawngreen
        <option value="FFFACD" style="background-color:#FFFACD;">Lemonchiffon
        <option value="ADD8E6" style="background-color:#ADD8E6;">Lightblue
        <option value="F08080" style="background-color:#F08080;">Lightcoral
        <option value="E0FFFF" style="background-color:#E0FFFF;">Lightcyan
        <option value="FAFAD2" style="background-color:#FAFAD2;">Lightgoldenrodyellow
        <option value="90EE90" style="background-color:#90EE90;">Lightgreen
        <option value="D3D3D3" style="background-color:#D3D3D3;">Lightgrey
        <option value="FFB6C1" style="background-color:#FFB6C1;">Lightpink
        <option value="FFA07A" style="background-color:#FFA07A;">Lightsalmon
        <option value="20B2AA" style="background-color:#20B2AA;">Lightseagreen
        <option value="87CEFA" style="background-color:#87CEFA;">Lightskyblue
        <option value="778899" style="background-color:#778899;">Lightslategray
        <option value="B0C4DE" style="background-color:#B0C4DE;">Lightsteelblue
        <option value="FFFFE0" style="background-color:#FFFFE0;">Lightyellow
        <option value="00FF00" style="background-color:#00FF00;">Lime
        <option value="32CD32" style="background-color:#32CD32;">Limegreen
        <option value="FAF0E6" style="background-color:#FAF0E6;">Linen
        <option value="FF00FF" style="background-color:#FF00FF;">Magenta
        <option value="800000" style="background-color:#800000;color:white;">Maroon
        <option value="66CDAA" style="background-color:#66CDAA;">Mediumauqamarine
        <option value="0000CD" style="background-color:#0000CD;">Mediumblue
        <option value="BA55D3" style="background-color:#BA55D3;">Mediumorchid
        <option value="9370D8" style="background-color:#9370D8;">Mediumpurple
        <option value="3CB371" style="background-color:#3CB371;">Mediumseagreen
        <option value="7B68EE" style="background-color:#7B68EE;">Mediumslateblue
        <option value="00FA9A" style="background-color:#00FA9A;">Mediumspringgreen
        <option value="48D1CC" style="background-color:#48D1CC;">Mediumturquoise
        <option value="C71585" style="background-color:#C71585;">Mediumvioletred
        <option value="191970" style="background-color:#191970;color:white;">Midnightblue
        <option value="F5FFFA" style="background-color:#F5FFFA;">Mintcream
        <option value="FFE4E1" style="background-color:#FFE4E1;">Mistyrose
        <option value="FFE4B5" style="background-color:#FFE4B5;">Moccasin
        <option value="FFDEAD" style="background-color:#FFDEAD;">Navajowhite
        <option value="000080" style="background-color:#000080;color:white;">Navy
        <option value="FDF5E6" style="background-color:#FDF5E6;">Oldlace
        <option value="808000" style="background-color:#808000;">Olive
        <option value="688E23" style="background-color:#688E23;">Olivedrab
        <option value="FFA500" style="background-color:#FFA500;">Orange
        <option value="FF4500" style="background-color:#FF4500;">Orangered
        <option value="DA70D6" style="background-color:#DA70D6;">Orchid
        <option value="EEE8AA" style="background-color:#EEE8AA;">Palegoldenrod
        <option value="98FB98" style="background-color:#98FB98;">Palegreen
        <option value="AFEEEE" style="background-color:#AFEEEE;">Paleturquoise
        <option value="D87093" style="background-color:#D87093;">Palevioletred
        <option value="FFEFD5" style="background-color:#FFEFD5;">Papayawhip
        <option value="FFDAB9" style="background-color:#FFDAB9;">Peachpuff
        <option value="CD853F" style="background-color:#CD853F;">Peru
        <option value="FFC0CB" style="background-color:#FFC0CB;">Pink
        <option value="DDA0DD" style="background-color:#DDA0DD;">Plum
        <option value="B0E0E6" style="background-color:#B0E0E6;">Powderblue
        <option value="800080" style="background-color:#800080;">Purple
        <option value="FF0000" style="background-color:#FF0000;">Red
        <option value="BC8F8F" style="background-color:#BC8F8F;">Rosybrown
        <option value="4169E1" style="background-color:#4169E1;">Royalblue
        <option value="8B4513" style="background-color:#8B4513;">Saddlebrown
        <option value="FA8072" style="background-color:#FA8072;">Salmon
        <option value="F4A460" style="background-color:#F4A460;">Sandybrown
        <option value="2E8B57" style="background-color:#2E8B57;">Seagreen
        <option value="FFF5EE" style="background-color:#FFF5EE;">Seashell
        <option value="A0522D" style="background-color:#A0522D;">Sienna
        <option value="C0C0C0" style="background-color:#C0C0C0;">Silver
        <option value="87CEEB" style="background-color:#87CEEB;">Skyblue
        <option value="6A5ACD" style="background-color:#6A5ACD;">Slateblue
        <option value="708090" style="background-color:#708090;">Slategray
        <option value="FFFAFA" style="background-color:#FFFAFA;">Snow
        <option value="00FF7F" style="background-color:#00FF7F;">Springgreen
        <option value="4682B4" style="background-color:#4682B4;">Steelblue
        <option value="D2B48C" style="background-color:#D2B48C;">Tan
        <option value="008080" style="background-color:#008080;">Teal
        <option value="D8BFD8" style="background-color:#D8BFD8;">Thistle
        <option value="FF6347" style="background-color:#FF6347;">Tomato
        <option value="40E0D0" style="background-color:#40E0D0;">Turquoise
        <option value="EE82EE" style="background-color:#EE82EE;">Violet
        <option value="F5DEB3" style="background-color:#F5DEB3;">Wheat
        <option value="FFFFFF" style="background-color:#FFFFFF;">White
        <option value="F5F5F5" style="background-color:#F5F5F5;">Whitesmoke
        <option value="FFFF00" style="background-color:#FFFF00;">Yellow
        <option value="9ACD32" style="background-color:#9ACD32;">YellowGreen
        </option>
   <?
   }// end function

//interface functions
function writeOptions($min,$max,$sel=0)
{
   for($i=$min;$i<=$max;$i++){
      $retval .= "<option value=".$i;
      if ($i==$sel) $retval .= " selected";
      $retval .= ">".$i;
      }
   return $retval."</option>";
   }

function writeScales($min,$max,$divide=1,$addplus=false)
{
   for($i=$min;$i<=$max;$i++){
      $retval .= "<option value=\"".($i/$divide)."\">";
      if ($addplus==true && $i>0) $retval .= "+";
      $retval .= $i;
      $retval .= "%";
      }
   return $retval."</option>";
   }

function writeGammaScales()
{
  for($i=0;$i<3;$i++)
     for($j=1;$j<10;$j++){
      $retval .= "<option value=\"$i.$j\">$i.$j";
      }
  return $retval."</option>";
}


function getDirs($basedir)
{

  // reading all filenames
 $handle = opendir($basedir);
 while($file = readdir($handle)){
    if  (!strpos($file,".") && !is_dir($file)){
      $h = @opendir($basedir.$file);
      if ($h){
           $subdirs[] = $basedir.$file."/";
           $nextsubs = getDirs($basedir.$file."/");
           if ($nextsubs)
             for($i=0;$i<sizeof($nextsubs);$i++)
                $subdirs[] = $nextsubs[$i];
           }
         }
      }
 return $subdirs;

}

function getSubDirs($basedir,$currentdir)
{
 $alldirs = getDirs($basedir);
 if ($alldirs)
   for($i=0;$i<sizeof($alldirs);$i++)
      if($alldirs[$i]!=$currentdir)$retstr .= "<option value='".$alldirs[$i]."'>".$alldirs[$i];

 if ($retstr){
  if($currentdir!=$basedir) $base = "<option value='$basedir'>".$basedir;
  $retstr = "<option value=''>None selected".$base.$retstr;
  }else{
    $retstr = "<option value=''>No subdirs";
    }

 return $retstr."</option>";
}

function getPix($dir)
{
  // opening directory for reading
  $handle = @opendir($dir);
  // reading all filenames
  while($file = @readdir($handle)){
    // skip directories
    if  (!is_dir($file)){
      // if the file is not an image, getimagesize won't result (or error :-)
      $img = getimagesize($dir."/".$file);
      // 1,2,3,5 = gif, jpg, png,wbmp;
      //if ($img[2]>0 && $img[2]<4 || $img[2]==5)
      if ($img){
        $filenames[] = $file;
        }else{
           $h = @opendir($dir.$file);
           if ($h) $filenames[] = "[".$file."]";
           }
      }
   }// end while
  return $filenames;
}

// used for sorting
function cmp($a,$b)
{
 return strcasecmp($a, $b);
}

function getFiles($dir,$newimage="")
{
   $stylecol = " style=\"background-color:#FFFFCC;\"";

   $files = getPix($dir);

   if ($dir!=IMG_DIR)$retstr .=  "<option $stylecol value=\"[..]\">[..]".$GLOBALS["message_dir_up"];
   usort($files, "cmp");
   //reset($files);
   for($i=0;$i<sizeof($files);$i++){
     $retstr .= "<option";
     if (strpos($files[$i],"]")) $retstr .= $stylecol;
     if ($newimage && $files[$i]==$newimage) {
       $retstr .=  " selected";
       $selected = true;
       }
     $retstr .=  ">".$files[$i];
     }

   if (!$selected) $retstr .= "<option value='' selected>".$GLOBALS["message_no_file"];
   $retstr .=  "</option>";
   return $retstr;
}

function getMergeFiles($dir,$newimage)
{
    $files = getPix($dir);
    @usort($files, "cmp");

    for($i=0;$i<sizeof($files);$i++)
       if (!strpos($files[$i],"]") && $files[$i]!=$newimage)
            $retstr .= "<option value=\"".$files[$i]."\">".$files[$i]."</option>";

    return $retstr;
}

function cleanupTemp($dir,$newimage="")
{
  $handle = @opendir($dir);
  if($handle) while($file = @readdir($handle)){
     if (!is_dir($file) && strpos($file,"__")){
         unlink($dir.$file);
         if ($file==$newimage) unset($newimage);
         }
     }
  return $newimage;
}

function prevdir($dir)
{
$dirarray = split("/",$dir);
if (sizeof($dirarray)) $maxlength = sizeof($dirarray)-2;
for ($i=0;$i<$maxlength;$i++) $retval .= $dirarray[$i]."/";
if (!$retval) $retval = IMG_DIR;
return $retval;
}

function getTrueTypes()
{

  $handle = opendir(FNT_DIR);
  while($file = readdir($handle)) $files[] = $file;
  usort($files, "cmp");
  foreach($files as $file){
     if (!is_dir($file) && strpos($file, ".ttf")){
         $split = split("\.",$file);
         $retstr .= "<option value=\"".FNT_DIR.$file."\">".$split[0];
         }
     }

  return $retstr."</option>";

}

function readExif($dir, $file)
{

if (function_exists("exif_read_data")) $exif = @exif_read_data("$dir/$file","IFD0");

if ($exif){
  //print_r($exif);
  while(list($id,$array) = each($exif))
        if (is_array($array))
          while(list($item,$value) = each($array))
             $retstr .= "$item: $value<br />\n";
        }else{
           $retstr = $GLOBALS["message_no_exif"];
            }

return $retstr;

}

function getHandle($directory,$filename)
{
  $size = GetImageSize($directory.$filename);

  $type = $size[2];
  switch ($type){
         case 1:
              $im = imagecreatefromgif($directory.$filename);
              $this->type="gif";
         break;
         case 2:
              $im = imagecreatefromjpeg($directory.$filename);
         break;
         case 3:
              $im = imagecreatefrompng($directory.$filename);
              $this->type="png";
         break;
         }
  return $im;
}

function outputColorAt($posx,$posy,$dir,$filename){

  $img = getHandle($dir,$filename);
  $color = imagecolorat($img, $posx, $posy);
  $colorrgb = imagecolorsforindex($img,$color);

  if ($colorrgb["red"]>0)$hred = dechex($colorrgb["red"]); else $hred = "00";
  if (strlen($hred)<2)$hred = "0".$hred;

  if ($colorrgb["green"]>0)$hgreen = dechex($colorrgb["green"]); else $hgreen = "00";
  if (strlen($hgreen)<2)$hgreen = "0".$hgreen;

  if ($colorrgb["blue"]>0)$hblue = dechex($colorrgb["blue"]); else $hblue = "00";
  if (strlen($hblue)<2)$hblue = "0".$hblue;

  $hexcolor = strtoupper($hred.$hgreen.$hblue);
  imagedestroy($img);
  $retstr = "<html><head><head><script language=\"JavaScript1.2\">var curcol='$hexcolor'</script></head><body><form name=\"frameform\"><input type=\"text\" name=\"currentcolor\" value=\"$hexcolor\"></form></body></html>";
  return $retstr;
}


// embedded images
function cornerleft()
  {
    header("Content-type: image/gif");
    header("Content-length: 290");
    echo base64_decode(
'R0lGODlhGQAZAMQAAP///+zu8d3h5tXb4dbW1s/V3czU2sXN1c'.
'PK0cPExMHCw7y+wLW1tbC2va6yuKurrJmZmf///wAAAAAAAAAA'.
'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BA'.
'UUABEALAAAAAAZABkAAAWfICCOZGmeaHoqysI8CZG4sEzHSZ6I'.
'CeJEEULg8AsOi0IgULRACgoNIOEZDQoGyoiIAUwECkUvuBvAZk'.
'UPI1F6ZBuyS0Ds6RxbzXCR0C4Ol+FKPAdVQmtGb4BxTVJ0jHiJ'.
'W2R8f4mBAGmFSAGIlXFzdlOPnXpffqKjcoNunYBMTqeskRFesL'.
'GXh6yVPKG5ugBCtb08vbYJxKjGx5ByyokhADs='.
'');
}
function cornerright()
  {
    header("Content-type: image/gif");
    header("Content-length: 292");
    echo base64_decode(
'R0lGODlhGQAZAMQAAP///+zv8t3h5tXc5NbW1s/V3dHS08XN1c'.
'PK0cLDw8HCw7y+wLW1ta+0u66yuKurrJmZmf///wAAAAAAAAAA'.
'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BA'.
'UUABEALAAAAAAZABkAAAWhYCSOZGlGCQCc7JmubSy+skzX5xAY'.
'Km4OAsLNJyrsIo8eMaJTiBhKH9AgciyiNSM10jgMZc2qFtuaih'.
'qF4JelPR+OSVg54Iw4jIknuWTmprdWeyNtXG9bXWsjYXZ4YjuC'.
'fWgCh2lCe4RdR4VwZIt3AXmMoHpyTAOUk2d/Z1elAQRVb7B2sm'.
'cILwm5CQYJDwwLu72/wb7ALyrIycrLzM3OyyEAOw=='.
'');
}

function logo()
  {
    header("Content-type: image/gif");
    header("Content-length: 967");
    echo base64_decode(
'R0lGODlhUAAUAOYAAP///+/89f/v7+/y/9/57N/y3//f3+/f/8'.
'/14r/y2f/M5f/MzOfP/8/Z///Mv6/vz/+/37/lv9XU1P/Fn/+/'.
'v5/sxd+//7/Zv7/M/6/fr4/pvPzDX/rBX/+vr/e+Xf+l0v+yf9'.
'ev/6/Pr3/lsq+//5/Zn++4Wv+lj/+pb/+ZzLy7um/iqf+ZmY/S'.
'j+SwVrW1tJ+y/8yZ/1/fn7CvrtalUY+8j4+l//9/f/+MP6WlpM'.
'2eTT/ZjG/Fb79//3+yf3+Z/8SXSv9lsi/VgpmZmV+/X7dv//9m'.
'Zh/SeW+M//9lP0+5T4yLig/Pb6aAPgDMZj+yP/9PT19//39/fv'.
'8zmZp2Oi+sL/8/P09y/3Fwbv8zMx+lHz+MPz9l//8zAIVmMmZm'.
'Zg+fD/8fHy+CL3hcLS9Z/wCZAFtbWv8PDx9M/09OTWNMJYcP//'.
'8AAA8//4AA/1E+HkFAPwBmAAAz/zo6OTMzMz8xFzwtFi8kESIh'.
'IR8YCxgYFxAQEBIOBwkIBQAAAAAAACH5BAUUAAAALAAAAABQAB'.
'QAAAf/gACCg4SFhoeIiYqLjI2Oj5CRjCpSWFhSOYM5L5Kdnooq'.
'aXt9eXl8fHMzAHh0n66vQ3h8ak06OkBed3hfeq2vv5EzeHlUJh'.
'vHxzpvfX2+AAtJ0dJJrhRQbGxQC4ooE45pfVQeHOTlHDR2fs4C'.
'Dg4nXe0Onx1nLAACRmcCiTggjSp76rgwR5BKM0MOuhDyIWJLjQ'.
'M9BvU4IOjBjh0aBoWxNwhKB0ENonBBMkBQP0EZlDxpMSgFhCAf'.
'lvQZM45gOR15nA1KSCiOmAsXLLgZ5MYCgApMKiQQIuMZGwOHGs'.
'j5geEKmpInW4ApkaGKEkFTgihQgKWPF5vmaOREqHBQHBGC/4QS'.
'NXqkgiACTghQYIMoSpRBaGAAOKmlhKACZQoAmAJBkJSZNdHi1C'.
'mIp9sLcYcKKgrAiefPCRaw2WeIy49Bpgf7KxNhEOvFCgQBFIiW'.
'XJODhSwLioMZgNzNRpk8GERA0JmPg4wYAXAFCWAbqgGAyXC4TA'.
'LYg+CEi5y2jjq2PXszcBMCQA/OK4QUH8EkAIAbYaACYMGGAgAS'.
'bTAAsNGG4kkeVRQQABFVgBWbbHoQYwwyG9CgRh/f5dbWbr0BUM'.
'Qaa8TAWQArMOGEEAgkx4YVWdQziA1oyEGGftEFwAMYZSihGHaD'.
'LKHHLLXQgIsde4hCGTCECECBfUAOogIce/BRSiQee8wxhASsFC'.
'mlIy9gYYYZWGQiyAsqTOnll2CGKeaYZJZ5SCAAOw=='.
'');
}

function pixpos()
  {
    header("Content-type: image/gif");
    header("Content-length: 132");
    echo base64_decode(
'R0lGODlhHgAeAJEAAP//////AP8AAAAAACH5BAUUAAAALAAAAA'.
'AeAB4AAAJVhI8oku1vFpxQ0qsY3nbf7k1g+IxkY56ZCgUB27jy'.
'CwO0RbO3lpfLD3RZFkKg8RgMDAVFpKYV4dV2hp5q5qohstpV95'.
'CChVljVfl0JqVDa0+b86QUAAA7'.
'');
}

function unEncodeCallBack( $callBack )
{
    return str_replace('_AND_', '&', $callBack );
}


?>
