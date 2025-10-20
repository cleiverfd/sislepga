@echo off
echo Limpiando configuración de Laravel...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
@REM php artisan optimize:clear
echo Limpieza completada.
pause