	<dl class="container" style="padding-top:0;">
		<dd class="row clearfix">
			<div class="col-sm-12">
				<div class="carousel slide" id="carousel-1">
					<ol class="carousel-indicators">
						<li data-slide-to="0" data-target="#carousel-1">
						</li>
						<li data-slide-to="1" data-target="#carousel-1" class="active">
						</li>
						<li data-slide-to="2" data-target="#carousel-1">
						</li>
					</ol>
					<div class="carousel-inner">
<?php
/**Show 3 recommended articles' cover picture in home page*/
	$sql_articleRecom = "SELECT a.id,a.name,m.name AS menu,a.coverimg FROM article AS a INNER JOIN site_menu AS m ON a.smenu_id=m.id WHERE a.flag != 0 ORDER BY a.flag LIMIT 3";
	$res_articleRecom = $mysql->query($sql_articleRecom);
	while($row_articleRecom = $mysql->fetch($res_articleRecom)){
?>		
						<div class="item">
							<img alt="1260x570" src="static/img/article/<?php echo $row_articleRecom['coverimg'];?>" width="100%"/>
							<div class="carousel-caption">
								<h4>
					<?php echo $row_articleRecom['menu'];?>
								</h4>
								<p><a href="index.php?page=article&aid=<?php echo $row_articleRecom['id'];?>" class="homelink">
					<?php echo $row_articleRecom['name'];?></a>
								</p>
							</div>
						</div>
<?php
	}echo "<script>$('.item')[1].className = 'item active'</script>";
?>
					</div> <a class="left carousel-control" href="#carousel-1" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-1" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
		</dd>
		<dd class="row clearfix">
			<div class="col-md-9">
				<div class="row">
<?php
/**Show 3 recommended cars picture in home page*/
	$sql_carRecom = "SELECT id,name,displacement,ttm,thumb FROM car WHERE flag != 0 ORDER BY flag LIMIT 3";
	$res_carRecom = $mysql->query($sql_carRecom);
	while($row_carRecom = $mysql->fetch($res_carRecom)){
?>
					<div class="col-sm-4">
						<div class="thumbnail">
							<img width='100%' src="static/img/car/<?php echo $row_carRecom['thumb'];?>" />
							<div class="caption">
								<h3>
									<?php echo $row_carRecom['name'];?>
								</h3>
								<p>
									<?php echo $row_carRecom['name'].'&nbsp'.$row_carRecom['displacement'].'L&nbsp'.$row_carRecom['ttm'];?>
								</p>
								<p>
									<a class="btn" href="index.php?page=car&cid=<?php echo $row_carRecom['id'];?>">More »</a>
								</p>
							</div>
						</div>
					</div>
<?php
	}
?>
				</div>
			</div>
			<div class="col-md-3" style="background:#f8f8f8;">
				<form method="post" action='index.php#logform' id='logform'>
				<p style="font-size:1.3em;text-align:center;font-weight:bold">Log in or Sign up</p>
					<div class="form-group">
						 <label>Username</label><input type="text" class="form-control" name='logname' placeholder='David' required/>
					</div>
					<div class="form-group">
						 <label>Password</label><input type="password" class="form-control" name='logpwd' placeholder='1234' required/>
					</div>
					<div class="form-group">
						 <button type="submit" class="btn btn-primary" name='log'>Log in</button>
						 <a id="modal-1" href="#modal-container-1" data-toggle="modal"><button type="reset" class="btn btn-default">Sign up
						 </button></a>
					</div>
				</form>
<?php	
/**If login show customer information*/	
		if(isset($_SESSION['userid'])){
			echo "<script>document.getElementById('logform').style.display='none'</script>";
			echo "<div class='text-center' id='userInfo'>
				<img src='static/img/avatar/{$_SESSION['avatar']}' class='avatar center-block'>
				<h3>Welcome, {$_SESSION['user']}</h3>
				<p><b>UID: <b> 1</p>
				<a href='index.php?page=profile'>My Profile</a><br/>
				<a href='index.php?page=drive'>My Request</a><br/>
				<a href='index.php?logout#footer'>Log Out</a>
			</div>";
		}
