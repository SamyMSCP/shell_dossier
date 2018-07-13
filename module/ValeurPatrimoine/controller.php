<?php
require_once("class/core/Module.php");
class ValeurPatrimoine extends Module
{
	protected final function getGraph($id_dh)
	{
		if (isPreprod())
		{
			$dir = "/var/www/html/";
			putenv("MSCPI_ENV=preprod");
		}
		else if (isProd())
		{
			$dir = "/var/www/html/";
			putenv("MSCPI_ENV=moncompte");
		}
		else
			$dir = "/Applications/XAMPP/xamppfiles/htdocs/mscpi/";

		$cmd = 'phantomjs '.$dir.'photomaton.js '.urlencode(ft_crypt_information($id_dh));
		$base64 = exec($cmd);

		if ($base64 != false && $base64 != 'error')
		{
			/*if (($img = imagecreatefromstring(base64_decode($base64))))
			{
				$img2 = imagecreatetruecolor(4000, 3000);
				$white = imagecolorallocate($img, 255, 255, 255);
				imagefill($img2, 0,0, $white);
				imagecopyresampled($img2,$img, 0,500,0,0, 4000,2322, 4200, 2600);
				$img3 = imagerotate($img2, 270, 0);
				ob_start();
				imagepng($img3);
				$data = ob_get_contents();
				ob_end_clean();
				imagedestroy($img);
				imagedestroy($img2);
				imagedestroy($img3);
				return base64_encode($data);
			}*/
			try
			{
				$img = new Imagick();
				$img->readimageblob(base64_decode($base64));
				$img->setImageFormat("png");
				$img->adaptiveResizeImage(2000, 0);
				//$img->rotateimage(new ImagickPixel("#FFFFFF"), 90);
				return base64_encode($img->getImageBlob());
			}
			catch (Exception $e)
			{
				error_log($e->getMessage());
			}
		}
		return null;
	}
}
