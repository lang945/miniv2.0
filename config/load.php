<?php

require_once 'config.php';

//依次加载
foreach($files as $value){
    require_once ''.$value.'';
    //echo "$value<br>";
}

