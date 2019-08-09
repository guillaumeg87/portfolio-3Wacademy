# Portfolio-3WAcademy **_(en cours..._**)
**_Ce portfolio est réalisé dans le cadre de ma formation à la [3WAcademy](https://3wa.fr/)_**

**_Contraintes:_**
Projet "from scratch" utilisant les 5 langages enseignés à la 3WAcademy:
          * HTML
          * CSS
          * Javascript
          * PHP
          * MySQL
         
## INSTALLATION DU PROJET

Ouvrir le terminal et cloner le projet : 
```
git clone git@github.com:guillaumeg87/portfolio-3Wacademy.git
```

Avoir un serveur local ou utiliser cet environnement local utilisant Docker : 
```
git clone git@github.com:mattcontet/environment.git
```
## BASE DE DONNEES

Ouvrez le projet dans votre navigateur, le projet va se charger de vous installer la base de donnéee, avec les informations que vous indiquerez dans le formulaire d'nstallation.
 
## WEBPACK

Ce projet utilise les fonctions sommaires de [WEBPACK](https://webpack.js.org/), et de gérer les assets au même endroit avec le même outil:
- utilisation de [SASS](https://sass-lang.com/), compilation et minification du css 
- Traduction du JS ES6 en ES 5 avec [Babel](https://babeljs.io/)
- Minification du JS avec Uglify

// @TODO à regarder, minification des images...

__Installation de Webpack:__
 
Installer [Node JS](https://nodejs.org/en/) et NPM, si on ne les a pas déjà.

Installer Webpack :
```  
npm install --save-dev webpack@latest webpack-dev-server@latest
npm install -g webpack@latest
```
Installer Babel:
```
npm install --save-dev gulp-babel @babel/core @babel/preset-env
```

Installer les dépendances pour le css:
```
npm i --save-dev sass-loader node-sass css-loader style-loader autoprefixer postcss-loader
npm install --save-dev mini-css-extract-plugin
```

Installer Webpack server : 
```
npm install webpack-dev-server --save-dev
```

Installer Webpack Dashboard (voir les executions de webpack un peu mieux présentées...)
```
npm install webpack-dashboard --save-dev
```
### Utilisation de Webpack pendant le dev

Commande permettant de convertir le SCSS en CSS à haque sauvegarde:
```
npm run watch
```

**_Automatisation en phase de dev:_**
- Compilation du SASS en CSS
- Compilation du JS ES6 en ES5
- Vue des actions de Webpack dans le dashboard
```
npm run start
```

Minifier les assets pour la prod : 
```
npm run prod
```



__Notes:__ 

Avec Webpack 4 *ExtractTextWebpackPlugin* est déprécié,utiliser [Mini Css Extract Plugin](https://webpack.js.org/plugins/mini-css-extract-plugin/#root)

Ajout du fichier Webpack 4 [.babelrc](https://stackoverflow.com/questions/52092739/upgrade-to-babel-7-cannot-read-property-bindings-of-null/52092788)



__Sources à conserver pour webpack:__ 

https://www.sitepoint.com/webpack-beginner-guide/

https://www.alsacreations.com/tuto/lire/1754-debuter-avec-webpack.html

https://github.com/babel/gulp-babel/issues/124