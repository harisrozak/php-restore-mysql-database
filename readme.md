#PHP Restore MySQL Database
Run this php file on cron or direct url to restore your specific MySQL database from a sql dump file.

Make sure you have fill all required variable on this file, for example:
```
key = 'yourpassword';

$credential['host'] = "localhost";
$credential['user'] = "root";
$credential['passwd'] = "root";
$credential['dbName'] = "wordpress-tutorial";
$credential['dumpdir'] = "/home/haris/wordpress-tutorial.sql";
```

##Usage Example
**Direct url usage**

`http://demo.example.com/restore-database.php?key=yourpassword`

**Cron command**

`/usr/bin/wget -q -O temp.txt http://demo.example.com/restore-database.php?key=yourpassword`