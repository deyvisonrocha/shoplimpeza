<?php
class Common {
	public static function removeSpecialChars($string) {
		setlocale(LC_CTYPE, 'pt_BR.utf8');
		$string = strtolower($string);
		$string = strtr($string, ' ', '-');
		
		return iconv('UTF-8', 'ASCII//TRANSLIT', iconv('UTF-8', 'UTF-8//IGNORE', $string));
	}
}