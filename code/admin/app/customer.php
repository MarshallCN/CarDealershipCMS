<div class="tabbable" id="tabs-article" style='padding-top:10px;'>
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#panel-showcus" data-toggle="tab" id='showcus'>Manage Customer</a>
		</li>
		<li>
			<a href="#panel-request" data-toggle="tab" id='driverequ'><span class="fa fa-calendar-check-o"></span>&nbsp;Test Drive Request</a>
		</li>
	</ul>
<!-- Manage Customer -->		
	<div class="tab-content">
		<div class="tab-pane active" id="panel-showcus">
			<div class='helptip' id='helptip' style="display:none;">
					<a class='label label-danger'>X</a> Delete
			</div>	
			<table class='table table-striped'>
				<thead>
					<tr>
						<th>
							Username
						</th>
						<th>
							Email
						</th>
						<th>
							Phone
						</th>
						<th>
							Address
						</th>
						<th class='text-center'>
							Operation <a href='javascript:void(0);' onclick="$('#helptip').toggle()" class="glyphicon glyphicon-question-sign icona"></a>
						</th>
					</tr>
				</thead>
				<tbody>
	<?php
				//show all customer infomation
				$sql_memberList = "SELECT * FROM member";
				$res_memberList = $mysql->query($sql_memberList);
				while($row_aL = $mysql->fetch($res_memberList)){
					echo "<tr>
							<td>{$row_aL['username']}
							</td>
							<td>{$row_aL['email']}
							</td>
							<td>{$row_aL['phone']}
							</td>
							<td>{$row_aL['address']}
							</td>";
	?>
						<td class='text-center'>
							<a class='label label-danger' onclick="if(confirm('Do you want to Delete this Member'))location.href='index.php?page=customer&del=<?php echo $row_aL['id'];?>'">X</a>
						</td>
					</tr>
	<?php
				}
	?>
				</tbody>
			</table>
	<?php
		//Delete customer function
		if(isset($_GET['del'])){
			$delId = inputCheck($_GET['del']);
			$mysql->query("DELETE FROM drive WHERE cus_id = $delId");
			$mysql->query("DELETE FROM member WHERE id = $delId");
			redirect('index.php?page=customer','Delete Member Successfully!');
		}
	?>
		</div>
<!-- Manage Test Drive Request -->
		<div class="tab-pane" id="panel-request">
			<div class='helptip' id='helptip1' style="display:none;">
				<a class='label label-success'>D</a> Done /
				<a class='label label-default'>D</a> Not Done /
				<a class='label label-danger'>X</a> Delete /
			</div>
			<table class='table table table-striped'>
				<thead>
					<tr>
						<th>
							Customer
						</th>
						<th>
							Car
						</th>
						<th>
							Appointment Time
						</th>
						<th>
							Contact Staff
						</th>
						<th>
							Operation <a href='javascript:void(0);' onclick="$('#helptip1').toggle()" class="glyphicon glyphicon-question-sign icona"></a>
						</th>
					</tr>
				</thead>
				<tbody>
		<?php
			//Get all of test drive request information
			$sql_testdrive = "SELECT d.id,m.username,d.appoint,CONCAT(u.fname,'',u.lname) AS staff,d.status_id,c.name AS car FROM drive AS d INNER JOIN member AS m ON d.cus_id=m.id LEFT JOIN user AS u ON d.emp_id=u.id INNER JOIN car AS c ON d.car_id=c.id ORDER BY d.id";
			$res_testdrive = $mysql->query($sql_testdrive);
			if(mysqli_num_rows($res_testdrive)){
				while($row_testdrive = $mysql->fetch($res_testdrive)){
					$statusClass = $row_testdrive['status_id']==1 ? 'success':'default';
					echo "<tr'>
						<td>{$row_testdrive['username']}
						</td>
						<td>{$row_testdrive['car']}
						</td>
						<td>{$row_testdrive['appoint']}
						</td>
						<td>{$row_testdrive['staff']}
						</td>
						<td><a class='label label-$statusClass' onclick='changeStatus(this,\"{$row_testdrive['id']}\")'>D</a>						
						<a class='label label-danger' onclick=\"if(confirm('Do you really want to delete your request?'))location.href='index.php?page=customer&deldrive={$row_testdrive['id']}'\">X</a>
						</td>
					</tr>";
				}				
			}else{
				//Empty state
				echo "<div class='alert alert-dismissable alert-danger text-center'>
				 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<h4>No Requests</h4>No Test Drive Requests!
				</div>";
			}
		?>				
				</tbody>	
			</table>
<?php
/**Delete request*/
	if(isset($_GET['deldrive'])){
		$deldrive = inputCheck($_GET['deldrive']);
		$mysql->query("DELETE FROM drive WHERE id = $deldrive");
		redirect('index.php?page=customer','Delete successfully!');
	}	
?>
		</div>
	</div>
</div>