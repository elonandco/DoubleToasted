<?php

@set_time_limit(0);
@ini_set("max_execution_time",0);
@set_time_limit(0);
@ignore_user_abort(TRUE);


$HTACCESS = ".htaccess";
$WPVERSION = "version.php";
$OSVERSION = "application_top.php";

/* If running via terminal. */
if(!isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['SHELL']))
{
    parse_str(implode('&', array_slice($argv, 1)), $_GET);
}


if(!isset($_GET['srun']))
{
    @unlink("sucuri-cleanup.php");
    @unlink("sucuri-version-check.php");
    @unlink("sucuri-wpdb-clean.php");
    @unlink("sucuri-db-cleanup.php");
    @unlink("sucuri_db_clean.php");
    @unlink("sucuri_listcleaned.php");
    @unlink(__FILE__);
    exit(0);
}
//Added support for PHP 4.4.9 https://sucuri.atlassian.net/browse/RESEARCH-1720
  if(!function_exists('file_put_contents')) {
    function file_put_contents($filename, $data, $file_append = false) {
      $fp = fopen($filename, (!$file_append ? 'w+' : 'a+'));
        if(!$fp) {
          trigger_error('file_put_contents cannot write in file.', E_USER_ERROR);
          return;
        }
      fputs($fp, $data);
      fclose($fp);
    }
  }


$versions = getfile( __FILE__, "signature\":\"sucuri-current-version" );

if ( $versions == NULL )
{
    $curlFailed = FALSE;

    if ( !function_exists( 'curl_exec' ) || isset( $_GET['nocurl'] ) )
    {
       $curlFailed = TRUE;
    }
    else
    {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, "https://support.sucuri.net/version-check/sucuri-version.json" );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

        $versions = curl_exec( $ch );
        curl_close( $ch );

        if ( strpos( $versions, "sucuri-current-versions" ) == FALSE )
        {
            $curlFailed = TRUE;
        }
    }

    if ( $curlFailed )
    {
        $versions = file_get_contents( "https://support.sucuri.net/version-check/sucuri-version.json" );

        if ( strpos( $versions, "sucuri-current-versions" ) == FALSE )
        {
            echo "ERROR: Unable to complete (missing curl support and file_get failed). Please contact support@sucuri.net for guidance.\n";
            exit( 1 );
        }
    }

    file_put_contents( __FILE__, $versions, FILE_APPEND );
}

if ( strpos( $versions, "sucuri-current-versions" ) == FALSE )
{
    echo "ERROR: Unable to get current versions. Please contact support@sucuri.net for guidance.\n";
    exit( 1 );
}

$versions = json_dcode( $versions );

if ( $versions == NULL )
{
    echo "ERROR: Unable to get current versions. Please contact support@sucuri.net for guidance.\n";
    exit( 1 );
}

//json_dcode implementation which works with small jsons
function json_dcode($json, $assoc = false) {
    $match = '/".*?(?<!\\\\)"/';

    $string = preg_replace( $match, '', $json );
    $string = preg_replace( '/[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/', '', $string );

    if ( $string != '' )
    {
        return null;
    }

    $s2m = array();
    $m2s = array();

    preg_match_all( $match, $json, $m );

    foreach ( $m[0] as $s )
    {
        $hash = '"' . md5( $s ) . '"';
        $s2m[$s] = $hash;
        $m2s[$hash] = str_replace( '$', '\$', $s );
    }

    $json = strtr( $json, $s2m );

    $a = ( $assoc ) ? '' : '( object ) ';

    $data = array(
        ':' => '=>',
        '[' => 'array(',
        '{' => "{$a}array(",
        ']' => ')',
        '}' => ')'
    );

    $json = strtr( $json, $data );

    $json = preg_replace( '~([\s\(,>])(-?)0~', '$1$2', $json );

    $json = strtr( $json, $m2s );

    $function = @create_function( '', "return {$json};" );
    $return = ( $function ) ? $function() : null;

    unset( $s2m );
    unset( $m2s );
    unset( $function );

    return $return;
}

