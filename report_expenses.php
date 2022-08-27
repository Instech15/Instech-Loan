<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<h3 align="center">Expenses Report</h3>
			<h5 align="center">Select a start and end date (first and last day) of the month of which report you're about to generate.</h5>
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
			</div>
		</div>
		
	<div class="card">
	<table  class="table table-bordered">
		<thead>
			<th>SN</th>
			<th>Amount</th>
			<th>Category</th>
			<th>Recipent's Name</th>
			<th>Date</th>
		</thead>
		<tbody>
		<?php
			if (isset($_POST['submit'])){
				include('db_connect.php');
				$from=date('Y-m-d',strtotime($_POST['from']));
				$to=date('Y-m-d',strtotime($_POST['to']));
				$oquery=$conn->query("select * from `expenses` where `date` between '$from' and '$to'");
				while($orow = $oquery->fetch_array()){
					?>
					<tr>
						<td><?php echo $orow['id']?></td>
						<td><?php echo $orow['expense']?></td>
						<td><?php echo $orow['note']?></td>
						<td><?php echo $orow['name']?></td>
						<td><?php echo $orow['date']?></td>
					</tr>
					<?php 
				}
			}
		?>
</div>
		
		<tr>
			<?php
				if (isset($_POST['submit'])){
				include('db_connect.php');
				$from=date('Y-m-d',strtotime($_POST['from']));
				$to=date('Y-m-d',strtotime($_POST['to']));
				$oquery=$conn->query("select sum(expense) as total from `expenses` where `date` between '$from' and '$to'");
				while($orow = $oquery->fetch_array()){
			?>
		<tr>
			<td><strong>Total</strong></td>
			<td><strong><?php echo number_format($orow['total'],2) ?></strong></td>
			<td></td>
			<td></td>
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
	$('#expenses-list').dataTable()
	$('#new_expenses').click(function(){
		uni_modal("New expenses","manage_expenses.php",'mid-large')
	})
	$('.edit_expenses').click(function(){
		uni_modal("Edit expenses","manage_expenses.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_expenses').click(function(){
		_conf("Are you sure to delete this expenses?","delete_expenses",[$(this).attr('data-id')])
	})
function delete_expenses($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_expenses',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("expenses successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>