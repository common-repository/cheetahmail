<?php

	function decode_letters($str)
	{

		$str = str_ireplace("&agrave;","à",$str);
		$str = str_ireplace("&acirc;","â",$str);
		$str = str_ireplace("&atrim;","ä",$str);

		$str = str_ireplace("&eacute;","é",$str);
		$str = str_ireplace("&egrave;","è",$str);
		$str = str_ireplace("&ecirc;","ê",$str);
		$str = str_ireplace("&etrim;","ë",$str);

		$str = str_ireplace("&ugrave;","ù",$str);
		$str = str_ireplace("&ucirc;","û",$str);
		$str = str_ireplace("&utrim;","ü",$str);

		$str = str_ireplace("&ocirc;","ô",$str);
		$str = str_ireplace("&otrim;","ö",$str);
	
		$str = str_ireplace("&icirc;","î",$str);
		$str = str_ireplace("&itrim;","ï",$str);
		
		$str = str_ireplace("&ccedil;","ç",$str);

		$str = str_ireplace("&rsquo;","'",$str);
		
		
		$str = str_ireplace("&euro;","€",$str);
		$str = str_ireplace("&gt;",">",$str);
		$str = str_ireplace("&lt;","<",$str);
		$str = str_ireplace("&deg;","°",$str);
		
		return $str;
	}
	
	
	
	function toTxt( $text )
	{
		
		$text = preg_replace(
			array(
			  // Remove invisible content
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu'
			),
			array(
				' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '
			),
			$text );
			
			$text = nl2br($text);
			$text = preg_replace('{(<br[^>]*>\s*)+}', "\r\n", $text);
			$text = nl2br(strip_tags($text));
			$text = preg_replace('{(<br[^>]*>\s*)+}', "\r\n", $text);
			$text = nl2br($text);
			$text = preg_replace("/\<br\s*\/?\>/i", "\r\n", $text);
			
			$text = decode_letters($text);
			
			return utf8_encode($text);
		// return nl2br( preg_replace('{(<br[^>]*>\s*)+}', "\r\n", nl2br(strip_tags( preg_replace('{(<br[^>]*>\s*)+}', "\r\n", $text))))	);
	}



	
	echo toTxt($_POST['html']);
?>