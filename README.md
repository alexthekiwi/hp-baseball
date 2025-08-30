# Statamic Starter Kit
A base starter for Statamic with our preferred config and boilerplate.

## Using this starter kit
Starting a new project (with the [Statamic CLI](https://github.com/statamic/cli)):
```
statamic new my-app the-caretakers/statamic-starter-kit
```

Or install into an existing project:
```
php please starter-kit:install the-caretakers/statamic-starter-kit
```

## Getting started
Install frontend dependencies:
```
npm install
```

Compile assets:
```
npm run dev
```

## Exporting
To export this starter kit for use:
```
php please starter-kit:export .
```

---

# Project README

## Installation
Create an environment file:
```
cp .env.example .env
```

Install PHP dependencies:
```
composer install
```

Set the encryption key:
```
php artisan key:generate
```

Install front-end dependencies:
```
npm install
```

## Development
Start the dev server:
```
npm run dev
```

## Production
Compile the front-end assets:
```
npm run build
```
