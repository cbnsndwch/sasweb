<?php

function apk_info($APK)
{
    $SIZE = filesize($APK);
    $SDK = exec('aapt dump --values badging ' . $APK . ' | grep ^sdkVersion: | cut -d' . '"' . '\'' . '" -f2 | head -1');
    $ID = exec('aapt dump --values badging ' . $APK . ' | grep ^package: | cut -d' . '"' . '\'' . '" -f2 | head -1');
    $LABEL = exec('aapt dump --values badging ' . $APK . ' | grep application-label | cut -d: -f2 | head -1 ');
	$LABEL = substr($LABEL,1, strlen($LABEL)- 2);
    $VERSION = exec('aapt dump --values badging ' . $APK . ' | grep ^package: | cut -d' . '"' . '\'' . '" -f4 | head -1 ');
    $CODE = exec('aapt dump --values badging ' . $APK . ' | grep ^package: | cut -d' . '"' . '\'' . '" -f6 | head -1 ');
    $RES = exec('aapt dump --values badging ' . $APK . ' | grep ^application: | cut -d= -f3 | head -1');
	$RES = substr($RES,1, strlen($RES)- 2);
    return array('id' => $ID, 'label' => $LABEL, 'version' => $VERSION, 'code' => $CODE, 'sdk' => $SDK, 'size' => $SIZE, 'icon' => $RES);
}

function apk_icon($APK)
{
    $info = apk_info($APK);
    exec('unzip -p "' . $APK . '" ' . $info['icon'] . ' > icons/' . $info['id'] . '.png');
}

function db()
{
    try {
        $db = 'index.db';
        $PDO = new PDO('sqlite:' . $db);
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        echo 'Connexion impossible';
    }
    return $PDO;
}

function createdb()
{
    $info = apk_info('jaas.apk');
    $jaas_description = "Just another android store (Jaas) allows you to search and install apps. Just install it and test it.Enjoy !";
    $jass_category = "Tools";
    $db = db();
    $db->exec("create table apks (id TEXT UNIQUE PRIMARY KEY, label TEXT, version TEXT, code TEXT,description TEXT, category TEXT, sdkversion TEXT, size INT, downloads INT)");
    $q = $db->prepare('INSERT INTO apks (id,label,version,code,sdkversion,size,downloads,description,category) VALUES (:id,:label,:version,:code,:sdk,:size,\'0\',:description,:category)');
    $q->execute(array(':id' => $info['id'], ':label' => $info['label'], ':version' => $info['version'], ':code' => $info['code'], ':sdk' => $info['sdk'], ':size' => $info['size'], ':description' => $jaas_description, ':category' => $jass_category));
    $db = null;
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
        copy($APK, 'pool/' . $file['id'] . '.apk');
    }
}

function apk_exist($file)
{
    $info = apk_info($file);
    $db = db();
    $i = $db->query('SELECT COUNT(*) FROM apks WHERE id = \'' . $info['id'] . '\'')->fetchColumn();
    $version = $db->query('select version from apks where id is \'' . $info['id'] . '\'');
    $old = $version->fetch(\PDO::FETCH_ASSOC);
    $db = null;
    if ($i > 0) {
        $in_db = true;
        if ($old['version'] < $info['version']) {
            $in_db = 'update';
        }
    } else {
        $in_db = false;
    }

    if (file_exists('pool/' . $info['id'] . '.apk')) {
        if (filesize('pool/' . $info['id'] . '.apk') >= filesize($file)) {
            $in_pool = true;
        }
    } else {
        $in_pool = false;
    }

    return array('db' => $in_db, 'pool' => $in_pool);
}

function get_apks_to_update($db)
{
    $query = $db->query('SELECT * FROM apks WHERE (description == "" OR category == "" OR category == "Untrusted" ) /*ORDER BY label DESC*/');
    $total_records = $db->query('SELECT COUNT(*) FROM apks WHERE (description == "" OR category == "" OR category == "Untrusted" )')->fetchColumn();
    return array($query, $total_records);
}

