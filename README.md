# supreme-waddle
PHPractice with Laravel.

*Simple project management app.*

To start a project:
```bash
cp .env.example .env
composer install
npm install && npm run dev
docker-compose up -d --build
php artisan key:generate
php artisan migrate --seed
php artisan ide-helper:generate
./vendor/bin/phpunit 
```


**TODO backend:**
- [x] Init project
- [ ] Write bashscript for correct start a project with Docker
- [ ] Create first tests and models

**TODO frontend:**
- [ ] Create a layout
- [ ] Create a basic views for existing controllers

Model | Migration & Seeder | Tests | Views
------------ | ------------- | ------------- | -------------
Project | + | + | -
Task | + | + | -
User | + | - | -
