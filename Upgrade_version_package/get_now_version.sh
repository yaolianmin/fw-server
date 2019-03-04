#!/bin/bash
mysql -uroot -pmysql_yii <<EOF
	use fw_server;
	select version from version where statue=1;
EOF