function update_apk($id, $description, $category, $db)
{
    $query = "UPDATE apks SET description=:description, category=:category WHERE id=:id";
    $q = $db->prepare($query);
    $q->execute(array(':description' => $description, ':category' => $category, ':id' => $id));
}

function get_contenido($id)
{
    $url = 'https://play.google.com/store/apps/details?id=' . $id . '&hl=en';
    global $proxy;
    if (isset($proxy)) {
        $var = explode("@", $proxy);
        $auth = $var[0];
        $host = $var[1];
        $sLogin = base64_encode($auth);
        $aHTTP['http']['proxy'] = 'tcp://' . $host;
        $aHTTP['http']['request_fulluri'] = true;
        $aHTTP['http']['method'] = 'GET';
        $aHTTP['http']['header'] = "User-Agent: My PHP Script\r\n";
        $aHTTP['http']['header'] .= "Referer: http://play.google.com/\r\n";
        $aHTTP['http']['header'] .= "Proxy-Authorization: Basic $sLogin";
        $context = stream_context_create($aHTTP);
        $html = @file_get_contents($url, false, $context);
    } else {
        $html = @file_get_contents($url, false);
    }

    if ($html === FALSE) {
        $div_contenido[1][0] = 'This Aplication may cause damage to your device';
        $categoria[2][0] = 'Untrusted';
    } else {
        preg_match_all("/\<div\ id\=\"doc\-original\-text\" itemprop=\"description\"\>(.*?)\<\/div\>/", $html, $div_contenido);
        preg_match_all("/\<a href\=\"\/store\/apps\/category\/(.*?)\?feature\=category\-nav\"\>(.*?)\<\/a\>/", $html, $categoria);
    }

    return array('descripcion' => $div_contenido[1][0], 'categoria' => $categoria[2][0]);
}

function get_external_data($db)
{
    list ($apks, $total) = get_apks_to_update($db);
    echo $total . ": Aplicaciones para actualizar\n";
    while ($row = $apks->fetch(\PDO::FETCH_ASSOC)) {
        $var = get_contenido($row['id']);
        $descripcion = $var['descripcion'];
        $categoria = $var['categoria'];
        update_apk($row['id'], $descripcion, $categoria, $db);
        echo "Agregado: " . $row['label'] . " as $categoria\n";
    }
}

function update_from_pool()
{
    $db = db();
    $j = 0;
    $files = get_files('pool');
    foreach ($files as $file) {
        $info = apk_info($file);
        $exist = apk_exist($file);
        if (!$exist['db']) {
            $q = $db->prepare('INSERT INTO apks (id,label,version,code,sdkversion,size,downloads,description,category) VALUES (:id,:label,:version,:code,:sdk,:size,\'0\',:description,:category)');
            $q->execute(array(':id' => $info['id'], ':label' => $info['label'], ':version' => $info['version'], ':code' => $info['code'], ':sdk' => $info['sdk'], ':size' => $info['size'], ':description' => "", ':category' => ""));
        } else {
            if ($exist['db'] === 'update') {
                $q = $db->prepare('UPDATE apks SET label=:label,version=:version,code=:code,sdkversion=:sdk,size=:size,description=:description,category=:category WHERE id=:id');
                $q->execute(array(':id' => $info['id'], ':label' => $info['label'], ':version' => $info['version'], ':code' => $info['code'], ':sdk' => $info['sdk'], ':size' => $info['size'], ':description' => "", ':category' => ""));
                $j++;
            }
        }
    }
    get_external_data($db);
    list (, $total) = get_apks_to_update($db);
    $db = null;

    echo "$j: Aplicaciones Upgradeadas\n";

    if ($total > 0) {
        echo "$total: Aplicaiones sin actualizar o no confiables\n";
    }
}

