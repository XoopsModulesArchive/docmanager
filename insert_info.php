<?php
// $Id: insert_info.php,v 1.5 2005/03/14 20:05:43 jsaucier Exp $
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


// Include Xoops header
require(XOOPS_ROOT_PATH.'/header.php');


$myts =& MyTextSanitizer::getInstance();



// Function to insert a folder in the current parent dir
function insert_folder() {
    
    global $xoopsDB, $xoopsUser, $myts;
    
    $insert_folder = false;
    
    
    // Check if we have a folder name
    if (!empty($_POST['folder_name'])) {
    
        $folder_name = $myts->addSlashes($_POST['folder_name']);
        
        $parent_id = (int) $_POST['folder_id'];
        $hidden = 0;
        $inherit_rights = 1;
        $owner = $xoopsUser->uid();
        $create_date = time();
        
        
        // Select the config path
        $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
        $result = $xoopsDB->query($sql);
        $myconfig = $xoopsDB->fetchArray($result);


        // Get current dir path
        $current_dir = get_current_dir_path($parent_id);
        
        if ( is_writable($current_dir) && if_folder_exist($parent_id) ) {
            
            do {
            
                $folder_nameondisk = ereg_replace('[0-9]', null, md5(time())).rand();
                $dir_to_create = $current_dir.$folder_nameondisk;
                
                if ( !file_exists($dir_to_create) ) {
                
                    $sql = sprintf("INSERT INTO %s (folders_id, folders_name, folders_nameondisk, folders_createddate, folders_modificationdate, folders_inheritrights, folders_hidden, folders_owner, folders_usermod, folders_parent_id) VALUES (%u, '%s', '%s', %u, %u, %u, %u, %u, %u, %u)", $xoopsDB->prefix("docmanager_folders"), '', $folder_name, $folder_nameondisk, $create_date, $create_date, $inherit_rights, $hidden, $owner, $owner, $parent_id);
                
                    
                    // Insert the dir and redirect to the docmanager center
                    if ($dir_to_create !== "/" && strpos($dir_to_create, $myconfig['configs_path']) !== false && strpos($dir_to_create, "..") !== true && strpos($dir_to_create, " ") !== true) {
                    
                        if ($result = $xoopsDB->query($sql)) {
                        
                            $new_dir = $xoopsDB->getInsertId();                
                            
                            // Create the folder
                            mkdir($dir_to_create, 0755);
                            
                            redirect_header("index.php?curent_dir=".$new_dir."",1,_MD_CREATEFOLDER_SAVE_GOOD);
                        }
                        else {
                            echo _MD_CREATEFOLDER_SAVE_ERROR_BD;
                            echo "<br /><br />";
                            echo _MD_GO_BACK;
                            $insert_folder = true;
                        }
                    }
                    else {
                        echo _MD_CREATEFOLDER_SAVE_ERROR_PATH;
                        echo "<br /><br />";
                        echo _MD_GO_BACK;
                        $insert_folder = true;
                    }
                }
                
            } while ($insert_folder == false);
        }
        else {
            echo _MD_CREATEFOLDER_SAVE_ERROR_WRITABLE;
            echo "<br /><br />";
            echo _MD_GO_BACK;
        }        
    }
    else {
        echo _MD_CREATEFOLDER_SAVE_ERROR_NAME;
        echo "<br /><br />";
        echo _MD_GO_BACK;
    }    
}



// Function to erase a folder and everything that is inside
function erase_folder() {
    
    $folder_id = (int) $_POST['folder_id'];
    
    if ( if_folder_exist($folder_id) ) {

        $dir_to_erase = get_current_dir_path($folder_id);
        
        if ( is_writable($dir_to_erase) && file_exists($dir_to_erase) ) {
            // Delete on disk and on DB
            if (delete_current_dir_on_bd($folder_id) && delete_current_dir_on_disk($dir_to_erase)) {
                redirect_header("index.php",1,_MD_ERASEFOLDER_GOOD);
            }
            else {
                echo _MD_ERASEFOLDER_BAD;
                echo "<br /><br />";
                echo _MD_GO_BACK;
            }
        }
        else {
            echo _MD_ERASEFOLDER_ERASE_RIGHTS;
            echo "<br /><br />";
            echo _MD_GO_BACK;
        }
    }
    else {
        echo _MD_ERASEFOLDER_ERASE_DONTEXIST;
        echo "<br /><br />";
        echo _MD_GO_BACK;    
    }
}



