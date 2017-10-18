<?php 
function dd($str)
{
 	echo '<pre>';
    // print_r($str);
	var_dump(debug_backtrace());
    echo '</pre>';
    die;
}