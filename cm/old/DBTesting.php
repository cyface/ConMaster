<?php

include_once("DB.php");

function handle_pear_error ($error) {
    echo "An error occurred while trying to run your query.<br>\n";
    echo "Error message: " . $error->getMessage() . "<br>\n";
    echo "A more detailed error description: " . $error->getDebugInfo() . "<br>\n";
}

PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handle_pear_error');

$dsn = array(
    'phptype'  => 'mysql',
    'hostspec' => 'localhost',
    'database' => 'cyface',
    'username' => 'cyface',
    'password' => 'jmnd9ivb'
);


echo "Built DSN.<br>";

$dbh = DB::connect($dsn,array('debug' => '1'));
echo "Connected.<br>";


$stmt = $dbh->autoPrepare('person',array('first_name','last_name'),DB_AUTOQUERY_INSERT);
$dbh->execute($stmt,array('timmy','white'));

$stmt = 'SELECT
            *
         FROM
            person
         WHERE first_name = \'timmy\'';
$rows = $dbh->getAssoc($stmt, DB_FETCHMODE_ASSOC);

foreach ($rows as $key => $value) {
	echo "<h3>Key: $key</h3>";
	foreach ($value as $columnname => $columnvalue) {
		echo "<b>$columnname:</b> $columnvalue<br>";
	}
}

//$stmt = $dbh->prepare('UPDATE person SET last_name = ?, first_name = ? WHERE person_id = ?');
//$dbh->execute($stmt,array('foolast','foofirst',1));




?>