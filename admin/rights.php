<?php
// $Id: rights.php,v 1.3 2005/01/17 16:33:07 jsaucier Exp $
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


include '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
$module_id = $xoopsModule->getVar('mid');


// Select the current_dir that we are in
if (!empty($_GET['curent_dir'])) {
    $folder_id = $_GET['curent_dir'];
}
else {
    $folder_id = 0;
    exit(_AM_RIGHTS_NOVALID_FOLDER);
}


// Set the header
xoops_cp_header();
    
    
    
// Select the info of the current dir
$sql = "SELECT folders_id, folders_name, folders_inheritrights, folders_hidden FROM ".$xoopsDB->prefix("docmanager_folders")." WHERE folders_id = ".$folder_id;
$result = $xoopsDB->query($sql);
$current_folder = $xoopsDB->fetchArray($result);


// If the current folder exist
if (!empty($current_folder)) {


    // Check if it's the primary folder, if yes, check out the constant name
    if ($folder_id == 1) {
        $folder_name = constant($current_folder['folders_name']);
    }
    else {
        $folder_name = $current_folder['folders_name'];
    }
    
    
    // Fill up form information
    $title_of_form = "";
    $perm_desc = _AM_RIGHTS_DESC;
    $perm_name = $folder_id;
    $checked_inherit = ($current_folder['folders_inheritrights']==1 ? "checked" : "");
    $checked_hidden = ($current_folder['folders_hidden']==1 ? "checked" : "");
    
    
    // Select all the rights
    $sql = "SELECT rights_id, rights_name FROM ".$xoopsDB->prefix("docmanager_rights")." WHERE rights_applied_to_folders = 1";
    $result = $xoopsDB->query($sql);
    
    
    
    // Build the item list
    while ($rights_array = $xoopsDB->fetchArray($result)) {
        $item_list[$rights_array['rights_id']] = constant($rights_array['rights_name']);
    }
    
    
    
    
    // Make the form
    $form = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc);
    
    foreach ($item_list as $item_id => $item_name) {
        $form->addItem($item_id, $item_name);
    }
    

    
    
    // Build the form to add some rights (hidden and inherit)
    echo "<b>"._AM_RIGHTS_TITLE.$folder_name."</b>";
    
    
    // If it's the parent folder, dont permit hidden and inherit
    if ($folder_id != 1) {
        echo "<br /><br />";
        echo "<form name='hidden_folder' id='hidden_folder' action='".XOOPS_URL."/modules/docmanager/admin/set_rights.php' method='post'>";
        echo _AM_OPTIONS_INHERIT_FOLDER;
        echo "&nbsp;&nbsp;";
        echo "<input name='is_inherit' type='checkbox' ".$checked_inherit."></input>";
        echo "<br />";
        echo _AM_OPTIONS_HIDDEN_FOLDER;
        echo "&nbsp;&nbsp;";
        echo "<input name='is_hidden' type='checkbox' ".$checked_hidden."></input>";    
        echo "<br /><br />";
        echo "<input type='hidden' name='folder_id' value='".$folder_id."'></input>";
        echo "<input type='submit' value='"._AM_OPTIONS_VALIDATE."'></input>";
        echo "</form>";
        echo "<br />";
    }
    
    // If we inherit, dont show the rights form
    if ($checked_inherit != "checked") {
        echo $form->render();
    }
    
}
else {
    echo _AM_RIGHTS_NOVALID_FOLDER;
}



// Set the footer
xoops_cp_footer();

?>
