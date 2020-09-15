<script>
	$(document).ready(function(){
		time = setInterval(function(){printTime()},1000)
	});
</script>
<div class="tabbable" id="tabs-dashboard" style='padding-top:10px;'>
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#panel-dashboard" data-toggle="tab">Dashboard</a>
		</li>
		<li>
			<a href="#panel-editprofile" data-toggle="tab" id='myprofile'><span class="glyphicon glyphicon-cog"></span>&nbsp;My Profile</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="panel-dashboard">
			<h2 class='text-center'>Chengdu Ferrari Dealership CMS</h2><br>
			<div class='col-sm-12 userinfo'>
				<label>Current User Infomation</label>
				<table class='table'>
					<tr><th>Username:</th><td><?php echo $_SESSION['admin'];?></td>
						<th>User Role:</th><td class='btn-success'><?php echo $mysql->oneQuery("SELECT name FROM role WHERE id = {$_SESSION['role']}");?></td>
	<?php
		//Get current user's information
		$sql_userinfo = "SELECT * from user WHERE id = {$_SESSION['adminid']}";
		$res_userinfo = $mysql->fetch($mysql->query($sql_userinfo)); //Last login ip = columns from user table
		$sql_curip = "SELECT loginip,logintime FROM loginlog WHERE success = 1 AND username = '{$_SESSION['admin']}' ORDER BY logintime DESC LIMIT 1";
		$curip = $mysql->oneQuery($sql_curip); //Current ip = Last record from loginlog table
		$diffIp = $curip==$res_userinfo['lastloginip'] ? "":"btn-warning' title='Different From Last Login IP";
	?>
					</tr>
					<tr><th>Last Login IP:</th><td><?php echo $res_userinfo['lastloginip'];?></td>
						<th>Last Login Time:</th><td><?php echo $res_userinfo['lastlogindate'];?></td>
					</tr>
					<tr><th>Current IP: </th>
						<td class='<?php echo $diffIp;?>'><?php echo $curip;?></td>
						<th>Current Time: </th>
						<td id="curtime"></td>
					</tr>
					<td class='split' colspan=4></td>
				</table>
				<div class='clientinfo'>
					<b>Current Client: </b>
					<?php echo $_SERVER['HTTP_USER_AGENT'];?>
				</div>
			</div>
			<div class='col-sm-12 sysinfo'>
			<label>System Infomation</label>
				<table class='table table-striped'>
					<tr>
						<th>Server OS: 
						</th>
						<td><?php echo PHP_OS;?>
						</td>
					</tr>
						<th>System Environment: 
						</th>
						<td><?php echo $_SERVER["SERVER_SOFTWARE"];?>
						</td>
					</tr>
					</tr>
						<th>MySQL Version: 
						</th>
						<td><?php echo mysqli_get_server_info($mysql->conn);?>
						</td>
					</tr>
					</tr>
						<th>Upload Limit: 
						</th>
						<td><?php echo ini_get('upload_max_filesize');?>
						</td>
					</tr>
					</tr>
						<th>Execution Time Limit: 
						</th>
						<td><?php echo ini_get('max_execution_time');?>
						</td>
					</tr>
					</tr>
						<th>Remaing Storage: 
						</th>
						<td><?php echo ROUND((@disk_free_space(".") / (1024 * 1024)), 2).'M';?>
						</td>
					</tr>
					<tr>
						<th>Current Database: 
						</th>
						<td><?php $cdb=$mysql->oneQuery('SELECT DATABASE()');echo $cdb;?>
						</td>
					</tr>
						<th>Total Tables: 
						</th>
						<td><?php echo $mysql->oneQuery("SELECT count(TABLE_NAME) FROM information_schema.TABLES WHERE TABLE_SCHEMA='$cdb'");?>
						</td>
					</tr>
					</tr>
						<th>Total Users: 
						</th>
						<td><?php echo $mysql->oneQuery("SELECT COUNT(*) FROM user");?>
						</td>
					</tr>
					</tr>
						<th>Total Members: 
						</th>
						<td><?php echo $mysql->oneQuery("SELECT COUNT(*) FROM member");?>
						</td>
					</tr>
					</tr>
						<th>Total Cars: 
						</th>
						<td><?php echo $mysql->oneQuery("SELECT COUNT(*) FROM car");?>
						</td>
					</tr>
					</tr>
						<th>Total Articles: 
						</th>
						<td><?php echo $mysql->fetch($mysql->query("SELECT COUNT(*) FROM article"))[0];?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="tab-pane" id="panel-editprofile">
			<form method='post' style='padding-top:20px;'>
				<div class='col-md-3 col-md-offset-1'>
					<label>Change Password</label>
				</div>
				<div class="form-group col-md-6 col-md-offset-1">
					
					<div class="form-group">
						 <label>Password </label>
						 <input type="password" class="form-control" name='oldpwd' required/>
					</div>
					<div class="form-group">
						 <label>Password </label>
						 <input type="password" class="form-control" onchange='checkpwd()' name='pwd' required/>
						 <kbd class='seepwd' onmousedown="seepwd('pwd')"><i class='fa fa-eye'></i></kbd>
					</div>
					<div class="form-group">
						<label>Password Confirm </label>
						<input type="password" class="form-control" onchange='checkpwd()' name='pwdConfirm' required/>
						<kbd class='seepwd' onmousedown="seepwd('pwdConfirm')" onclick='checkpwd()'><i class='fa fa-eye'></i></kbd>
					</div><hr/>
					<div class="form-group col-md-4 col-md-offset-4" style='padding:0'>
						 <button type="submit" class="btn btn-block btn-lg btn-success" name='sign' onmousedown='checkpwd()' disabled>Submit</button>
					</div>
				</div>
			</form>
			<form method='post' style='padding-top:20px;'>
				<div class='col-md-3 col-md-offset-1'>
					<label>Change Information</label>
				</div>
				<div class="form-group col-md-6 col-md-offset-1">
					<div class="form-group col-md-6">
						<label>Last name</label><input type="text" class="form-control" name='lname' maxlength=20/>
					</div>
					<div class="form-group col-md-6">
						<label>First name</label><input type="text" class="form-control" name='fname' maxlength=20/>
					</div>
					<div class="form-group col-md-6">
						<label>Phone</label><input type="tel" class="form-control" name='tel' maxlength=30/>
					</div>
					<div class="form-group col-md-6">
						<label>Email</label><input type="email" class="form-control" name='email' maxlength=30/>
					</div>
					<div class="form-group col-md-4 col-md-offset-4" style='padding:0'>
						<button type="submit" class="btn btn-block btn-lg btn-success" name='editinfo'>Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php 
