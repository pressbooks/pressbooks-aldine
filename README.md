# Aldine

[![Build Status](https://travis-ci.org/pressbooks/pressbooks-aldine.svg?branch=dev)](https://travis-ci.org/pressbooks/pressbooks-aldine) [![GitHub Release](https://img.shields.io/github/release/pressbooks/pressbooks-aldine/all.svg)](https://github.com/pressbooks/pressbooks-aldine/releases/latest)

Aldine is the new root theme for [Pressbooks](https://github.com/pressbooks/pressbooks), based on [Sage](https://roots.io/sage/).

## Features

* Sass for stylesheets
* ES6 for JavaScript
* [Webpack](https://webpack.github.io/) for compiling assets, optimizing images, and concatenating and minifying files
* [Browsersync](http://www.browsersync.io/) for synchronized browser testing
* [Laravel Blade](https://laravel.com/docs/5.4/blade) as a templating engine
* [Controller](https://github.com/soberwp/controller) for passing data to Blade templates

## Requirements

Make sure all dependencies have been installed before moving on:

* [PHP](http://php.net/manual/en/install.php) >= 7.0
* [Composer](https://getcomposer.org/download/)
* [WordPress](https://wordpress.org/) >= 4.8.1
* [Pressbooks](https://github.com/pressbooks/pressbooks) >= 4.3
* [Node.js](http://nodejs.org/) >= 6.9.x
* [Yarn](https://yarnpkg.com/en/docs/install)

## Theme installation

Download the [latest zipped release](https://github.com/pressbooks/pressbooks-aldine/releases/latest) to your Pressbooks themes directory (`wp-content/themes` or `app/themes`) and unzip the theme folder.

## Theme structure

```shell
themes/pressbooks-aldine/  # → Theme root
├── app/                  # → Theme PHP
│   ├── controllers/      # → Controller files
│   ├── widgets/          # → Custom widget classes
│   ├── admin.php         # → Theme customizer setup
│   ├── filters.php       # → Theme filters
│   ├── helpers.php       # → Helper functions
│   └── setup.php         # → Theme setup
│   └── widgets.php       # → Widget initialization
├── composer.json         # → Autoloading for `app/` files
├── composer.lock         # → Composer lock file (never edit)
├── dist/                 # → Built theme assets (never edit)
├── node_modules/         # → Node.js packages (never edit)
├── package.json          # → Node.js dependencies and scripts
├── resources/            # → Theme assets and templates
│   ├── assets/           # → Front-end assets
│   │   ├── config.json   # → Settings for compiled assets
│   │   ├── build/        # → Webpack and ESLint config
│   │   ├── fonts/        # → Theme fonts
│   │   ├── images/       # → Theme images
│   │   ├── scripts/      # → Theme JS
│   │   └── styles/       # → Theme stylesheets
│   ├── functions.php     # → Composer autoloader, theme includes
│   ├── index.php         # → Never manually edit
│   ├── screenshot.png    # → Theme screenshot for WP admin
│   ├── style.css         # → Theme meta information
│   └── views/            # → Theme templates
│       ├── layouts/      # → Base templates
│       └── partials/     # → Partial templates
└── vendor/               # → Composer packages (never edit)
```

## Theme development

* Run `yarn` from the theme directory to install dependencies
* Update `resources/assets/config.json` settings:
  * `devUrl` should reflect your local development hostname
  * `publicPath` should reflect your WordPress folder structure (`/wp-content/themes/pressbooks-aldine` for non-[Bedrock](https://roots.io/bedrock/) installs)

### Build commands

* `yarn run start` — Compile assets when file changes are made, start Browsersync session
* `yarn run build` — Compile and optimize the files in your assets directory
* `yarn run build:production` — Compile assets for production
