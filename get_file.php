<?php
// $Id: get_file.php,v 1.9 2005/03/14 20:05:43 jsaucier Exp $
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


// Include the Xoops mainfile
include '../../mainfile.php';


// Set the URL for the module
$docmanager_url = XOOPS_URL."/modules/docmanager";


// Include own function
require_once XOOPS_ROOT_PATH."/modules/docmanager/include/functions.php";



// Check if the user as admin right to the module
if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
        $is_mod_admin = true;
} else {
        $is_mod_admin = false;
}




// Select the current_file
if (!empty($_GET['curent_file'])) {
    $current_file = (int) $_GET['curent_file'];
}
else {
    $current_file = 0;
}



// Select the current_dir that we are in
if (!empty($_GET['curent_dir'])) {
    $current_dir = (int) $_GET['curent_dir'];
}
else {
    $current_dir = 0;
}




// Test if the file exist in the current dir, if we have the right to access it
if (if_file_is_in_dir($current_file, $current_dir) && have_access_right_to_folder($current_dir)) {


    $sql = "SELECT files_id, files_name, files_foldersid FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_id = ".$current_file;
    $result = $xoopsDB->query($sql);
    $myrow = $xoopsDB->fetchArray($result);


    // Select the config path
    $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
    $result = $xoopsDB->query($sql);
    $myconfig = $xoopsDB->fetchArray($result);
    
    
    // IE 5 and 5.5 cannot download from streaming attachment, must be empty
    $attachment = (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 5")) ? "" : "attachment; ";
    
    $file_path = get_current_dir_path($myrow['files_foldersid']).get_file_name($myrow['files_id'],2);
    
    
    if ($file_path !== "/" && strpos($file_path, $myconfig['configs_path']) !== false && strpos($file_path, "..") !== true && strpos($file_path, " ") !== true && file_exists($file_path) === true && is_readable($file_path) === true) {
    
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
            
            // Another sh*ty IE fix to replace dot with %2e in filename (affect all MSIE)
            $myrow['files_name'] = preg_replace('/\./', '%2e', $myrow['files_name'], substr_count($myrow['files_name'], '.') - 1);
            
            // IE cannot download from sessions without a cache
            header('Cache-Control: ');
            header('Pragma: ');
        }
        else {
            header('Cache-Control: no-cache, must-revalidate');
            header('Pragma: no-cache');
        }    
        
        header("Content-Type: application/force-download");
        header('Content-Disposition: '.$attachment.'filename="'.$myrow['files_name'].'"');
        header('Content-Description: "'.$myrow['files_name'].'"');
        header("Content-Length: ".filesize($file_path));
        header("Connection: close");
        
        
        $fn = fopen($file_path, "rb");
        fpassthru($fn);
    }
    else {
        echo _MD_FILE_ERROR_RIGHTS;
        echo "<br /><br />";
        echo _MD_GO_BACK;
    }
}
else {
    // Display the error
    echo _MD_FILE_ERROR_RIGHTS;
    echo "<br /><br />";
    echo _MD_GO_BACK;
}

?>
