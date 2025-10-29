<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_formatoverde = "localhost";
$database_formatoverde = "formatoverde";
$username_formatoverde = "root";
$password_formatoverde = "root";
$formatoverde = mysql_pconnect($hostname_formatoverde, $username_formatoverde, $password_formatoverde) or trigger_error(mysql_error(),E_USER_ERROR); 
?>