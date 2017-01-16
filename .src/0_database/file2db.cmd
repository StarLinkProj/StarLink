SET _host=localhost
SET _port=13306
SET _database=starlink.dev
SET _user=dev

gunzip < %1 | mysql -h%_host% -P%_port% -u%_user% -pdev --database=%_database%

@ECHO OFF
SET _host=
SET _port=
SET _database=
SET _user=