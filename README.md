# Howick Pakuranga Baseball
The website for HP Hawks.

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
