<?php
// $Id: index.php,v 1.5 2005/03/14 20:05:43 jsaucier Exp $
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
$xoopsOption['template_main'] = 'docmanager_index.html';


// Include Xoops header
require(XOOPS_ROOT_PATH.'/header.php');



// Set the CSS for the module
$xoops_module_header = "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".$docmanager_url."/templates/style.css\" />\n";




// Build the navigation bar //

// Select the current_dir that we are in
if (!empty($_GET['curent_dir'])) {
    $current_dir = (int) $_GET['curent_dir'];
}
else {
    $current_dir = 1;
}



// Test if we have the right to access this folder
if (if_folder_exist($current_dir) && have_access_right_to_folder($current_dir) && (is_not_hidden($current_dir) || $is_mod_admin)) {


    // Loop to find the current folders and all the parent folders
    
    $i = 0;
    
    $parent_dir = $current_dir;
    
    while ($parent_dir != 0) {
        $sql = "SELECT folders_id, folders_name, folders_hidden, folders_parent_id FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_id = ".$parent_dir;
        $result = $xoopsDB->query($sql);
        $list_folder[$i] = $xoopsDB->fetchArray($result);
        $parent_dir = $list_folder[$i]['folders_parent_id'];
        $i++;
    }
    
    $i--;
    
    
    // Build the navigation bar with the folder array
    
    $j = $i;
    
    $first = true;
    
    while ($j >= 0) {
    
        // If it's the first folder, take the constant name
        if ($first == true) {
            $list_folder[$j]['folders_name'] = constant($list_folder[$j]['folders_name']);
            $first = false;
        }
        
        $xoopsTpl->append('docmanager_navigation_bar_id', $list_folder[$j]['folders_id']);


        // If it's an hidden folder, put hidden next to the name (must be an admin)
        if ( is_not_hidden($list_folder[$j]['folders_id']) == false ) {
            $xoopsTpl->append('docmanager_navigation_bar_name', $list_folder[$j]['folders_name']."&nbsp;&nbsp;("._MD_FOLDER_HIDDEN.")");
        }
        else {
            $xoopsTpl->append('docmanager_navigation_bar_name', $list_folder[$j]['folders_name']);
        }
        
        $j--;
    }
    
    
    
    
    $action_bar = "";
    
    // Build the action bar //
    if (have_create_right_for_folder($list_folder[0]['folders_id'])) {
        $action_bar .= "<a href='".$docmanager_url."/create_folder.php?curent_dir=".$list_folder[0]['folders_id']."'>"._MD_FOLDER_CREATE."</a>";
        $action_bar .= "&nbsp;&nbsp;|&nbsp;&nbsp;";
    }
    
    if (have_mod_right_to_folder($list_folder[0]['folders_id'])) {
        $action_bar .= "<a href='".$docmanager_url."/mod_folder.php?curent_dir=".$list_folder[0]['folders_id']."'>"._MD_FOLDER_MOD."</a>";
        $action_bar .= "&nbsp;&nbsp;|&nbsp;&nbsp;";
    }

    if (have_erase_right_to_folder($list_folder[0]['folders_id'])) {
        $action_bar .= "<a href='".$docmanager_url."/erase_folder.php?curent_dir=".$list_folder[0]['folders_id']."'>"._MD_FOLDER_ERASE."</a>";
        $action_bar .= "&nbsp;&nbsp;|&nbsp;&nbsp;";
    }
    
    if (have_create_right_for_file($list_folder[0]['folders_id'])) {
        $action_bar .= "<a href='".$docmanager_url."/create_file.php?curent_dir=".$list_folder[0]['folders_id']."'>"._MD_FILE_CREATE."</a>";
        $action_bar .= "&nbsp;&nbsp;|&nbsp;&nbsp;";
    }
    
    
    $action_bar = substr($action_bar, 0, strrpos($action_bar, "|"));
    
    
    
    
    // Build the folders list //
    
    $sql = "SELECT folders_id, folders_name, folders_hidden, folders_parent_id FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_parent_id = ".$list_folder[0]['folders_id']." ORDER BY folders_name";
    $result = $xoopsDB->query($sql);
    
    while ($myrow = $xoopsDB->fetchArray($result)) {
    
        if (have_access_right_to_folder($myrow['folders_id']) && (is_not_hidden($myrow['folders_id']) || $is_mod_admin)) {
        
            $xoopsTpl->append('docmanager_folderlist_id', $myrow['folders_id']);
            
            
            // If it's an hidden folder, put hidden next to the name (must be an admin)
            if ( is_not_hidden($myrow['folders_id']) == false ) {
                $xoopsTpl->append('docmanager_folderlist_name', $myrow['folders_name']."&nbsp;&nbsp;("._MD_FOLDER_HIDDEN.")");
            }
            else {
                $xoopsTpl->append('docmanager_folderlist_name', $myrow['folders_name']);
            }
            
            if (have_erase_right_to_folder($myrow['folders_id'])) {
                $xoopsTpl->append('docmanager_folderlist_erase', 1);
            }
            
            if (have_mod_right_to_folder($myrow['folders_id'])) {
                $xoopsTpl->append('docmanager_folderlist_mod', 1);
            }
            
        }
    }
    
    
    
    
    
    // Build the documents list //
    
    $sql = "SELECT files_id, files_name, files_type, files_space, files_modificationdate, files_foldersid FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_foldersid = ".$list_folder[0]['folders_id']." ORDER BY files_name";
    $result = $xoopsDB->query($sql);
    
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $xoopsTpl->append('docmanager_filelist_id', $myrow['files_id']);
        $xoopsTpl->append('docmanager_filelist_name', $myrow['files_name']);
        $xoopsTpl->append('docmanager_filelist_icon', $myrow['files_type']);
        $xoopsTpl->append('docmanager_filelist_space', $myrow['files_space'] ." Ko");
        $xoopsTpl->append('docmanager_filelist_date', formatTimestamp($myrow['files_modificationdate'],"s"));
        
        // Check if we can erase
        if (have_erase_right_to_file($myrow['files_foldersid'])) {
            $xoopsTpl->append('docmanager_filelist_erase', 1);
        }
    }
    
    $error = 0;
}
else {
    // Display the error
    $xoopsTpl->assign('docmanager_error', _MD_FOLDER_ERROR_RIGHTS);
    $error = 1;
}



