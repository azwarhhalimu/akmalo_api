<?php
class ImageHelper extends Helper {
    var $helpers = array('Html');
    var $cacheDir = 'imagecache';

    function getfile($i) {

        preg_match_all("/data:(.*);base64,/", $i, $temp_imagetype);

        $imagetype = $temp_imagetype[1][0];

        $image = base64_decode(preg_replace("/data.*base64,/","",$i));

        //echo $image;

        ob_start();

        //header("Content-type: ".$imagetype);
        header('Content-Type: image/jpeg');
        print($image);

        $data = ob_get_clean();

        //file_put_contents($this->webroot.'tmp/temp.jpg', 'test' );

        file_put_contents(ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'tmp/temp.jpg', $data );


        //return ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'tmp/temp2.jpg';
        //return 'temp2.jpg';
        return 'temp.jpg';
    //}
    }


    //source from: http://bakery.cakephp.org/articles/hundleyj/2007/02/16/image-resize-helper and modified for base64_decode
    function resize($path, $width, $height, $aspect = true, $htmlAttributes = array(), $return = false) {
        $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type 

        //$fullpath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.$this->themeWeb.IMAGES_URL;

        $fullpath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.IMAGES_URL;

        $temppath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'tmp/';


        //$formImage = imagecreatefromstring(base64_decode(preg_replace("/data.*base64,/","",$path)));

        //$url = $formImage;

        //$path = $this->getfile($path);

        $url = $temppath.$path;

        //$url = preg_replace("/data.*base64,/","",$path);

        //$url = base64_decode($url);

        if (!($size = getimagesize($url)))
            return; // image doesn't exist

        if ($aspect) { // adjust to aspect.
            if (($size[1]/$height) > ($size[0]/$width))  // $size[0]:width, [1]:height, [2]:type
                $width = ceil(($size[0]/$size[1]) * $height);
            else
                $height = ceil($width / ($size[0]/$size[1]));
        }

        $relfile = $this->cacheDir.'/'.$width.'x'.$height.'_'.basename($path); // relative file
        $cachefile = $fullpath.$this->cacheDir.DS.$width.'x'.$height.'_'.basename($path);  // location on server

        if (file_exists($cachefile)) {
        $csize = getimagesize($cachefile);
        $cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
        if (@filemtime($cachefile) < @filemtime($url)) // check if up to date
            $cached = false;
        } else {
            $cached = false;
        }

        if (!$cached) {
            $resize = ($size[0] > $width || $size[1] > $height) || ($size[0] < $width || $size[1] < $height);
        } else {
            $resize = false;
        }

        if ($resize) {
            $image = call_user_func('imagecreatefrom'.$types[$size[2]], $url);
            if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($width, $height))) {
                imagecopyresampled ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            } else {
                $temp = imagecreate ($width, $height);
                imagecopyresized ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            }
                call_user_func("image".$types[$size[2]], $temp, $cachefile);
                imagedestroy ($image);
                imagedestroy ($temp);
        }
        return $this->output(sprintf($this->Html->image($relfile,$htmlAttributes)));
    }
}
?>