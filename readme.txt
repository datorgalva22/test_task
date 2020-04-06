1) git clone https://github.com/datorgalva22/test_task

2) run "composer update"

3) change DB name and password in "/.env" file

4) create new DB with name from step 3

5) change file "test_task/app/Http/Services/GuideService.php" 63 line
	from: 	$API_link = ''
	to	$API_link = 'API LINK'

6) run "php artisan migrate" command

7) run "php artisan schedule:run"

8) add to CronTab "* * * * * cd /var/www/test_task && php artisan schedule:run >> /dev/null 2>&1"


