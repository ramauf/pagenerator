<?php
/**
 * Created by PhpStorm.
 * User: ramauf
 * Date: 27.09.2016
 * Time: 21:24
 */
namespace App\Http\Models;
class Functions 
{
    public static function getMonths($type = 1){
        if ($type == 1) return [
            '1' => 'Январь',
            '2' => 'Февраль',
            '3' => 'Март',
            '4' => 'Апрель',
            '5' => 'Май',
            '6' => 'Июнь',
            '7' => 'Июль',
            '8' => 'Август',
            '9' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь'
        ];
        if ($type == 2) return [
            '1' => 'Января',
            '2' => 'Февраля',
            '3' => 'Марта',
            '4' => 'Апреля',
            '5' => 'Мая',
            '6' => 'Июня',
            '7' => 'Июля',
            '8' => 'Августа',
            '9' => 'Сентября',
            '10' => 'Октября',
            '11' => 'Ноября',
            '12' => 'Декабря'
        ];
    }
    public static function sendPost($url, $flags = null)
    {
        $flags['ref'] = isset($flags['ref']) ? $flags['ref'] : '';
        $flags = [
            'postdata' => @$flags['postdata'],
            'ref' => @$flags['ref'],
            'return_headers' => @$flags['return_headers'],
            'return_only_cookies' => @$flags['return_only_cookies'],
            'timeout' => @$flags['timeout'],
            'cookie_file' => @$flags['cookie_file']
        ];

        $s = curl_init();
        curl_setopt($s, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($s, CURLOPT_URL, $url);
        if (isset($flags['cookie_file'])){
            curl_setopt($s, CURLOPT_COOKIEJAR, $flags['cookie_file']);
            curl_setopt($s, CURLOPT_COOKIEFILE, $flags['cookie_file']);
        }
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($s, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($s, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($s, CURLOPT_HEADER, $flags['return_headers'] || $flags['return_only_cookies']);
        curl_setopt($s, CURLOPT_USERAGENT, '');

        if ($flags['timeout']) {
            curl_setopt($s, CURLOPT_CONNECTTIMEOUT, $flags['timeout']);
        }

        if ($flags['postdata']) {
            curl_setopt($s, CURLOPT_POST, true);
            curl_setopt($s, CURLOPT_POSTFIELDS, http_build_query($flags['postdata']));
        }
        if ($flags['ref']) {
            curl_setopt($s, CURLOPT_REFERER, $flags['ref']);
        }

        /*$cookie = $this->cookie;
        $cookie .= $this->additional_cookie;
        curl_setopt($s, CURLOPT_COOKIE, $cookie);*/

        $res = curl_exec($s);
        curl_close($s);

        /*if ($flags['return_only_cookies']) {
            $res = self::parseCookie($res, true);
        }*/

        return $res;
    }

    private function parseCookie($string, $into_array = false)
    {
        preg_match_all("/Set-Cookie: (.*?)=(.*?);/i", $string, $res);
        $cookie = null;
        if (count($res) > 0) {
            foreach ($res[1] as $key => $value) {
                if (!$into_array) {
                    $cookie .= $value . '=' . $res[2][$key] . '; ';
                    if (strstr($value, 'steamMachineAuth')) {
                        file_put_contents($this->bot_cookie_file, $value . '=' . $res[2][$key] . ';');
                    }
                } else {
                    $cookie[$value] = $res[2][$key];
                }
            }
        }

        return $cookie;
    }
}