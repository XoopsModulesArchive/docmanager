<?php
// $Id: search.inc.php,v 1.3 2005/03/14 20:05:43 jsaucier Exp $
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

    
function docmanager_search($queryarray, $andor, $limit, $offset, $userid) {

    global $xoopsDB, $xoopsUser, $xoopsModule;
    
    
    require_once("swish-e.class.php");
    require_once("functions.php");   
    
    
    
    // Check if the user as admin right to the module
    $xoopsModule = XoopsModule::getByDirname("docmanager");
    
    if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
        $is_mod_admin = true;
    } else {
        $is_mod_admin = false;
    }

    

    // Select the config path
    $sql = "SELECT configs_path FROM ".$xoopsDB->prefix("docmanager_configs");
    $result = $xoopsDB->query($sql);
    $myconfig = $xoopsDB->fetchArray($result);


    // Set the index position
    $objSW = new swish($myconfig['configs_path']."/tools/index.swish-e", "/usr/bin/swish-e");



    // Build the query
    $query = "";
    
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$query .= $queryarray[0];
        
		for($i=1; $i<$count; $i++) {
			$query .= " $andor ";
			$query .= $queryarray[$i];
		}
	}
    
    
    // Exec the query
    $objSW->set_params($query);
    
    $res = $objSW->get_result();
    
    
    
    // Build the return array
    $ret = array();
	$i = 0;
    
    
    if ( is_array($res) ) {
    
        foreach($res as $v) {
        
            // Select the file in DB
            $file_nameondisk = substr($v['URL'], strrpos($v['URL'], "/") + 1);
            
            $sql = "SELECT files_id, files_name, files_modificationdate, files_usermod, files_foldersid FROM ".$xoopsDB->prefix("docmanager_files")." WHERE files_nameondisk = '".$file_nameondisk."'";
            $result = $xoopsDB->query($sql);
            $myrow = $xoopsDB->fetchArray($result);
            
            
            // Check if user have the right
            if ( if_folder_exist($myrow['files_foldersid']) && have_access_right_to_folder($myrow['files_foldersid']) && (is_not_hidden($myrow['files_foldersid']) || $is_mod_admin)) {
            
                $ret[$i]['image'] = "images/extensions/".check_file_type($myrow['files_name']);
                $ret[$i]['link'] = "view_file.php?curent_file=".$myrow['files_id']."&amp;curent_dir=".$myrow['files_foldersid']."";
                $ret[$i]['title'] = $myrow['files_name']." - ".($v['SCORE'] / 10)." %";
                $ret[$i]['time'] = $myrow['files_modificationdate'];
                $ret[$i]['uid'] = $myrow['files_usermod'];
                $i++;
            }
        }
    }
    
	return $ret;
    
}

?>
