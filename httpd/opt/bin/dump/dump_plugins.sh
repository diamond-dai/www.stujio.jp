#!/bin/bash
echo 'dump plugins started'
echo /var/www/html/${WP_DIR}/wp-content/plugins/
rsync -av --delete /var/www/html/${WP_DIR}/wp-content/plugins /opt/seed/
rm -f /opt/seed/plugins/wp-plugins-setup
echo 'dump plugins finished'
