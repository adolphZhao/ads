#!/usr/bin/env bash

cd /c/htdocs/default
ps aux | awk '{if($0~/video-run-corn/){print $2}}' | xargs kill -9
echo 'stop exists processes . . . '
chown -R www:www ./

php cron_new.php video-run-corn 2>&1 > /var/log/domain_detect.log &
echo 'create new processes . . . '
