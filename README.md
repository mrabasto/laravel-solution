# Exam Solutions

**Notes**:
- other solutions can be found in `other_solutions` folder
- regarding the data:
- - please move the csv data included in this exam to `/store/app/public` folder and name it `source.csv` (if it's not there)
- - please run `php artisan csv:process` to process the `source.csv` in `/storage/app/public` folder
- you can run `php artisan migrate:refresh --seed` to run the migrations and the dummy user that can be found in `Database\Seeders\DatabaseSeeder`;
- APIs were available and authenticated via Laravel Sanctum
- - You can view it in `routes/api.php` or run this command `php artisan serve route:list --path=api`
- This solution is in Laravel 10 and ran in `PHP 8.2.11`