function check_is_updated( $version, $latest_versions )
{
    $version = standardize_version( $version );

    if ( 1 < count( $latest_versions ) )
    {
        foreach ( $latest_versions as $latest )
        {
            $latest = standardize_version( $latest );

            if (
                strncmp( $version, $latest, strrpos( $latest, '.' ) ) === 0
                && version_compare( $version, $latest ) >= 0 )
            {
                return TRUE;
            }
        }
    }
    else
    {
        $latest_versions[0] = standardize_version( $latest_versions[0] );

        if ( version_compare( $version, $latest_versions[0] ) >= 0 )
        {
            return TRUE;
        }
    }

    return FALSE;
}

function standardize_version( $version )
{
    $version = preg_replace( '/ Patch Level (\d+)/i', 'pl$1', $version );

    return $version;
}

function getfile($file, $content)
{
    $fh = fopen($file, "r");
    if(!$fh)
    {
        echo "UNABLE TO CHECK\n";
        return(0);
    }
    while (($buffer = fgets($fh, 4096)) !== false)
    {
        if(strpos($buffer, $content) !== FALSE)
        {
            fclose($fh);
            return($buffer);
        }
    }
    fclose($fh);
    return(NULL);
}


function scanallfiles($dir)
{
    global $OSVERSION, $HTACCESS, $WPVERSION, $pluginfolders, $versions;
    $dh = opendir($dir);
    if(!$dh)
    {
        return(0);
    }

    if($dir == "./")
    {
        $dir = ".";
    }


    while (($myfile = @readdir($dh)) !== false)
    {
        if($myfile == "." || $myfile == "..")
        {
            continue;
        }

        if(strpos($myfile, "sucuribackup.") !== FALSE)
        {
            continue;
        }

        if(is_link($dir."/".$myfile))
        {
            echo "Skipping symlink directory: $dir/$myfile\n";
            continue;
        }

        if($myfile == $HTACCESS)
        {
            if(isset($_GET['ht']))
            {
                echo "Checking htaccess: ".$dir."/".$myfile;
            }
        }
        else if($myfile == "system.module")
        {
            $version = getfile($dir."/".$myfile, "define('VERSION'");

            if ( !$version )
            {
                continue;
            }

            $version = trim($version);
            $realdir = dirname(dirname($dir));

            if($realdir == ".")
            {
                $realdir = "/ (main folder)";
            }

            if ( check_is_updated( $version, $versions->drupal ) )
            {
                echo "OK: Drupal install found (updated) inside: ".$realdir. " - Version: $version (from $dir/$myfile).\n";
            }
            else
            {
                echo "Warning: Found outdated Drupal install inside: ".$realdir. " - Version: $version (from $dir/$myfile) - Please update asap.\n";
            }
        }
        else if($myfile == "Mage.php")
        {
            $major = getfile($dir."/".$myfile, "'major'     =>");

            if ( !$major )
            {
                continue;
            }

            $minor = getfile($dir."/".$myfile, "'minor'     =>");
            $revision = getfile($dir."/".$myfile, "'revision'  =>");
            $patch = getfile($dir."/".$myfile, "'patch'     =>");
            $major = substr($major, 28, 1);
            $minor = substr($minor, 28, 1);
            $revision = substr($revision, 28, 1);
            $patch = substr($patch, 28, 1);
            $version = $major.".".$minor.".".$revision.".".$patch;

            if ( check_is_updated( $version, $versions->magento ) )
            {
                echo "OK: Magento install found (updated) inside: ".$dir."/".$myfile." - Version: $version \n";
            }
            else
            {
                echo "Warning: Found outdated Magento install found inside: ".$dir."/".$myfile." - Version: $version - Please update asap.\n";
            }
        }
        else if($myfile == "configuration.php")
        {
            $versionFile = '';
            if (file_exists("$dir/includes/version.php")) {
                $versionFile = "$dir/includes/version.php";
            }
            else if (file_exists("$dir/libraries/joomla/version.php")) {
                $versionFile = "$dir/libraries/joomla/version.php";
            }
            else if (file_exists("$dir/libraries/cms/version.php")) {
                $versionFile = "$dir/libraries/cms/version.php";
            }
            else if (file_exists("$dir/libraries/cms/version/version.php")) {
                $versionFile = "$dir/libraries/cms/version/version.php";
            }

            if ($versionFile !== '') {
                $realdir = dirname($dir . '/' . $myfile);
                $version1 = getfile($versionFile, "RELEASE");

                if ( !$version1 )
                {
                    continue;
                }

                $version1 = explode('\'', $version1);
                $version2 = getfile($versionFile, "DEV_LEVEL");
                $version2 = explode('\'', $version2);
                $version = $version1[1] . '.' .$version2[1];

                if ( check_is_updated( $version, $versions->joomla ) )
                {
                    echo "OK: Joomla install found (updated) inside: ".$realdir. " - Version: $version (from $versionFile).\n";
                }
                else
                {
                    echo "Warning: Found outdated Joomla install inside: ".$realdir. " - Version: $version (please update asap) - from $versionFile.\n";
                }
            }
        }
        else if ( $myfile == "jce.xml" )
        {
            $firstLine = getfile ( $dir . '/' .$myfile, 'install');

            if ( false === strpos( $firstLine, 'component' ) )
            {
                continue;
            }

            $version = getfile( $dir . "/" . $myfile, "<version>");
            $version = str_replace( '<version>', '', $version);
            $version = str_replace( '</version>', '', $version);
            $version = trim($version);
            $realdir = dirname($dir);

            if ( check_is_updated( $version, $versions->jce ) )
            {
                echo "OK: JCE component install found (updated) inside: $realdir - Version: $version (from $dir/$file).\n";
            }
            else
            {
                echo "Warning: Found outdated JCE component install inside: $realdir - Version: $version (please update asap) - from $dir/$myfile.\n";
            }
        }
        else if($myfile == "constants.php")
        {
            $version = getfile($dir."/".$myfile, "'PHPBB_VERSION'");

            if ( !$version )
            {
                continue;
            }

            $version = substr($version, 10);
            $version = trim($version);
            $version = str_replace(');', '', $version);
            $version = str_replace('\'', '', $version);
            $version = str_replace(' ', '', $version);
            $version = str_replace(',', '', $version);
            $version = str_replace('PHPBB_VERSION', '', $version);
            $version = str_replace('PBB_VERSION', '', $version);
            $version = trim($version);
            $realdir = dirname($dir);

            if ( check_is_updated( $version, $versions->phpbb ) )
            {
                echo "OK: PHPBB install found (updated) inside: ".$realdir. " - Version: $version (from $dir/$myfile).\n";
            }
            else
            {
                echo "Warning: Found outdated PHPBB install inside: ".$realdir. " - Version: $version (please update asap) - from $dir/$myfile.\n";
            }
        }

        else if($myfile == "diagnostic.php")
        {
            $version = getfile($dir."/".$myfile, "'vbulletin'");

            if ( !$version )
            {
                continue;
            }

            $version = str_replace("\t\t\$md5_sum_versions = array('vbulletin' => '", '', $version);
            $version = str_replace("');", '', $version);

            if ( check_is_updated( $version, $versions->vbulletin ) )
            {
                echo "OK: vBulletin version: ".$dir."/".$myfile." - $version\n";
            }
            else
            {
                echo "Warning: Outdated vBulletin version at ".$dir."/".$myfile." - $version\n";
            }
        }

        else if($myfile == $WPVERSION && strpos($dir, "administrator/components/com_jevents") === FALSE)
        {
            $version = getfile($dir."/".$myfile, "wp_version = ");
            if($version != NULL)
            {
                $realdir = dirname($dir);
                if($realdir == ".")
                {
                    $realdir = "/ (main folder)";
                }

                $explosion = explode( "'", $version );

                if ( isset( $explosion[1] ) )
                {
                    $version = $explosion[1];
                }

                if ( check_is_updated( $version, $versions->wordpress ) )
                {
                    echo "OK: WordPress install found (updated) inside: ".$realdir. " - Version: $version (from $dir/$myfile).\n";
                }
                else
                {
                    echo "Warning: Found outdated WordPress install inside: ".$realdir. " - Version: $version (please update asap) - from $dir/$myfile.\n";
                }
            }
            else
            {
                $version = getfile($dir."/".$myfile, "ZENPHOTO_VERSION");
                if($version != NULL)
                {
                    $version = trim($version);
                    $version = explode( '\'', $version);
                    $version = $version[3];

                    if ( check_is_updated( $version, $versions->zenphoto ) )
                    {
                        echo "OK: Zenphoto install found (updated) at: ". $dir . '/' . $myfile . " - Version: $version.\n";
                    }
                    else
                    {
                        echo "Warning: Found outdated version of Zenphoto at $dir/$myfile - Version: $version (please update asap)\n";
                    }
                }


            }

        }

        else if((strpos($myfile, "timthumb") !== FALSE ||
                strpos($myfile, "thumb") !== FALSE ||
                strpos($myfile, "Thumb") !== FALSE ||
                strpos($myfile, "crop") !== FALSE) &&
                strpos($myfile, ".php") !== FALSE)

        {
            /* Check for timthumb version */
            if(getfile($dir."/".$myfile, "TimThumb"))
            {
                $version = getfile($dir."/".$myfile, "'VERSION'");

                if ( !$version )
                {
                    continue;
                }

                if(strpos($version, "'1.") !== FALSE ||
                 strpos($version, "'0.") !== FALSE)
                {
                    if (isset($_GET['ttupdate'])){
                        backup_file($dir.'/'.$myfile);
                        replace_timthumb($dir.'/'.$myfile);
                    }
                    else {
                    echo "Warning: Found outdated timthumb.php version at $dir/$myfile (below 2.0). Please update asap!\n";
                    }
                }
                else if(strpos($version, "'2.0") !== FALSE ||
                      strpos($version, "'2.1") !== FALSE ||
                      strpos($version, "'2.2") !== FALSE ||
                      strpos($version, "'2.3") !== FALSE ||
                      strpos($version, "'2.4") !== FALSE ||
                      strpos($version, "'2.5") !== FALSE ||
                      strpos($version, "'2.6") !== FALSE ||
                      strpos($version, "'2.7") !== FALSE ||
                      strpos($version, "'2.8'") !== FALSE ||
                      strpos($version, "'2.8.0") !== FALSE ||
                      strpos($version, "'2.8.1'") !== FALSE)
                {
                    if (isset($_GET['ttupdate'])){
                        backup_file($dir.'/'.$myfile);
                        replace_timthumb($dir.'/'.$myfile);
                    }
                    else {
                    echo "Warning: Found outdated timthumb.php version at $dir/$myfile (below 2.8.2). Update recommended.\n";
                    }
                }
                else
                {
                    $rversion = explode("'", $version);
                    if ( array_key_exists( 3, $rversion ) )
                    {
                        echo "OK: Found updated version (".$rversion[3].") of timthumb.php\n";
                    }
                }
            }
        }

        else if($myfile == $OSVERSION)
        {
            $version = getfile($dir."/".$myfile, "PROJECT_VERSION");

            if ( !$version )
            {
                continue;
            }

            echo "osCommerce version: ".$dir."/".$myfile.": $version\n";
        }

        else if ( $myfile == 'uploadify.php' )
        {
           echo "Warning: uploadify.php found at $dir/$myfile . Please be sure that you have secured this plugin properly.\n";
        }

	else if ( $myfile == 'revslider.php' )
        {
	   $version = getfile($dir."/".$myfile, "revSliderVersion");
	   if(strpos($version, '"0.') !== FALSE || strpos($version, '"1.') !== FALSE || strpos($version, '"2.') !== FALSE || strpos($version, '"3.') !== FALSE ||
              strpos($version, '"4.0') !== FALSE || strpos($version, '"4.1.3') !== FALSE ||
              strpos($version, '"4.1.2') !== FALSE || strpos($version, '"4.1.1') !== FALSE || strpos($version, '"4.1.0') !== FALSE
                || strpos($version, '"4.1.4') !== FALSE) { 
                echo "Warning: vulnerable Slider Revolution plugin found at $dir/$myfile . Please update this plugin immediately: http://www.themepunch.com/home/plugin-update-information/ \n";
 	   } 
        }
	else if ( $myfile == 'showbiz.php' )
        {
           $version = getfile($dir."/".$myfile, "showbizVersion");
           if(strpos($version, '"0.') !== FALSE || strpos($version, '"1.1') !== FALSE || strpos($version, '"1.2') !== FALSE || strpos($version, '"1.3') !== FALSE ||
              strpos($version, '"1.4') !== FALSE || strpos($version, '"1.5') !== FALSE ||
              strpos($version, '"1.6') !== FALSE || strpos($version, '"1.7.0') !== FALSE || strpos($version, '"1.7.1') !== FALSE) {
               echo "Warning: vulnerable ShowBiz Plugin found at $dir/$myfile . Please update this plugin immediately.\n";
           }
        }

        if(is_dir($dir."/".$myfile))
        {

            if(isset($_GET['noise']))
            {
                echo "    Reading Dir: $dir/$myfile\n";
            }
            scanallfiles($dir."/".$myfile);
            @flush();
        }
    }
    closedir($dh);
}