// Function to mod a folder
function mod_folder() {

    global $xoopsDB, $xoopsUser, $myts;
    
    
    // Check if we have a folder name
    if (!empty($_POST['new_folder_name'])) {
    
        $folder_name = $myts->addSlashes($_POST['new_folder_name']);
        $folder_id = (int) $_POST['folder_id'];
        
        $user_mod = $xoopsUser->uid();
        $mod_date = time();
        
        
        if ( if_folder_exist($folder_id) ) {
            $sql = sprintf("UPDATE %s SET folders_name = '%s', folders_modificationdate = %u, folders_usermod = %u WHERE folders_id = %u", $xoopsDB->prefix("docmanager_folders"), $folder_name, $mod_date, $user_mod, $folder_id);
            
            
            if ($result = $xoopsDB->query($sql)) {
            
                redirect_header("index.php?curent_dir=".$folder_id."",1,_MD_MODFOLDER_SAVE_GOOD);
            }
            else {
                echo _MD_MODFOLDER_SAVE_BAD;
                echo "<br /><br />";
                echo _MD_GO_BACK;
            }
        }
        else {
            echo _MD_MODFOLDER_SAVE_DONTEXIST;
            echo "<br /><br />";
            echo _MD_GO_BACK;
        }
    }
    else {
        echo _MD_MODFOLDER_BAD_NAME;
        echo "<br /><br />";
        echo _MD_GO_BACK;
    } 
    
}



// Function to insert a file in the current parent dir
function insert_file() {
    
    global $xoopsDB, $xoopsUser, $myts;
    
    $insert_file = false;
    
    
    // Check if we have a file
    if (is_uploaded_file($_FILES['file_to_add']['tmp_name'])) {
        
        $file_name = $myts->addSlashes($_FILES['file_to_add']['name']);        
        $extension = strtolower(strrchr($file_name, "."));
        
        $parent_id = (int) $_POST['folder_id'];
        $owner = $xoopsUser->uid();
        $create_date = time();
        $file_type = check_file_type($file_name);
        $file_space = ceil(($_FILES['file_to_add']['size'] / 1000));
        
        
        // Select the config path
        $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
        $result = $xoopsDB->query($sql);
        $myconfig = $xoopsDB->fetchArray($result);        


        $current_dir = get_current_dir_path($parent_id);
        
        if ( is_writable($current_dir) && if_folder_exist($parent_id) ) {
            
            do {
            
                $file_nameondisk = ereg_replace('[0-9]', null, md5(time())).rand().$extension;
                $where_to_put_file = $current_dir.$file_nameondisk;

                if ( !file_exists($where_to_put_file) ) {
                    
                    $sql = sprintf("INSERT INTO %s (files_id, files_name, files_nameondisk, files_type, files_space, files_createddate, files_modificationdate, files_owner, files_usermod, files_foldersid) VALUES (%u, '%s', '%s', '%s', %u, %u, %u, %u, %u, %u)", $xoopsDB->prefix("docmanager_files"), '', $file_name, $file_nameondisk, $file_type, $file_space, $create_date, $create_date, $owner, $owner, $parent_id);
        
        
                    // Insert the file and redirect to the docmanager center
                    if ($where_to_put_file !== "/" && strpos($where_to_put_file, $myconfig['configs_path']) !== false && strpos($where_to_put_file, "..") !== true && strpos($where_to_put_file, " ") !== true) {
            
                        if ($result = $xoopsDB->query($sql)) {
                    
                            $new_file = $xoopsDB->getInsertId();
                
                            // Move the file
                            move_uploaded_file($_FILES['file_to_add']['tmp_name'], $where_to_put_file);
                
                            redirect_header("view_file.php?curent_file=".$new_file."&curent_dir=".$parent_id."",1,_MD_CREATEFILE_SAVE_GOOD);
                        }
                        else {
                            echo _MD_CREATEFILE_SAVE_ERROR_BD;
                            echo "<br /><br />";
                            echo _MD_GO_BACK;                        
                            $insert_file = true;
                        }
                    }
                    else {
                        echo _MD_CREATEFILE_SAVE_ERROR_PATH;
                        echo "<br /><br />";
                        echo _MD_GO_BACK;                    
                        $insert_file = true;
                    }
                }
                
            } while ($insert_file == false);
        }
        else {
            echo _MD_CREATEFILE_SAVE_WRITABLE;
            echo "<br /><br />";
            echo _MD_GO_BACK;
        }
    }
    else {
        switch($_FILES['file_to_add']['error']){
            case 0:
                echo _MD_CREATEFILE_UPLOAD_PROBLEM;
                echo "<br /><br />";
                echo _MD_GO_BACK;
                break;
            case 1:
                echo _MD_CREATEFILE_UPLOAD_TOOBIG;
                echo "<br /><br />";
                echo _MD_GO_BACK;                
                break;
            case 2:
                echo _MD_CREATEFILE_UPLOAD_TOOBIG;
                echo "<br /><br />";
                echo _MD_GO_BACK;                
                break;
            case 3:
                echo _MD_CREATEFILE_UPLOAD_PARTIAL;
                echo "<br /><br />";
                echo _MD_GO_BACK;                
                break;
            case 4:
                echo _MD_CREATEFILE_UPLOAD_NOFILE;
                echo "<br /><br />";
                echo _MD_GO_BACK;                
                break;
            default:
                echo _MD_CREATEFILE_UPLOADPROBLEM;
                echo "<br /><br />";
                echo _MD_GO_BACK;                
                break;
        }
    }    
}



