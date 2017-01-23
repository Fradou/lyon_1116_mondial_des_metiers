Tag ton métier
=====
Application de vote destinée au Mondial des métiers de Lyon.

Deploiement :
1) Cloner repository
2) Verifier que les fuseaux horaires sont actifs dans le php.ini
3) composer install
4) doctrine:database:create
5) doctrine:schema:update  
    En cas de problème "AppKernel ligne 19", relancer composer install, FOSUser ne s'est pas installé correctement.
6) Importer base de données
6) assets:install --symlink
7) Mettre droit serveur sur app/cache et app/log