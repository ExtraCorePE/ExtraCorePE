#!/bin/bash

linux_php_32="PHP7.tar.gz https://dl.bintray.com/pocketmine/PocketMine/PHP_7.0.6_x86_Linux.tar.gz"
linux_php_64="PHP7.tar.gz https://dl.bintray.com/pocketmine/PocketMine/PHP_7.0.6_x86-64_Linux.tar.gz"
osx_php_32="PHP7.tar.gz https://dl.bintray.com/pocketmine/PocketMine/PHP_7.0.3_x86_MacOS.tar.gz"
osx_php_64="PHP7.tar.gz https://dl.bintray.com/pocketmine/PocketMine/PHP_7.0.3_x86-64_MacOS.tar.gz"

echo "[ExtraCorePE] Do you want to install?"
echo "(y)es, (n)o"
read i

if [ "$i" == yes ] || [ "$i" == y ]
 then
 clear
 echo "[ExtraCorePE] Loading Data..."
  sleep 1
 echo "[ExtraCorePE] Loaded!"
  sleep 1
 echo "[ExtraCorePE] Downloading Files..." 
 
if [ -e "start.sh" ]
 then
 echo "[ExtraCorePE] Could not download 'start.sh' File Already Exists!"
else
 wget 'https://raw.githubusercontent.com/ExtraCorePE/ExtraCorePE/master/start.sh'
 chmod +x start.sh
fi  

if [ -d "bin/php7" ]
 then
 echo "[ExtraCorePE] Skipping PHP, it is already installed!";
 echo "If you want to update PHP, delete the bin folder and run this File again"
else
 echo "[ExtraCorePE] Your running $OSTYPE $(uname -m), Downloading PHP for your systen..."
//Linux
if [ $(uname -m) == x86_64 ] && [ $OSTYPE == linux-gnu ]
 then
 wget -O $linux_php_64 --no-check-certificate
 tar -xf PHP7.tar.gz
 echo "Downloaded PHP for x86-64"
  sleep 5
fi
if [ $(uname -m) == x86 ] && [ $OSTYPE == linux-gnu ]
 then
 wget -O $linux_php_32 --no-check-certificate
 tar -xf PHP7.tar.gz
 echo "Downloaded PHP for x86"
  sleep 5
 fi
//OSX
if [ $(uname -m) == x86_64 ] && [ $OSTYPE == darwin ]
 then
 wget -O $osx_php_64 --no-check-certificate
 tar -xf PHP7.tar.gz
 echo "Downloaded PHP for x86-64"
  sleep 5
fi
if [ $(uname -m) == x86 ] && [ $OSTYPE == darwin ]
 then
 wget -O $osx_php_32 --no-check-certificate
 tar -xf PHP7.tar.gz
 echo "Downloaded PHP for x86"
  sleep 5
 fi
fi  

if [ ! -d "src" ]
 then
 clear
 echo "[ExtraCorePE] Downloading ExtraCorePE latest..."
  sleep 1
 git clone https://github.com/ExtraCorePE/ExtraCorePE.git
 mv -i ./ExtraCorePE/src/ ./
  sleep 1
 echo "[ExtraCorePE] Done Downloading!"
  clear
fi

 echo "Done!"
if [ -d "bin/php7" ] && [ -d "src" ] && [ -e "start.sh" ]
 then
 rm PHP7.tar.gz
 rm -rf ExtraCorePE/
 echo "Would you like to start the server now?"
 echo "(y)es, (n)o"
read a
if [ "$a" == yes ] || [ "$a" == y ]
 then 
 clear
 sleep 2 
 echo "Starting..."
 ./start.sh
fi
if [ "$a" == no ] || [ "$a" == n ]
 then 
 echo "[ExtraCorePE] Stopping Installer"
 sleep 2
 echo "[ExtraCorePE] Stopped!"
 fi
fi

if [ ! -d "bin/php7" ]
 then
 echo "[Error] Something went wrong with the installation!"
 echo "'PHP' was not installed"
 echo "Try running the install.sh file again, if you see this error again use the link below to contact us"
 echo "Here is our Gitter Chat: https://gitter.im/ExtraCorePE/ExtraCorePE"
fi
if [ ! -d "src" ] 
 then
 echo "[Error] Something went wrong with the installation!"
 echo "'src' did now download"
 echo "Try running the install.sh file again, if you see this error again use the link below to contact us"
 echo "Here is our Gitter Chat: https://gitter.im/ExtraCorePE/ExtraCorePE"
fi 
if [ ! -e "start.sh" ] 
 then
 echo "[Error] Something went wrong with the installation!"
 echo "'start' file did not download"
 echo "Try running the install.sh file again, if you see this error again use the link below to contact us"
 echo "Here is our Gitter Chat: https://gitter.im/ExtraCorePE/ExtraCorePE"
 fi
fi

if [ "$i" == no ] || [ "$i" == n ]
 then 
 echo "[ExtraCorePE] Stopping installation..."
 sleep 2
 echo "[ExtraCorePE] Stopped!"
fi
