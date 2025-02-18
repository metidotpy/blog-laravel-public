# For run this project, at the first please clone it
---
# Then go to the directory of project and run this commands:
```bash
composer install
npm i
npm run build
```
---
# Then run this commands for clear the cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan migrate
```
---
# Then run this command for seed the default data:
```bash
php artisan db:seed
```
---
# At the end just run the project and have fun :)
```bash
php artisan serve
```
---
### Wroted by Mehdi Radfar -> AKA "metidotpy"
### This is a test project for [Gilasweb](https://gilasweb.ir)
