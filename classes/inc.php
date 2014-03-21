<?php


    error_reporting(E_ALL);
    ini_set("display_errors", 1);

$files = glob($_SERVER["DOCUMENT_ROOT"]."/clicker/classes/*.php");
//die(var_dump(__FILE__));
foreach($files as $file){
//    echo "$file | ".__FILE__." <br />\n";
    if($file !== __FILE__){
        require_once "$file";
    }
}