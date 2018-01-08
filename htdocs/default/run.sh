#!/usr/bin/env bash

cd /c/htdocs/default
ps aux | awk '{if($0~/video-run-corn/){print $2}}' | xargs kill -9
echo 'stop exists processes . . . '
chown -R www:www ./

php corn.php video-run-corn >> /dev/null &
echo 'create new processes . . . '
