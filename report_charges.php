<?php include 'db_connect.php' ?>
<html>
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

<div class="container-fluid" id="areaID">
	<div class="col-lg-12">
		<div class="card">

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

			<div class="card-body">
			<h3 align="center">Charges Report</h3>
				<table class="table table-bordered" id="loan-list">
					<colgroup>
						<col width="2%">
						<col width="10%">
						<col width="8%">
						<col width="8%">
						<col width="8%">
						<col width="8%">
						<col width="8%">
						<col width="10%">
						<col width="10%">
						<col width="20%">

					</colgroup>
					<thead>
						
						<tr>
							<th class="text-center">SN</th>
							
							<th class="text-center">Payee's Reference No.</th>
							<th class="text-center">Risk Premium</th>
							<th class="text-center">Registration Fee</th>
							<th class="text-center">Savings</th>
							<th class="text-center">Pass Book</th>
							<th class="text-center">Loan Form</th>
							<th class="text-center">ID Card</th>
							<th class="text-center">Loan Amount</th>
							<th class="text-center">Trans. Dates</th>

						</tr>
					</thead>
					<tbody>
						<?php
								if (isset($_POST['submit'])){
								include('db_connect.php');
								$from=date('Y-m-d',strtotime($_POST['from']));
								$to=date('Y-m-d',strtotime($_POST['to']));
								$oquery=$conn->query("select * from `loan_list` where `date_created` between '$from' and '$to'");
				while($orow = $oquery->fetch_array()){
					?>
					<tr>
						<td><?php echo $orow['id']?></td>
						<td><?php echo $orow['ref_no']?></td>
						<td><?php echo $orow['risk']?></td>
						<td><?php echo $orow['reg']?></td>
						<td><?php echo $orow['savings']?></td>
						<td><?php echo $orow['pbook']?></td>
						<td><?php echo $orow['lform']?></td>
						<td><?php echo $orow['idcard']?></td>
						<td><?php echo $orow['amount']?></td>
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
				$oquery=$conn->query("SELECT sum(risk) as totalrisk, sum(reg) as totalreg, sum(savings) as totalsavings, sum(pbook) as totalpbook, sum(lform) as totallform, sum(idcard) as totalidcard, sum(amount) as totalamount from loan_list where `date_created` between '$from' and '$to'");
				while($orow = $oquery->fetch_array()){
			?>
			<td><strong>Total</strong></td>
			<td></td>
			<td><strong><?php echo number_format($orow['totalrisk'],2) ?></strong></td>
			<td><strong><?php echo number_format($orow['totalreg'],2) ?></strong></td>
			<td><strong><?php echo number_format($orow['totalsavings'],2) ?></strong></td>
			<td><strong><?php echo number_format($orow['totalpbook'],2) ?></strong></td>
			<td><strong><?php echo number_format($orow['totallform'],2) ?></strong></td>
			<td><strong><?php echo number_format($orow['totalidcard'],2) ?></strong></td>
			<td><strong><?php echo number_format($orow['totalamount'],2) ?></strong></td>
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