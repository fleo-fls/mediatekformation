# Mediatekformation - Extension Back-Office
## Présentation
Ce dépôt est une extension du projet initial Mediatekformation.<br> Il conserve les fonctionnalités de consultation pour le public tout en ajoutant une interface d'administration sécurisée pour la gestion du catalogue.<br>
Dépôt d'origine : Vous pouvez retrouver le projet initial et sa présentation complète ici :
https://github.com/CNED-SLAM/mediatekformation
## Fonctionnalités Ajoutées (Back-Office)
Ajout d'une partie Admin, permettant aux gestionnaires de la médiathèque de mettre à jour le contenu sans passer par la base de données.<br>
Tapez /admin dans l'url pour accéder au formulaire d'identification.<br>
<img width="2794" height="461" alt="Capture d&#39;écran 2026-03-10 221501" src="https://github.com/user-attachments/assets/a7dfd119-77e7-4947-98fd-2af2769103d5" />
<img width="1526" height="1218" alt="Capture d&#39;écran 2026-02-22 130020" src="https://github.com/user-attachments/assets/139ebed3-2cdf-4857-8a3b-8508b7aaa4c6" />
### 1. Gestion des Formations
Une nouvelle interface permet de lister toutes les formations avec des options de modification et de suppression.<br>
<img width="2691" height="1531" alt="Capture d&#39;écran 2026-03-10 221339" src="https://github.com/user-attachments/assets/d223997e-a8e9-4e1f-9328-76f024232e13" />
Ajout/Modification : Formulaire complet pour éditer le titre, la description, la vidéo YouTube (via son ID) et la playlist associée.<br>
Suppression : Possibilité de retirer une formation obsolète du catalogue.<br>
### 2. Gestion des Playlists
Une nouvelle interface permet de lister toutes les playlists avec des options de modification et de suppression.<br>
<img width="2720" height="573" alt="Capture d&#39;écran 2026-03-10 221737" src="https://github.com/user-attachments/assets/eac9602f-b14e-445e-8163-75cd99556f24" />
Création : Ajout de nouvelles playlists thématiques.<br>
<img width="2720" height="570" alt="Capture d&#39;écran 2026-03-10 221750" src="https://github.com/user-attachments/assets/e6961b86-b8ff-4e0c-b5aa-ceee1525fa09" />
Édition : Modification du nom et de la description des playlists existantes.<br>
<img width="2744" height="582" alt="Capture d&#39;écran 2026-03-10 221814" src="https://github.com/user-attachments/assets/0a3cf7f7-6e3c-4789-81d4-3bd7c12e64e0" />
Suppression : Suppression sécurisée (vérification si la playlist contient des vidéos).<br>
### 3. Gestion des Catégories
Liste des catégories, possibilité d'ajout de categorie<br>
<img width="2313" height="597" alt="Capture d&#39;écran 2026-03-10 222506" src="https://github.com/user-attachments/assets/4b766b48-c87b-4301-90b2-cc85b0ac6c3d" />
Possibilité de suppression d'une categorie si celle ci ne contient plus de formation, sinon le bouton de suppression reste grisé.<br>
### Installation et Utilisation en Local
Prérequis:<br> Assurez-vous d'avoir installé WampServer, Composer et Git.<br>
Clonage et Préparation:<br> Clonez le dépôt dans votre dossier www : git clone [https://github.com/fleo-fls/mediatekformation] mediatekformation.<br>
Ouvrez un terminal dans le dossier et lancez : composer install. Cela va crer le dossier vendor indispensable au bon fonctionnement de l'application.<br>
Base de données:<br> Créez une base de données nommée mediatekformation dans phpMyAdmin.<br>
Importez le fichier mediatekformation.sql situé à la racine du projet.<br>
Configuration:<br> Modifier ou créer le fichier .env (pour des raison de sécurité il n'est pas dans le dépot) et adaptez la ligne DATABASE_URL avec vos identifiants locaux.<br>
Accédez à l'application via : http://localhost/mediatekformation/public/index.php

