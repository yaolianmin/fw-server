# !/bin/bash
# function: update fw-server
# Time:    2018-07-13 16:36
# upgrade mysql
sed -i -e 's|memory_limit = 128M|memory_limit = 1500M|'  /etc/php.ini
sed -i -e 's|short_open_tag = Off|short_open_tag = On|' /etc/php.ini
sed -i -e 's|zlib.output_compression = Off|zlib.output_compression = On|' /etc/php.ini
sed -i -e 's|max_execution_time = 30|max_execution_time = 0|' /etc/php.ini
sed -i -e 's|max_input_time = 60|max_input_time = 120|' /etc/php.ini
sed -i -e 's|log_errors_max_len = 1024|log_errors_max_len = 100|' /etc/php.ini
sed -i -e 's|max_file_uploads = 20|max_file_uploads = 100|' /etc/php.ini
sed -i -e 's|default_socket_timeout = 60|default_socket_timeout = 120|' /etc/php.ini
sed -i -e 's|pdo_mysql.cache_size = 2000|pdo_mysql.cache_size = |' /etc/php.ini
sed -i -e 's|mysqli.cache_size = 2000|;mysqli.cache_size = |' /etc/php.ini
#update mysql db
version=`sh /var/www/fw-server/Upgrade_version_package/get_now_version.sh`
ver=${version:9:7}
if [ $ver == '1.0.0.7' ] ; then 
   mysql -uroot -pmysql_yii <<EOF
     use fw_server;
     update version set statue='0' where statue='1';
     insert into version values (8,'V1.0.0.8','0'),(9,'V1.0.0.9','0'),(10,'V1.0.1.0','0'),(11,'V1.0.1.1','0'),(12,'V1.0.1.2','1');
EOF
elif [ $ver == '1.0.0.8' ] ; then 
   mysql -uroot -pmysql_yii <<EOF
     use fw_server;
     update version set statue='0' where statue='1';
     insert into version values (9,'V1.0.0.9','0'),(10,'V1.0.1.0','0'),(11,'V1.0.1.1','0'),(12,'V1.0.1.2','1');
EOF
elif [ $ver == '1.0.0.9' ] ; then
   mysql -uroot -pmysql_yii <<EOF
     use fw_server;
     update version set statue='0' where statue='1';
     insert into version values (10,'V1.0.1.0','0'),(11,'V1.0.1.1','0'),(12,'V1.0.1.2','1');
EOF
elif [ $ver == '1.0.1.0' ] ; then
   mysql -uroot -pmysql_yii <<EOF
     use fw_server;
     update version set statue='0' where statue='1';
     insert into version values (11,'V1.0.1.1','0'),(12,'V1.0.1.2','1');
EOF
elif [ $ver == '1.0.1.1' ] ; then
   mysql -uroot -pmysql_yii <<EOF
     use fw_server;
     update version set statue='0' where statue='1';
     insert into version values (12,'V1.0.1.2','1');
EOF
fi
