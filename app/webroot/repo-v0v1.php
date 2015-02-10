<?php

function apk_info($APK)
{
    $SIZE = filesize($APK);
    $SDK = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^sdkVersion: | soft\\cut -d' . '"' . '\'' . '" -f2 | soft\\head -1');
    $ID = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^package: | soft\\cut -d' . '"' . '\'' . '" -f2 | soft\\head -1');
    $LABEL = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep application-label | soft\\cut -d: -f2 | soft\\head -1 ');
    $LABEL = substr($LABEL,1, strlen($LABEL)- 2);
    $VERSION = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^package: | soft\\cut -d' . '"' . '\'' . '" -f4 | soft\\head -1 ');
    $CODE = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^package: | soft\\cut -d' . '"' . '\'' . '" -f6 | soft\\head -1 ');
    $RES = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^application: | soft\\cut -d= -f3 | soft\\head -1');
    $RES = substr($RES,1, strlen($RES)- 2);
    return array('id' => $ID, 'label' => $LABEL, 'version' => $VERSION, 'code' => $CODE, 'sdk' => $SDK, 'size' => $SIZE, 'icon' => $RES);
}

function apk_icon($APK)
{
    $file = apk_info($APK);
//    exec('unzip -p "' . $APK . '" ' . $info['icon'] . ' > iconslaunchers/' . $info['id'] . '.png');
    $path = 'pool\\' . $file['id'] . '\\';// . $file['code'] . '\\';// . $file['id'] . '.apk';
    if (!is_dir($path)) {
        mkdir($path, 0777);
    }
    $path .=  $file['code'] . '\\';
    if (!is_dir($path)) {
        mkdir($path, 0777);
    }
    $path .= $file['id'] . '.png';
    exec('unzip -p "' . $APK . '" ' . $file['icon'] . ' > ' . $path);
}


function is_apk($filename)
{
    return (substr(strrchr($filename, '.'), 1) == 'apk') ? true : false;
}

function get_files($path)
{
    global $files;
    if (is_dir($path)) {
        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != "..") {
                    if ((!is_dir("$path/$file")) && (is_apk("$path/$file"))) {
                        $files[] = "$path/$file";
                    } else {
                        get_files("$path/$file");
                    }
                }
            }
            closedir($dh);
        }
    }
    return $files;
}

function copy_to_pool($APK)
{
    if (is_apk($APK)) {
        $file = apk_info($APK);
        $path = 'pool\\' . $file['id'] . '\\';// . $file['code'] . '\\';// . $file['id'] . '.apk';

        if (!is_dir($path)) {
            mkdir($path, 0777);
        }
        $path .=  $file['code'] . '\\';
        if (!is_dir($path)) {
            mkdir($path, 0777);
        }
        $path .= $file['id'] . '.apk';
        echo "Copiada " . $path ." \n";
        copy($APK, $path);
    }
}

function repo_update()
{
        if (!is_dir('pool')) {
            mkdir('pool', 0777);
        }
        $files = get_files('pool_old');
        $i = 0;
        foreach ($files as $file) {            
			copy_to_pool($file);
			apk_icon($file);
			$i++;
        }
        echo "$i: Aplicaiones Agregadas\n";
        //update_from_pool();
    

    //if (!isset($params['dir']) && $params['update']) {
    //    update_from_pool();
    //}
}

function run($a)
{
    if (isset($a[1])) {        
        @repo_update();
    } else {
        echo "==========================================================================================\n";
        echo " HERRAMIENTA PARA HACER UDDATE DE LA ESTRUCTURA DE FICHEROS DE LA VERSION 0 A LA VERSION 1\n";
        echo " \n";
        echo " USO:\n";
        echo " Crea repositorio con la estructura correcta de un dir llamado pool_old a un dir llamado pool\n";
    }
}

@run($_SERVER['argv']);
