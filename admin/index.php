<?php
// $Id: index.php,v 1.4 2005/04/26 13:14:35 jsaucier Exp $
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

if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include_once "../language/".$xoopsConfig['language']."/main.php";
} else {
	include_once "../language/english/main.php";
}


function make_gestion() {

    global $xoopsDB;
    
    
    $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
    $result = $xoopsDB->query($sql);
    $the_path = $xoopsDB->fetchArray($result);
    
    xoops_cp_header();
    
    
    echo _AM_FOLDER_ROOT . "&nbsp;";
    if ( file_exists($the_path['configs_path']) ) {
        echo "<b>" . _AM_FOLDER_ROOT_GOOD . "</b>";
    }
    else {
        echo "<b>" . _AM_FOLDER_ROOT_BAD . "</b>";
    }
    
    echo "<br />" . _AM_FOLDER_PARENT . "&nbsp;";
    if ( file_exists($the_path['configs_path'] . "/parent_folder") ) {
        echo "<b>" . _AM_FOLDER_PARENT_GOOD . "</b>";
    }
    else {
        echo "<b>" . _AM_FOLDER_PARENT_BAD . "</b>";
    }

    echo "<br />" . _AM_FOLDER_PARENT2 . "&nbsp;";
    if ( is_writable($the_path['configs_path'] . "/parent_folder") ) {
        echo "<b>" . _AM_FOLDER_PARENT2_GOOD . "</b>";
    }
    else {
        echo "<b>" . _AM_FOLDER_PARENT2_BAD . "</b>";
    }

    echo "<br />" . _AM_FOLDER_TOOLS . "&nbsp;";
    if ( file_exists($the_path['configs_path'] . "/tools") ) {
        echo "<b>" . _AM_FOLDER_TOOLS_GOOD . "</b>";
    }
    else {
        echo "<b>" . _AM_FOLDER_TOOLS_BAD . "</b>";
    }
    
    echo "<br /><br /><br />";
    echo "<form action='index.php?op=savegestion' method='post'>\n";
    echo _AM_GESTION_PATH;
    echo "&nbsp;&nbsp;";
    echo "<input name='the_path' type='text' value='".$the_path['configs_path']."'></input>";    
    echo "<br /><br />";
    echo "<input type='submit' value='"._AM_GESTION_VALIDATE."'></input>";
    echo "</form>";
    
    xoops_cp_footer();

}


function save_gestion() {

    global $xoopsDB, $_POST;
    
    
    $sql = "UPDATE ".$xoopsDB->prefix("docmanager_configs")." SET configs_path = '".$_POST['the_path']."'";
    
    if ($result = $xoopsDB->query($sql)) {
        redirect_header("index.php?op=gestion",1,_AM_GESTION_SAVE_GOOD);
    }
    else {
        echo _AM_GESTION_SAVE_BAD;
    }
    
}



$op = $_GET['op'];

switch ($op) {
case "gestion":
	make_gestion();
	break;
case "savegestion":
    save_gestion();
    break;
default:
	make_gestion();
	break;
}
?>
