<?php

    set_time_limit(900);

    function get_files($dir, $level=0)
    {
        foreach(glob(rtrim($dir,'/').'/*') as $file)
        {
            echo str_repeat('|&nbsp;&nbsp;', $level);
            echo '-'.$file.'<br>';

            if (substr($file,-4)=='.php')
            {
                $fileData = file_get_contents($file);
                $regexp = '~(?:public|private|protected)\s*function([^(]+)\([^)]*\)\s*{~Usix';
                if (preg_match_all($regexp, $fileData, $regs))
                {
                    for($i=0; $i<count($regs[0]); $i++)
                    {
                        echo str_repeat('|&nbsp;&nbsp;', $level+3);
                        $methodName = trim($regs[1][$i]);
                        echo '<small style="color:blue;">+'.$methodName.'</small><br>';
                        $fileData = str_replace(
                            $regs[0][$i],
                            $regs[0][$i].PHP_EOL."orlovDebug('".$file."','".$methodName."');",
                            $fileData
                        );
                    }
                }
                file_put_contents($file, $fileData);
            }

            if ($file!='.' AND $file!='..' AND is_dir($file))
            {
                get_files($file, $level+1);
            }
        }
    }

    get_files('app/code');