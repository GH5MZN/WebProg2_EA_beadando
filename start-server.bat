@echo off
cd /d "%~dp0"
echo Starting Laravel development server...
cd public
php -S localhost:8000 -t . ../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php
pause