/**Edit Password*/
	if(isset($_POST['sign'])){
		$oldpwd = inputCheck($_POST['oldpwd']);
		$res_pwd = $mysql->fetch($mysql->query("SELECT pwd,salt FROM user WHERE id = '{$_SESSION['adminid']}'"));
		$oldpwdhash = MD5($oldpwd.$res_pwd['salt']);
		if($oldpwdhash == $res_pwd['pwd']){
			$newpwdhash = MD5($_POST['pwd'].$res_pwd['salt']);
			if($newpwdhash==$oldpwdhash){
				echo "<script>$('#myprofile').click();
					$('[name=\"pwd\"').addClass('alert-danger');
					$('[name=\"pwd\"').focus();
					alert('New Password Cannot be same as the original one!');
				</script>";
			}else{
				$sql_newPwd = "UPDATE user SET pwd = '$newpwdhash' WHERE id = {$_SESSION['adminid']}";
				$mysql->query($sql_newPwd);
				unset($_SESSION['admin']);
				unset($_SESSION['adminid']);
				unset($_SESSION['role']);
				redirect('login.php','Change Password Successfully!\\nPlease Log in again!');
			}
		}else{
			echo "<script>$('#myprofile').click();
				$('[name=\"oldpwd\"').addClass('alert-danger');
				$('[name=\"oldpwd\"').focus();
				alert('Wrong Password');
			</script>";
		}
	}
/**Edit User Info*/
	echo "<script>
				$('[name=\"fname\"').val('".inputCheck($res_userinfo['fname'])."')
				$('[name=\"lname\"').val('".inputCheck($res_userinfo['lname'])."')
				$('[name=\"tel\"').val('".inputCheck($res_userinfo['tel'])."')
				$('[name=\"email\"').val('".inputCheck($res_userinfo['email'])."')
		</script>";
	if(isset($_POST['editinfo'])){
		$fname = inputCheck($_POST['fname']);
		$lname = inputCheck($_POST['lname']);
		$tel = inputCheck($_POST['tel']);
		$email = inputCheck($_POST['email']);
		$sql_updateInfo = "UPDATE user SET fname = '$fname', lname = '$lname', tel = '$tel', email = '$email' WHERE id = '{$_SESSION['adminid']}'";
		$mysql->query($sql_updateInfo);
		redirect('index.php?page=dashboard','Change information Successfully!');
	}
?>