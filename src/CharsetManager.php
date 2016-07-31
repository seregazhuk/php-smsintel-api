<?php

namespace seregazhuk\SmsIntel;

class CharsetManager {

	/**
	 * @param $string
	 * @param int $pattern_size
	 * @return mixed|string
	 */
	public static function detect($string, $pattern_size = 50) {
		$first2 = substr($string, 0, 2);
		$first3 = substr($string, 0, 3);
		$first4 = substr($string, 0, 3);

		$UTF32_BIG_ENDIAN_BOM = chr(0x00) . chr(0x00) . chr(0xFE) . chr(0xFF);
		$UTF32_LITTLE_ENDIAN_BOM = chr(0xFF) . chr(0xFE) . chr(0x00) . chr(0x00);
		$UTF16_BIG_ENDIAN_BOM = chr(0xFE) . chr(0xFF);
		$UTF16_LITTLE_ENDIAN_BOM = chr(0xFF) . chr(0xFE);
		$UTF8_BOM = chr(0xEF) . chr(0xBB) . chr(0xBF);

		if ($first3 == $UTF8_BOM)
			return 'UTF-8';
		elseif ($first4 == $UTF32_BIG_ENDIAN_BOM)
			return 'UTF-32';
		elseif ($first4 == $UTF32_LITTLE_ENDIAN_BOM)
			return 'UTF-32';
		elseif ($first2 == $UTF16_BIG_ENDIAN_BOM)
			return 'UTF-16';
		elseif ($first2 == $UTF16_LITTLE_ENDIAN_BOM)
			return 'UTF-16';

		$list = array('CP1251', 'UTF-8', 'ASCII', '855', 'KOI8R', 'ISO-IR-111', 'CP866', 'KOI8U');
		$c = strlen($string);
		if ($c > $pattern_size) {
			$string = substr($string, floor(($c - $pattern_size) / 2), $pattern_size);
			$c = $pattern_size;
		}

		$reg1 = '/(\xE0|\xE5|\xE8|\xEE|\xF3|\xFB|\xFD|\xFE|\xFF)/i';
		$reg2 = '/(\xE1|\xE2|\xE3|\xE4|\xE6|\xE7|\xE9|\xEA|\xEB|\xEC|\xED|\xEF|\xF0|\xF1|\xF2|\xF4|\xF5|\xF6|\xF7|\xF8|\xF9|\xFA|\xFC)/i';

		$mk = 10000;
		$enc = 'UTF-8';
		foreach ($list as $item) {
			$sample1 = @iconv($item, 'cp1251', $string);
			$gl = @preg_match_all($reg1, $sample1, $arr);
			$sl = @preg_match_all($reg2, $sample1, $arr);
			if (!$gl || !$sl)
				continue;
			$k = abs(3 - ($sl / $gl));
			$k += $c - $gl - $sl;
			if ($k < $mk) {
				$enc = $item;
				$mk = $k;
			}
		}
		return $enc;
	}
}