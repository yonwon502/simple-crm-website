@echo off
echo ========================================
echo Port and Process Check for XAMPP
echo ========================================
echo.

echo Checking port 80 (Apache):
netstat -ano | findstr :80
echo.

echo Checking port 3306 (MySQL):
netstat -ano | findstr :3306
echo.

echo Checking port 443 (HTTPS):
netstat -ano | findstr :443
echo.

echo Checking port 8080 (Alternative HTTP):
netstat -ano | findstr :8080
echo.

echo ========================================
echo Process Details (if PIDs found above):
echo ========================================
echo.

echo To find which process is using a port:
echo 1. Look at the PID (last number) from above
echo 2. Run: tasklist /FI "PID eq [PID_NUMBER]"
echo 3. Or run: tasklist /FI "PID eq [PID_NUMBER]" /FO TABLE
echo.

echo Common XAMPP processes to look for:
echo - httpd.exe (Apache)
echo - mysqld.exe (MySQL)
echo - xampp-control.exe (XAMPP Control Panel)
echo.

echo ========================================
echo XAMPP Service Check:
echo ========================================
echo.

echo Checking if XAMPP services are running:
sc query Apache2.4
echo.
sc query MySQL80
echo.

echo ========================================
echo Troubleshooting Steps:
echo ========================================
echo.
echo 1. Open XAMPP Control Panel
echo 2. Stop Apache and MySQL
echo 3. Wait 10 seconds
echo 4. Start Apache and MySQL again
echo 5. Check if ports are now available
echo.

pause 