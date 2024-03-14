<?php

namespace App\Helpers;

class Resize
{
    public $source;
    public $destin;
    public $type;
    public $srcWidth;
    public $srcHeight;
    public $maxWidth  = 1920;
    public $maxHeight = 1000;
    private $bmp;
    private $bmpraw;
    private $header;
    private $img;

    /* Get the image source and set the destination file */

    public function __construct($source, $destin='')
    {
        $this->source = $source;
        $this->destin = $destin;
        if (!$destin)
            $this->destin = 'tmb_'.$source;
    }

    /* Resize with maxWidth and maxHeight */

    public function resize($width='', $height='')
    {
        /* Get the image type */
        list($this->srcWidth, $this->srcHeight, $this->type) = getimagesize($this->source);
        
        /* Check if this image is BMP and convert to JPG */ 
        if ($this->type == IMAGETYPE_BMP) {
            $savejpg = str_replace(['bmp', 'BMP'], 'jpg', $this->source);
            $this->bmp2jpg($this->source, $savejpg);
            $this->source = $savejpg;
            $this->type = IMAGETYPE_JPEG;    
            $this->destin = str_replace(['bmp', 'BMP'], 'jpg', $this->destin);
        }

        /* Check and Set the width and height */
        if ($width)  $this->maxWidth  = $width;
        if ($height) $this->maxHeight = $height;  
        if ($this->srcWidth <= $this->maxWidth && $this->srcHeight <= $this->maxHeight) {
            copy($this->source, $this->destin);
            return $this->destin;
        }
        $k = min($this->maxWidth/$this->srcWidth, $this->maxHeight/$this->srcHeight);               
        $newWidth  = round($k * $this->srcWidth);
        $newHeight = round($k * $this->srcHeight);

        $newImg = imagecreatetruecolor($newWidth, $newHeight);

        /* Check if this image is GIF and preserve transparency */ 
        if ($this->type == IMAGETYPE_GIF) {
            $im = imagecreatefromgif($this->source);
            $trnprt_indx = imagecolortransparent($im);
            // If we have a specific transparent color
            if ($trnprt_indx >= 0) {
                // Get the original image's transparent color's RGB values
                $trnprt_color = imagecolorsforindex($im, $trnprt_indx);
                // Allocate the same color in the new image resource
                $trnprt_indx  = imagecolorallocate($newImg, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);				
                // Completely fill the background of the new image with allocated color.
                imagefill($newImg, 0, 0, $trnprt_indx);				
                // Set the background color for new image to transparent
                imagecolortransparent($newImg, $trnprt_indx);
            }
            imagecopyresampled($newImg, $im, 0, 0, 0, 0, $newWidth, $newHeight, $this->srcWidth, $this->srcHeight);
            imagegif($newImg, $this->destin);
        }

        /* Check if image jpeg */
        elseif ($this->type == IMAGETYPE_JPEG) {
            $im = imagecreatefromjpeg($this->source);
            imagecopyresampled($newImg, $im, 0, 0, 0, 0, $newWidth, $newHeight, $this->srcWidth, $this->srcHeight);
            imagejpeg($newImg, $this->destin);
        }

        /* Check if image is PNG and preserve transparency */
        elseif ($this->type == IMAGETYPE_PNG){
            $im = imagecreatefrompng($this->source);
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
            imagefilledrectangle($newImg, 0, 0, $newWidth, $newHeight, $transparent);
            imagecopyresampled($newImg, $im, 0, 0, 0, 0, $newWidth, $newHeight, $this->srcWidth, $this->srcHeight);
            imagepng($newImg, $this->destin);
        }
        
        else {trigger_error('Unsupported filetype!', E_USER_WARNING);
            exit();
        }

        imagedestroy($im);
        imagedestroy($newImg);

        return $this->destin;
    }

    /* Convert BMP to JPG image */
    public function bmp2jpg($bmp, $save_as) {
        $this->bmp = $bmp;
        $this->getbmpraw();
        $this->imgbmp();
        imagejpeg($this->img, $save_as);
        imagedestroy($this->img);
    }

    // Checks if $bmp is raw or file and returns raw bmp data
    private function getbmpraw() {
        if(is_string($this->bmp)) {
            if($f = fopen($this->bmp, "rb")) {
                $this->bmpraw = fread($f, filesize($this->bmp));
                fclose($f);
                return;
            } else {
                $error = 'Error opening file '.$this->bmp;
                throw new Exception($error);
                return false;
            }
        } else if(is_object($this->bmp)) {
            $this->bmpraw = $this->bmp;
            return;
        } else {
            $error = 'Invalid variable passed to function';
            throw new Exception($error);
            return false;
        }
    }

