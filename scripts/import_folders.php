<?php
// $Id: import_folders.php,v 1.4 2005/03/14 20:05:43 jsaucier Exp $
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


// Include Xoops mainfile for the settings and variables
require '../mainfile.php';
require '../modules/docmanager/include/functions.php';



// Set here the path that you want to import
$path_to_import = "/var/www/import";


$return_value = true;
$myts =& MyTextSanitizer::getInstance();



echo "Start Import<br>";


// Start the import
import_folders($path_to_import, 1);


if ( $return_value == true ) {
    echo "Import went good<br>";
}
else {
    echo "Error in import<br>";
}

echo "End";




/* Function that loop the current folder and all sub files and folders on the disk
   It insert the folder and the file in the docmanager
 */
function import_folders($path_to_import, $parent_id_import) {
    
    global $xoopsDB, $return_value;
    
    
    $handle = opendir($path_to_import);
      
    
    // Loop the folder to see if there are files or folders
    while (false !== ($FolderOrFile = readdir($handle)) && $return_value == true) {
        
        if ($FolderOrFile != "." && $FolderOrFile != "..") { 
            
            if (is_dir($path_to_import . "/" . $FolderOrFile)) {
                
                // Recursive loop to import this folder
                $new_parent_id_import = insert_folder($FolderOrFile, $parent_id_import);

                if ( $new_parent_id_import == 0 ) {
                    $return_value = false;
                }
                else {
                    import_folders($path_to_import . "/" . $FolderOrFile, $new_parent_id_import);
                }
            }
            else {
                // Insert this file
                $new_file_id_import = insert_file($path_to_import . "/" . $FolderOrFile, $FolderOrFile, $parent_id_import);

                if ( $new_file_id_import == 0 ) {
                    $return_value = false;
                }
            }
        } 
    }
  
    closedir($handle);
    
}




// Function to insert a folder in the current parent dir
function insert_folder($the_folder, $parent_folder_id) {
    
    global $xoopsDB, $xoopsUser, $myts;
    
    $insert_folder = false;
    $return = 0;
    
    
    $folder_name = $myts->addSlashes(iconv("ISO-8859-1//TRANSLIT", "ISO-8859-1//TRANSLIT", $the_folder)); // JEFF Check here if you get weird folder name
        
    $parent_id = (int) $parent_folder_id;
    $hidden = 0;
    $inherit_rights = 1;
    $owner = $xoopsUser->uid();
    $create_date = time();
        
        
    // Select the config path
    $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
    $result = $xoopsDB->query($sql);
    $myconfig = $xoopsDB->fetchArray($result);

        
    $current_dir = get_current_dir_path($parent_id);
    
    if ( is_writable($current_dir) && if_folder_exist($parent_id) ) {
        
        do {
        
            $folder_nameondisk = ereg_replace('[0-9]', null, md5(time())).rand();
            $dir_to_create = get_current_dir_path($parent_id).$folder_nameondisk;
            
            if ( !file_exists($dir_to_create) ) {
            
                $sql = sprintf("INSERT INTO %s (folders_id, folders_name, folders_nameondisk, folders_createddate, folders_modificationdate, folders_inheritrights, folders_hidden, folders_owner, folders_usermod, folders_parent_id) VALUES (%u, '%s', '%s', %u, %u, %u, %u, %u, %u, %u)", $xoopsDB->prefix("docmanager_folders"), '', $folder_name, $folder_nameondisk, $create_date, $create_date, $inherit_rights, $hidden, $owner, $owner, $parent_id);

                // Insert the dir and redirect to the docmanager center
                if ($dir_to_create !== "/" && strpos($dir_to_create, $myconfig['configs_path']) !== false && strpos($dir_to_create, "..") !== true && strpos($dir_to_create, " ") !== true) {
                    
                    if ($result = $xoopsDB->queryF($sql)) {
                        
                        $new_dir = $xoopsDB->getInsertId();                
                        
                        // Create the folder
                        mkdir($dir_to_create, 0755);
                        
                        $return = $new_dir;
                        $insert_folder = true;
                    }
                    else {
                        $return = 0;
                        $insert_folder = true;
                    }
                }
                else {
                    $return = 0;
                    $insert_folder = true;
                }
            }
        } while ($insert_folder == false);
    }
    else {
        $return = 0;
    }
    
    return $return;
}



// Function to insert a file in the current parent dir
function insert_file($file_path, $filename, $parent_folder_id) {
    
    global $xoopsDB, $xoopsUser, $myts;
    
    $return = 0;
    $insert_file = false;
    
    $file_name = $myts->addSlashes(iconv("ISO-8859-1//TRANSLIT", "ISO-8859-1//TRANSLIT", $filename)); // JEFF Check here if you get weird file name    
    $extension = strtolower(strrchr($file_name, "."));
    
    $parent_id = (int) $parent_folder_id;
    $owner = $xoopsUser->uid();
    $create_date = time();
    $file_type = check_file_type($file_name);
    $file_space = ceil((filesize($file_path) / 1000));
    
    
    // Select the config path
    $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
    $result = $xoopsDB->query($sql);
    $myconfig = $xoopsDB->fetchArray($result);        


    $current_dir = get_current_dir_path($parent_id);
        
    if ( is_writable($current_dir) && if_folder_exist($parent_id) ) {
            
        do {
            
            $file_nameondisk = ereg_replace('[0-9]', null, md5(time())).rand().$extension;
            $where_to_put_file = get_current_dir_path($parent_id).$file_nameondisk;
    
            if ( !file_exists($where_to_put_file) ) {
            
                $sql = sprintf("INSERT INTO %s (files_id, files_name, files_nameondisk, files_type, files_space, files_createddate, files_modificationdate, files_owner, files_usermod, files_foldersid) VALUES (%u, '%s', '%s', '%s', %u, %u, %u, %u, %u, %u)", $xoopsDB->prefix("docmanager_files"), '', $file_name, $file_nameondisk, $file_type, $file_space, $create_date, $create_date, $owner, $owner, $parent_id);
    
    
                // Insert the file and redirect to the docmanager center
                if ($where_to_put_file !== "/" && strpos($where_to_put_file, $myconfig['configs_path']) !== false && strpos($where_to_put_file, "..") !== true && strpos($where_to_put_file, " ") !== true) {
                    
                    if ($result = $xoopsDB->queryF($sql)) {
                    
                        $new_file = $xoopsDB->getInsertId();
                        
                        // Copy the file
                        copy($file_path, $where_to_put_file);
                        
                        $return = $new_file;
                        $insert_file = true;
                        
                    }
                    else {
                        $return = 0;
                        $insert_file = true;
                    }
                }
                else {
                    $return = 0;
                    $insert_file = true;
                }
            }
        } while ($insert_file == false);
    }
    else {
        $return = 0;
    }
    
    return $return;
}

?>
