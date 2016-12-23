#!/bin/bash
_host=localhost
_port=3306
_database=
_user=
gunzip < $1 | mysql -h$_host -P$_port -u$_user -p --database=$_database