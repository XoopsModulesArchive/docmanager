<?php
// $Id: main.php,v 1.2 2005/03/14 20:05:43 jsaucier Exp $
// Module language


define("_MD_DOCMANAGER_MAIN_TITLE", "Document center");

define("_MD_GO_BACK", "<a href='javascript:history.go(-1);'>Return</a>");

define("_MD_NAVIGATION_TITLE","Navigate : ");
define("_MD_PARENTFOLDER", "Root");

define("_MD_ACTION_TITLE","Possibles actions for this folder : ");

define("_MD_FOLDER_TITLE","Folders list for : ");
define("_MD_FOLDER_NAME", "Name");
define("_MD_FOLDER_DELETE", "Erase");
define("_MD_FOLDER_HIDDEN", "Hidden");
define("_MD_FOLDER_CREATE", "Create a folder");
define("_MD_FOLDER_ERASE", "Erase the folder");
define("_MD_FOLDER_MOD", "Rename the folder");
define("_MD_FOLDER_MOD2", "Rename");


define("_MD_DOCUMENT_TITLE","Documents list for : ");
define("_MD_FILE_NAME", "Name");
define("_MD_FILE_DATE", "Modification Date");
define("_MD_FILE_SPACE", "Size");
define("_MD_FILE_SUMMARY", "Summary");
define("_MD_FILE_DELETE", "Erase");
define("_MD_FILE_CREATE", "Add File");


define("_MD_ADMIN_TITLE", "Administration");
define("_MD_RIGHTS_TITLE", "Modify folder's rights : ");

define("_MD_FOLDER_ERROR_RIGHTS", "This folder doesn't exist");

define("_MD_EDITRIGHTS", "Edit rights : ");

define("_MD_DOCMANAGER_CREATEFOLDER", "Create a folder in : ");
define("_MD_CREATEFOLDER_NAME", "Name of folder : ");
define("_MD_CREATEFOLDER_SUBMIT", "Create");
define("_MD_CREATEFOLDER_CANCEL", "Cancel");

define("_MD_CREATEFOLDER_SAVE_GOOD", "The folder has been added");
define("_MD_CREATEFOLDER_SAVE_ERROR_NAME", "You must enter a valid folder name");
define("_MD_CREATEFOLDER_SAVE_ERROR_BD", "Error when adding to the BD, the folder has not been created");
define("_MD_CREATEFOLDER_SAVE_ERROR_PATH", "Error in the folder path, the folder has not been created");
define("_MD_CREATEFOLDER_SAVE_ERROR_WRITABLE", "Error the parent folder is not writable, the folder has not been created");


define("_MD_DOCMANAGER_MODFOLDER", "Rename the folder : ");
define("_MD_MODFOLDER_NAME", "New name for folder : ");
define("_MD_MODFOLDER_SUBMIT", "Rename");
define("_MD_MODFOLDER_CANCEL", "Cancel");

define("_MD_MODFOLDER_PARENT", "You cannot modify the Root folder");

define("_MD_MODFOLDER_BAD_NAME", "You must enter a valid folder name");
define("_MD_MODFOLDER_SAVE_GOOD", "The folder has been modified");
define("_MD_MODFOLDER_SAVE_BAD", "Error in modifying the folder");
define("_MD_MODFOLDER_SAVE_DONTEXIST", "The folder don't exist");

define("_MD_DOCMANAGER_ERASEFOLDER", "Erase the folder : ");
define("_MD_ERASEFOLDER_CONFIRM", "Are you sure to delete this folder and it's content?");
define("_MD_ERASEFOLDER_SUBMIT", "Confirm");
define("_MD_ERASEFOLDER_CANCEL", "Cancel");

define("_MD_ERASEFOLDER_GOOD", "The folder has been erased");
define("_MD_ERASEFOLDER_BAD", "Error in erasing the folder");
define("_MD_ERASEFOLDER_ERASE_DONTEXIST", "The folder don't exist");
define("_MD_ERASEFOLDER_ERASE_RIGHTS", "The folder don't have the good permissions to be erased");

define("_MD_ERASEFOLDER_PARENT", "You cannot erase the Root folder");


define("_MD_DOCMANAGER_CREATEFILE", "Create a file in the folder : ");
define("_MD_CREATEFILE_NAME", "File to add : ");
define("_MD_CREATEFILE_SUBMIT", "Add");
define("_MD_CREATEFILE_CANCEL", "Cancel");

