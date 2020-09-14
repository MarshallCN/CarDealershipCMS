	<dl class="container">
		<h1 class="text-center text-danger"><?php echo ucwords($_SESSION['user'])."'s Profile";?></h1>
		<dd class="row clearfix">
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
					<img src='static/img/avatar/<?php $Avatar=$mysql->oneQuery("SELECT avatar FROM member WHERE id = '{$_SESSION['userid']}'");
					echo $Avatar;$_SESSION['avatar']=$Avatar;?>' width=100 id='avatarthum'>
				</div>
				<div class="form-group col-md-6 col-md-offset-1">
					<div class="form-group col-md-6">
						<label>Phone</label><input type="tel" class="form-control" name='tel' maxlength=50/>
					</div>
					<div class="form-group col-md-6">
						<label>Email</label><input type="email" class="form-control" name='email' maxlength=50 required/>
					</div>
					<div class="form-group col-md-6">
						<label>Address</label><input type="text" class="form-control" name='address' maxlength=100/>
					</div>
					<div class="form-group col-md-6">
						<label>Avatar</label>
						<select class="form-control" name='avatar' onchange='showthumb()'> 
							<option value="">Select a Avatar...</option>
			<?php
			//Get avatar pictures
				$avadir = "./static/img/avatar/";
				if(is_dir($avadir)){
					$files=scandir($avadir);
					for($i=2;$i<count($files);$i++){
						echo "<option value='{$files[$i]}'>".$files[$i]."</option>";
					}
				}
			?>
						</select>
					</div>
					<div class="form-group col-md-4 col-md-offset-4" style='padding:0'>
						<button type="submit" class="btn btn-block btn-lg btn-success" name='editinfo'>Submit</button>
					</div>
				</div>
			</form>
		</dd>
	</dl>

<?php 
/**Edit Password*/
		if(isset($_POST['sign'])){
		$oldpwd = inputCheck($_POST['oldpwd']);
		$rightpwd = $mysql->oneQuery("SELECT pwd FROM member WHERE id = {$_SESSION['userid']}");
		if($rightpwd == md5($oldpwd)){
			$newpwd = inputCheck($_POST['pwd']);
			if($newpwd==$oldpwd){
				echo "<script>
					$('[name=\"pwd\"').addClass('alert-danger');
					$('[name=\"pwd\"').focus();
					alert('New Password Cannot be same as original one!');
				</script>";
			}else{
				$sql_newPwd = "UPDATE member SET pwd = MD5('$newpwd') WHERE id = {$_SESSION['userid']}";
				echo $sql_newPwd;
				$mysql->query($sql_newPwd);
				unset($_SESSION['user']);
				unset($_SESSION['userid']);
				unset($_SESSION['avatar']);
				redirect('index.php#footer','Change Password Successfully!\\nPlease Log in again!');
			}
		}else{
			echo "<script>$('#myprofile').click();
				$('[name=\"oldpwd\"').addClass('alert-danger');
				$('[name=\"oldpwd\"').focus();
				alert('Wrong Password');
			</script>";
		}
	} 
/**Edit Member Info*/
	$sql_memberinfo = "SELECT * from member WHERE id = {$_SESSION['userid']}";
	$res_memberinfo = $mysql->fetch($mysql->query($sql_memberinfo));
	echo "<script>
				$('[name=\"tel\"').val('".inputCheck($res_memberinfo['phone'])."')
				$('[name=\"email\"').val('".inputCheck($res_memberinfo['email'])."')
				$('[name=\"address\"').val('".inputCheck($res_memberinfo['address'])."')
				$('[name=\"avatar\"').val('".inputCheck($res_memberinfo['avatar'])."')
		</script>";
	if(isset($_POST['editinfo'])){
		$tel = inputCheck($_POST['tel']);
		$email = inputCheck($_POST['email']);
		$address = inputCheck($_POST['address']);
		$avatar = inputCheck($_POST['avatar']);
		$sql_updateInfo = "UPDATE member SET phone = '$tel', email = '$email', address = '$address',avatar = '$avatar' WHERE id = '{$_SESSION['userid']}'";
		$mysql->query($sql_updateInfo);
		redirect('index.php?page=profile','Change information Successfully!');
	}
?>