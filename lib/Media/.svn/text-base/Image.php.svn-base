<?php
class Image {
	public static function resize($srcfile, $width, $height = null, $destfile = null) {
        $info = getimagesize($srcfile);	    
        if($info[2] == IMAGETYPE_JPEG) {
            $ext = 'jpeg';
        } elseif($info[2] == IMAGETYPE_GIF) {
            $ext = 'gif';
        } elseif($info[2] == IMAGETYPE_PNG) {
            $ext = 'png';            
        } else
            die('unsupported image type');
        
	    if (!$height) {
	        $height = $width;
	    }

        $func = 'imagecreatefrom'.$ext;	    
        $src  = $func($srcfile);
        
        $srcwidth  = imagesx($src);
        $srcheight = imagesy($src);	        
        
        $dest = imagecreatetruecolor($width, $height);
        imagecopyresampled($dest, $src, 0, 0, 0, 0, $width, $height, $srcwidth, $srcheight);
	        
        if (!$destfile) {
            $destfile = $srcfile;
        }
        
        $func = 'image'.$ext;        
        $func($dest, $destfile);
	        
        imagedestroy($src);                
        imagedestroy($dest);
	}	
}
?>