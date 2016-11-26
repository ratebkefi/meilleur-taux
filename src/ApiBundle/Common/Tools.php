<?php

namespace ApiBundle\Common;

class Tools
{
    public static function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    public static function random_color() {
        return self::random_color_part() . self::random_color_part() . self::random_color_part();
    }
    public static function simularColor($color){

        $tab['red']=hexdec (substr($color,0,2));
        $tab['green']=hexdec (substr($color,2,2));
        $tab['blue']=hexdec (substr($color,4,2));
        asort($tab);
        $tab=array_reverse($tab);

        $i=0;
        $newtab=array();
        foreach($tab as $key=>$value){
            if($i==0){
                $newtab[$key]=$value-50;
            }else{
                $newtab[$key]=$value;
            }
            ++$i;
        }
        $newtab["red"]=str_pad( dechex( $newtab["red"] ), 2, '0', STR_PAD_LEFT);
        $newtab["green"]=str_pad( dechex( $newtab["green"] ), 2, '0', STR_PAD_LEFT);
        $newtab["blue"]=str_pad( dechex( $newtab["blue"] ), 2, '0', STR_PAD_LEFT);
        //self::dump($newtab,true);
        return $newtab['red'].$newtab['green'].$newtab['blue'];
    }
    public static function recupereMinMaxDelai($listeDelai,&$minDelai,&$maxDelai)
    {
        $minDelai = 24;
        $maxDelai = 0;
        for($count=0;$count<count($listeDelai);$count++)
        {
            if($listeDelai[$count] < $minDelai)
            {
                $minDelai = $listeDelai[$count];
            }
            if($listeDelai[$count] > $maxDelai)
            {
                $maxDelai = $listeDelai[$count];
            }
        }
    }

    public static function  toStamp2($date) {

        $d = explode('-', $date);
        $date2 = mktime(0,0,0, $d[1], $d[2], $d[0]);
        return $date2;
    }
    public static function date_diff_par_jour($date1, $date2) {
        $s = strtotime($date2)-strtotime($date1);
        $d = intval($s/86400);
        return $d;
    }
// compte le nombre de jours entre deux dates SQL aaaa-mm-jj
    public static function date_diff2($date1, $date2) {
        $s = strtotime($date2)-strtotime($date1);
        $d = intval($s/86400)+1;
        return $d;
    }
    public static function trimspace($str)
    {
        return $text = str_replace(' ', '', $str);
    }

    public static function getDay($date)
    {
        $date = strtotime($date);
        $date = date("l", $date);
        return self::traduireJourFREN($date);
    }

    public static function traduireJourFREN($Jour)
    {
        if ($Jour == "Monday") {
            return "Lundi";
        } elseif ($Jour == "Tuesday") {
            return "Mardi";

        } elseif ($Jour == "Wednesday") {
            return "Mercredi";

        } elseif ($Jour == "Thursday") {
            return "Jeudi";

        } elseif ($Jour == "Friday") {
            return "Vendredi";

        } elseif ($Jour == "Saturday") {
            return "Samedi";

        } elseif ($Jour == "Sunday") {
            return "Dimanche";

        }
    }

    public static function dropNull($array)
    {
        if (count($array) > 0) {
            foreach ($array as $key => $value) {
                if ($value == "") {
                    unset($array[$key]);
                } else {
                    $array[$key] = trim($value);
                }
            }
            return $array;
        } else {
            return array();
        }

    }

    public static function generatecodeCoupon($dealid, $orderItemId, $qte)
    {
        $name = $dealid;
        $name .= $orderItemId;
        $name .= $qte + 1;
        // get random number
        $length = 5;
        $characters = '0123456789';
        $string = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[rand(0, 9)];
        }
        //$name.="-".$string;
        $name .= $string;
        return $name;
    }

    public static function randomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789@{}[]()+-*c";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    public static function encrypt($data)
    {
        $key = "secret";  // Clé de 8 caractères max
        $data = serialize($data);
        $td = mcrypt_module_open(MCRYPT_DES, "", MCRYPT_MODE_ECB, "");
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = base64_encode(mcrypt_generic($td, '!' . $data));
        mcrypt_generic_deinit($td);
        return $data;
    }

    public static function decrypt($data)
    {
        $key = "secret";
        $td = mcrypt_module_open(MCRYPT_DES, "", MCRYPT_MODE_ECB, "");
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mdecrypt_generic($td, base64_decode($data));
        mcrypt_generic_deinit($td);

        if (substr($data, 0, 1) != '!')
            return false;

        $data = substr($data, 1, strlen($data) - 1);
        return unserialize($data);
    }

    public static function string2url($string)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $string);
        // trim
        $text = trim($text, '-');
        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
        /*$separator = '-';
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array( '&' => 'et');
        $string = mb_strtolower( trim( $string ), 'UTF-8' );
        $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
        $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;*/

    }

    public static function dump($data, $tst = FALSE)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($tst)
            exit;
    }

    public static function reformatDate($str)
    {
        $date = explode("/", $str);
        $dt = new \DateTime();
        $dt->setDate($date[2], $date[1], $date[0]);
        return $dt;
    }

    public static function reformatDateTime($time)
    {
        $tab = explode(' ', $time);
        $heur = explode(':', $tab[1]);
        $date = explode("/", $tab[0]);
        $dt = new \DateTime();
        $dt->setDate($date[2], $date[1], $date[0]);
        $dt->setTime($heur[0], $heur[1]);
        return $dt;
    }

    public static function reformatTime($time)
    {
        $tab = explode(":", $time);
        if (strlen($tab[0]) == 1) {
            $tab[0] = "0" . $tab[0];
        }
        $dt = new \DateTime();
        $dt->setTime($tab[0], $tab[1]);
        return $dt;
    }

}
