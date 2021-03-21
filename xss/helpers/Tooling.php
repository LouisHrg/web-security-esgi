<?php

function dd($variable){
    echo '<pre style="font-size:17px">';
    die(var_dump($variable));
    echo '</pre>';
}