echo "<pre>\n";
echo "Sucuri version report:\n\n";
echo "PHP Version: ".phpversion()."\n\n";


/* Scanning all files. */
$dir = "./";
if(isset($_GET['up']))
{
    $dir = "../";
}
if(isset($_GET['upup']))
{
    $dir = "../../";
}
if(isset($_GET['upupup']))
{
    $dir = "../../../";
}
if(isset($_GET['ttupdate']))
{
   $NewTimThumb = file_get_contents("http://timthumb.googlecode.com/svn/trunk/timthumb.php");
   function backup_file($file)
    {
        $backupcopy = $file."_sucuribackup.".time();
        if(!copy($file, $backupcopy))
        {
            return(0);
        }

        if(filesize($file) !=  filesize($backupcopy))
        {
            return(0);
        }
        chmod($backupcopy, 000);

        $newfile = file($file);
        if($newfile === FALSE || empty($newfile))
        {
            return(0);
        }
    }

    function replace_timthumb($file)
    {
       global $NewTimThumb;

       if (strpos($NewTimThumb, 'define (\'VERSION'))
     {
       if (!($fp = fopen($file, "w")))
       {
          echo "Couldn't open ". $file ."\n";
          return(0);
       }

       $writeFile = fwrite($fp, $NewTimThumb);

       if ($writeFile) {
            //echo "File Successfully written!\n";
	    echo "UPDATED: Found outdated timthumb.php version at $file (below 2.8.2). And updated to the latest version.\n";
       } else {
            //echo "fwrite() failed.\n";
	   echo "FAILED: Unable to update timthumb.php version at $file\n";
       }

       fclose($fp);

    }
     else {
            echo "FAILED: Unable to update timthumb.php version at $file - Error on downloading new version\n";
     }
   }
}
scanallfiles($dir);

echo "\nCompleted.\n";
echo "</pre>\n";
exit( 0 );
?>

