#!/bin/bash
# set -x

function init_seed() {
  WP_DIR=$1
  echo 'copy plugins'
  mkdir -p /var/www/html/${WP_DIR}/wp-content/plugins/
  if [ ! -e /var/www/html/${WP_DIR}/wp-content/wp-plugins-setup ]; then
    \cp -arf /opt/seed/plugins/* /var/www/html/${WP_DIR}/wp-content/plugins/
    touch /var/www/html/${WP_DIR}/wp-content/wp-plugins-setup
  fi

  # DB上でデフォルトのプラグインが無効になってたらアンインストール
  # WPコンテナ使うと起動時にコピーされるため
  # remove default plugins
  sudo -u www-data wp plugin uninstall hello
  sudo -u www-data wp plugin uninstall akismet

  echo 'copy uploads'
  mkdir -p /var/www/html/${WP_DIR}/wp-content/uploads/
  if [ ! -e /var/www/html/${WP_DIR}/wp-content/wp-uploads-setup ]; then
    \cp -arf /opt/seed/uploads/* /var/www/html/${WP_DIR}/wp-content/uploads/
    touch /var/www/html/${WP_DIR}/wp-content/wp-uploads-setup
    rm -f /var/www/html/${WP_DIR}/wp-content/uploads/cache/*
  fi
}

function init_wp_content() {
  WP_DIR=$1
  # wp-contentのディレクトリ作成 & permission設定
  # upgradeがないと更新系すべて失敗する Warning: Failed to create directory
  content_directories='
plugins
uploads
languages
upgrade
cache
'
  content_directories_list=($(echo $content_directories))
  for ((i = 0; i < ${#content_directories_list[@]}; ++i)); do
    directory=${content_directories_list[$i]}
    # echo "directory: ${content_directories_list[$i]}"
    mkdir -p "/var/www/html/${WP_DIR}/wp-content/${directory}/"
  done
  # themes以外の権限変更 themesはhostなので変更しない
  find "/var/www/html/${WP_DIR}/wp-content/" -mindepth 1 -maxdepth 1 -type d -name themes -prune -o -type d -exec chown -R www-data:www-data {} \;
  find "/var/www/html/${WP_DIR}/wp-content/" -type d -name themes -prune -o -type d -exec chmod 705 {} \;
  find "/var/www/html/${WP_DIR}/wp-content/" -type d -name themes -prune -o -type f -exec chmod 604 {} \;

  # wp-content自体のpermission変更
  chown www-data:www-data "/var/www/html/${WP_DIR}/wp-content/"
  chmod 705 "/var/www/html/${WP_DIR}/wp-content/"

}

echo "setup start."

cd /var/www/html

echo "update index.php"
cat <<EOF >index.php
<?php
define('WP_USE_THEMES', true);
require( dirname( __FILE__ ) . '/$WP_DIR/wp-blog-header.php' );
EOF

is_wp_install=$(sudo -u www-data wp core is-installed)
if [ ! $is_wp_install ] && [ -f /opt/install/config.yml ]; then
  echo "wordpress is not installed"
  init_wp_content $WP_DIR
  . ~/.bashrc
  pip install pyyaml
  python /opt/bin/setup_wp/install_wp.py $WP_THEME_NAME $WP_DIR $WP_HOME_URL
else

  home_url=$(sudo -u www-data wp option get home)
  echo "home_url: $home_url"
  echo "WP_HOME_URL: $WP_HOME_URL"
  # 本番などから持ってきたDBの場合URLが違うのでローカルのURLに置き換える
  if [ $home_url != $WP_HOME_URL ]; then
    sudo -u www-data wp search-replace $home_url $WP_HOME_URL
    # 既存SQLからリビジョン削除 数M削れたりする
    echo "delete post revisions start."
    sudo -u www-data wp post delete $(sudo -u www-data wp post list --post_type='revision' --format=ids) --force
    echo "delete post revisions finished."
  fi
  # seed をコピー
  init_seed $WP_DIR

  # DBの更新があれば更新
  sudo -u www-data wp core update-db

  # rewrite ruleの更新
  sudo -u www-data wp rewrite flush

fi

cd "/var/www/html/${WP_DIR}"

# mail文字化け対応
cp /opt/bin/resources/wpmp-config.php "/var/www/html/${WP_DIR}/wp-content/"

init_wp_content $WP_DIR

# 日本語化
sudo -u www-data wp language core install ja --activate

echo "setup finished."
