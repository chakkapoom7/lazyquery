<?php 

class DB {
    private $config ;
    private $conn ;

    function __construct( $configfile = './config.json' ) {
        $this->config = json_decode( file_get_contents( $configfile ) , true )  ; 


        $connectionInfo = array( "Database"=>$this->config['dbname'], "UID"=>$this->config['username'], "PWD"=>$this->config['password'] );
        $conn = sqlsrv_connect( $this->config['dburl'], $connectionInfo);

        if( $conn === false ) {
            die( print_r( sqlsrv_errors(), true));
        }


        $this->conn = $conn;
    }

    public function curconf () {
        return $this->config;
    }    

    public function query ( $sqlstr ) {
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
                // print_r($row);
            }
            return  array("result"=>true, "data"=>$resdata ) ;
        }
        // while($row = sqlsrv_fetch_array( $resault , SQLSRV_FETCH_ASSOC))
        // {
        // 	print_r($row);
        // }
    }

    public function close ( ) {
        sqlsrv_close($this->conn);
    }

} 


/*


$con=mysqli_connect("localhost","my_user","my_password","my_db");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// Perform queries 
mysqli_query($con,"SELECT * FROM Persons");
mysqli_query($con,"INSERT INTO Persons (FirstName,LastName,Age) 
VALUES ('Glenn','Quagmire',33)");

mysqli_close($con);

*/
?>