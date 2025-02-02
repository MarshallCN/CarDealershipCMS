<?php 
	session_start();
	require "../include/db.php";
	include 'include/header.html';
?>
<dl class="adminnav">
	<dd class="row clearfix">
	<h1 class='sysTit text-center'><a href='../index.php'><img src='../static/img/ferrari_logo_sm1.jpg' height=100></a>&nbsp;Ferrari Content Management System</h1>
		<div class="col-md-6 col-md-offset-3 main loginform">
			<form method="post" class='col-md-10 col-md-offset-1'>
				<h2 class="text-center">Log in or Sign up</h2>
					<div class="form-group">
						 <label>Username</label><input type="text" class="form-control" name='username' maxlength=20 placeholder='admin' oninput="checkNewName('admin')" required/><kbd class='seepwd hidden'><i class=''></i></kbd>
					</div>
					<div class="form-group">
						 <label>Password </label>
						 <input type="password" class="form-control" name='pwd' placeholder='1234' required/>
						 <kbd class='seepwd' onmousedown="seepwd('pwd')"><i class='fa fa-eye'></i></kbd>
					</div>
				<!-- Only show when Sign up -->
					<span id='signInput' style='display:none'>
						<div class="form-group">
							<label>Password Confirm </label>
							<input type="password" class="form-control" onchange='checkpwd()' name='pwdConfirm'/>
							<kbd class='seepwd' onmousedown="seepwd('pwdConfirm')" onclick='checkpwd()'><i class='fa fa-eye'></i></kbd>
						</div>
						<div class="form-group col-md-6">
							<label>Last name</label><input type="text" class="form-control" name='lname' maxlength=20/>
						</div>
						<div class="form-group col-md-6">
							<label>First name</label><input type="text" class="form-control" name='fname' maxlength=20/>
						</div>
						<div class="form-group">
							<label>Job Type</label>
							<select class="form-control" name='role'>
								<option value="">Select a Role...</option> 
					<?php
						//Get all the role
						$sql_queryRole = "SELECT * FROM role";
						$res_queryRole = $mysql->query($sql_queryRole);
						while($row_queryRole = $mysql->fetch($res_queryRole)){
							$valid = $row_queryRole['pid']>3 ? $row_queryRole['id']:"'' disabled";
							echo "<option value=$valid>{$row_queryRole['name']}</option>";
						}
					?>
							</select>
						</div>
						<div class="form-group">
							<label>Phone Number</label><input type="tel" class="form-control" name='tel' maxlength=30/>
						</div>
						<div class="form-group">
							<label>Email</label><input type="email" class="form-control" name='email' maxlength=30/>
						</div>
					</span>
					<div class="form-group col-md-6" style='padding:0'>
						 <button type="button" class="btn btn-block btn-lg btn-default" onclick='showSignForm()' name='formlabel'>New Staff</button>
					</div>
					<div class="form-group col-md-6" style='padding:0'>
						 <button type="submit" class="btn btn-block btn-lg btn-success" name='log'>Log in</button>
					</div>
			</form>
		
<?php
	include "include/footer.html";
/**Log in*/	
	if(isset($_POST['log'])){
		$username = strtolower(inputCheck($_POST['username']));
		$pwd = inputCheck($_POST['pwd']);
		$res_pwd = $mysql->query("SELECT id,pwd,salt,role_id FROM user WHERE username = '$username'"); 
		$adminInfo = $mysql->fetch($res_pwd);
		$pwdhash = MD5($pwd.$adminInfo['salt']);
		$userIP = getenv("REMOTE_ADDR");
		if(mysqli_num_rows($res_pwd)){
			$rightpwd = $adminInfo['pwd'];
			if($pwdhash == $rightpwd){
				//Before login, get the last success login records from loginlog table
				$res_lastLogin = $mysql->fetch($mysql->query("SELECT loginip,logintime FROM loginlog WHERE success = 1 AND username = '$username' ORDER BY logintime DESC LIMIT 1"));
				//Storage the last login records in user table
				$mysql->query("UPDATE user SET lastloginip='{$res_lastLogin['loginip']}',lastlogindate='{$res_lastLogin['logintime']}' WHERE id = {$adminInfo['id']}");
				//Create new login records as curent login info, store in loginlog table
				$mysql->query("INSERT loginlog VALUES('','$userIP','$username','$pwdhash',NOW(),1)");
				//log in
				$_SESSION['admin'] = $username;
				$_SESSION['adminid'] = $adminInfo['id'];
				$_SESSION['role'] = $adminInfo['role_id'];
				echo "<script>$('[name=\"username\"').addClass('alert-success');$('[name=\"pwd\"').addClass('alert-success');</script>";
			}else{
				$mysql->query("INSERT loginlog VALUES('','$userIP','$username','$pwd',NOW(),0)");
				echo "<script>$('[name=\"username\"').addClass('alert-success')
					$('[name=\"pwd\"').addClass('alert-danger')
					$('[name=\"username\"').val('$username')
					alert('Wrong Password');$('[name=\"pwd\"').focus();
				</script>";
			}
		}else{
			$mysql->query("INSERT loginlog VALUES('','$userIP','$username','$pwd',NOW(),0)");
			echo "<script>$('[name=\"username\"').addClass('alert-danger');$('[name=\"username\"').focus();alert('Username not found')</script>";
		}	
	}
	
/**Sign up*/	
	if(isset($_POST['sign'])){
		$username = strtolower(inputCheck(preg_replace("/\s/","",$_POST['username'])));
		$nameUsed = $mysql->query("SELECT id FROM user WHERE username = '$username'");
		if(!mysqli_num_rows($nameUsed)||!empty($username)){
			$pwd = inputCheck($_POST['pwd']);
			$salt=base64_encode(mcrypt_create_iv(6,MCRYPT_DEV_RANDOM)); //Add random salt
			$pwdhash = MD5($pwd.$salt); //MD5 of pwd+salt
			$lname = inputCheck($_POST['lname']);
			$fname = inputCheck($_POST['fname']);
			$role = inputCheck($_POST['role']);
			$tel = inputCheck($_POST['tel']);
			$email = inputCheck($_POST['email']);
			$userIP = getenv("REMOTE_ADDR");
			$mysql->query("INSERT loginlog VALUES('','$userIP','$username','$pwdhash',NOW(),1)");
			$sql_newUser = "INSERT user(username,pwd,salt,fname,lname,role_id,tel,email,lastloginip,lastlogindate) VALUES ('$username','$pwdhash','$salt','$fname','$lname','$role','$tel','$email','','')";
			$mysql->query($sql_newUser);
			$_SESSION['admin'] = $username;
			$_SESSION['adminid'] =  mysqli_insert_id($mysql->conn);
			$_SESSION['role']=$role;
		}else{
			echo "<script>alert('Username has been used or empty, please change another one!')</script>";
		}
	}
	
/**after log in*/
	if(isset($_SESSION['admin'])){
		redirect('index.php');
	}	
?>
		