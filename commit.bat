@echo off

set /p msg=Enter commit description :

git add .
git commit -m "%msg%"
git push origin master

color 0a
echo.
echo Success!
pause > nul
