# Fonctionnement Général

### Partie Back office

#### Le formbuilder

Tout le fonctionnement du back office, repose sur le form builder.  
Le back office sert à saisir du contenu, et ceci se fait par le biais de formulaire. Je n'ai pas eu envi d'écrire les formulaires en dur, je ne trouvais pas ça forcément intéressant, et répétitif.

J'ai alors opté pour un moyen plus dynamique. 

Le foncionnement du formbuilder repose  sur une logique faite en Javascript, qui peut générer des formulaires de 2 façon:

*  depuis un fichier de configuration en JSON \(formulaire de  création de contenu, options de départ, formulaire de création / édition d'un modèle déjà construit,
* soit dynamiquement en JS \(ajout de nouveau champ dans le formulaire de création  d'un contenu\)

En effet, lorsqu'on clique sur le bouton "Ajouter un nouveau type de contenu", on peut choisir quel type de contenu créer:

* Settings =&gt; sera placé dans la partie Setttings de la nav bar
* Taxonomy =&gt; permet d'enrichir un contenu, et de le catégoriser
* Content =&gt; Est un contenu riche que l'on affichera en front, et catégorisable

Suite à cela, on peut ajouter tous les types de champs que l'on souhaites pour  créer ce contenu:

* Text
* Date
* Textarea
* Select
* Entity-Référence \(liaison à une taxonomy\)
* Checkbox
* Radio

Une fois  que l'on a créé  la structure \(modèle\) de notre contenu, on valide le formulaire et voici les actions qui sont faites ensuite:

* Validation de la saisie utilisateur
* split des données et formatage
* création de la table correspondante à ce contenu avec toutes les colonnes  \(1colonne = 1 champ\)
* création de l'entrée de menu en fonction de l'option  qui a été choisie \(Settings, Taxonomy ou Content\)
* création d'un fichier de configuration  du formulaire d'édition en JSON

Lors de la création / édition d'un contenu, le fichier JSON du contenu est récupéré, hydraté avec les données récupérées depuis la BDD \(si c'est une édition\), ensuite un fichier temporaire est créé afin de ne pas risque de casser le modèle  JSON de ce contenu, puis le formulaire de création / édition construit grâce au code JS.

A la soumission du formulaire, le fichier temporaires est supprimé;

