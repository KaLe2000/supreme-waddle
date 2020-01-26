# supreme-waddle
PHPractice with Laravel.

*Simple project management app.*

To start a project:
```bash
docker-compose up -d
composer install
phpunit
php artisan migrate --seed
php artisan ide-helper:generate 
```


**TODO backend:**
- [x] Init project
- [x] Init Docker
- [ ] Create first tests and models

**TODO frontend:**
- [ ] Create a layout
- [ ] Create a basic views for existing controllers

Model | Migration & Seeder | Tests | Views
------------ | ------------- | ------------- | -------------
Project | + | + | -
User | + | - | -
