# Cahier des Charges - Système d'Indexation de Documents
	1. Introduction
		1.1 Objectif du Projet
Le projet vise à concevoir et développer un système d'indexation de documents, permettant la gestion, l'analyse et la recherche avancée de documents textuels au sein d'une base de données. L'objectif est de fournir aux utilisateurs une plateforme conviviale pour explorer et retrouver des informations pertinentes à partir de documents HTML.

	1.2 Contexte
Le système sera utilisé dans le cadre de la gestion de documents en ligne, où des utilisateurs pourront télécharger, indexer et rechercher des documents textuels. L'accent sera mis sur l'analyse approfondie du contenu des documents, l'attribution de poids aux termes clés et la fourniture d'une interface utilisateur intuitive pour la recherche.

	2. Fonctionnalités Principales
		2.1 Gestion des Documents
			2.1.1 Téléchargement de Documents
Les utilisateurs peuvent télécharger des documents au format HTML via une interface dédiée.
			2.1.2 Analyse des Documents
Les documents HTML seront analysés pour extraire le contenu textuel pertinent.
Nettoyage du HTML pour éliminer les balises, scripts et styles superflus.
			2.1.3 Extraction des Métadonnées
Extraction des métadonnées telles que le titre, la description et les mots-clés à partir des balises meta.
		2.2 Indexation des Documents
			2.2.1 Segmentation en Mots
Le contenu des documents sera segmenté en mots en filtrant les mots vides et courts.
			2.2.2 Attribution de Poids
Attribution de poids aux mots en fonction de leur fréquence d'occurrence.
Coefficients de poids différenciés pour les mots provenant des titres, descriptions et corps des documents.
			2.2.3 Stockage en Base de Données
Création de tables de base de données pour stocker les informations sur les documents, les mots et les relations entre eux.
		2.3 Recherche de Documents
			2.3.1 Interface de Recherche
Les utilisateurs peuvent effectuer des recherches en entrant des mots-clés dans une interface conviviale.
Prise en charge de la recherche avancée avec opérateurs logiques.
			2.3.2 Résultats de Recherche
Affichage des résultats de recherche avec des informations clés sur chaque document.
Possibilité de trier les résultats par pertinence ou date.
		2.4 Nuage de Mots-Clés
			2.4.1 Génération Dynamique
Génération dynamique d'un nuage de mots-clés représentant les termes les plus pertinents pour chaque document.
			2.4.2 Interaction Utilisateur
Les utilisateurs peuvent visualiser le nuage de mots-clés associé à un document spécifique.
	3. Spécifications Techniques
		3.1 Langages et Technologies
			3.1.1 Côté Serveur
PHP pour la logique serveur et la connexion à la base de données.
MySQL comme base de données relationnelle.
			3.1.2 Côté Client
HTML, CSS et Bootstrap pour l'interface utilisateur.
JavaScript avec D3.js pour la création dynamique des nuages de mots-clés.
		3.2 Fonctions PHP
			3.2.1 Fonctions d'Analyse des Documents
getBody($modele, $chaine_html) : Extraction du corps d'une page HTML à l'aide d'un modèle regex.
traitementElement($separateurs, $chaine) : Division d'une chaîne en mots en filtrant les mots vides et courts.
getDescription($source) : Récupération de la balise meta "description".
getKeywords($source) : Récupération de la balise meta "keywords".
getTitle($modele, $chaine) : Récupération du titre d'une page HTML via un modèle regex.
			3.2.2 Fonctions d'Indexation
poids($tabl_occurrences, $coeff) : Attribution de poids aux mots en fonction de leur occurrence.
			3.2.3 Fonctions de Connexion à la Base de Données
connexionBD() : Établissement de la connexion à la base de données MySQL.
	4. Sécurité
		4.1 Protection contre les Attaques
			4.1.1 Requêtes Préparées
Utilisation généralisée de requêtes SQL préparées pour prévenir les attaques par injection SQL.
			4.1.2 Validation des Données
Validation rigoureuse des données entrantes pour assurer la sécurité du système.
	5. Interface Utilisateur
		5.1 Pages Principales
			5.1.1 Page d'Accueil
Présentation du système, informations sur la procédure de téléchargement et d'indexation.
			5.1.2 Interface de Recherche
Zone de recherche avec options avancées.
Affichage des résultats avec liens vers les documents.
			5.1.3 Visualisation de Document
Affichage détaillé d'un document, y compris le nuage de mots-clés associé.
	6. Maintenance et Évolutivité
		6.1 Documentation
			6.1.1 Documentation du Code
Commentaires détaillés pour chaque section du code.
Guide d'installation et de configuration.
			6.1.2 Manuel d'Utilisateur
Documentation utilisateur complète pour une utilisation optimale du système.
		6.2 Possibilité d'Extension
			6.2.1 Structure Modulaire
Conception modulaire permettant l'ajout facile de nouvelles fonctionnalités.
Prise en charge de la croissance future et de l'ajout de nouvelles fonctionnalités.
