# lazyquery
php mssql/mysql query lib for lazy people

### rerquiment
* php 
* sqlsrv plugin for mssql.

### structure
* config.json
```js
{
    "dburl"     : "dburl",
    "username"  : "dbusername",
    "password"  : "dbpassword",
    "dbname"    : "dbname",
    "dbtype"    : "mssql/mysql"
}
```
* lazyquery.php

### how to use
#### quick 

```php
    require ("lazyquery.php"); 

    $x = new DB (); // use  "config.json" by default.

    $dataobject = $x->query ( "SELECT * FROM tbl_test" );

     print_r( $dataobject['data'] );

    $x->close();
```


#### detail 

```php
    // load class.
    require ("lazyquery.php"); 

    // instantiate.
    $x = new DB (); // use  "config.json" by default.
    // or
    // $x = new DB ("otherconfig.json");
    
    // call quary.
    $dataobject = $x->query ( "SELECT * FROM tbl_test" );

    // use data.
    if($dataobject['result']){
        print_r( $dataobject['data'] );
    }else{
        echo "query unsuccess.\n\r";
        print_r( $dataobject['data'] );
    }

    // close.
    $x->close();
```