/**Log in and show result*/
		if(isset($_POST['log'])){
			$user = inputCheck($_POST['logname']);
			$inputpwd = inputCheck($_POST['logpwd']);
			$sql_userinfo = "SELECT * FROM member WHERE username = '$user'";
			$res_userinfo = $mysql->fetch($mysql->query($sql_userinfo));
			$pwd = $res_userinfo['pwd'];
			$userid = $res_userinfo['id'];
			echo "<div class='alert alert-dismissable alert-danger text-center' id='logerror'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4>";
			echo "<script>document.getElementsByName('logname')[0].value='{$_POST['logname']}';document.getElementsByName('logpwd')[0].value='$inputpwd'</script>";
			if(!empty($pwd)){
				if($pwd == md5($inputpwd)){
					$_SESSION['user'] = inputCheck(ucwords($res_userinfo['username']));
					$_SESSION['avatar'] = inputCheck($res_userinfo['avatar']);
					$_SESSION['userid'] = inputCheck($userid);
					echo "<script>$('#logerror').hide();changeStyle('logname','alert-success');changeStyle('logpwd','alert-success');setTimeout(function(){window.location.href='index.php'},500)</script>";
				}else{
					echo "Wrong Password";
					echo "<script>changeStyle('logpwd','alert-danger');changeStyle('logname','alert-success');</script>";
				}
			}else{
				echo "Username not found";
				echo "<script>changeStyle('logname','alert-danger');</script>";
			}
			echo "</h4></div>";
		}
/*Sign up**/		
		if(isset($_POST['sign'])){
			$username = inputCheck(strtolower(preg_replace("/\s/","",$_POST['username'])));
			$password = inputCheck(preg_replace("/\s/","",$_POST['pwd']));
			$phone = inputCheck($_POST['phone']);
			$address = inputCheck($_POST['address']);
			$email = inputCheck($_POST['email']);
			$ary_username=[];
			$sql_username = "SELECT username FROM member";
			$res_username = $mysql->query($sql_username);
			echo "<div class='alert alert-dismissable alert-danger text-center'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4>";
			while($row_username = $mysql->fetch($res_username)){
				$ary_username[]=$row_username['username'];
			}
			if(in_array($username,$ary_username)){
				echo "Username already exists!";
			}else if(empty($username)){
				echo "Username is Empty!";
			}else{
				if(strlen($password)>3){
					$sql_signin = "INSERT member (username,pwd,phone,email,address) VALUES ('$username',md5('$password'),'$phone','$email','$address')";
					$mysql->query($sql_signin);
					$_SESSION['user'] = $username;
					$_SESSION['avatar'] = 'head1.png';
					$_SESSION['userid'] = mysqli_insert_id($mysql->conn);
					redirect('index.php');
				}else{
					echo "Password must longer than 3!";
				}
			}
		}
	
?>
				</div>
			</div>
		</dd>
	</dl>
			<div class="modal fade" id="modal-container-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h1 class="modal-title text-center">
								Sign up
							</h1>
						</div>
						<div class="modal-body">
							<form action='index.php#footer' method='post'>
							  <div class='form-group'>
								<label>Username:&nbsp;<span class='req'>*</span></label>
									<input type='text' name='username' class='form-control' maxlength=15 placeholder='David' oninput="checkNewName('cus')" required /><kbd class='seepwd hidden'><i class=''></i></kbd><br/>
								<label>Password:&nbsp;<span class='req'>*</span></label>
									<input type='password' name='pwd' class='form-control' onchange='checkpwd()' maxlength=20 placeholder='1234' required /><kbd class='seepwd' onmousedown="seepwd('pwd')"><i class='fa fa-eye'></i></kbd><br/>
								<label>Password Again:&nbsp;<span class='req'>*</span></label>
									<input type='password' name='pwdConfirm' class='form-control' onchange='checkpwd()'  maxlength=20 placeholder='1234' required /><kbd class='seepwd' onmousedown="seepwd('pwdConfirm')" onclick='checkpwd()'><i class='fa fa-eye'></i></kbd><br/>
								<label>Email:&nbsp;<span class='req'>*</span></label>
									<input type='email' name='email' class='form-control' maxlength=50 placeholder='David@gmail.com' required /><br/>
								<label>Phone:&nbsp;</label>
									<input type='tel' name='phone' class='form-control' maxlength=22 placeholder='1234567890'/><br/>
								<label>Address:&nbsp;</label>
									<input type='text' name='address' class='form-control' maxlength=100 placeholder='CDUT_Str.123'/><br/>
							  </div>
								<button type='submit' class='btn btn-success btn-block btn-lg' name='sign' style='padding-right:0;' disabled />Sign up</button>
							</form>
						</div>
					</div>	
				</div>
			</div>