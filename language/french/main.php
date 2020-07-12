<?php
// $Id: main.php,v 1.2 2005/03/14 20:05:43 jsaucier Exp $
// Module language


define("_MD_DOCMANAGER_MAIN_TITLE", "Centre de documentation");

define("_MD_GO_BACK", "<a href='javascript:history.go(-1);'>Retour &agrave; la page pr&eacute;c&eacute;dente</a>");

define("_MD_NAVIGATION_TITLE","Navigation : ");
define("_MD_PARENTFOLDER", "Racine");

define("_MD_ACTION_TITLE","Actions possibles sur le r&eacute;pertoire : ");

define("_MD_FOLDER_TITLE","Liste des r&eacute;pertoires dans : ");
define("_MD_FOLDER_NAME", "Nom");
define("_MD_FOLDER_DELETE", "Effacer");
define("_MD_FOLDER_HIDDEN", "Cach&eacute;");
define("_MD_FOLDER_CREATE", "Cr&eacute;er un r&eacute;pertoire");
define("_MD_FOLDER_ERASE", "Effacer le r&eacute;pertoire");
define("_MD_FOLDER_MOD", "Renommer le r&eacute;pertoire");
define("_MD_FOLDER_MOD2", "Renommer");


define("_MD_DOCUMENT_TITLE","Liste des documents dans : ");
define("_MD_FILE_NAME", "Nom");
define("_MD_FILE_DATE", "Date Modification");
define("_MD_FILE_SPACE", "Taille");
define("_MD_FILE_SUMMARY", "Sommaire");
define("_MD_FILE_DELETE", "Effacer");
define("_MD_FILE_CREATE", "Ajouter un fichier");


define("_MD_ADMIN_TITLE", "Administration");
define("_MD_RIGHTS_TITLE", "Modifier les permissions du r&eacute;pertoire : ");

define("_MD_FOLDER_ERROR_RIGHTS", "Ce r&eacute;pertoire n'existe pas");

define("_MD_EDITRIGHTS", "Edition des permissions : ");

define("_MD_DOCMANAGER_CREATEFOLDER", "Cr&eacute;er un r&eacute;pertoire dans : ");
define("_MD_CREATEFOLDER_NAME", "Nom du r&eacute;pertoire : ");
define("_MD_CREATEFOLDER_SUBMIT", "Cr&eacute;er");
define("_MD_CREATEFOLDER_CANCEL", "Annuler");

define("_MD_CREATEFOLDER_SAVE_GOOD", "Le r&eacute;pertoire a &eacute;t&eacute; ajout&eacute;");
define("_MD_CREATEFOLDER_SAVE_ERROR_NAME", "Vous devez entrez un nom de r&eacute;pertoire valide");
define("_MD_CREATEFOLDER_SAVE_ERROR_BD", "Erreur lors de l'ajout dans la BD, le r&eacute;pertoire n'a pas &eacute;t&eacute; cr&eacute;&eacute;");
define("_MD_CREATEFOLDER_SAVE_ERROR_PATH", "Erreur dans le chemin du r&eacute;pertoire, le r&eacute;pertoire n'a pas &eacute;t&eacute; cr&eacute;&eacute;");
define("_MD_CREATEFOLDER_SAVE_ERROR_WRITABLE", "Erreur le r&eacute;pertoire parent ne poss&egrave;de pas les permissions d'&eacute;criture, le r&eacute;pertoire n'a pas &eacute;t&eacute; cr&eacute;&eacute;");


define("_MD_DOCMANAGER_MODFOLDER", "Renommer le r&eacute;pertoire : ");
define("_MD_MODFOLDER_NAME", "Nouveau nom du r&eacute;pertoire : ");
define("_MD_MODFOLDER_SUBMIT", "Renommer");
define("_MD_MODFOLDER_CANCEL", "Annuler");

define("_MD_MODFOLDER_PARENT", "Vous ne pouvez pas modifier le r&eacute;pertoire parent");

