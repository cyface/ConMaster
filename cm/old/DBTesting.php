<?php

include_once("DB.php");

function handle_pear_error ($error) {
    echo "An error occurred while trying to run your query.<br>\n";
    echo "Error message: " . $error->getMessage() . "<br>\n";
    echo "A more detailed error description: " . $error->getDebugInfo() . "<br>\n";
}

PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handle_pear_error');

$dsn = array(
    'phptype'  => "mysql",
    'hostspec' => "fdmreports.uswc.uswest.com",
    'database' => "cm",
    'username' => "cm",
    'password' => "cm"
);
$dbh = DB::connect($dsn);

/*
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
*/

require_once 'Pager.php';
$from = 0;   // The row to start to fetch from (you might want to get this
		  // param from the $_GET array
$limit = 10; // The number of results per page
$maxpages = 10; // The number of pages for displaying in the pager (optional)
$res = $dbh->limitQuery('SELECT * FROM person', $from, $limit);
$nrows = 0; // Alternative you could use $res->numRows()
while ($row = $res->fetchrow()) {
	echo "$row";
 $nrows++;
}
$data = DB_Pager::getData($from, $limit, $nrows, $maxpages);


?>