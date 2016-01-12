#Belldandy - a simple, web-based bell system.#

Required: 
	*mpg321
	*webserver with PHP support
	*an OS that has cron

#Background:#
   Belldandy was written for Logos International School to replace the iPod touch that had been installed when no local company could be sourced for a 'real' bell system. While, in principal, this could be run from any computer it was created with the vision of using a Raspberry Pi.


#Installation:#
Put files in an appropriate directory with appropriate permissions for web access.
Make a copy of your system crontab in cron.stub and update directories as appropriate
add the gencron.sh job run with appropriate permissions at an appropriate interval
Be very mindful of security. Don't want arbitrary jobs getting pushed in with root access!

#Raspbery Pi on Raspbian Installation:#
```
apt-get update
apt-get install git apache2 php5 libapache2-mod-php5 php5-sqlite mpg321
cd /var/www
git clone https://github.com/AsianHope/belldandy.git
chmod 777 belldandy -R
```
modify /etc/apache2/sites-enabled and change DocumentRoot to /var/www/belldandy and restart apache with
```
service apache2 restart
```

Finally, trigger the system to insert the tasks into your crontab
```
sh /var/www/belldandy/gencron.sh
```
Browse to your Pi and change some bells around! Bells should regenerate every 5 minutes.


