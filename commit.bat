@echo off

set /p msg=Enter commit description : 

echo.
echo git add
echo.
git add .

echo.
echo git commit
echo.
git commit -m "%msg%"

echo.
echo git push
echo.
git push origin master

color 0a
echo.
echo Success!
pause > nul