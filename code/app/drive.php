	<dl class="container">
		<h1 class="text-center text-danger"><?php echo ucwords($_SESSION['user'])."'s Test Drive Requests";?></h1>
		<dd class="row clearfix table-striped col-md-10 col-md-offset-1">
			<table class='table'>
				<thead>
					<tr>
						<th>
							Car
						</th>
						<th>
							Appointment Time
						</th>
						<th>
							Contacts
						</th>
						<th>
							Status
						</th>
						<th>
							Delete
						</th>
					</tr>
				</thead>
				<tbody>
		<?php
			//Get all of test drive information of the user
			$sql_testdrive = "SELECT d.id,m.username,d.appoint,CONCAT(u.fname,'',u.lname) AS staff,d.status_id,c.name AS car FROM drive AS d INNER JOIN member AS m ON d.cus_id=m.id LEFT JOIN user AS u ON d.emp_id=u.id INNER JOIN car AS c ON d.car_id=c.id WHERE m.id={$_SESSION['userid']}";
			$res_testdrive = $mysql->query($sql_testdrive);
			if(mysqli_num_rows($res_testdrive)){
				while($row_testdrive = $mysql->fetch($res_testdrive)){
					$statusClass = $row_testdrive['status_id']==1 ? 'check alert-success':'question alert-danger';
					echo "<tr'>
						<td>{$row_testdrive['car']}
						</td>
						<td>{$row_testdrive['appoint']}
						</td>
						<td>{$row_testdrive['staff']}
						</td>
						<td><span class='fa fa-$statusClass'></span>
						</td>
						<td><a class='label label-danger' onclick=\"if(confirm('Do you really want to delete your request?'))location.href='index.php?page=drive&del={$row_testdrive['id']}'\">X</a>
						</td>
					</tr>";
				}
			}else{
				//Empty state
				echo "<div class='alert alert-dismissable alert-danger text-center'>
				 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<h4>No Requests</h4>
				You have No Test Drive Requests!
				</div>";
			}
		?>				
				</tbody>	
			</table>
		</dd>
	</dl>
<?php
/**Function of delete test drive request*/
	if(isset($_GET['del'])){
		$delID = inputCheck($_GET['del']);
		$mysql->query("DELETE FROM drive WHERE id = $delID");
		redirect('index.php?page=drive','Delete successfully!');
	}
?>