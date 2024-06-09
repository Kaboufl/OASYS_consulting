# OASYS Consulting

OASYS Consulting, agence de développement de projets informatiques, a pour mission de concevoir des solutions digitales sur-mesure pour ses clients. Afin d'optimiser sa gestion de projet interne et d'accroître la collaboration entre ses équipes, OASYS Consulting a développé une application web métier type statique. Elle fait parfois appel à des sous-traitants pour compléter certaines tâches.

Notre mission est de créer une application web type statique permettant aux différents intervenants d'OASYS Consulting de gérer efficacement les projets et d'en assurer un suivi rigoureux.

Cette application centralise les informations relatives aux projets, automatise des tâches et offre des fonctionnalités dédiées à chaque type d'utilisateur : administrateurs, chefs de projet et intervenants.

Fonctionnalités clés de l'application :

- Gestion centralisée des projets : Création, modification, suppression et consultation des projets, avec suivi des étapes et des interventions.
- Affectation des ressources : Assignation des chefs de projet et des intervenants aux projets et aux étapes.
- Suivi des interventions : Enregistrement des dates de début et de fin, des commentaires et des pièces jointes pour chaque intervention.
- Statistiques et reporting : Consultation de tableaux de bord et de rapports pour analyser les données des projets et suivre leur avancement.
- Interfaces utilisateur dédiées : Des interfaces ergonomiques et intuitives conçues pour répondre aux besoins spécifiques de chaque type d'utilisateur.

## Interprétation du cahier des charges

## Les domaines

Un domaine est un moyen de catégoriser les projets, les principaux domaines sont :
 - Formation
 - Systèmes et Réseaux
 - Développement
 - Infogérance

### Les projets

Les projets ont un nom (libellé), ils sont rattachés à un [domaine](#les-domaines) et au compte client qui a commandité ce dernier. Ils ont également un statut et un taux horaire négocié en amont avec le client.

Les projets ont un chef de projet assigné, ce chef de projet est **forcément** un salarié d'OASYS Consulting.

### Les étapes

Les projets sont segmentés en étapes pour garantir une traçabilité optimale de l'avancement du projet. Les étapes ont un libellé et sont facturées directement au client.

### Les interventions

Les interventions référencent l'étape et le membre du personnel responsable de l'intervention, avec un suivi des dates de début et de fin

## L'architecture de l'application

L'application devra proposer différentes interfaces à différents types d'utilisateurs :

 - Un portail administrateur
    - Gestion des clients, des projets ainsi que du personnel
    - Assigne les chefs de projets
 - Chef de projet
    - Gestion du projet (ses différents étapes et leurs interventions associées)
    - Affectation des intervenants / prestataires externes aux interventions
    - Possibilité de voir quelle est la part d'intervenants internes et externes
 - Intervenant
    - Possibilité de modifier le commentaire de suivi de l'intervention assignée

## Stack technique du projet

Pour faire ce site statique, j'ai choisi de partir sur une solution de type PHP, plus particulièrement avec le framework [Laravel](https://laravel.com/) constituant une base solide à partir de laquelle développer
un projet. Une base de données MySQL assurera le stockage des informations de l'application, elle sera accédée par l'application via Eloquent, l'ORM de Laravel qui permet de créer des modèles
et ainsi travailler sur la base de données en conservant une syntaxe de programmation orientée objet.

Le serveur de développement utilise Docker afin de minimiser l'impact de l'environnement système sur le fonctionnement de l'application. J'utilise l'image [Laravel Sail](https://laravel.com/docs/10.x/sail#installation)
offrant un environnement de développement complet pour un projet Laravel. Le serveur de développement utilise Vite, qui permet une expérience de développement plus fluide grâce au Hot Module Replacement.

Pour le design des interfaces, le package [Tailwind CSS](https://tailwindcss.com/) est utilisé conjointement avec Vite pour générer le fichier CSS à la volée

## Fonctionnalités et interfaces utilisateur

L'interface utilisateur de l'administrateur est la plus complète de l'application, il a accès à :
- Consultation, création, modification et suppression des clients
- Consultation, création, modification et suppression des projets
- Consultation, création, modification et suppression des étapes
- Consultation, création, modification et suppression des interventions
- Consultation, création, modification et suppression des intervenants (salariés / prestataires externes)
- Consultations de statistiques sur les projets

Celle du chef de projet permet :
 - Consultation du projet assigné
 - Consultation et création des étapes du projet
 - Consultation et création des interventions des étapes
 - Assignation d'un intervenant sur l'intervention

Celle de l'intervenant permet :
 - Consultation et modification du commentaire de l'intervention assignée
