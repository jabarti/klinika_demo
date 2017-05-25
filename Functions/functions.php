<?php

/****************************************************
 * Project:     Klinika_Local
 * Filename:    functions.php
 * Encoding:    UTF-8
 * Created:     2016-06-28
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
    function in_arrayi($needle, $haystack) {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
    
    function parse_date($date){
        $time = strtotime($date);
        $newformat = date('Y-m-d',$time);
        return $newformat;
    }

