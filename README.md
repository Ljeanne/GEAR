# GEAR

#Initialisation du projet
## 1) mettre à jours les dépendances :
###composer install
## 2) Démarrer le serveur : php bin/console server:run

#DATABASE
## 1) créer une base de donnée 
## 2) php bin/console doctrine:schema:update --force
## 3) php bin/console doctrine:fixture:load
## les utilisateurs et leur produits seront créé 

# ADMIN
## Pour accéder à l'admin : 127.0.0.1:8000/admin
## Il faut être authentifié comme un admin pour pouvoir l'utiliser
### Donner le admin à un utilisateur :
#### 1) php bin/console fos:user:promote user1
#### 2) donner le role ROLE_ADMIN 

