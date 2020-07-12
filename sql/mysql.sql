CREATE TABLE docmanager_configs (
  configs_id int(10) NOT NULL auto_increment,
  configs_path VARCHAR(255) NOT NULL,
  PRIMARY KEY  (configs_id)
) TYPE=MyISAM COMMENT='Configs Table';

INSERT INTO docmanager_configs VALUES (1,'/var/www/uploads');

CREATE TABLE docmanager_files (
  files_id int(10) NOT NULL auto_increment,
  files_name varchar(255) NOT NULL default '',
  files_nameondisk varchar(255) NOT NULL default '',
  files_type VARCHAR(10) NOT NULL,
  files_space int(10) NOT NULL default '0',
  files_createddate int(10) unsigned NOT NULL default '0',
  files_modificationdate int(10) unsigned NOT NULL default '0',
  files_owner mediumint(8) NOT NULL default '0',
  files_usermod mediumint(8) NOT NULL default '0',
  files_foldersid int(10) NOT NULL default '0',
  PRIMARY KEY  (files_id)
) TYPE=MyISAM COMMENT='Files Table';

CREATE TABLE docmanager_folders (
  folders_id int(10) NOT NULL auto_increment,
  folders_name varchar(255) NOT NULL default '',
  folders_nameondisk varchar(255) NOT NULL default '',
  folders_createddate int(10) unsigned NOT NULL default '0',
  folders_modificationdate int(10) unsigned NOT NULL default '0',
  folders_inheritrights tinyint(1) NOT NULL default '0',
  folders_hidden BIT NOT NULL,
  folders_owner mediumint(8) NOT NULL default '0',
  folders_usermod mediumint(8) NOT NULL default '0',
  folders_parent_id int(10) NOT NULL default '0',
  PRIMARY KEY  (folders_id)
) TYPE=MyISAM COMMENT='Folders Table';

INSERT INTO docmanager_folders VALUES (1,'_MD_PARENTFOLDER','parent_folder',0,0,0,0,0,0,0);

CREATE TABLE docmanager_rights (
  rights_id int(10) NOT NULL auto_increment,
  rights_code varchar(10) NOT NULL default '',
  rights_name varchar(255) NOT NULL default '',
  rights_applied_to_folders tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (rights_id)
) TYPE=MyISAM COMMENT='Rights Table';

INSERT INTO docmanager_rights VALUES (1,'CR','_MD_DBRIGHTS_CREATEFOLDER',1),(2,'MR','_MD_DBRIGHTS_MODFOLDER',1),(3,'SR','_MD_DBRIGHTS_ERASEFOLDER',1),(4,'CF','_MD_DBRIGHTS_CREATEFILE',1),(5,'MF','_MD_DBRIGHTS_MODFILE',1),(6,'SF','_MD_DBRIGHTS_ERASEFILE',1),(7,'AR','_MD_DBRIGHTS_ACCESSFOLDER',1);