define("_MD_CREATEFILE_SAVE_GOOD", "The file has been added");
define("_MD_CREATEFOLDER_SAVE_ERROR_BD", "Error when adding to the BD, the file has not been created");
define("_MD_CREATEFOLDER_SAVE_ERROR_PATH", "Error in the file path, the file has not been created");
define("_MD_CREATEFILE_SAVE_WRITABLE", "The destination folder is not writable");
define("_MD_CREATEFILE_UPLOAD_PROBLEM", "Error in file upload");
define("_MD_CREATEFILE_UPLOAD_NOFILE", "You must specify a file");
define("_MD_CREATEFILE_UPLOAD_TOOBIG", "File too big, please choose another");
define("_MD_CREATEFILE_UPLOAD_PARTIAL", "The file has been uploaded partially");

define("_MD_DOCMANAGER_ERASEFILE", "Erase the file : ");
define("_MD_ERASEFILE_CONFIRM", "Are you sure you want to erase this file?");
define("_MD_ERASEFILE_SUBMIT", "Confirm");
define("_MD_ERASEFILE_CANCEL", "Cancel");

define("_MD_ERASEFILE_GOOD", "The file has been erased succesfully");
define("_MD_ERASEFILE_ERROR_PATH", "Error in file path, the file will not be erased");
define("_MD_ERASEFILE_ERROR_BD", "Error when erasing the file in BD, the file will not be erased");
define("_MD_ERASEFILE_ERROR_DONTEXIST", "The file don't exist");
define("_MD_ERASEFILE_ERROR_RIGHTS", "The file don't have the good permissions to be erased");

define("_MD_FILE_ERROR_RIGHTS", "This file doesn't exist");


define("_MD_DOCMANAGER_MODFILE", "Rename the file : ");
define("_MD_MODFILE_NAME", "New name for file : ");
define("_MD_MODFILE_SUBMIT", "Rename");
define("_MD_MODFILE_CANCEL", "Cancel");

define("_MD_MODFILE_BAD_NAME", "You must enter a valid file name");
define("_MD_MODFILE_SAVE_GOOD", "The file has been modified");
define("_MD_MODFILE_SAVE_BAD", "Error in modifying the file");
define("_MD_MODFILE_SAVE_DONTEXIST", "The file don't exist");

define("_MD_DOCMANAGER_VIEWFILE", "File informations");
define("_MD_VIEWFILE_TYPE", "File type : ");
define("_MD_VIEWFILE_NAME", "File name : ");
define("_MD_VIEWFILE_SPACE", "File size : ");
define("_MD_VIEWFILE_CREATEDDATE", "Creation date : ");
define("_MD_VIEWFILE_MODDATE", "Modification date : ");
define("_MD_VIEWFILE_OWNER", "File owner : ");
define("_MD_VIEWFILE_USERMOD", "Last modification user : ");
define("_MD_VIEWFILE_ACTION", "Possibles actions");
define("_MD_VIEWFILE_GET", "Download");
define("_MD_VIEWFILE_MAJ", "Update");
define("_MD_VIEWFILE_RENAME", "Rename");
define("_MD_VIEWFILE_ERASE", "Erase");

define("_MD_VIEWFILE_BACKFOLDER", "Return to folder");

define("_MD_SUMMARY_TITLE", "Summary");


define("_MD_GETFILE_GOOD", "End of download");

define("_MD_DOCMANAGER_MAJFILE", "File update : ");
define("_MD_MAJFILE_NAME", "Choose the file to update : ");
define("_MD_MAJFILE_SUBMIT", "Update");
define("_MD_MAJFILE_CANCEL", "Cancel");

define("_MD_MAJFILE_SAVE_GOOD", "The file has been updated");
define("_MD_MAJFILE_SAVE_ERROR_PATH", "Error in file path, the file will not be updated");
define("_MD_MAJFILE_SAVE_ERROR_BD", "Error in inserting in the BD, the file will not be updated");
define("_MD_MAJFILE_SAVE_ERROR_WRITABLE", "The file don't have the good permissions to be updated");
define("_MD_MAJFILE_SAVE_ERROR_DONTEXIST", "The file don't exist");




define("_MD_DBRIGHTS_CREATEFOLDER", "Creating folders");
define("_MD_DBRIGHTS_MODFOLDER", "Modifying folders");
define("_MD_DBRIGHTS_ERASEFOLDER", "Deleting folders");
define("_MD_DBRIGHTS_CREATEFILE", "Creating files");
define("_MD_DBRIGHTS_MODFILE", "Modifying files");
define("_MD_DBRIGHTS_ERASEFILE", "Deleting files");
define("_MD_DBRIGHTS_ACCESSFOLDER", "Access to folders");

?>
