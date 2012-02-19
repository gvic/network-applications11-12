<?php

/**
 * @return array
 * @param array $src
 * @param array $in
 * @param int|string $pos
 */
function array_push_before($src, $in, $pos) {
    if (is_int($pos))
        $R = array_merge(array_slice($src, 0, $pos), $in, array_slice($src, $pos));
    else {
        foreach ($src as $k => $v) {
            if ($k == $pos)
                $R = array_merge($R, $in);
            $R[$k] = $v;
        }
    }return $R;
}

/**
 * @return array
 * @param array $src
 * @param array $in
 * @param int|string $pos
 */
function array_push_after($src, $in, $pos) {
    if (is_int($pos))
        $R = array_merge(array_slice($src, 0, $pos + 1), $in, array_slice($src, $pos + 1));
    else {
        foreach ($src as $k => $v) {
            $R[$k] = $v;
            if ($k == $pos)
                $R = array_merge($R, $in);
        }
    }return $R;
}

function array_to_html_list($arr) {
    $output = "<ul>";
    foreach ($arr as $key => $value) {
        $output .= "<li>$value</li>";
    }
    $output .= "</ul>";
    return $output;
}

function print_a(array $ar) {
    echo "<pre>";
    print_r($ar);
    echo "</pre>";
}

function flat_array(array $array, $separator) {
    $n = count($array);
    $i = 0;
    $out = "";
    for ($i = 0; $i < $n; $i++) {
        $out .= $array[$i];
        if ($i < $n - 1)
            $out .= $separator;
    }
    return $out;
}

function slugify($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-_]/', '-', $str);
    $str = preg_replace('/-+/', "_", $str);
    return $str;
}

function slug_to_readable($str) {
    return ucfirst(str_replace("_", " ", $str));
}

/**
 * word-sensitive substring function with html tags awareness 
 * @author benny@bennyborn.de (http://php.net/manual/en/function.substr.php)
 * @param text The text to cut 
 * @param len The maximum length of the cut string 
 * @returns string 
 * */
function substrws($text, $len = 180) {

    if ((strlen($text) > $len)) {

        $whitespaceposition = strpos($text, " ", $len) - 1;

        if ($whitespaceposition > 0)
            $text = substr($text, 0, ($whitespaceposition + 1));

        // close unclosed html tags 
        if (preg_match_all("|<([a-zA-Z]+)>|", $text, $aBuffer)) {

            if (!empty($aBuffer[1])) {

                preg_match_all("|</([a-zA-Z]+)>|", $text, $aBuffer2);

                if (count($aBuffer[1]) != count($aBuffer2[1])) {

                    foreach ($aBuffer[1] as $index => $tag) {

                        if (empty($aBuffer2[1][$index]) || $aBuffer2[1][$index] != $tag)
                            $text .= '</' . $tag . '>';
                    }
                }
            }
        }
    }

    return $text;
}

function is_multi($a) {
    $rv = array_filter($a, 'is_array');
    if (count($rv) > 0)
        return true;
    return false;
}

/**
 * @param type $stringVariableName
 * @return string
 */
function caseSwitchToSpaces($stringVariableName) {
    $pattern = '/([A-Z])/';
    $replacement = ' ${1}';
    return preg_replace($pattern, $replacement, $stringVariableName);
}

