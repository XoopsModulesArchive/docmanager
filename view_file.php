<?php
// $Id: view_file.php,v 1.4 2005/03/14 20:05:43 jsaucier Exp $
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


// Include the module header
include 'header.php';

    
// Set the template
$xoopsOption['template_main'] = 'docmanager_viewfile.html';    
    

// Include Xoops header
require(XOOPS_ROOT_PATH.'/header.php');



// Set the CSS for the module
$xoops_module_header = "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".$docmanager_url."/templates/style.css\" />\n";




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




// Test if the file exist in the current dir, if we have the right to access it and if the folder is not hidden
if (if_file_is_in_dir($current_file, $current_dir) && have_access_right_to_folder($current_dir) && (is_not_hidden($current_dir) || $is_mod_admin)) {


    $sql = "SELECT files_id, files_name, files_type, files_space, files_createddate, files_modificationdate, files_owner, files_usermod, files_foldersid FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_id = ".$current_file;
    $result = $xoopsDB->query($sql);
    $myrow = $xoopsDB->fetchArray($result);
    $xoopsTpl->assign('docmanager_folder_id', $myrow['files_foldersid']);
    $xoopsTpl->assign('docmanager_file_id', $myrow['files_id']);
    $xoopsTpl->assign('docmanager_file_name', $myrow['files_name']);
    $xoopsTpl->assign('docmanager_file_type', $myrow['files_type']);
    $xoopsTpl->assign('docmanager_file_space', $myrow['files_space']);
    $xoopsTpl->assign('docmanager_file_createddate', formatTimestamp($myrow['files_createddate']));
    $xoopsTpl->assign('docmanager_file_modificationdate', formatTimestamp($myrow['files_modificationdate']));
    $xoopsTpl->assign('docmanager_file_owner', XoopsUser::getUnameFromId($myrow['files_owner']));
    $xoopsTpl->assign('docmanager_file_usermod', XoopsUser::getUnameFromId($myrow['files_usermod']));



    // Build the action bar
    $action_bar = "<a href='".$docmanager_url."/get_file.php?curent_file=".$myrow['files_id']."&amp;curent_dir=".$myrow['files_foldersid']."'>"._MD_VIEWFILE_GET."</a>";
    $action_bar .= "&nbsp;&nbsp;|&nbsp;&nbsp;";
    $action_bar .= "<a href='".$docmanager_url."/view_file.php?curent_file=".$myrow['files_id']."&amp;curent_dir=".$myrow['files_foldersid']."&amp;summary=1'>"._MD_SUMMARY_TITLE."</a>";
    $action_bar .= "&nbsp;&nbsp;|&nbsp;&nbsp;";    

    if (have_mod_right_to_file($myrow['files_foldersid'])) {
        $action_bar .= "<a href='".$docmanager_url."/maj_file.php?curent_file=".$myrow['files_id']."&amp;curent_dir=".$myrow['files_foldersid']."'>"._MD_VIEWFILE_MAJ."</a>";
        $action_bar .= "&nbsp;&nbsp;|&nbsp;&nbsp;";
        $action_bar .= "<a href='".$docmanager_url."/mod_file.php?curent_file=".$myrow['files_id']."&amp;curent_dir=".$myrow['files_foldersid']."'>"._MD_VIEWFILE_RENAME."</a>";
        $action_bar .= "&nbsp;&nbsp;|&nbsp;&nbsp;";        
    }

    if (have_erase_right_to_file($myrow['files_foldersid'])) {
        $action_bar .= "<a href='".$docmanager_url."/erase_file.php?curent_file=".$myrow['files_id']."&amp;curent_dir=".$myrow['files_foldersid']."'>"._MD_VIEWFILE_ERASE."</a>";
        $action_bar .= "&nbsp;&nbsp;|&nbsp;&nbsp;";
    }

    $action_bar = substr($action_bar, 0, strrpos($action_bar, "|"));
    
    $xoopsTpl->assign('docmanager_viewfile_action_bar', $action_bar);
    
    
    if ( isset($_GET['summary']) && $_GET['summary'] == 1 ) {
    
        // Select the config path
        $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
        $result = $xoopsDB->query($sql);
        $myconfig = $xoopsDB->fetchArray($result);    
        
        
        $current_file_path = get_file_name($current_file, 2);
        $current_dir_path = get_current_dir_path($current_dir);
        
        
        exec("php ".$myconfig['configs_path']."/tools/ots_script.php curent_file=".$current_dir_path.$current_file_path." file_type=".$myrow['files_type']." file_space=".$myrow['files_space']."", $ots_summary);
        
        $xoopsTpl->assign('docmanager_viewfile_summary', iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ots_summary[3])); // JEFF Check this if char is weird in summary
        $xoopsTpl->assign('docmanager_summary_title', _MD_SUMMARY_TITLE);
        
    }
    
    
    $error = 0;

}
else {
    // Display the error
    $xoopsTpl->assign('docmanager_error', _MD_FILE_ERROR_RIGHTS);
    $error = 1;
}



// Set langage options
$xoopsTpl->assign('docmanager_back_to_folder', _MD_VIEWFILE_BACKFOLDER);
$xoopsTpl->assign('docmanager_title', _MD_DOCMANAGER_VIEWFILE);
$xoopsTpl->assign('docmanager_lang_file_type', _MD_VIEWFILE_TYPE);
$xoopsTpl->assign('docmanager_lang_file_name', _MD_VIEWFILE_NAME);
$xoopsTpl->assign('docmanager_lang_file_space', _MD_VIEWFILE_SPACE);
$xoopsTpl->assign('docmanager_lang_file_createddate', _MD_VIEWFILE_CREATEDDATE);
$xoopsTpl->assign('docmanager_lang_file_moddate', _MD_VIEWFILE_MODDATE);
$xoopsTpl->assign('docmanager_lang_file_owner', _MD_VIEWFILE_OWNER);
$xoopsTpl->assign('docmanager_lang_file_usermod', _MD_VIEWFILE_USERMOD);
$xoopsTpl->assign('docmanager_viewfile_action', _MD_VIEWFILE_ACTION);


// Set other options
$xoopsTpl->assign('docmanager_main_title', _MD_DOCMANAGER_MAIN_TITLE);
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
$xoopsTpl->assign('docmanager_url', $docmanager_url);


// Include Xoops footer
include 'footer.php';

?>
