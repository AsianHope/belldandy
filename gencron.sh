#!/bin/sh
/var/www/belldandy/process.php
cat /var/www/belldandy/cron.stub /var/www/belldandy/bell.stub > /etc/crontab