// Function to erase a file
function erase_file() {
    
    global $xoopsDB, $_POST;
    
    
    $file_id = (int) $_POST['file_id'];
    $folder_id = (int) $_POST['folder_id'];
    
    
    // Select the config path
    $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
    $result = $xoopsDB->query($sql);
    $myconfig = $xoopsDB->fetchArray($result);
    
    
    if ( if_file_is_in_dir($file_id, $folder_id) ) {
    
        // Get the path to the file with the nameondisk
        $file_to_erase = get_current_dir_path($folder_id).get_file_name($file_id, 2);
        
        
        if ( is_writable($file_to_erase) && file_exists($file_to_erase) ) {
        
            $sql = sprintf("DELETE FROM %s WHERE files_id = %u", $xoopsDB->prefix("docmanager_files"), $file_id);
            
            
            // Check to see if its safe to delete the file
            if ($file_to_erase === "/" || strpos($file_to_erase, $myconfig['configs_path']) === false || strpos($file_to_erase, "..") === true || strpos($file_to_erase, " ") === true) {
                echo _MD_ERASEFILE_ERROR_PATH;
                echo "<br /><br />";
                echo _MD_GO_BACK;
            }
            else {
                if ($result = $xoopsDB->query($sql) && unlink($file_to_erase)) {        
                    redirect_header("index.php?curent_dir=".$folder_id,1,_MD_ERASEFILE_GOOD);
                }
                else {
                    echo _MD_ERASEFILE_ERROR_BD;
                    echo "<br /><br />";
                    echo _MD_GO_BACK;
                }
            }
        }
        else {
            echo _MD_ERASEFILE_ERROR_RIGHTS;
            echo "<br /><br />";
            echo _MD_GO_BACK;        
        }
    }
    else {
        echo _MD_ERASEFILE_ERROR_DONTEXIST;
        echo "<br /><br />";
        echo _MD_GO_BACK;    
    }
}



