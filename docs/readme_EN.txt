
Documentation for the docmanager module Version 1.1.0

Jeff Saucier

   <jsaucier _AT_ infostrategique _DOT_ com>
     _________________________________________________________

   Table of Contents
   ChangeLog
   Informations
   Installation

        Requirements
        Module installation
        Extras
     _________________________________________________________

ChangeLog

   I recommend to update to this new version. Simply overwrite the
   files  for  the module (don't forget the "tools" and "scripts"
   folder).

   Here is what change since the last version :

     * Better  error  reporting  when folder don't have the right
       permissions on disk
     * In the administration interface, you can now see if everything
       is OK
     * Bugs corrections
     _________________________________________________________

Informations

   This module allow you to operate a documentation center that user
   can access. It allow :

     * Full text search with swish-e integration
     * Summary with Open Text Summarizer integration
     * Rights administration ( only on folders for the moment )
     * Hide or show folder
     * Create/modify/delete folders/files

   This  module has been developped for the CRISP extranet and is
   released with the GPL license.
     _________________________________________________________

Installation

Requirements

   This module has been tested with the following configurations. It
   may work on other plateforme and configurations :

     * Xoops 2.0.7.x and 2.0.9.x
     * Linux and Apache
     * Open     Text     Summarizer    for    the    summary    (
       http://libots.sourceforge.org )
     * Swish-E for the full text search ( http://www.swish-e.org )

   If you plan to use the full text search and summary features, you
   must convert file to text with the following utilities :

     * pdftotext ( http://www.glyphandcog.com/ )
     * ps2ascii
     * links ( http://links.sourceforge.net/ )
     * catdoc ( http://www.45.free.net/~vitus/ice/catdoc/ )
     * ppthtml ( http://chicago.sourceforge.net/xlhtml/ )

   You can always edit the ots_script.php page to change the program
   that I use to convert file.
     _________________________________________________________

Module installation

   To install this module, first untar or unzip it. It will create a
   folder named "docmanager".

   Copy this folder to the Xoops modules folder and activate the new
   module from the administration page.

   Now, you must create a folder on your server where you will put the
   file. I recommend to put this folder outside of your web path to
   keep the documents access secure.

   Now,  in  the  folder  you have created, create a folder named
   "parent_folder" and one named "tools" without the quotes. Adjust the
   permissions for the "parent_folder" folder to make it writable by
   your web server.

   So, to resume, if the folder you have choose to put the file is
   "/var/www/uploads", here is the final structure with permissions :
jeff@portable docmanager $ ls -ld /var/www/uploads/
drwxr-xr-x  2 root   root   4096 Nov 22 11:53 uploads

jeff@portable docmanager $ ls -l /var/www/uploads/
drwxr-xr-x  3 apache apache 4096 Nov 22 13:35 parent_folder
drwxr-xr-x  2 root   root   4096 Nov 22 11:53 tools

   Now, copy the two files of the "tools" folder of docmanager in the
   new "tools" folder you have just created and erase the folder from
   docmanager.

   Copy the "sentence_filter.pl" script from the "scripts" folder in
   your system PATH and make it executable.

   After setting the folder structure on the disk, go to the docmanager
   administration page and set the folder your have choosen in the text
   field and click "Validate".

   When the page refresh, you must see four "OK" appear. If not, you
   have do something wrong. Please doucle check the step below.

   If it's all OK, you can now use docmanager!

   NOTE:  Please  check  the  paths in include/search.inc.php and
   tools/ots_script.php. The next version will do it automatically.

   NOTE:  Delete the "scripts" folder from docmanager folder. The
   scripts in this folder is explain in the Extras section.
     _________________________________________________________

Extras

   If you plan to use ppthtml ( http://chicago.sourceforge.net/xlhtml/
   ), a patch is avaible in the "scripts" folder to fix a problem with
   long folders name.

   If you check in the "scripts" folder of docmanager, you will see
   some scripts. The scripts are targeted specially for the CRISP but
   you can have a good start to write your own. Here is an explanation
   of the scripts :

     * sentence_filter.pl : Put it in the system path. It allow to
       remove junk from text to ease OTS in doing better summary
     * cron.swish-e  : Allow you to do incremential index of your
       document
     * cron.swish-e.weekly : Allow you to do full reindex of your
       document
     * import_folders.php  :  Script  to  import  a folder in the
       documentation center. Put it in a folder directly in the Xoops
       path and launch it via your browser.

   If you plan to use OTS (Open Text Summarizer), you must copy and
   make  executable sentence_filter.pl in your PATH or change the
   ots_script.php file.

   Remember, you must erase the "scripts" folder to assure security of
   the module. Don't keep it on a running server.
