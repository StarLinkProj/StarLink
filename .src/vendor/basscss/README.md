# Bassplate
Boilerplate for [Basscss](http://basscss.com) with postcss

## Features

- Basic `index.html` template with asset links and responsive viewport meta tag
- Starter folder structure
- npm run scripts for processing with postcss
- postcss plugins
  - import
  - custom-media
  - custom-properties
  - calc
  - color-function
  - discard-comments
  - autoprefixer

## Getting Started

You will need

- [git](https://git-scm.com/)
- [Node.js](http://nodejs.org/download/)
- **[npm v3](https://docs.npmjs.com/getting-started/installing-node#updating-npm)** - just a `sudo npm install -g npm` away

To start fresh, clone Bassplate into a new project and remove its git directory.

``` bash
git clone https://github.com/basscss/bassplate.git new-project
cd new-project
rm -rf .git
```

Install the dependencies.

``` bash
npm install
```

Start watching files for compilation.

``` bash
npm start
```

Use `index.html` as a starting point, and edit `src/base.css` to customize the CSS.

## Adding optional modules

To add [other helpful basscss modules](https://www.npmjs.com/search?q=basscss), add the relevant `@import` to `src/base.css` and add the dependency to your `package.json`

So to add the basscss [background image utils](https://github.com/basscss/background-images)
you'd:

Edit `src/base.css`

```css
@import 'basscss-background-images';
```

Add the dependency

```sh
npm install basscss-background-images
```

and then recompile with

```sh
npm run css
```

##Menu Ids
    114 about/news - template Starlink-news
	118 blog       - template Starlink-blog
	121 collaboration-kerio-connect,
    122 dataprotection-kerio-control,
    123 distributedorganization-starlink,
    124 conferencing-kerio-operator

    то есть
		105 consulting
    106 IT-outsourcing
    107 integration
		108 datacenter
    109 security
    110 webprojects
    111 О компании
    112 Услуги,
    113 Решения,
    115 Контакты,
    117 Кто мы?,
    119 Портфолио,
    120 Вакансии
    134 Виртуализация,
    135 Хостинг / Колокейшн,
    136 Аренда серверов и ПО (SaaS),
    137 SSL-сертификаты,
    138 аналы связи

---

MIT License

