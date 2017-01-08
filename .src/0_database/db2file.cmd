SET _host=localhost
SET _port=
SET _database=
SET _user=
SET _tablenames="_admintools_|_ak_|_akeeba_|_ark_|_wf_|_j2xml_"

@ECHO OFF
FOR /F "delims=" %%i IN ('date /t') DO set _date=%%i
FOR /F "delims=" %%i IN ('time /t') DO set _time=%%i
SET "_timestamp=%_date:~6,4%%_date:~3,2%%_date:~0,2%_%_time::=%"
@ECHO ON

mysql -h%_host% -P%_port% -u%_user% -p -e "show tables;" %_database%  | ^
grep -Ev "Tables_in|"%_tablenames%                                    | ^
xargs mysqldump -P%_port% -u%_user% -p --no-create-db %_database%     | ^
gzip > ".%_timestamp%.sql.gz"

@ECHO OFF
SET _host=
SET _port=
SET _database=
SET _user=
SET _tablenames=
SET _date=
SET _time=
SET _timestamp=