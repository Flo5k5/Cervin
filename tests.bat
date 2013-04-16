@echo off

cd tests
call phpunit

:EXIT
echo.
echo.
echo Press any key to quit
pause > nul