<?php

include('Pager.php');

$params['itemData'] = range(1, 140);
$pager = &new Pager($params);
$data  = $pager->getPageData();
$links = $pager->getLinks();
list($from, $to) = $pager->getOffsetByPageId();

?>
<html>
<body>

<table border="0" width="100%">
	<tr>
		<td colspan="3" align="center">
			Displaying [<?=$from?> - <?=$to?>] of <?=$pager->_totalItems?> <br />
			<?=$links['pages']?>
		</td>
	</tr>

	<tr>
		<td><nobr><?=$links['back']?></nobr></td>
		<td align="center" width="100%">&nbsp;</td>
		<td align="right"><nobr><?=$links['next']?></nobr></td>
	</tr>

	<tr>
		<td colspan="3">
			<pre><?print_r($data)?></pre>
		</td>
	</tr>
</table>

<h4>Results from methods:</h4>
<pre>
getCurrentPageID()...: <?=$pager->getCurrentPageID()?> 
getNextPageID()......: <?var_dump($pager->getNextPageID())?>
getPreviousPageID()..: <?var_dump($pager->getPreviousPageID())?>
numItems()...........: <?var_dump($pager->numItems())?>
numPages()...........: <?var_dump($pager->numPages())?>
isFirstPage()........: <?var_dump($pager->isFirstPage())?>
isLastPage().........: <?var_dump($pager->isLastPage())?>
isLastPageComplete().: <?var_dump($pager->isLastPageComplete())?>
</pre>

</body>
</html>