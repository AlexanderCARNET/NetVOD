# Deefy - Projet (S3)



## Groupe

- Hugo Antzorn

- Walid Bouaoukel

- Alexander Carnet

- Florian Hannezo

- Ilias Boudouah  



## Description



NetVOD est une application web développée en PHP permettant la diffusion de séries à la demande.

Les utilisateurs peuvent créer un compte, sélectionner un profil, parcourir un catalogue de séries, consulter les fiches des épisodes, reprendre la lecture et gérer leurs listes personnalisées :



Séries en cours

Séries terminées

Favoris



## Installation



### 1 Cloner le projet dans le dossier de votre serveur local

- git clone https://github.com/AlexanderCARNET/NetVOD.git

- cd NetVOD


###  2 Installer les dépendances PHP avec Composer :

composer install


###  3 Importer la base de données

Depuis phpMyAdmin : importer le fichier "database.sql"



###  4 Créer le fichier de configuration à partir de l’exemple

cp Config.db.exemple.ini Config.db.ini


###  5 Ouvrir le fichier Config.db.ini et renseigner vos informations

Exemple :

&nbsp;- driver=mysql

&nbsp;- username=root

&nbsp;- password=""

&nbsp;- host=localhost

&nbsp;- database=NomDeVotreBase



###  6 Lancer votre serveur local (ex: XAMPP)

&nbsp;puis ouvrir le projet dans le navigateur :

&nbsp;http://localhost/NetVOD/



## Comptes de test



| Email | Mot de passe |

|--------|---------------|
| user1@mail.com| 0123456789 |



## Documents


- `database.sql` → script de création et d’insertion







