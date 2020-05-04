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
php artisan ide-helper:generate
php artisan migrate --seed
./vendor/bin/phpunit 
```


**TODO backend:**
- [x] Init project
- [x] Create first tests and models
- [ ] Write bashscript for correct start a project with Docker
- [ ] Create "Invite Friend" functional
- [ ] Add integration with Social's
- [ ] Add valid SSL [Let's Encrypt](https://letsencrypt.org/)

**TODO Social integration:**
- [ ] Registration from VK
- [ ] Registration from FB
- [ ] TG reminder bot

**TODO frontend:**
- [ ] Create a layout
- [x] Create a basic views for existing controllers
- [ ] Add Push-notifications to "Activity"

Model | Migration & Seeder | Tests | Views
------------ | ------------- | ------------- | -------------
Project | + | + | -
Task | + | + | -
User | + | - | -
Activity | + | + | x

**FIXME**
Check Policies & Validations