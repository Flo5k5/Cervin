@echo off

:CLEAR
cls
if exist "%~dp0\data\cache\js\" del /f /q /s "%~dp0\data\cache\js\*" && FOR /D %%p IN ("%~dp0\data\cache\js\*") DO rmdir "%%p" /s /q
if exist "%~dp0\data\cache\css\" del /f /q /s "%~dp0\data\cache\css\*" && FOR /D %%p IN ("%~dp0\data\cache\css\*") DO rmdir "%%p" /s /q
echo.
echo.
echo Press any key to clear cache
pause>nul
goto CLEAR

:EXIT
echo.
echo Exiting...
ping -n 2 127.0.0.1 > nul