function repo_clean(){
    $db=db();
    list ($apks, $total) = get_apks_to_update($db);
    echo $total . ": Aplicaciones para eliminar\n";
    while ($row = $apks->fetch(\PDO::FETCH_ASSOC)) {
        unlink('pool/'.$row['id'].'.apk');
        unlink('icons/'.$row['id'].'.png');
        $db->query('DELETE FROM apks WHERE id =\''.$row['id'].'\'');
        echo "Eliminado: " . $row['label']." \n";
    }
    $db=null;
}

function repo_gen($params)
{
    if (isset($params['dir'])) {
        createdb();
        if (!is_dir('pool')) {
            mkdir('pool', 0777);
        }
        if (!is_dir('icons')) {
            mkdir('icons', 0777);
        }
        copy_to_pool('jaas.apk');
        apk_icon('jaas.apk');

        $files = get_files($params['dir']);
        $i = 0;
        foreach ($files as $file) {
            $exist = apk_exist($file);
            if (!$exist['pool'] && (!$exist['db'] || ($exist['db'] == 'update'))) {
                copy_to_pool($file);
                apk_icon($file);
                $i++;
            }
        }
        echo "$i: Aplicaiones Agregadas\n";
        update_from_pool();
    }

    if (!isset($params['dir']) && $params['update']) {
        update_from_pool();
    }
}

function run($a)
{
    if (isset($a[1])) {
        $arg = $a;
        foreach ($arg as $key) {
            if (($key != 'repo_gen') && ($key != './repo_gen')) {
                $varg = explode("=", $key);
                switch ($varg[0]) {
                    case 'dir':
                        $dir = $varg[1];
                        break;
                    case 'proxy':
                        global $proxy;
                        $proxy = $varg[1];
                        break;
                    case 'update':
                        $update = true;
                        break;
                    case 'clean':
                        repo_clean();
                        break;
                    default:
                        echo "'$varg[0]': parametro erroneo\n";
                        break;
                }
            }
        }
        $param = array('dir' => $dir, 'update' => $update);
        @repo_gen($param);
    } else {
        echo "==========================================================================================\n";
        echo " HERRAMIENTA PARA CREAR REPOSITORIO DE APLICACIONNES DE ANDROID\n";
        echo " \n";
        echo " USO:\n";
        echo " Crea repositorio con las aplicaciones contenidas en 'dir':\n";
        echo "  ~$ repo_gen dir=<directorio de apks>\n";
        echo " Actualizar descripciones de las aplicaciones en el repositorio: \n";
        echo "  ~$ repo_gen update\n";
        echo " Limpia el repositorio de aplicaciones \"Untrusted\" sin confirmación:\n";
        echo "  ~$ repo_gen clean\n";
        echo " Uso a travez de Proxy: \n";
        echo "  ~$ repo_gen dir=<directorio de apks> proxy=<usuario>:<contraseña>@<servidor>:<puerto>\n";
        echo "  ~$ repo_gen update proxy=<usuario>:<contraseña>@<servidor>:<puerto>\n";
        echo " \n";
        echo " INFO:\n";
        echo "  1- Todas las carpetas y archivos generados deben ser colocadas en un servidor web.\n";
        echo "  2- Las Aplicaciones categoizadas como \"Untrusted\" no se encontraron en Google Play:\n" ;
        echo "     -> Trate de correr el script con 'update' más de una vez  \n";
        echo "        (usando la configuracion del proxy si es necesaio)\n";
        echo "     -> Si después de varios intentos aún quedan aplicaciones marcadas como \"Untrusted\" \n";
        echo "        ejecute 'repo_gen clean' para eliminarlas. \n";
        echo "     NOTA: Las aplicasiones marcadas como \"Untrusted\" pueden tener contenido indeseado, \n";
        echo "           o causar daños a los dispositivos\n";
        echo " \n";
        echo " REQUERIMIENTOS:\n";
        echo "  aapt        : Android Asset Packaging Tool.\n";
        echo "  php5-sqlite : Modulo de sqlite para PHP.\n";
        echo "  jaas.apk    : Aplicacion para acceder al repositorio utilizando dispositivos Android.\n";
        echo "==========================================================================================\n";
    }
}

@run($_SERVER['argv']);
