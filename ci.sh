#!/bin/bash
curl -fsSL https://github.com/ExtraCorePE/ExtraCorePE/releases/download/DevTools/DevTools_v1.0.phar -o plugins/DevTools.phar
echo Running lint...
shopt -s globstar
for file in **/*.php; do
    OUTPUT=`php -l "$file"`
    [ $? -ne 0 ] && echo -n "$OUTPUT" && exit 1
done
echo Lint done successfully.
echo -e "version\nms\nstop\n" | php src/pocketmine/PocketMine.php --no-wizard | grep -v "\[ExtraCorePE] Adding "
if ls plugins//ExtraCorePE/ExtraCorePE*.phar >/dev/null 2>&1; then
    echo Server packaged successfully.
else
    echo No phar created!
    exit 1
fi