// Function to mod a file
function mod_file() {

    global $xoopsDB, $xoopsUser, $myts;
    
    $insert_file = false;
    $rename = false;
    
    
    // Check if we have a file name
    if (!empty($_POST['new_file_name'])) {
    
        $file_name = $myts->addSlashes($_POST['new_file_name']);
        $extension = strtolower(strrchr($file_name, "."));
        $file_id = (int) $_POST['file_id'];
        $folder_id = (int) $_POST['folder_id'];
        $file_type = check_file_type($file_name);
        
        $user_mod = $xoopsUser->uid();
        $mod_date = time();
        
        
        $sql = "SELECT files_id, files_name, files_nameondisk, files_foldersid, files_type FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_id = ".$file_id;
        $result = $xoopsDB->query($sql);
        $myrow = $xoopsDB->fetchArray($result); 
        
        
        if (strcmp($extension, strtolower(strrchr($myrow['files_nameondisk'], "."))) != 0) {
            
            $current_dir = get_current_dir_path($folder_id);
            
            do {
                $file_nameondisk = ereg_replace('[0-9]', null, md5(time())).rand().$extension;
                $where_to_put_file = $current_dir.$file_nameondisk;
                    
                if ( !file_exists($where_to_put_file) ) {
                    $insert_file = true;
                }
            } while ($insert_file == false);
            
            if ( is_writable($current_dir) && is_writable($current_dir.$myrow['files_nameondisk']) ) {
                rename($current_dir.$myrow['files_nameondisk'], $where_to_put_file);
                $rename = true;
            }
            else {
                $rename = false;
            }
        }
        else {
            $file_nameondisk = $myrow['files_nameondisk'];
            $rename = true;
        }
        
        
        
        $sql = sprintf("UPDATE %s SET files_name = '%s', files_nameondisk = '%s', files_type = '%s', files_modificationdate = %u, files_usermod = %u WHERE files_id = %u", $xoopsDB->prefix("docmanager_files"), $file_name, $file_nameondisk, $file_type, $mod_date, $user_mod, $file_id);
        
        
        if ( $rename == true && if_file_is_in_dir($file_id, $folder_id) ) {
            if ($result = $xoopsDB->query($sql)) {
            
                redirect_header("view_file.php?curent_dir=".$folder_id."&curent_file=".$file_id."",1,_MD_MODFILE_SAVE_GOOD);
            }
            else {
                echo _MD_MODFILE_SAVE_BAD;
                echo "<br /><br />";
                echo _MD_GO_BACK;    
            }
        }
        else {
            echo _MD_MODFILE_SAVE_DONTEXIST;
            echo "<br /><br />";
            echo _MD_GO_BACK;        
        }
    }
    else {
        echo _MD_MODFILE_BAD_NAME;
        echo "<br /><br />";
        echo _MD_GO_BACK;
    } 
    
}



