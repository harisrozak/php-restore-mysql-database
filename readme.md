#PHP Restore MySQL Database
Run this php file on cron or direct url to restore your specific MySQL database from a sql dump file.

Make sure you have fill all required variable on this file, for example:
```
$key = 'yourpassword';

$this->cred['host'] = "localhost";
$this->cred['user'] = "root";
$this->cred['passwd'] = "root";
$this->cred['dbName'] = "example_db";
$this->cred['dumpdir'] = "/home/harishost/backups-db/example_db.sql";
$this->cred['prefix'] = "wp_";
```

##Usage Example
**Direct url usage**

`http://demo.example.com/restore-database.php?key=yourpassword`

**Cron command**

`/usr/bin/wget -q -O temp.txt http://demo.example.com/restore-database.php?key=yourpassword`