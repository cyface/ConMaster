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

$table_name = 'person';
$colA = 'state';
$colB = 'city';

$table_name = $_GET['table_name'];
$colA = $_GET['colA'];
$colB = $_GET['colB'];

$stmt = "SELECT
            IFNULL($colA,'_NULL') $colA,
			IFNULL($colB,'_NULL') $colB,
			count(*) count
         FROM
            $table_name
         GROUP BY
		 	IFNULL($colA,'_NULL'),
			IFNULL($colB,'_NULL')
		 ORDER BY
		    IFNULL($colA,'_NULL'),
			IFNULL($colB,'_NULL')";
$rows = $dbh->getAll($stmt, DB_FETCHMODE_ASSOC);

//echo '<pre>'; echo print_r($rows); echo '</pre>';

require_once( 'class.TemplatePower.inc.php');

//make a new TemplatePower object
$tpl = new TemplatePower( './templates/report.html' );

//let TemplatePower do its thing, parsing etc.
$tpl->prepare();

$tpl->assign('colAHeader',ucwords(str_replace('_',' ',$colA)));
$tpl->assign('colBHeader',ucwords(str_replace('_',' ',$colB)));

$lastColA = -1;
$aggregate = 0;

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
			$tpl->assign('count',$aggregate);
			$aggregate = 0;
			
			$tpl->newBlock('result_row');
			$tpl->assign('colA',$row[$colA]);
		break;
	} //end switch
	$lastColA = $row[$colA];
	$aggregate += $row['count'];
	$tpl->assign('colB',$row[$colB]);
	$tpl->assign('count',$row['count']);
}
$tpl->newBlock("total_row"); //Final total
$tpl->assign('colA',$lastColA);
$tpl->assign('count',$aggregate);


//print the result
$tpl->printToScreen();

?>