define("_MD_MODFOLDER_BAD_NAME", "Vous devez entrez un nom de r&eacute;pertoire valide");
define("_MD_MODFOLDER_SAVE_GOOD", "Le r&eacute;pertoire a &eacute;t&eacute; modifi&eacute;");
define("_MD_MODFOLDER_SAVE_BAD", "Erreur dans la modification du r&eacute;pertoire");
define("_MD_MODFOLDER_SAVE_DONTEXIST", "Le r&eacute;pertoire n'existe pas");

define("_MD_DOCMANAGER_ERASEFOLDER", "Effacer le r&eacute;pertoire : ");
define("_MD_ERASEFOLDER_CONFIRM", "Etes vous s&ucirc;r de vouloir effacer ce r&eacute;pertoire et tout ce qu'il contient?");
define("_MD_ERASEFOLDER_SUBMIT", "Confirmer");
define("_MD_ERASEFOLDER_CANCEL", "Annuler");

define("_MD_ERASEFOLDER_GOOD", "Le r&eacute;pertoire a &eacute;t&eacute; effac&eacute; correctement");
define("_MD_ERASEFOLDER_BAD", "Erreur dans l'effacement du r&eacute;pertoire");
define("_MD_ERASEFOLDER_ERASE_DONTEXIST", "Le r&eacute;pertoire n'existe pas");
define("_MD_ERASEFOLDER_ERASE_RIGHTS", "Le r&eacute;pertoire n'a pas les droits suffisants pour &ecirc;tre effac&eacute;");

define("_MD_ERASEFOLDER_PARENT", "Vous ne pouvez pas effacer le r&eacute;pertoire Racine");


define("_MD_DOCMANAGER_CREATEFILE", "Cr&eacute;er un fichier dans le r&eacute;pertoire : ");
define("_MD_CREATEFILE_NAME", "Fichier &agrave; ajouter : ");
define("_MD_CREATEFILE_SUBMIT", "Ajouter");
define("_MD_CREATEFILE_CANCEL", "Annuler");

define("_MD_CREATEFILE_SAVE_GOOD", "Le fichier a &eacute;t&eacute; ajout&eacute;");
define("_MD_CREATEFILE_SAVE_ERROR_BD", "Erreur lors de l'ajout dans la BD, le fichier n'a pas &eacute;t&eacute; cr&eacute;&eacute;");
define("_MD_CREATEFILE_SAVE_ERROR_PATH", "Erreur dans le chemin du fichier, le fichier n'a pas &eacute;t&eacute; cr&eacute;&eacute;");
define("_MD_CREATEFILE_SAVE_WRITABLE", "Le r&eacute;pertoire de destination n'a pas les droits suffisants pour ajouter le fichier");
define("_MD_CREATEFILE_UPLOAD_PROBLEM", "Erreur dans l'upload du fichier");
define("_MD_CREATEFILE_UPLOAD_NOFILE", "Vous devez sp&eacute;cifier un fichier");
define("_MD_CREATEFILE_UPLOAD_TOOBIG", "Fichier trop gros, veuillez en choisir un autre");
define("_MD_CREATEFILE_UPLOAD_PARTIAL", "Le fichier n'a &eacute;t&eacute; uploader que partiellement");

define("_MD_DOCMANAGER_ERASEFILE", "Effacer le fichier : ");
define("_MD_ERASEFILE_CONFIRM", "Etes vous s&ucirc;r de vouloir effacer ce fichier?");
define("_MD_ERASEFILE_SUBMIT", "Confirmer");
define("_MD_ERASEFILE_CANCEL", "Annuler");

define("_MD_ERASEFILE_GOOD", "Le fichier a &eacute;t&eacute; effac&eacute; correctement");
define("_MD_ERASEFILE_ERROR_PATH", "Erreur dans le chemin du fichier, le fichier ne sera pas effac&eacute;");
define("_MD_ERASEFILE_ERROR_BD", "Erreur lors de l'effacement dans la BD, le fichier ne sera pas effac&eacute;");
define("_MD_ERASEFILE_ERROR_DONTEXIST", "Le fichier sp&eacute;cifi&eacute; n'existe pas");
define("_MD_ERASEFILE_ERROR_RIGHTS", "Le fichier n'a pas les droits suffisants pour &ecirc;tre effac&eacute;");

