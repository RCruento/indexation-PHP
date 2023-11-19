# Cahier des Charges - Projet d'Indexation de Documents

## Introduction

Ce cahier des charges détaille les spécifications du projet d'indexation de documents. L'objectif principal est de permettre la recherche de documents en fonction de mots-clés et d'afficher un nuage de mots-clés associé à chaque document.

## Fonctionnalités

1. **Indexation de Documents :**
   - Le système doit être capable de parcourir un ensemble de documents HTML.
   - Extraction du titre, de la description, des mots-clés et du corps du document.

2. **Traitement des Mots-Clés :**
   - Les mots-clés extraits doivent être nettoyés et filtrés.
   - Attribution de poids aux mots en fonction de leur fréquence.

3. **Recherche de Documents :**
   - Un formulaire de recherche permet aux utilisateurs de rechercher des documents par mot-clé.
   - Affichage des résultats de la recherche avec le titre, la source, la description et le poids.

4. **Affichage du Nuage de Mots-Clés :**
   - Pour chaque document, un bouton permet d'afficher un nuage de mots-clés.
   - Utilisation de D3.js pour générer le nuage de mots-clés.

## Technologies Utilisées

- **Frontend :**
  - HTML, CSS, Bootstrap
  - JavaScript, jQuery
  - D3.js pour le nuage de mots-clés

- **Backend :**
  - PHP pour le traitement des données
  - MySQL pour la gestion de la base de données

## Structure du Projet

- **`index.php` :** Page principale avec la barre de navigation, formulaire de recherche et affichage des résultats.
- **`assets/` :** Dossier contenant les fichiers CSS, JavaScript, et les bibliothèques tierces.
- **`assets/php/` :** Dossier contenant les scripts PHP pour le traitement des données.
- **`documents/` :** Dossier contenant les documents HTML à indexer.

## Installation

1. Clonez le dépôt : `git clone [URL_DU_REPO]`
2. Importez la base de données à partir du fichier SQL fourni.
3. Configurez la connexion à la base de données dans `assets/php/fonction.php`.
4. Lancez le projet via un serveur local.

## Utilisation

1. Accédez à la page d'indexation : `http://localhost/chemin/vers/index.php`
2. Utilisez le formulaire de recherche pour trouver des documents.
3. Cliquez sur le bouton pour afficher le nuage de mots-clés associé à chaque document.

## Explications des Fonctions PHP

### `connexionBD()`

Cette fonction établit une connexion à la base de données MySQL et la renvoie.

### `getBody($modele, $chaine_html)`

Extrait le corps d'une page HTML en utilisant un modèle regex et le renvoie.

### `traitementElement($separateurs, $chaine)`

Divise une chaîne en mots en filtrant les mots vides et courts. Utilise la liste de mots vides définie dans le fichier `assets/dictionnaire.txt`.

### `poids($tabl_occurrences, $coeficient)`

Attribue des poids aux mots en fonction de leur occurrence. Calcul du poids en multipliant l'occurrence par un coefficient.

### `getDescription($source)`, `getKeywords($source)`, `getTitle($modele, $chaine)`

Ces fonctions extraient respectivement la description, les mots-clés et le titre d'une page HTML en utilisant des modèles regex.

### `Unaccent($txt)`

Supprime les accents des caractères d'une chaîne en utilisant la classe `Transliterator`.

### `PDL($dossier)`, `traitement($source)`

La fonction `PDL` parcourt le dossier spécifié et appelle la fonction `traitement` pour chaque fichier HTML trouvé. La fonction `traitement` effectue le nettoyage du HTML, extrait les données pertinentes, calcule les poids des mots et les insère dans la base de données.

