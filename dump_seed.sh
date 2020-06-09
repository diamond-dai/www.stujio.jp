#!/bin/bash
docker-compose exec db /opt/mysql_db_dump.sh
docker-compose exec httpd /opt/bin/dump/dump_plugins.sh
docker-compose exec httpd /opt/bin/dump/dump_uploads.sh