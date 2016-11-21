<?php 
/**
 * Custom Helper Class
 * @author Julio Vedovatto <juliovedovatto@gmail.com>
 *
 */

namespace app\components;

use Yii;

class Helper {
	
	const NULL_DATE = '0000-00-00',
		NULL_TIME = '00:00:00',
		NULL_DATETIME = '0000-00-00 00:00:00';
	
	public static function mysql2date($date, $format = 'm/d/Y H:i') {
		return date($format, strtotime($date));
	}
	
	
	/**
	 * Truncate string to a predefined length.
	 * @param string $str
	 * @param int $length
	 * @param number $rep (0|1) (0 truncate before finishing the word, 1 truncate after finishing the word) 
	 * @param string $append_dots
	 * @return string
	 */
	public static function str_truncate($str, $length, $rep = 0, $append_dots = true) {
		$new_length = $rep == 0 ? mb_strrpos(mb_substr($str,0,$length),' ') : mb_strpos(mb_substr($str,$length),' ') + $length;
	
		return mb_strlen($str) > $length ? mb_substr($str, 0, $new_length) . ($append_dots ? '...' : '') : $str;
	}
	
}