<?php 

class DB {
    private $config ;
    private $conn ;

    function __construct( $configfile = './config.json' ) {
        $this->config = json_decode( file_get_contents( $configfile ) , true )  ; 

        if($this->config['dbtype'] === "mssql"){

            $connectionInfo = array( "Database"=>$this->config['dbname'], "UID"=>$this->config['username'], "PWD"=>$this->config['password'] );
            $conn = sqlsrv_connect( $this->config['dburl'], $connectionInfo);
            if( $conn === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $this->conn = $conn;

        }elseif( $this->config['dbtype'] === "mysql" ){

            $conn=mysqli_connect($this->config['dburl'],$this->config['username'],$this->config['password'],$this->config['dbname']);
            if (mysqli_connect_errno())
            {
                die ( "Failed to connect to MySQL: " . mysqli_connect_error() );
            }
            $this->conn = $conn;
        }

    }

    public function curconf () {
        return $this->config;
    }    

    public function query ( $sqlstr ) {

        if( $this->config['dbtype'] === "mssql" ){

            $stmt = sqlsrv_query( $this->conn , $sqlstr );
            
            if( $stmt === false ) {
                // die(print_r(sqlsrv_errors(), true));
                // sqlsrv_free_stmt($stmt);
                return array("result"=>false,"data"=>sqlsrv_errors());
            }else{
                $resdata = array();
                while($row = sqlsrv_fetch_array( $stmt , SQLSRV_FETCH_ASSOC))
                {
                    array_push($resdata,$row);
                }
                return  array("result"=>true, "data"=>$resdata ) ;
            }

            // while($row = sqlsrv_fetch_array( $resault , SQLSRV_FETCH_ASSOC))
            // {
            // 	print_r($row);
            // }

        } elseif ( $this->config['dbtype'] === "mysql" ) {
            $resdata = array();

            $result = mysqli_query( $this->conn , $sqlstr );

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    array_push($resdata,$row);
                }
                return  array("result"=>true, "data"=>$resdata ) ;
             } else {
                return  array("result"=>true, "data"=>array() ) ;
             }
            
        }

    }

    public function close ( ) {
        if( $this->config['dbtype'] === "mssql" ){
            sqlsrv_close($this->conn);
        } elseif ( $this->config['dbtype'] === "mysql" ) {
            mysqli_close($this->conn);
        }
    }

} 


?>