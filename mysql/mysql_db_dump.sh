#!/bin/bash
filename="/docker-entrypoint-initdb.d/seed.sql"

# 差分のみをチェックするため下記を削除
# * コメント --skip-comments
# * オートインクリメントのインクリメント値 (sed 's/ AUTO_INCREMENT=[0-9]*//g')
mysqldump --skip-comments	-u $WORDPRESS_DB_USER "-p${WORDPRESS_DB_PASSWORD}" -x $MYSQL_DATABASE |sed 's/ AUTO_INCREMENT=[0-9]*//g' >$filename

