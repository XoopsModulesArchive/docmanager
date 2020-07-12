
Documentation pour le module docmanager Version 1.1.0

Jeff Saucier

   <jsaucier _AT_ infostrategique _DOT_ com>
     _________________________________________________________

   Table des matières
   ChangeLog
   Informations
   Installation

        Pré requis
        Installation
        Extras
     _________________________________________________________

ChangeLog

   Je  recommande  de faire la mise à jour version cette nouvelle
   version. Simplement copier les fichiers par dessus les autres (ne
   pas oublier les fichiers dans le répertoire "tools" et "scripts").

   Voici ce qui a changé depuis la dernière version :

     * Meilleur retour d'erreur quand le répertoire sur le disque n'a
       pas les bonnes permissions
     * Vous pouvez maintenant voir dans l'interface d'administration si
       tout est correct
     * Correction de bugs
     _________________________________________________________

Informations

   Ce  module permet d'opérer un centre de documentation pour les
   utilisateurs d'un site. Il permet :

     * La recherche plein texte avec l'intégration de swish-e
     * Le résumé d'un texte avec l'intégration d'Open Text Summarizer
     * La  gestion  des  droits  ( présentement seulement sur les
       répertoires )
     * De rendre un répertoire caché ou visible
     * Création/modification/suppression de répertoires/fichiers

   Ce module a été développé pour l'extranet du CRISP et est distribué
   sous license GPL.
     _________________________________________________________

Installation

Pré requis

   Ce module a été testé avec les configurations suivantes. D'autres
   configurations peuvent sûrement être supportées :

     * Xoops 2.0.7.x et 2.0.9.x
     * Linux et Apache
     * Open    Text    Summarizer    pour    les    sommaires   (
       http://libots.sourceforge.org )
     * Swish-E pour les recherches plein texte ( http://www.swish-e.org
       )

   Si vous pensez utiliser les recherches plein texte et les sommaires,
   vous  devez  avoir les utilitaires suivants pour convertir les
   fichiers :

     * pdftotext ( http://www.glyphandcog.com/ )
     * ps2ascii
     * links ( http://links.sourceforge.net/ )
     * catdoc ( http://www.45.free.net/~vitus/ice/catdoc/ )
     * ppthtml ( http://chicago.sourceforge.net/xlhtml/ )

   Vous pouvez toujours éditer le fichier ots_script.php pour changer
   les programmes utilisés.
     _________________________________________________________

Installation

   Pour installer ce module, vous devez commencer par le décompresser.
   Un répertoire "docmanager" sera créé.

   Copiez ce répertoire dans le répertoire des modules de Xoops et
   aller l'activer dans l'interface d'administration de Xoops.

   Maintenant, vous devez créer un répertoire sur le disque de votre
   serveur qui contiendra les fichiers du centre de documentation. Je
   vous recommande de créer ce répertoire en dehors du répertoire web
   afin de garder l'accès aux documents sécuritaire.

   Un  fois  le  répertoire  créé, vous devez maintenant créer un
   répertoire nommé "parent_folder" et un nommé "tools" (sans les
   guillemets)  dans le répertoire choisit plus haut. Ajustez les
   permissions  afin  que votre serveur web puisse écrire dans le
   répertoire "parent_folder".

   Alors, pour résumer le tout, si vous avez choisit de mettre vos
   fichiers dans le répertoire "/var/www/uploads", voici le résultat
   final avec les permissions :
jeff@portable docmanager $ ls -ld /var/www/uploads/
drwxr-xr-x  2 root   root   4096 Nov 22 11:53 uploads

jeff@portable docmanager $ ls -l /var/www/uploads/
drwxr-xr-x  3 apache apache 4096 Nov 22 13:35 parent_folder
drwxr-xr-x  2 root   root   4096 Nov 22 11:53 tools

   Maintenant, copiez les deux fichiers dans le répertoires "tools" de
   docmanager dans le nouveau répertoire "tools" que vous venez de
   créer et effacer le répertoire "tools" de docmanager.

   Copier le fichier "sentence_filter.pl" du répertoire "scripts" dans
   votre chemin système (PATH) et rendez le exécutable.

   Après avoir fait ces étapes, allez dans la page de configuration de
   docmanager dans Xoops et inscrivez le répertoire choisit plus haut
   et cliquez sur "Valider".

   Quand la page revient, vous devrez voir quatres "OK". Si vous ne les
   voyez pas, vous avez fait de quoi de pas correct. SVP, revérifiez
   les étapes précédentes.

   Si  vous  voyez  que des "OK", vous pouvez maintenant utiliser
   docmanager!

   NOTE:   Assurez   vous   que   les   PATH   dans   le  fichier
   include/search.inc.php et tools/ots_script.php sont correct. La
   prochaine version validera ceci automatiquement.

   NOTE: Effacez le répertoire "scripts" de docmanager. Le contenu de
   ce répertoire est expliqué dans la section Extras.
     _________________________________________________________

Extras

   Si vous pensez utiliser ppthtml (
   http://chicago.sourceforge.net/xlhtml/ ), une patch est disponible
   dans le répertoire "scripts" pour corriger un problème avec les noms
   de répertoires longs.

   Si vous regarder dans le répertoire "scripts", vous verres quatres
   scripts. Ces script ont été fait spécifiquement pour le CRISP mais
   peuvent être utile pour vous aider à faire vos propres scripts.
   Voici une explication rapide de chaques scripts :

     * sentence_filter.pl : À mettre dans le path du système afin
       d'augmenter l'efficacité des résumés. Fait simplement un tri
       dans un texte afin d'éléminer le plus de "junk" possible
     * cron.swish-e : Script cron qui permet d'indexer le contenu du
       centre de documentation de faÃ§on incrémentale
     * cron.swish-e.weekly : Script cron qui réindex le contenu au
       complet du centre de documentation
     * import_folders.php : Script pour importer un répertoire dans le
       centre de documentation. À placer dans un répertoire directement
       dans la racine de Xoops et exécuter avec le navigateur.

   Si  vous  pensez  utiliser  OTS,  vous devez copier le fichier
   "sentence_filter.pl" et le rendre exécutable dans le path de votre
   système.

   N'oubliez pas, vous devez effacer le répertoire "scripts" pour
   assurer une meilleur sécurité du module.
