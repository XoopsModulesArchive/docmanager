<?php
// $Id: ots_script.php,v 1.7 2005/04/26 13:14:35 jsaucier Exp $
//  ------------------------------------------------------------------------ //
//                           Document Manager                                //
//            Copyright (c) 2004 Informatique Strategique IS                 //
//                  <http://www.infostrategique.com/>                        //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //


define("_CANNOT_SEARCH", "Cannot do summary for this type of file.");
define("_CANNOT_DO_SUMMARY", "Cannot do summary for this file.");

define("_OTS_PATH", "/usr/bin/ots");
define("_OTS_PARAMS", "-d fr");

define("_CAT_PATH", "/bin/cat");
define("_CAT_PARAMS", "");

define("_PDFTOTEXT_PATH", "/usr/bin/pdftotext");
define("_PDFTOTEXT_PARAMS", "-enc UTF-8");

define("_PS2ASCII_PATH", "/usr/bin/ps2ascii");
define("_PS2ASCII_PARAMS", "");

define("_LINKS_PATH", "/usr/bin/links");
define("_LINKS_PARAMS", "-force-html -dump");

define("_CATDOC_PATH", "/usr/bin/catdoc");
define("_CATDOC_PARAMS", "-w -s 8859-1");

define("_PPTHTML_PATH", "/usr/bin/ppthtml");
define("_PPTHTML_PARAMS", "");

define("_FILTER_SCRIPT", "/usr/bin/sentence_filter.pl");
define("_FILTER_PARAMS", "");


$_GET['file_space'] = (int) $_GET['file_space'];
$_GET['file_type'] = addslashes($_GET['file_type']);
$_GET['curent_file'] = escapeshellcmd($_GET['curent_file']);
$_GET['curent_file'] = str_replace('\*', '*', $_GET['curent_file']);


// Try to set up a good ratio for the summary
if ( $_GET['file_space'] >= 0 && $_GET['file_space'] < 50 ) {
    define("_OTS_RATIO", "-r 25");
}
elseif ( $_GET['file_space'] >= 50 && $_GET['file_space'] <= 500 ) {
    define("_OTS_RATIO", "-r 15");
}
elseif ( $_GET['file_space'] >= 500 && $_GET['file_space'] <= 1000 ) {
    define("_OTS_RATIO", "-r 10");
}
elseif ( $_GET['file_space'] >= 1000 ) {
    define("_OTS_RATIO", "-r 5");
}




$popen = false;


switch ($_GET['file_type']) {

    case "doc.png":
        $ots_handle = popen(_CATDOC_PATH." "._CATDOC_PARAMS." ".$_GET['curent_file']." | "._FILTER_SCRIPT." "._FILTER_PARAMS." | "._OTS_PATH." "._OTS_RATIO." "._OTS_PARAMS."", "r");
        $popen = true;
        break;
        
    case "gif.png":
        $popen = false;
        break;
    
    case "html.png":
        $ots_handle = popen(_LINKS_PATH." "._LINKS_PARAMS." ".$_GET['curent_file']." | "._FILTER_SCRIPT." "._FILTER_PARAMS." | "._OTS_PATH." "._OTS_RATIO." "._OTS_PARAMS."", "r");
        $popen = true;
        break;
        
    case "js.png":
        $popen = false;
        break;
        
    case "mdb.png":
        $popen = false;
        break;
        
    case "pdf.png":
        $ots_handle = popen(_PDFTOTEXT_PATH." "._PDFTOTEXT_PARAMS." ".$_GET['curent_file']." - | "._FILTER_SCRIPT." "._FILTER_PARAMS." | "._OTS_PATH." "._OTS_RATIO." "._OTS_PARAMS."", "r");
        $popen = true;
        break;
        
    case "ppt.png":
        $ots_handle = popen(_PPTHTML_PATH." "._PPTHTML_PARAMS." ".$_GET['curent_file']." | "._FILTER_SCRIPT." "._FILTER_PARAMS." | "._OTS_PATH." "._OTS_RATIO." "._OTS_PARAMS."", "r");
        $popen = true;
        break;
        
    case "ps.png":
        $ots_handle = popen(_PS2ASCII_PATH." "._PS2ASCII_PARAMS." ".$_GET['curent_file']." | "._FILTER_SCRIPT." "._FILTER_PARAMS." | "._OTS_PATH." "._OTS_RATIO." "._OTS_PARAMS."", "r");
        $popen = true;    
        break;
        
    case "swf.png":
        $popen = false;
        break;
        
    case "txt.png":
        $ots_handle = popen(_CAT_PATH." "._CAT_PARAMS." ".$_GET['curent_file']." | "._FILTER_SCRIPT." "._FILTER_PARAMS." | "._OTS_PATH." "._OTS_RATIO." "._OTS_PARAMS."", "r");
        $popen = true;
        break;            
        
    case "wav.png":
        $popen = false;
        break;
        
    case "xls.png":
        $popen = false;
        break;            
        
    case "xml.png":
        $popen = false;
        break;
        
    case "zip.png":
        $popen = false;
        break;  

    default:
        $popen = false;
}



if ( $popen ) {
    $ots_summary = "";
    while ($line = @fgets($ots_handle, 4096))
        $ots_summary .= $line;
    
    pclose($ots_handle);
    
    if ( trim($ots_summary) == "" ) {
        $ots_summary = _CANNOT_DO_SUMMARY;
    }
}
else {
    $ots_summary = _CANNOT_SEARCH;
}

echo $ots_summary;

?>
