<?php
/**
 * Mad TTS - PHP Google TTS API without keys
 * PHP Version 5.5.
 *
 * @see	NULL
 *
 * @author    Marcial Paul Gargoles (Da Leecher/Mad Developer) <im.codename@gmail.com>
 * @copyright 2018 - Marcial Paul G.
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */
class MadTTS {
	private static $base_url = 'https://translate.google.com/translate_tts';
	// language ISO 639-1
	public static $supported_languages = ["id","en","hi","ar","zh-CN","zh-TW","zh","fr","ja","tr","pt","ru","es","de","ko","iw","pa","gu","bn","mr","vi","th","pl","ta","te","ka","ml","af","da","is","nl","no","sv","bg","cs","el","ro","sk","it","fi","hu","hr","sq","kn","et","lt","lv","uk","fa","bs","mk","sl","sr","si","lo","am","km","my","az","hy","kk","ky","uz","ny","rw","sn","st","sw","xh","zu","ku","ne","ps","sd","ur","ceb","jw","ms","mn","su","tl","ca","co","eu","gl","mt","mi","haw","sm","yo","ig","ha","be","fy","ht","lb","mg","yi","hmn","so","tg","tk","tt","ug","cy","eo","ga","gd","la","or"];
	private static $default_lang = 'en'; // english
	public static function setDefaultLang($d){
		self::$default_lang = $d;
	}
	public static function isSupportedLang($lg){
		return in_array($lg, self::$supported_languages);
	}
	public static function say($text, $lang = null){
		if(200 < strlen($text)) {
			$text = 'limit your characters to less than 200. this API is powered by Leetshares dot com and Google Text-to-Speach.';
			$lang = 'en';
		}
		$lang = $lang===null ? self::$default_lang : $lang;
		if(!self::isSupportedLang($lang)) {
			$text = 'unsupported language.';
			$lang = 'en';
		}
		$c = curl_init();
		curl_setopt_array($c, [
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_FAILONERROR => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36',
			CURLOPT_URL => self::$base_url.'?'.http_build_query([
				'ie' => 'UTF-8',
				'q' => $text,
				'tl' => $lang,
				'textlen' => strlen($text),
				'client' => 'tw-ob'
			])
		]);
		$d = curl_exec($c);
		curl_close($c);
		return $d;
	}
	public static function sayMp3($text, $lang = null) {
		header('Content-Type: audio/mpeg');
		die(self::say($text, $lang));
	}
}
