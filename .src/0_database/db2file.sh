#!/bin/bash
_host=localhost
_port=3306
_database=
_user=
_tablenames="_admintools_|_ak_|_akeeba_|_ark_|_wf_"

read -s -p "Password: " _password

mysql -h$_host -P$_port -u$_user -p$_password -e "show tables;" $_database | \
grep -Ev "Tables_in|$_tablenames" | \
xargs mysqldump -u$_user -p$_password --no-create-db $_database | \
gzip > ".$(date +%Y%m%d_%H%M).sql.gz"
