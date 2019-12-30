---
description: 'Read me du projet Github : https://github.com/guillaumeg87/portfolio-3Wacademy'
---

# Portfolio-3WAcademy

_**Ce portfolio est réalisé dans le cadre de ma formation à la**_ [_**3WAcademy**_](https://3wa.fr/)

_**Contraintes:**_ Projet "from scratch" utilisant les 5 langages enseignés à la 3WAcademy: \* HTML \* CSS \* Javascript \* PHP \* MySQL

[![project-version](https://camo.githubusercontent.com/5021b456a318623c290ed13fe0df6dd6e53ed4ec/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f50726f6a6563745f76657273696f6e2d302e302d7265642e737667)](https://camo.githubusercontent.com/5021b456a318623c290ed13fe0df6dd6e53ed4ec/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f50726f6a6563745f76657273696f6e2d302e302d7265642e737667) [![status](https://camo.githubusercontent.com/2221b6c81273585f47bd4e4402d7778ae65dee0c/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f5374617475732d696e5f646576656c6f706d656e742d626c75652e737667)](https://camo.githubusercontent.com/2221b6c81273585f47bd4e4402d7778ae65dee0c/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f5374617475732d696e5f646576656c6f706d656e742d626c75652e737667) [![php](https://camo.githubusercontent.com/f52b82f1eced1ec7dac2a1f8e2c4acd4948e77e6/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f7068702d372e332d626c756576696f6c65742e7376673f6c6f676f3d706870)](https://camo.githubusercontent.com/f52b82f1eced1ec7dac2a1f8e2c4acd4948e77e6/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f7068702d372e332d626c756576696f6c65742e7376673f6c6f676f3d706870) [![webpack](https://camo.githubusercontent.com/89b8e66a3a5b8ccb52eb980e4b5633e6fb0b7ebc/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f7765627061636b2d342e33392d79656c6c6f772e7376673f6c6f676f3d7765627061636b)](https://camo.githubusercontent.com/89b8e66a3a5b8ccb52eb980e4b5633e6fb0b7ebc/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f7765627061636b2d342e33392d79656c6c6f772e7376673f6c6f676f3d7765627061636b) [![sass](https://camo.githubusercontent.com/75abf4e371f91d04ea85eda5791a5ae17aea3a40/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f6373732d736173732d70696e6b2e7376673f6c6f676f3d73617373)](https://camo.githubusercontent.com/75abf4e371f91d04ea85eda5791a5ae17aea3a40/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f6373732d736173732d70696e6b2e7376673f6c6f676f3d73617373) [![framework](https://camo.githubusercontent.com/343507ef71916113d9e1a053045eda4c90273ee0/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f6672616d65776f726b2d66726f6d5f736372617463682d626c61636b2e737667)](https://camo.githubusercontent.com/343507ef71916113d9e1a053045eda4c90273ee0/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f6672616d65776f726b2d66726f6d5f736372617463682d626c61636b2e737667)

## INSTALLATION DU PROJET

Ouvrir le terminal et cloner le projet :

```text
git clone git@github.com:guillaumeg87/portfolio-3Wacademy.git
```

Avoir un serveur local ou utiliser cet environnement local utilisant Docker :

```text
git clone git@github.com:mattcontet/environment.git
```

## BASE DE DONNEES

Ouvrez le projet dans votre navigateur, le projet va se charger de vous installer la base de donnéee, avec les informations que vous indiquerez dans le formulaire d'nstallation.

## WEBPACK

Ce projet utilise les fonctions sommaires de [WEBPACK](https://webpack.js.org/), et de gérer les assets au même endroit avec le même outil:

* utilisation de [SASS](https://sass-lang.com/), compilation et minification du css
* Traduction du JS ES6 en ES 5 avec [Babel](https://babeljs.io/)
* Minification du JS avec Uglify

// @TODO à regarder, minification des images...

**Installation de Webpack:**

Installer [Node JS](https://nodejs.org/en/) et NPM, si on ne les a pas déjà.

Installer Webpack :

```text
npm install --save-dev webpack@latest webpack-dev-server@latest
npm install -g webpack@latest
```

Installer Babel:

```text
npm install --save-dev gulp-babel @babel/core @babel/preset-env
```

Installer les dépendances pour le css:

```text
npm i --save-dev sass-loader node-sass css-loader style-loader autoprefixer postcss-loader
npm install --save-dev mini-css-extract-plugin
```

Installer Webpack server :

```text
npm install webpack-dev-server --save-dev
```

Installer Webpack Dashboard \(voir les executions de webpack un peu mieux présentées...\)

```text
npm install webpack-dashboard --save-dev
```

### Utilisation de Webpack pendant le dev

Commande permettant de convertir le SCSS en CSS à haque sauvegarde:

```text
npm run watch
```

_**Automatisation en phase de dev:**_

* Compilation du SASS en CSS
* Compilation du JS ES6 en ES5
* Vue des actions de Webpack dans le dashboard

```text
npm run start
```

Minifier les assets pour la prod :

```text
npm run prod
```

### Debug PHP

J'ai créé un tout petit service de debug qui s'utilise de la façon suivante:

```text
Dumper::dump($var|'string');
```

Ceci permet d'avoir des var\_dump mieux formatés et plus lisible pour developer et débuguer

**Notes:**

Avec Webpack 4 _ExtractTextWebpackPlugin_ est déprécié,utiliser [Mini Css Extract Plugin](https://webpack.js.org/plugins/mini-css-extract-plugin/#root)

Ajout du fichier Webpack 4 [.babelrc](https://stackoverflow.com/questions/52092739/upgrade-to-babel-7-cannot-read-property-bindings-of-null/52092788)

**Sources à conserver pour webpack:**

[https://www.sitepoint.com/webpack-beginner-guide/](https://www.sitepoint.com/webpack-beginner-guide/)

[https://www.alsacreations.com/tuto/lire/1754-debuter-avec-webpack.html](https://www.alsacreations.com/tuto/lire/1754-debuter-avec-webpack.html)

[https://github.com/babel/gulp-babel/issues/124](https://github.com/babel/gulp-babel/issues/124)

