<?php
	$datecond='';
	if(!empty($_GET['from']) && !empty($_GET['to']))
	{
		$dateCond="DATE(trn_date) >= '($_GET['from'])' AND DATE(trn_date) <= '($_GET['to'])'";
	}
	$sql="select * from payments where ($datecond) and ($dateCond) asc";
	$stmt=include(db_connect.php)->prepare($sql);
	$stmt=$stmt->execute();$arr=$stmt->fetchAll(PDO:: FETCH_ASSOC)
	
?>
<form method="get" action="index.php">
	<div>
		<label>Start Date</label>
		<input type="date" name="from" placeholder="Select Start Date" value="<?php echo isset(_GET[from]) ?$_GET['from'] : ?>"/>
	</div>
	<div>
		<label>End Date</label>
		<input type="date" name="to" placeholder="Select End Date" value="<?php echo isset(_GET[to]) ?$_GET['to'] : ?>"/>
	</div>
	<div>
		<input type="submit" value="Generate">
	</div>
</form>