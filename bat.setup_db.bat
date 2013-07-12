@echo off
echo.

set hour=%time:~0,2%
if "%hour:~0,1%" == " " set hour=0%hour:~1,1%

set bin_doctrine=%~dp0\vendor\doctrine\doctrine-module\bin\doctrine-module
set file="%date:~6,4%%date:~3,2%%date:~0,2%%hour%%time:~3,2%%time:~6,2%.sql"
set host=localhost
set db=cervin
set user=root

:MENU
echo -- Default values --
echo Host : %host%
echo DB : %db%
echo User: %user%
rem echo File: %file%
echo.
set /p msg=Use default values : (y/n)? 
if "%msg%"=="y" goto IMPORT
if "%msg%"=="n" goto CONFIG
goto MENU

:CONFIG
set /p host=Host : 
echo.

set /p db=DB : 
echo.

set /p user=User : 
echo.

goto IMPORT


:IMPORT
echo.
echo Deleting database: %db%
echo.
echo DROP DATABASE IF EXISTS %db% > %file%
mysql -h %host% -u %user% < %file%
echo.
echo Creating database: %db%
echo.
echo CREATE DATABASE IF NOT EXISTS %db% > %file%
mysql -h %host% -u %user% < %file%
del /F /Q %file%
echo.
echo SQL dump to import:
echo.
php "%bin_doctrine%" orm:schema-tool:create --dump-sql
echo.
php "%bin_doctrine%" orm:schema-tool:update --force
echo.
echo Importing fixtures...
echo.
php "%bin_doctrine%" data-fixture:import > fixtures.log
goto EXIT

:EXIT
echo.
echo Press any key to quit
pause > nul