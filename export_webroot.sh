#!/bin/bash
mkdir -p ./export/htdocs/
docker cp `docker-compose ps -q httpd`:/var/www/html/ ./export/htdocs/