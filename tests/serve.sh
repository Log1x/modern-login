#!/usr/bin/env bash

cd tests
rm -rf tmp
mkdir -p tmp
cd tmp
wp core download
wget -O wp-content/db.php https://raw.githubusercontent.com/aaemnnosttv/wp-sqlite-db/master/src/db.php
mv wp-config-sample.php wp-config.php
wp core install --url=http://127.0.0.1:8080 --title="modern login" --admin_user=admin --admin_email=admin@example.org
wp plugin install advanced-custom-fields
wp plugin activate advanced-custom-fields
wp option update users_can_register 1
ln -sf ../../../.. wp-content/plugins/modern-login
mkdir -p wp-content/mu-plugins
ln -sf ../../../../tests/mu.php wp-content/mu-plugins/mu.php
wp plugin activate modern-login
wp server --host=127.0.0.1
