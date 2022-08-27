<div class="card-body">
			<form action="" method="GET">
				<div class="row">
					<div class="col-md4">
						<div class="form-group">
							
								<input type="date" name="from_date" class="form-control">
						</div>&nbsp;
					</div>
					<div class="col-md4">
						<div class="form-group">
							
								<input type="date" name="to_date" class="form-control">
						</div>
					</div>
					<div class="col-md4">
						<div class="form-group">
							
								<button type="submit" class="btn btn-primary" id="">Submit Request</button>
						</div>
					</div>
				</div>
			</form>
			</div>


            <?php
						$con=mysqli_connect("localhost", "root", "", "easybuy");
						if (isset($_GET['from_date']) && isset($_GET['to_date']))
						{
							$from_date=$_GET['from_date'];
							$to_date=$_GET['to_date'];
							$querry="SELECT * FROM expenses WHERE `date` BETWEEN '$from_date' AND '$to_date' order by id";
							$querry_run=mysqli_querry($con, $querry);

							if(mysqli_num_rows($querry) > 0)
							{
								foreach($querry_run as $row)
								{		
									echo $row['expense'];
								}
							}
							else
								{
									echo 'No Record found';
								}
							}
							?>