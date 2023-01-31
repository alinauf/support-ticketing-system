## Ticketing System

Follow the instructions below to work on the project:

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan migrate --seed 
php artisan serve 
```

To run the tests, run the below command

```bash
php artisan test
```
