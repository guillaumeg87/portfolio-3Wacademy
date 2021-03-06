---
description: >-
  Ce projet utilise les fonctions sommaires de
  [WEBPACK](https://webpack.js.org/), et de gérer les assets au même endroit
  avec le même outil:
---

# Webpack

Ce projet utilise les fonctions sommaires de [**`WEBPACK`**](https://webpack.js.org/), et de gérer les assets au même endroit avec le même outil:

* utilisation de [**`SASS`**](https://sass-lang.com/), compilation et minification du css
* Traduction du JS ES6 en ES 5 avec [**`Babel`**](https://babeljs.io/)
* Minification du JS avec Uglify

### Installation de Webpack:

#### Installer [Node JS](https://nodejs.org/en/) et NPM, si on ne les a pas déjà.

#### Installer Webpack :

```bash
npm install --save-dev webpack@latest webpack-dev-server@latest	
npm install -g webpack@latest	
```

#### Installer Babel:

```bash
npm install --save-dev gulp-babel @babel/core @babel/preset-env
```

#### Installer les dépendances pour le css:

```bash
npm i --save-dev sass-loader node-sass css-loader style-loader autoprefixer postcss-loader	
npm install --save-dev mini-css-extract-plugin
```

#### Installer Webpack server :

```bash
npm install webpack-dev-server --save-dev

```

####  Installer Webpack Dashboard \(voir les executions de webpack un peu mieux présentées...\)

```bash
npm install webpack-dashboard --save-dev
```

#### Sources Webpack

Avec Webpack 4 _ExtractTextWebpackPlugin_ est déprécié, utiliser [Mini Css Extract Plugin](https://webpack.js.org/plugins/mini-css-extract-plugin/#root)

Ajout du fichier Webpack 4 [_**.babelrc**_](https://stackoverflow.com/questions/52092739/upgrade-to-babel-7-cannot-read-property-bindings-of-null/52092788)_\*\*\*\*_

**Sources à conserver pour webpack:**

[https://www.sitepoint.com/webpack-beginner-guide/](https://www.sitepoint.com/webpack-beginner-guide/)

[https://www.alsacreations.com/tuto/lire/1754-debuter-avec-webpack.html](https://www.alsacreations.com/tuto/lire/1754-debuter-avec-webpack.html)

[https://github.com/babel/gulp-babel/issues/124](https://github.com/babel/gulp-babel/issues/124)