// Set the current folder
$xoopsTpl->assign('docmanager_current_folder', $list_folder[0]['folders_id']);
$xoopsTpl->assign('docmanager_current_folder_name', $list_folder[0]['folders_name']);


// Set the navigation bar
$xoopsTpl->assign('docmanager_navigation_bar_title', _MD_NAVIGATION_TITLE);

// Set the possible action
$xoopsTpl->assign('docmanager_action_bar_title', _MD_ACTION_TITLE);
$xoopsTpl->assign('docmanager_action_bar', $action_bar);

// Set the list of folders
$xoopsTpl->assign('docmanager_folder_title', _MD_FOLDER_TITLE);
$xoopsTpl->assign('docmanager_folder_name', _MD_FOLDER_NAME);
$xoopsTpl->assign('docmanager_folder_mod', _MD_FOLDER_MOD2);
$xoopsTpl->assign('docmanager_folder_delete', _MD_FOLDER_DELETE);

// Set the list of documents
$xoopsTpl->assign('docmanager_document_title', _MD_DOCUMENT_TITLE);
$xoopsTpl->assign('docmanager_file_name', _MD_FILE_NAME);
$xoopsTpl->assign('docmanager_file_date', _MD_FILE_DATE);
$xoopsTpl->assign('docmanager_file_space', _MD_FILE_SPACE);
$xoopsTpl->assign('docmanager_file_summary', _MD_FILE_SUMMARY);
$xoopsTpl->assign('docmanager_file_delete', _MD_FILE_DELETE);


// If admin, set the permissions bars
if ($is_mod_admin && $error == 0) {
    $show_rights_bar = 1;
}
else {
    $show_rights_bar = 0;
}

$xoopsTpl->assign('docmanager_admin_title', _MD_ADMIN_TITLE);
$xoopsTpl->assign('docmanager_admin', $show_rights_bar);
$xoopsTpl->assign('docmanager_rights_title', _MD_RIGHTS_TITLE);
$xoopsTpl->assign('docmanager_folderid', $list_folder[0]['folders_id']);



// Set other options
$xoopsTpl->assign('docmanager_main_title', _MD_DOCMANAGER_MAIN_TITLE);
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
$xoopsTpl->assign('docmanager_url', $docmanager_url);


// Include Xoops footer
include 'footer.php';

?>
