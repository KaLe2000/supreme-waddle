# supreme-waddle
PHPractice with Laravel.

*Simple project management app.*

To start a project:
```bash
./ci up #creating docker containers, installing dependency, migrating DB
./ci down #deleting containers
./ci start #start containers
./ci stop #stop containers
```


**TODO backend:**
- [x] Init project
- [x] Create first tests and models
- [x] Write bashscript for correct start a project with Docker
- [ ] Create "Invite Friend" functional
- [ ] Add integration with [Social's](https://github.com/SocialiteProviders/Providers)
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