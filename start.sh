#!/bin/bash

# This is the start.sh file for ExtraCorePE
# Please input ./start.sh to start server

# Variable define
DIR="$(cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd)"

# Change Directory
cd "$DIR"

# Choose if you want to loop (auto restart) the server after it is stopped
# If the server does not automatically restart upon DO_LOOP = "yes", it will have a delayed start
# If you try to restart manually before it loads automatically, RakLib issues will happen (Client cannot connect to server)

DO_LOOP="no"

##########################################
# DO NOT EDIT ANYTHING BEYOND THIS LINE! #
##########################################

while getopts "p:f:l" OPTION 2> /dev/null; do
	case ${OPTION} in
		p)
			PHP_BINARY="$OPTARG"
			;;
		f)
			POCKETMINE_FILE="$OPTARG"
			;;
		l)
			DO_LOOP="yes"
			;;
		\?)
			break
			;;
	esac
done

if [ "$PHP_BINARY" == "" ]; then
	if [ -f ./bin/php7/bin/php ]; then
		export PHPRC=""
		PHP_BINARY="./bin/php7/bin/php"
	elif [[ ! -z $(type php) ]]; then
		PHP_BINARY=$(type -p php)
	else
		echo "Couldn't find a working PHP 7 binary, please use the installer."
		exit 1
	fi
fi

if [ "$POCKETMINE_FILE" == "" ]; then
	if [ -f ./ExtraCorePE*.phar ]; then
	    	POCKETMINE_FILE="./ExtraCorePE*.phar"
	elif [ -f ./ExtraCorePE.phar ]; then
	    	POCKETMINE_FILE="./ExtraCorePE.phar"
	elif [ -f ./PocketMine-MP.phar ]; then
		POCKETMINE_FILE="./PocketMine-MP.phar"
	elif [ -f ./src/pocketmine/PocketMine.php ]; then
		POCKETMINE_FILE="./src/pocketmine/PocketMine.php"
	else
		echo "Couldn't find a valid ExtraCorePE installation"
		exit 1
	fi
fi

LOOPS=0

set +e
while [ "$LOOPS" -eq 0 ] || [ "$DO_LOOP" == "yes" ]; do
	if [ "$DO_LOOP" == "yes" ]; then
		"$PHP_BINARY" "$POCKETMINE_FILE" $@
	else
		exec "$PHP_BINARY" "$POCKETMINE_FILE" $@
	fi
	if [ "$DO_LOOP" == "yes" ]; then
		if [ ${LOOPS} -gt 0 ]; then
			echo "Restarted $LOOPS times"
		fi 
		echo "To escape the loop, press CTRL+C now. Otherwise, wait 5 seconds for the server to restart."
		echo ""
		sleep 5
		((LOOPS++))
	fi
done
