<?php
// $Id: set_rights.php,v 1.3 2005/01/17 16:33:07 jsaucier Exp $
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


$is_hidden = ($_POST['is_hidden'] == "on" ? 1 : 0);
$is_inherit = ($_POST['is_inherit'] == "on" ? 1 : 0);
$folder_id = $_POST['folder_id'];


// Update the rights infos
$sql = "UPDATE ".$xoopsDB->prefix("docmanager_folders")." SET folders_hidden = ".$is_hidden.", folders_inheritrights = ".$is_inherit." WHERE folders_id = ".$folder_id;

if ($result = $xoopsDB->query($sql)) {
    redirect_header("rights.php?curent_dir=".$folder_id,1,_AM_RIGHTS_UPDATE_GOOD);
}
else {
    echo _AM_RIGHTS_UPDATE_BAD;
}


?>
