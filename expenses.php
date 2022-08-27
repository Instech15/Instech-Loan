<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Expenses</b>
				</large>
				<button class="btn btn-primary btn-block col-md-2 float-right" type="button" id="new_expenses"><i class="fa fa-plus"></i> Add New Expenses</button>
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="expenses-list">
					<colgroup>
						<col width="10%">
						<col width="10%">
						<col width="20%">
						<col width="20%">
						<col width="10%">
						<col width="2%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">SN</th>
							<th class="text-center">Expenses</th>
							<th class="text-center">Category</th>
							<th class="text-center">Name of Recepient</th>
							<th class="text-center">Date</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
							$qry = $conn->query("SELECT * FROM expenses order by id desc");
							while($row = $qry->fetch_assoc()):

						 ?>
						 <tr>
						 	
						 	<td class="text-center"><?php echo $i++ ?></td>
							<td><?php echo $row['expense'] ?></td>
							<td><?php echo $row['note'] ?></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['date_created'] ?></td>

						 	<td class="text-center">
						 			<button class="btn btn-outline-primary btn-sm edit_expenses" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
						 			<button class="btn btn-outline-danger btn-sm delete_expenses" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></button>
						 	</td>

						 </tr>

						<?php endwhile; ?>
					</tbody>
				</table>
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