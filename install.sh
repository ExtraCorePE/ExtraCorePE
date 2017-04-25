#!/bin/bash

linux_php_32="PHP7.tar.gz https://dl.bintray.com/pocketmine/PocketMine/PHP_7.0.6_x86_Linux.tar.gz"
linux_php_64="PHP7.tar.gz https://dl.bintray.com/pocketmine/PocketMine/PHP_7.0.6_x86-64_Linux.tar.gz"

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
 echo -ne '[#####                  ] (33%)\r'
  sleep 1  
  
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
fi

if [ ! -d "bin/php7" ]
 then
 echo "[ExtraCorePE] Your running $OSTYPE, Downloading PHP for your systen..."
 uname -m
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
fi  

 echo -ne '[#############          ] (53%)\r'
  sleep 1   
 echo -ne '[###############        ] (57%)\r'
  sleep 1  
 echo -ne '[##################     ] (78%)\r'
  sleep 1
 echo -ne '[#######################] (100%)\r'
 echo -ne '\n'
 clear
 echo "Done!"
 echo "[ExtraCorePE] Run the 'start.sh' file to start the Server!"
 sleep 5
fi

if [ "$i" == no ] || [ "$i" == n ]
 then 
 echo "[ExtraCorePE] Stopping installation..."
 sleep 2
 echo "[ExtraCorePE] Stopped!"
fi
