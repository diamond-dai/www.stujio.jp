#!/bin/bash
echo 'dump uploads started'
echo /var/www/html/${WP_DIR}/wp-content/uploads/
rsync -avr --delete /var/www/html/${WP_DIR}/wp-content/uploads /opt/seed/
rm -f /opt/seed/uploads/wp-uploads-setup
echo 'dump uploads finished'
