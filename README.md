Tag ton métier
=====
Application de vote destinée au Mondial des métiers de Lyon.  
  
#### Deploiement :  
1) Cloner repository   
2) Verifier que les fuseaux horaires sont actifs dans le php.ini (et l'url rewriting ?)  
3) composer install  
4) doctrine:database:create  
5) doctrine:schema:update    
    En cas de problème "AppKernel ligne 19", relancer composer install, FOSUser ne s'est pas installé correctement.  
6) Importer base de données  
7) assets:install --symlink  
8) Mettre droit serveur sur app/cache et app/log

#### Déploiement : étape 2 :

1) sudo apt install php7.0-apcu  
2) sudo apt install php7.0-apcu-bc  
3) Aller vérifier que les modules sont biens dans mods-available de apache2 et CLI.   
Sur Debian 8 les symlinks devraient être déjà fait, si symlink manquant faire 4, sinon aller directement à 5.   
4) Créer apcu.ini et apc.ini s'ils ne sont pas présent dans php/7.0/mods-available :  
=> Un apcu.ini avec extension=apcu.so  
=> Un apc.ini avec extension=apc.so  
Puis faire les symlink depuis les conf.f de apache2 et cli.    
5) Dans php.ini, rajoutez les lignes suivantes :    
apc.shm_size=264    
apc.entries_hint=75000   
apc.ttl=60  
6) Relancer apache.  
7) Faire un pull du master. En cas de problème pour l'installation des modules apcu & apc, passer sur la branche master_noapcu  
8) Recupérer dump tables bdd answer.sql et job.sql puis les importer dans la base existante (chaque dump contient une seule table).  
9) Refaire un schema:update au cas où.    

Optionnel : 
* sudo apt install php7.0-dev
* Si utile : composer dump-autoload --optimize --no-dev --classmap-authoritative