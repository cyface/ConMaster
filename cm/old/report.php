<?php

require_once('DB.php');

function handle_pear_error ($error) {
    echo "An error occurred while trying to run your query.<br>\n";
    echo "Error message: " . $error->getMessage() . "<br>\n";
    echo "A more detailed error description: " . $error->getDebugInfo() . "<br>\n";
}

PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handle_pear_error');

$dsn = array(
    'phptype'  => "mysql",
    'hostspec' => "localhost",
    'database' => "cyface",
    'username' => "cyface",
    'password' => "jmnd9ivb"
);
$dbh = DB::connect($dsn,array('debug'=>'5'));

$table = $_GET['table'];
$colA = $_GET['colA'];
$colB = $_GET['colB'];
$whereClause = stripslashes(urldecode(($_GET['whereClause'])));
//echo '<PRE> whereClause: ' . $whereClause . '</PRE>';
if (!$_GET['table']) {
    $table = 'person';
}

if (!$_GET['colA']) {
    $colA = 'state';
}

if (!$_GET['colB']) {
    $colB = 'city';
}

if (!$_GET['whereClause']) {
    $whereClause = '1';
}

$stmt = "SELECT
            IF(LENGTH($colA),$colA,'_NULL') $colA,
			IF(LENGTH($colB),$colB,'_NULL') $colB,
			count(*) count
         FROM
            $table
		 WHERE
		 	$whereClause
         GROUP BY
		 	IF(LENGTH($colA),$colA,'_NULL'),
			IF(LENGTH($colB),$colB,'_NULL')
		 ORDER BY
		    IF(LENGTH($colA),$colA,'_NULL'),
			IF(LENGTH($colB),$colB,'_NULL')";
$rows = $dbh->getAll($stmt, DB_FETCHMODE_ASSOC);

//echo '<pre>'; echo print_r($rows); echo '</pre>';

require_once( 'class.TemplatePower.inc.php');

//make a new TemplatePower object
$tpl = new TemplatePower( './templates/report_two_col.html' );

//let TemplatePower do its thing, parsing etc.
$tpl->prepare();

$tpl->assign('colAHeader',ucwords(str_replace('_',' ',$colA)));
$tpl->assign('colBHeader',ucwords(str_replace('_',' ',$colB)));

$lastColA = -1;
$subtotal = 0;
$total = 0;

foreach ($rows as $row) {
	switch ($lastColA) {
		case -1:
			$lastColA = $row[$colA];
			$tpl->newBlock('result_row');
			$tpl->assign('colA',$row[$colA]);
		break;
		case ($row[$colA]):
			$tpl->newBlock('result_row');
			$tpl->assign('colA','');
		break;
		default: //when colA != $lastColA
			$tpl->newBlock("total_row");
			$tpl->assign('colA',$lastColA);
			$tpl->assign('count',$subtotal);
			$subtotal = 0;
			
			$tpl->newBlock('result_row');
			$tpl->assign('colA',$row[$colA]);
		break;
	} //end switch
	$lastColA = $row[$colA];
	$subtotal += $row['count'];
	$total += $row['count'];
	$tpl->assign('colB',$row[$colB]);
	$tpl->assign('count',$row['count']);
}
$tpl->newBlock("total_row"); //Final subtotal
$tpl->assign('colA',$lastColA);
$tpl->assign('count',$subtotal);
$tpl->newBlock("total_row"); //Final total
$tpl->assign('colA','Grand');
$tpl->assign('count',$total);


//print the result
$tpl->printToScreen();

?>