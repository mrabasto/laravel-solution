# Exam Solutions
**Quick Install Commands**
```bash
composer install

npm install && npm run dev

cp .env.example .env

php artisan key:gen
```
- I used sqlite db here for quick setup
```bash
touch database/database.sqlite
```

.env :
```env
DB_CONNECTION=sqlite
```

then :
```bash
php artisan migrate:refresh --seed

php artisan csv:process
```

**Notes**:
- other solutions can be found in `other_solutions` folder
- you should run `php artisan migrate:refresh --seed` to run the migrations and the dummy user that can be found in `Database\Seeders\DatabaseSeeder`;
- regarding the data:
- - please move the csv data included in this exam to `/store/app/public` folder and name it `source.csv` (if it's not there, a copy is in `other_solutions`)
- - please run `php artisan csv:process` to process the `source.csv` in `/storage/app/public` folder
- APIs were available and authenticated via Laravel Sanctum
- - You can view it in `routes/api.php` or run this command `php artisan serve route:list --path=api`
- This solution is in Laravel 10 and ran in `PHP 8.2.11`