// Function to update a file in the current parent dir
function maj_file() {
    
    global $xoopsDB, $xoopsUser, $myts;
    
    $insert_file = false;
    
    
    // Check if we have a file
    if (is_uploaded_file($_FILES['file_to_maj']['tmp_name'])) {
        
        $folder_id = (int) $_POST['folder_id'];
        $file_id = (int) $_POST['file_id'];


        $sql = "SELECT files_id, files_name, files_nameondisk, files_foldersid, files_type FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_id = ".$file_id;
        $result = $xoopsDB->query($sql);
        $myrow = $xoopsDB->fetchArray($result);      
        
        
        $file_name = $myts->addSlashes($_FILES['file_to_maj']['name']);        
        $extension = strtolower(strrchr($file_name, "."));
        $file_type = check_file_type($file_name);
        
        $usermod = $xoopsUser->uid();
        $mod_date = time();
        $file_space = ceil(($_FILES['file_to_maj']['size'] / 1000));
        
        
        
        // Select the config path
        $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
        $result = $xoopsDB->query($sql);
        $myconfig = $xoopsDB->fetchArray($result); 
        
        
        
        $current_dir = get_current_dir_path($folder_id);
        
        
        if ( if_file_is_in_dir($file_id, $folder_id) ) {
            
            if (strcmp($extension, strtolower(strrchr($myrow['files_nameondisk'], "."))) != 0) {
        
                do {
                    $file_nameondisk = ereg_replace('[0-9]', null, md5(time())).rand().$extension;
                    $where_to_put_file = $current_dir.$file_nameondisk;
                        
                    if ( !file_exists($where_to_put_file) ) {
                        $insert_file = true;
                    }
                } while ($insert_file == false);
                
                if ( is_writable($current_dir) && is_writable($current_dir.$myrow['files_nameondisk']) ) {
                    rename($current_dir.$myrow['files_nameondisk'], $where_to_put_file);
                }
            }
            else {
                $file_nameondisk = $myrow['files_nameondisk'];
                $where_to_put_file = $current_dir.$file_nameondisk;
            }


            if ( is_writable($where_to_put_file) && file_exists($where_to_put_file) ) {
            
                // Update the file and redirect to the docmanager center
                if ($where_to_put_file !== "/" && strpos($where_to_put_file, $myconfig['configs_path']) !== false && strpos($where_to_put_file, "..") !== true && strpos($where_to_put_file, " ") !== true) {
                
                    $sql = sprintf("UPDATE %s SET files_name = '%s', files_nameondisk = '%s', files_type = '%s', files_space = %u, files_modificationdate = %u, files_usermod = %u WHERE files_id = %u", $xoopsDB->prefix("docmanager_files"), $file_name, $file_nameondisk, $file_type, $file_space, $mod_date, $usermod, $file_id);
                    
                    if ($result = $xoopsDB->query($sql)) {
                    
                        // Move the file
                        move_uploaded_file($_FILES['file_to_maj']['tmp_name'], $where_to_put_file);
                        
                        redirect_header("view_file.php?curent_file=".$file_id."&curent_dir=".$folder_id."",1,_MD_MAJFILE_SAVE_GOOD);
                    }
                    else {
                        echo _MD_MAJFILE_SAVE_ERROR_BD;
                        echo "<br /><br />";
                        echo _MD_GO_BACK;
                    }
                }
                else {
                    echo _MD_MAJFILE_SAVE_ERROR_PATH;
                    echo "<br /><br />";
                    echo _MD_GO_BACK;
                }
            }
            else {
                echo _MD_MAJFILE_SAVE_ERROR_WRITABLE;
                echo "<br /><br />";
                echo _MD_GO_BACK;
            }
        }
        else {
            echo _MD_MAJFILE_SAVE_ERROR_DONTEXIST;
            echo "<br /><br />";
            echo _MD_GO_BACK;
        }
    }
    else {
        switch($_FILES['file_to_maj']['error']){
            case 0:
                echo _MD_CREATEFILE_UPLOAD_PROBLEM;
                echo "<br /><br />";
                echo _MD_GO_BACK;                 
                break;
            case 1:
                echo _MD_CREATEFILE_UPLOAD_TOOBIG;
                echo "<br /><br />";
                echo _MD_GO_BACK;                 
                break;
            case 2:
                echo _MD_CREATEFILE_UPLOAD_TOOBIG;
                echo "<br /><br />";
                echo _MD_GO_BACK;                 
                break;
            case 3:
                echo _MD_CREATEFILE_UPLOAD_PARTIAL;
                echo "<br /><br />";
                echo _MD_GO_BACK;                 
                break;
            case 4:
                echo _MD_CREATEFILE_UPLOAD_NOFILE;
                echo "<br /><br />";
                echo _MD_GO_BACK;                 
                break;
            default:
                echo _MD_CREATEFILE_UPLOADPROBLEM;
                echo "<br /><br />";
                echo _MD_GO_BACK;                 
                break;
        }
    }    
}



// Select the current operation
if (!empty($_POST['op'])) {
    $op = $_POST['op'];
}
else {
    $op = "";
}



// Redirect to the good function
switch ($op) {
    case "insert_folder":
        insert_folder();
        break;
    case "erase_folder":
        erase_folder();
        break;
    case "mod_folder":
        mod_folder();
        break;        
    case "insert_file":
        insert_file();
        break;
    case "erase_file":
        erase_file();
        break;
    case "mod_file":
        mod_file();
        break;         
    case "maj_file":
        maj_file();
        break;        
}





// Include Xoops footer
include 'footer.php';

?>