define("_MD_FILE_ERROR_RIGHTS", "Ce fichier n'existe pas");


define("_MD_DOCMANAGER_MODFILE", "Renommer le fichier : ");
define("_MD_MODFILE_NAME", "Nouveau nom du fichier : ");
define("_MD_MODFILE_SUBMIT", "Renommer");
define("_MD_MODFILE_CANCEL", "Annuler");

define("_MD_MODFILE_BAD_NAME", "Vous devez entrez un nom de fichier valide");
define("_MD_MODFILE_SAVE_GOOD", "Le fichier a &eacute;t&eacute; modifi&eacute;");
define("_MD_MODFILE_SAVE_BAD", "Erreur dans la modification du fichier");
define("_MD_MODFILE_SAVE_DONTEXIST", "Le fichier n'existe pas");

define("_MD_DOCMANAGER_VIEWFILE", "Information sur le fichier");
define("_MD_VIEWFILE_TYPE", "Type du fichier : ");
define("_MD_VIEWFILE_NAME", "Nom du fichier : ");
define("_MD_VIEWFILE_SPACE", "Taille du fichier : ");
define("_MD_VIEWFILE_CREATEDDATE", "Date de cr&eacute;ation : ");
define("_MD_VIEWFILE_MODDATE", "Date de derni&egrave;re modification : ");
define("_MD_VIEWFILE_OWNER", "Propri&eacute;taire du fichier : ");
define("_MD_VIEWFILE_USERMOD", "Dernier utilisateur &agrave; modifier : ");
define("_MD_VIEWFILE_ACTION", "Actions possibles");
define("_MD_VIEWFILE_GET", "T&eacute;l&eacute;charger");
define("_MD_VIEWFILE_MAJ", "Mettre &agrave; jour");
define("_MD_VIEWFILE_RENAME", "Renommer");
define("_MD_VIEWFILE_ERASE", "Effacer");

define("_MD_VIEWFILE_BACKFOLDER", "Retour au r&eacute;pertoire");

define("_MD_SUMMARY_TITLE", "Sommaire");


define("_MD_GETFILE_GOOD", "T&eacute;l&eacute;chargement termin&eacute;");

define("_MD_DOCMANAGER_MAJFILE", "Mise &agrave; jour du fichier : ");
define("_MD_MAJFILE_NAME", "Choisir le fichier pour mettre &agrave; jour : ");
define("_MD_MAJFILE_SUBMIT", "Mettre &agrave; jour");
define("_MD_MAJFILE_CANCEL", "Annuler");

define("_MD_MAJFILE_SAVE_GOOD", "Le fichier a &eacute;t&eacute; mis &agrave; jour correctement");
define("_MD_MAJFILE_SAVE_ERROR_PATH", "Erreur dans le chemin du fichier, le fichier ne sera pas mis &agrave; jour");
define("_MD_MAJFILE_SAVE_ERROR_BD", "Erreur lors de l'insertion dans la BD, le fichier ne sera pas mis &agrave; jour");
define("_MD_MAJFILE_SAVE_ERROR_WRITABLE", "Le fichier n'a pas les permissions pour &ecirc;tre mis &agrave; jour");
define("_MD_MAJFILE_SAVE_ERROR_DONTEXIST", "Le fichier n'existe pas");




define("_MD_DBRIGHTS_CREATEFOLDER", "Cr&eacute;ation de r&eacute;pertoire");
define("_MD_DBRIGHTS_MODFOLDER", "Modification de r&eacute;pertoire");
define("_MD_DBRIGHTS_ERASEFOLDER", "Supression de r&eacute;pertoire");
define("_MD_DBRIGHTS_CREATEFILE", "Cr&eacute;ation de fichier");
define("_MD_DBRIGHTS_MODFILE", "Modification de fichier");
define("_MD_DBRIGHTS_ERASEFILE", "Supression de fichier");
define("_MD_DBRIGHTS_ACCESSFOLDER", "Acc&egrave;s au r&eacute;pertoire");

?>
