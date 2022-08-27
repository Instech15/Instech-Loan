<?php include 'db_connect.php' ?>
<script type="text/javascript">function printPageArea(areaID){
    var printContent = document.getElementById(areaID);
    var WinPrint = window.open('', '', 'width=900,height=650');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
}
</script>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h3 align="center">Payments Report</h3>				
			</div>
			<div class="card-body">

			<div class="form-row">
						<form method="POST">
							<table>
								<tr>
									<td><label>From: </label><input class="form-control" style="width:300px; height:40px;" type="date" name="from"></td>
									<td><label>To: </label><input class="form-control" style="width:300px; height:40px;" type="date" name="to"></td>
								</tr>
								<tr>
									<td>
									<hr />
									<input type="submit" value="Generate Report" style="width:300px; height:40px;" name="submit" class="btn btn-success">
									</td>
								</tr>
							</table>
						</form>
					</div>
<br />
				<table class="table table-bordered" id="loan-list">
					<colgroup>
						<col width="10%">
						<col width="25%">
						<col width="20%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">SN</th>
							<th class="text-center">Payee</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Penalty</th>
							<th class="text-center">Date</th>
						</tr>
					</thead>
					<tbody>
					<?php
								if (isset($_POST['submit'])){
								include('db_connect.php');
								$from=date('Y-m-d',strtotime($_POST['from']));
								$to=date('Y-m-d',strtotime($_POST['to']));	
								$oquery=$conn->query("select * from payments where `date_created` between '$from' and '$to' order by id");
								while($orow = $oquery->fetch_array()){
									?>

<tr>
						<td><?php echo $orow['id']?></td>
						<td><?php echo $orow['payee']?></td>
						<td><?php echo number_format($orow['amount'],2) ?></td>
						<td><?php echo number_format($orow['penalty_amount'],2) ?></td>
						<td><?php echo $orow['date_created']?></td>
					</tr>
					<?php 
				}
			}
		?>		
						<tr>
			<?php
				if (isset($_POST['submit'])){
				include('db_connect.php');
				$from=date('Y-m-d',strtotime($_POST['from']));
				$to=date('Y-m-d',strtotime($_POST['to']));
				$oquery=$conn->query("SELECT sum(amount) as total, sum(penalty_amount) as penalty from payments where `date_created` between '$from' and '$to'");
				while($orow = $oquery->fetch_array()){
					?>
							<td><strong>Total</strong></td>
							<td></td>
			<td><strong><?php echo number_format($orow['total'],2) ?></strong></td>
			<td><strong><?php echo number_format($orow['penalty'],2) ?></strong></td>
			<td></td>
		</tr>
					<?php 
				}
			}
		?>
						
					</tbody>
				</table>
				<button onclick="window.print()" id="areaID" class="btn btn-success">Print Report</button>
			</div>
		</div>
	</div>
</div>
<style>
	td p {
		margin:unset;
	}
	td img {
	    width: 8vw;
	    height: 12vh;
	}
	td{
		vertical-align: middle !important;
	}
</style>	
<script>
	$('#loan-list').dataTable()
	$('#new_payments').click(function(){
		uni_modal("New Payement","manage_payment.php",'mid-large')
	})
	$('.edit_payment').click(function(){
		uni_modal("Edit Payement","manage_payment.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_payment').click(function(){
		_conf("Are you sure to delete this data?","delete_payment",[$(this).attr('data-id')])
	})
function delete_payment($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_payment',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Payment successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>