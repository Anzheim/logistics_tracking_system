<?php
$connectionInfo = array( "UID" => "sa", "PWD" => "povso3-ryrvap", "Database" => "logistics", "CharacterSet"=>"UTF-8" );
$link = sqlsrv_connect( "140.136.151.137", $connectionInfo );
if( $link ) {
     //echo "Connection established.<br>";
     echo "<br>";
} else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true ) );
}
return $link;
?>