    // Decodes $bmpraw and returns image object
    private function imgbmp() {

        $this->getbmpheader();
        //set info from header about BMP
        $w  = $this->header['width'];     //image width
        $h  = $this->header['height'];    //image height
        $s  = $this->header['bitmap_start'];  //offset where BMP data
        $b  = $this->header['bits_pixel'];    //bits per pixel
        $ds = $this->header['dib_size'];  //size of dib header
        $hs = 14;           //size of BMP file header data
        $ps = pow(2,$b) * 4;        //size of palette
        $bp = array('4','8','24');  //array of supported bp

        //validate $b matches what this script can read
        if(!in_array($b, $bp)) {
            $error = 'BMP bits per pixel not supported';
            throw new Exception($error);
            return false;
        }

        //check for and grab color palette on 4,8 bit images
        if(($b <= 8) && $s >= $hs+$ds+$ps) { 
            $cp = substr($this->bmpraw, $hs + $ds, $ps); //grab color palette after header
            $cp = bin2hex($cp); //convert to hex
            $cp = str_split($cp, 8); //split into color codes
        }   

        //create image object
        $this->img = imagecreatetruecolor($w, $h);

        //trim header from BMP
        $this->bmpraw = substr($this->bmpraw, $s);

        //convert to string of HEX
        $this->bmpraw = bin2hex($this->bmpraw);

        //get row size with padding (must be multiple of 4 bytes)
        $row_size = ceil(($b * $w / 8) / 4) * 8;

        //split data to array of rows
        $this->bmpraw=str_split($this->bmpraw,$row_size);

        //process data
        for($y=0; $y<$h; $y++) {
            
            //get 1 row (flip row vertical order)
            $row = $this->bmpraw[abs(($h-1)-$y)];

            //get row pixel data (remove trailing buffer)
            $row = substr($row, 0, $w * $b / 4);

            //split row to pixel
            $pixels = str_split($row, $b / 4);

            //process 24bit bitmap
            if($b == 24) {
                //write pixel data for row to img
                for($x=0; $x<$w; $x++) {
                    imagesetpixel($this->img, $x, $y, $this->getimgcolorfrom24($pixels[$x]));
                }
                //process palette based bitmap
            } else if(in_array($b, $bp)) { 
                //write pixel data for row to img
                for($x=0; $x<$w; $x++) {
                    imagesetpixel($this->img, $x, $y, $this->getimgcolorfrompalette($pixels[$x],$b,$cp));
                }
            } else {
                return false;
            }
        }
        unset($this->bmpraw);
    }

    //returns header of BMP raw
    private function getbmpheader() {
        //grab first 54 to determine file info
        if($header = substr($this->bmpraw, 0, 54)) {
            $header = unpack(
                    'a2type/'.          //00-2b - header to identify file type
                    'Vfile_size/'.      //02-4b - size of bmp in bytes
                    'vreserved1/'.      //06-2b - reserved
                    'vreserved2/'.      //08-2b - reserved
                    'Vbitmap_start/'.   //10-4b - offset of where bmp pixel array can be found
                    'Vdib_size/' .      //14-4b - size of dib header
                    'Vwidth/'.          //18-4b - width on pixels
                    'Vheight/'.         //22-4b - height in pixels
                    'vcolor_planes/'.   //26-2b - number of color planes
                    'vbits_pixel/'.     //28-2b - bits per pixel
                    'Vcompression/'.    //30-4b - compression method
                    'Vimage_size/'.     //34-4b - image size in bytes
                    'Vh_resolution/'.   //38-4b - horizontal resolution
                    'Vv_resolution/'.   //42-4b - vertical resolution
                    'Vcolor_palette/'.  //46-4b - number of colors in palette
                    'Vimp_colors/'      //50-4b - important colors
                    , $header);
                    $this->header = $header;
                    return;
        } else {
            $error = 'BMP header data not found';
            throw new Exception($error);
            return false;
        }

        //validate bitmap
        if($header['type'] != 'BM') {
            $error = 'BMP not valid';
            throw new Exception($error);
            return false;
        }
    }

    //24 bit to image color function
    private function getimgcolorfrom24($hc) {
        $hc = str_split($hc,2);
        $r = hexdec($hc[2]);
        $g = hexdec($hc[1]);
        $b = hexdec($hc[0]);
        return ($r * 65536) + ($g * 256) + $b;
    }

    //4,8 bit to image color function
    private function getimgcolorfrompalette($hc,$b,$cp) {
        $r = 0; //red
        $g = 0; //green
        $b = 0; //blue
        if($cp != 0) { //if defined, set rgb value based on palette
            $r = hexdec(substr($cp[hexdec($hc)],4,2));
            $g = hexdec(substr($cp[hexdec($hc)],2,2));
            $b = hexdec(substr($cp[hexdec($hc)],0,2));
            return ($r * 65536) + ($g * 256) + $b;
        } else if($b == '4') { //else if no palette and 4 bit, use standard 16 color palette as defined below
            switch ($hc) {
                case '0': //black
                $r = 0; $g = 0; $b = 0;
                break;
                
                case '1': //dark red
                $r = 128; $g = 0; $b = 0;
                break;

                case '2': //red
                $r = 255; $g = 0; $b = 0;
                break;

                case '3': //pink
                $r = 255; $g = 0; $b = 255;
                break;

                case '4': //teal
                $r = 0; $g = 128; $b = 128;
                break;

                case '5': //green
                $r = 0; $g = 128; $b = 0;
                break;

                case '6': //bright green
                $r = 0; $g = 255; $b = 0;
                break;

                case '7': //turquoise
                $r = 0; $g = 255; $b = 255;
                break;

                case '8': //dark blue
                $r = 0; $g = 0; $b = 128;
                break;

                case '9': //violet
                $r = 128; $g = 0; $b = 128;
                break;

                case 'a': //blue
                case 'A':
                $r = 0; $g = 0; $b = 255;
                break;

                case 'b': //gray 25%
                case 'B':
                $r = 192; $g = 192; $b = 192;
                break;

                case 'c': //gray 50%
                case 'C':
                $r = 128; $g = 128; $b = 128;
                break;

                case 'd': //dark yellow
                case 'D':
                $r = 128; $g = 128; $b = 0;
                break;

                case 'e': //yellow
                case 'E':
                $r = 255; $g = 255; $b = 0;
                break;

                case 'f': //white
                case 'F':
                $r = 255; $g = 255; $b = 255;
                break;

                default:
                $r = 0; $g = 0; $b = 0;
                break;
            }

            return ($r * 65536) + ($g * 256) + $b;

        } else {
            $error = 'BMP palette not found and image is not 4 bpp';
            throw new Exception($error);
            return false;
        }
    }

}

