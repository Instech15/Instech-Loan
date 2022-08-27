<?php 
extract($_POST);

$weekly = ($amount + ($amount * ($interest/100))) / $weeks;
$penalty = $weekly * ($penalty/100);

?>
<hr>
<table width="100%">
	<tr>
		<th class="text-center" width="33.33%">Total Payable Amount</th>
		<th class="text-center" width="33.33%">weekly Payable Amount</th>
		<th class="text-center" width="33.33%">Penalty Amount</th>
	</tr>
	<tr>
		<td class="text-center"><small><?php echo number_format($weekly * $weeks,2) ?></small></td>
		<td class="text-center"><small><?php echo number_format($weekly,2) ?></small></td>
		<td class="text-center"><small><?php echo number_format($penalty,2) ?></small></td>
	</tr>
</table>
<hr>
