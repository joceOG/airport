# BO_CLIENT (laravel + vue + vuetify + typescript)


## Installation

###  install laravel

``curl -s "https://laravel.build/example-app" | bash``

###  install laravel/ui

  > laravel/ui allows to install a js/css preprocessor in the laravel project

``composer require laravel/ui``

### install typescript

``npm install typescript --save-dev``

### Generate basic scaffolding

``php artisan ui vue``

### Install vuetify 

``npm install vuetify``

### Install vue plugins

``npm install vue-router vue-property-decorator vue-class-component vuetifyjs-mix-extension vuetify-loader``

### Install some material design icons

``npm install --save material-design-icons-iconfont``

### Setup Eslint

``npm install eslint --save-dev``
``npx eslint --init``
> Select "Use a popular style guide."
> Select "Standard."
> Select a config file format.
> If prompted, confirm the installation of the necessary dependencies.

### Setup webpack.mix.js

```
import {ts} from 'laravel-mix'
import 'vuetifyjs-mix-extension'

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

ts('resources/js/app.ts', 'public/js')
    .vuetify('vuetify-loader/dist/plugin').vue()
    .sass('resources/sass/app.scss', 'public/css')
```

### Setup resources/views/welcome.blade.php

```
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <title>Laravel Vuetify</title>
    </head>
    <body>
        <div id="app">

        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
```

### Setup tsconfig.js

```
{
  "compilerOptions": {
    "target": "esnext",
    "module": "esnext",
    "strict": true,
    "jsx": "preserve",
    "importHelpers": true,
    "moduleResolution": "node",
    "experimentalDecorators": true,
    "esModuleInterop": true,
    "allowSyntheticDefaultImports": true,
    "sourceMap": true,
    "baseUrl": ".",
    "paths": {
      "@/*": [
        "resources/js/*"
      ]
    },
    "lib": [
      "esnext",
      "dom",
      "dom.iterable",
      "scripthost"
    ]
  },
  "include": [
    "resources/**/*.ts",
    "resources/**/*.tsx",
    "resources/**/*.vue"
    ],
  "exclude": [
    "node_modules"
  ]
}
```

### Add resource/js/plugins/vuetify.ts

```
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {}

export default new Vuetify(opts)
```

### Add resources/js/app.ts

```
import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

Vue.config.productionTip = false

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
```

### Add resouces/js/shim.tsx.d.ts

```
import Vue, { VNode } from 'vue'

declare global {
  namespace JSX {
    // tslint:disable no-empty-interface
    interface Element extends VNode {}
    // tslint:disable no-empty-interface
    interface ElementClass extends Vue {}
    interface IntrinsicElements {
      [elem: string]: any;
    }
  }
}
```

### Add resources/js/shim.vue.d.ts

```
declare module '*.vue' {
  import Vue from 'vue'
  export default Vue
}
```

## Run project dev mode

### Run laravel project

``php artisan serve``
or
``./vendor/bin/sail up``

### compile vue project

``npm run build``

> watch automatically rebuilds the project when files are changed
> ``npm run watch``
