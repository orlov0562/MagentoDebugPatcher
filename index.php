<?php

// add this function to the top of the index.php

if (file_exists('orlov-debug.log')) unlink('orlov-debug.log');
function orlovDebug($filepath, $method)
{
    return;

    $trace = debug_backtrace();
    $traceLine = '';
    for ($i=1; $i<count($trace); $i++)
    {
       if ($traceLine) $traceLine.=' > ';
       if (isset($trace[$i]['class'])) $traceLine.=$trace[$i]['class'].'::';
       if (isset($trace[$i]['function'])) $traceLine.=$trace[$i]['function'];
    }

    $msg = str_repeat(' ', count($trace))
           .$method
           .' FROM '
           .$filepath
           .' TRACE '
           .$traceLine
           .'|'.date('H:i:s')
           .PHP_EOL
    ;

    file_put_contents('orlov-debug.log', $msg, FILE_APPEND);

}

// ...
// default index.php source
// ...