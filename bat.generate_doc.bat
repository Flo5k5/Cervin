@echo off
set module="%~dp0module"
set doc="%~dp0doc"

echo.
echo Code folder : %module%
echo Destination folder : %doc%
echo Generating documentation ...
echo.
php phpDocumentor.phar -d %module% -t %doc%
echo.

:EXIT
echo.
echo Press any key to quit
pause > nul