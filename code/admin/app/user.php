<div class='helptip1' id='helptip' style="display:none;">
		<a class='label label-primary'>E</a> Edit /
		<a class='label label-danger'>X</a> Delete /
	</div>		
		<table class='table table-striped'>
				<thead>
					<tr>
						<th>
							Username
						</th>
						<th>
							Role
						</th>
						<th>
							Real Name
						</th>
						<th>
							Phone
						</th>
						<th>
							Email
						</th>
						<th>
							Last Login IP
						</th>
						<th>
							Last Login Date
						</th>
						<th>
							Operation <a href='javascript:void(0);' onclick="$('#helptip').toggle()" class="glyphicon glyphicon-question-sign icona"></a>
						</th>
					</tr>
				</thead>
				<tbody>
	<?php
				//Show all uses' information
				$sql_userList = "SELECT u.*,CONCAT(u.fname,' ',lname) AS realname,r.name AS role FROM user AS u INNER JOIN role AS r ON u.role_id = r.id";
				$res_userList = $mysql->query($sql_userList);
				while($row_aL = $mysql->fetch($res_userList)){
					echo "<tr>
							<td>{$row_aL['username']}
							</td>
							<td>{$row_aL['role']}
							</td>
							<td>{$row_aL['realname']}
							</td>
							<td>{$row_aL['tel']}
							</td>
							<td>{$row_aL['email']}
							</td>
							<td>{$row_aL['lastloginip']}
							</td>
							<td>{$row_aL['lastlogindate']} 
							</td>";
	?>
						<td>
							<a class='label label-<?php echo $_SESSION['adminid']==$row_aL["id"]? 'default':'primary'?>' href='index.php?page=system&action=user&role=<?php echo $row_aL['id'];?>'>E</a>
							<a class='label label-<?php echo $_SESSION['adminid']==$row_aL["id"]? 'default':'danger'?>' onclick="if(confirm('Do you want to Delete this System User'))location.href='index.php?page=system&action=user&del=<?php echo $row_aL['id'];?>'">X</a>
						</td>
					</tr>
	<?php
				}
	?>
				</tbody>
			</table>
<!-- Edit role Form -->	
			<input type='hidden' id='modal-2' href='#modal-container-2' data-toggle='modal'></input>	
			<div class="modal fade" id="modal-container-2" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h1 class="modal-title text-center">
								Change User Role
							</h1>
						</div>
						<div class="modal-body">		
							<form method='post' action='index.php?page=system&action=user'>
							  <div class="form-group">
								<select class="form-control" name='newRole' required>
								  <option value="">Select a Role...</option>
					<?php
						//Get all user role
						$sql_queryRole = "SELECT * FROM role";
						$sql_queryRole = $mysql->query($sql_queryRole);
						while($row_queryRole = $mysql->fetch($sql_queryRole)){
							$isdiabled = $row_queryRole['pid']==0 ? 'disabled':'';
							echo "<option value='{$row_queryRole['id']}' $isdiabled>{$row_queryRole['name']}</option>";
						}
					?>
								</select>
							  </div>
								<div class="form-group">
									<label>Please Verify Your Password...</label>
									<input type='password' name='cfpwd' class="form-control" required/>
								</div>
								<input type='hidden' name='editid'/>
								<br/><button type='submit' class='btn btn-success btn-block' style='padding-right:0;'/>Submit</button>
							</form>
						</div>
					</div>	
				</div>
			</div>
<?php
/**Delete a user*/
		if(isset($_GET['del'])){
			$delId = inputCheck($_GET['del']);
			if($_SESSION['adminid']==$_GET['del']){
				echo "<script>alert('You cannot delete current account!')</script>";
			}else{
				$mysql->query("DELETE FROM user WHERE id = $delId");
				redirect('index.php?page=system&action=user','Delete System User Successfully!');
			}
		}
/**Edit Role of User*/
		if(isset($_GET['role'])){
			$newRoleId = inputCheck($_GET['role']);
			if($newRoleId==$_SESSION['adminid']){
				echo "<script>alert('You cannot edit your own job!')</script>";
			}else{
				echo "<script>$('#modal-2').click();$('[name=\"editid\"]').val('$newRoleId')</script>";
			}
		}
/**Update a user's role*/
		if(isset($_POST['newRole'])){
			$editId = inputCheck($_POST['editid']);
			$newRole = inputCheck($_POST['newRole']);
			$rightres = $mysql->fetch($mysql->query("SELECT pwd,salt FROM user WHERE id = {$_SESSION['adminid']}"));
			$cfpwdhash = md5($_POST['cfpwd'].$rightres['salt']);
			if($cfpwdhash == $rightres['pwd']){
				$sql_newRole = "UPDATE user SET role_id = '$newRole' WHERE id = '$editId'";
				$mysql->query($sql_newRole);
				redirect('index.php?page=system&action=user','Edit User Role Successfully!');
			}else{
				echo "<script>alert('Wrong Password!')</script>";
			}
		}
?>