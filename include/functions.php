<?php
// $Id: functions.php,v 1.3 2005/03/14 20:05:43 jsaucier Exp $
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


/* Function to check the rights
 * Take a folder id and a rights type as parameter
 * Return true if the user have the right, false if not
 */
function check_right($folder_id, $perm_id) {

    global $xoopsUser, $xoopsModule;
    
    
    // Set value
    $return_value = false;
    
    $perm_name = $folder_id;
    $perm_itemid = $perm_id;
    $module_id = $xoopsModule->getVar('mid');
    
    
    // Take the group
    if ($xoopsUser) {
        $groups = $xoopsUser->getGroups();
    }
    else {
        $groups = XOOPS_GROUP_ANONYMOUS;
    }
    
    $gperm_handler =& xoops_gethandler('groupperm');
    
    
    // Check the right and return the value
    if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
        $return_value = true;
    } else {
        $return_value = false;
    }
    
    return $return_value;
}



/* Function to check the rights for read access to folder
 * Take a folder id as parameter
 * Return true if the user have the right, false if not
 */
function have_access_right_to_folder($folder_id) {

    $return_value = false;
    
    
    $folder_id = found_inherit_rights_parent($folder_id);
    
    if (check_right($folder_id, 7)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function to check the rights for create access to folder
 * Take a folder id as parameter
 * Return true if the user have the right, false if not
 */
function have_create_right_for_folder($folder_id) {

    $return_value = false;
    
    
    $folder_id = found_inherit_rights_parent($folder_id);
    
    if (check_right($folder_id, 1)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function to check the rights for modification to folder
 * Take a folder id as parameter
 * Return true if the user have the right, false if not
 */
function have_mod_right_to_folder($folder_id) {

    $return_value = false;
    
    
    $folder_id = found_inherit_rights_parent($folder_id);
    
    if (check_right($folder_id, 2)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function to check the rights for erase access to folder
 * Take a folder id as parameter
 * Return true if the user have the right, false if not
 */
function have_erase_right_to_folder($folder_id) {

    $return_value = false;
    
    
    $folder_id = found_inherit_rights_parent($folder_id);
    
    if (check_right($folder_id, 3)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function to check the rights for create access to file
 * Take a folder id as parameter
 * Return true if the user have the right, false if not
 */
function have_create_right_for_file($folder_id) {
  
    $return_value = false;
    
    
    $folder_id = found_inherit_rights_parent($folder_id);
    
    if (check_right($folder_id, 4)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function to check the rights for modify access to file
 * Take a folder id as parameter
 * Return true if the user have the right, false if not
 */
function have_mod_right_to_file($folder_id) {

    $return_value = false;
    
    
    $folder_id = found_inherit_rights_parent($folder_id);
    
    if (check_right($folder_id, 5)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function to check the rights for erase access to file
 * Take a folder id as parameter
 * Return true if the user have the right, false if not
 */
function have_erase_right_to_file($folder_id) {

    $return_value = false;
    
    
    $folder_id = found_inherit_rights_parent($folder_id);
    
    if (check_right($folder_id, 6)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function that check if the folder is hidden
 * return true if the folder is not hidden
 * return false if the folder is hidden
 */
function is_not_hidden($folder_id) {

    global $xoopsDB, $is_mod_admin;
    
    $return_value = false;
    
    
    $folder_id = found_inherit_rights_parent($folder_id);
    
    $sql = "SELECT folders_hidden FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_id = ".$folder_id;
    $result = $xoopsDB->query($sql);
    $myrow = $xoopsDB->fetchArray($result);
    
    if ($myrow['folders_hidden'] == 0) {
        $return_value = true;
    }


    return $return_value;
    
}


/* Function that check if the folder exist
 * return true if the folder exist
 * return false if the folder dont exist
 */
function if_folder_exist($folder_id) {
    
    global $xoopsDB;
    
    $return_value = false;
    
    
    // Select the folder
    $sql = "SELECT folders_id FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_id = ".$folder_id;
    $result = $xoopsDB->query($sql);
    $current_folder = $xoopsDB->fetchArray($result);



    // Test if the current folder exist
    if (!empty($current_folder)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function that check if the file exist
 * return true if the file exist
 * return false if the file dont exist
 */
function if_file_exist($file_id) {
    
    global $xoopsDB;
    
    $return_value = false;
    
    
    // Select the file
    $sql = "SELECT files_id FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_id = ".$file_id;
    $result = $xoopsDB->query($sql);
    $current_file = $xoopsDB->fetchArray($result);



    // Test if the current file exist
    if (!empty($current_file)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function that check if the file exist in the specified folder
 * return true if the file exist in the specified folder
 * return false if the file is not in the specified folder
 */
function if_file_is_in_dir($file_id, $folder_id) {
    
    global $xoopsDB;
    
    $return_value = false;
    
    
    // Select the file
    $sql = "SELECT files_id, files_foldersid FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_id = ".$file_id." AND files_foldersid = ".$folder_id;
    $result = $xoopsDB->query($sql);
    $current_file = $xoopsDB->fetchArray($result);
    


    // Test if the current file exist in the specified folder
    if (!empty($current_file)) {
        $return_value = true;
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function that check if the folder inherit rights from a parent
 * If yes, return the parent that set the rights
 * Else, return the current dir
 */
function found_inherit_rights_parent($folder_id) {

    global $xoopsDB;
    
    $found_parent = false;
    
    
    // Loop while we dont have any parent folder left
    while ($found_parent == false) {
        $sql = "SELECT folders_id, folders_inheritrights, folders_parent_id FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_id = ".$folder_id;
        $result = $xoopsDB->query($sql);
        $myrow = $xoopsDB->fetchArray($result);
        
        
        if ($myrow['folders_inheritrights'] == 1) {
            $folder_id = $myrow['folders_parent_id'];
            $found_parent = false;
        }
        else {
            $folder_id = $myrow['folders_id'];
            $found_parent = true;
        }
    }
    
    return $folder_id;
}


/* Function that return the path to the folder
 */
function get_current_dir_path($folder_id) {

    global $xoopsDB;
    
    $parent_dir = (int) $folder_id;
    $i = 0;
    
    // Select the config path
    $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
    $result = $xoopsDB->query($sql);
    $myconfig = $xoopsDB->fetchArray($result);
    
    $path_to_dir = $myconfig['configs_path'] . "/";
    
    
    // Loop to find all the path
    while ($parent_dir != 0) {
        $sql = "SELECT folders_id, folders_nameondisk, folders_parent_id FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_id = ".$parent_dir;
        $result = $xoopsDB->query($sql);
        $current_dir[$i] = $xoopsDB->fetchArray($result);
        $parent_dir = $current_dir[$i]['folders_parent_id'];
        $i++;
    }
    

    $j = $i - 1;
    
    
    // Do the inverse loop to build the path on the right direction
    while ($j >= 0) {
        
        $path_to_dir .= $current_dir[$j]['folders_nameondisk']."/";
        
        $j--;
    }
    
    
    return $path_to_dir;
}


/* Function that delete the current folder and all sub files and folders on the disk
 * return true if all goes well
 * return false if there is an error
 */
function delete_current_dir_on_disk($folder_path) {
    
    global $xoopsDB;
    
    $return_value = false;
    
    
    // Select the config path
    $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
    $result = $xoopsDB->query($sql);
    $myconfig = $xoopsDB->fetchArray($result);
    
    
    
    // Make some check to see if it's not too dangerous to erase something
    if ($folder_path === "/" || strpos($folder_path, $myconfig['configs_path']) === false || strpos($folder_path, "..") === true || strpos($folder_path, " ") === true) {
        $return_value = false;
    }
    else {
    
        $handle = opendir($folder_path);
      
      
        // Loop the folder to see if there are files or folders
        while (false !== ($FolderOrFile = readdir($handle))) {
        
            if ($FolderOrFile !== "." && $FolderOrFile !== "..") { 
            
                if (is_dir($folder_path . "/" . $FolderOrFile)) {
                    // Recursive loop to clean that folder
                    delete_current_dir_on_disk($folder_path . "/" . $FolderOrFile);
                }
                else {
                    // Delete the file
                    unlink($folder_path . "/" . $FolderOrFile);
                }
            } 
        }
      
        closedir($handle);
        
        
        // If nothing remains, erase the folder
        if (rmdir($folder_path)) {
            $return_value = true;
        }
    }
    
    return $return_value;
}


/* Function that delete the current folder and all sub files and folder on BD
 * return true if all goes well
 * return false if there is an error
 */
function delete_current_dir_on_bd($folder_id) {

    global $xoopsDB;
    
    $folder_id = (int) $folder_id;
    $return_value = true;
    

    // Delete all the file for the folders
    $sql = sprintf("DELETE FROM %s WHERE files_foldersid = %u", $xoopsDB->prefix("docmanager_files"), $folder_id);
    $result = $xoopsDB->query($sql);
        
    // Select all the sub folder
    $sql = "SELECT folders_id, folders_parent_id FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_parent_id = ".$folder_id;
    $result = $xoopsDB->query($sql);
    
    
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $return_value = delete_current_dir_on_bd($myrow['folders_id']);
    }
    
    
    
    // Delete the folder
    $sql = sprintf("DELETE FROM %s WHERE folders_id = %u", $xoopsDB->prefix("docmanager_folders"), $folder_id);
    $result = $xoopsDB->query($sql);
    
    
    return $return_value;
}


/* Function to check if the user have all the erase right on all the sub files and folders
 * return true if the user have all the rights
 * return false if the user miss some rights
 */
function check_have_all_erase_right($folder_id) {

    global $xoopsDB;
    
    
    $return_value = true;
    
    
    // Check for the current dir if we have the right to delete the folder
    if ( have_access_right_to_folder($folder_id) && have_erase_right_to_folder($folder_id) ) {
        
        
        // Select all the file for the folders
        $sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_foldersid = ".$folder_id;
        $result = $xoopsDB->query($sql);
        list($count_file) = $xoopsDB->fetchRow($result);
        
        if ( $count_file > 0 && have_erase_right_to_file($folder_id) == false ) {
            $return_value = false;
        }
        
        
        // Select all the sub folder to check their rights
        $sql = "SELECT folders_id, folders_parent_id FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_parent_id = ".$folder_id;
        $result = $xoopsDB->query($sql);
        
        while ($return_value == true && $myrow = $xoopsDB->fetchArray($result)) {
            $return_value = check_have_all_erase_right($myrow['folders_id']);
        }
    }
    else {
        $return_value = false;
    }
    
    return $return_value;
    
}


/* Function to return the name of the file
 * If the second parameter is 1, return the name of the file
 * If the second parameter is 2, return the name on disk for file
 */
function get_file_name($file_id, $type) {

    global $xoopsDB;
    
    
    $return_value = "";
    
    // Select the file
    $sql = "SELECT files_id, files_name, files_nameondisk FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_id = ".$file_id;
    $result = $xoopsDB->query($sql);
    $current_file = $xoopsDB->fetchArray($result);

    if ( $type == 1 ) {
        $return_value = $current_file['files_name'];
    }
    else {
        $return_value = $current_file['files_nameondisk'];
    }
    
    
    return $return_value;
    
}


/* Function to check the file type of a file
 * return the file type (the icon to be use)
 */
function check_file_type($file_name) {

    $extension = strtolower(strrchr($file_name, "."));
    $return_value = "";
    
    
    switch ($extension) {
    
        case ".doc":
            $return_value = "doc.png";
            break;
            
        case ".gif":
        case ".jpg":
        case ".jpeg":
        case ".png":
        case ".bmp":
            $return_value = "gif.png";
            break;
        
        case ".html":
        case ".htm":
        case ".shtml":
            $return_value = "html.png";
            break;
            
        case ".js":
        case ".php":
        case ".asp":
        case ".c":
        case ".cpp":
        case ".pl";
        case ".py";
            $return_value = "js.png";
            break;
            
        case ".mdb":
            $return_value = "mdb.png";
            break;
            
        case ".pdf":
            $return_value = "pdf.png";
            break;
            
        case ".ppt":
            $return_value = "ppt.png";
            break;
            
        case ".ps":
            $return_value = "ps.png";
            break;
            
        case ".swf":
            $return_value = "swf.png";
            break;
            
        case ".txt":
            $return_value = "txt.png";
            break;            
            
        case ".wav":
        case ".mp3":
        case ".wma":
        case ".ogg":
            $return_value = "wav.png";
            break;
            
        case ".xls":
            $return_value = "xls.png";
            break;            
            
        case ".xml":
            $return_value = "xml.png";
            break;
            
        case ".zip":
            $return_value = "zip.png";
            break;  

        default:
            $return_value = "def.png";
    }
    
    
    return $return_value;
}

?>
