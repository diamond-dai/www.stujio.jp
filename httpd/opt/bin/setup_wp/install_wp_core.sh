#!/bin/bash
# set -x

WP_ADMIN_USER=$1
WP_THEME_NAME=$2
WP_HOME_URL=$3
WP_DIR=$4

echo "setup_wp_install.sh start"
cd "/var/www/html/${WP_DIR}"

install_result=$(wp core install)
echo "$install_result"
echo "setup finished."

wp option update home ${WP_HOME_URL}
wp post delete --force 1
wp post delete --force 2
wp post create --post_type=page --post_title=top --post_status=publish
top_id=$(wp post list --post_type=page --name=top --field=ID)
wp option update show_on_front "page"
wp option update page_on_front $top_id

# disable comments
wp option update default_comment_status 'closed'
wp option update default_ping_status 'closed'

# remove default plugins
wp plugin uninstall hello
wp plugin uninstall akismet

# Install blank theme if theme directory is empty
if [ -z "$(ls /var/www/html/${WP_DIR}/wp-content/themes/${WP_THEME_NAME})" ]; then
  wp scaffold _s $WP_THEME_NAME --force
fi
wp theme activate $WP_THEME_NAME

echo "setup_wp_install.sh end"
