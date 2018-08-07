<?php

function try_catch_finally(callable $to_try, callable $to_catch=null, callable $and_finally=null)
{
	$result = null;
	try {
	    $result = $to_try();
    } catch (Exception $ex) {
	    if($to_catch) {
	        $result = $to_catch($ex);
	    }
    }
    if($and_finally) {
        $and_finally($result);
    }
	return $result;
}
