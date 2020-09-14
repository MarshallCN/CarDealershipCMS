<?php
//Get Car ID and query car detail informaiton
if(isset($_GET['cid'])){
	$cid = (int)mysqli_real_escape_string($mysql->conn, $_GET['cid']);
	if(empty($cid))$cid=1;
	$sql_carinfo = "SELECT * FROM car WHERE id = $cid";
	$result = $mysql->query($sql_carinfo);
	$carinfo = $mysql->fetchassoc($result);
	$sql = "SHOW FULL COLUMNS FROM car";
	$res = $mysql->query($sql);
	$quan = [];//Store quantity unit
	while($test = $mysql->fetch($res)){
		$quan[$test["Field"]]=$test['Comment'];
	}
?>
<dl class="container">
	<h1 class="text-center text-danger">Ferrari <?php echo $carinfo['name'];?></h1>
	<dd class="row clearfix">
		<div class="col-md-6">
			<img src='static/img/car/<?php echo $carinfo['thumb'];?>' width="100%">
			<div class="form-group col-sm-5 col-md-offset-3" style="padding-top:20px">
				<button type="button"  id='modal' href='#modal-container' data-toggle='modal' class="btn btn-block btn-lg btn-danger">Appoint a Test Drive</button>
				<button type="button"  id='modal' class="btn btn-block btn-lg btn-primary" onclick='location.href="index.php?page=car"'><i class="fa fa-angle-double-left"></i>&nbsp;Back to Car List</button>
			</div>
		</div>
		<div class="col-md-6">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Technical Specifications</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
<?php
		//show all car detail except id and thumbnail path
		$carinfo = array_slice($carinfo,1,count($carinfo)-5);
		foreach($carinfo as $key => $value){
				$keyCap = ucwords($key);
				echo "
					<tr>
						<td>
							$keyCap
						</td>
						<td>
							$value {$quan[$key]}
						</td>
					</tr>";
			}
?>				
				</tbody>
			</table>
		</div>
	</dd>
</dl>
				
<div class="modal fade" id="modal-container" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h1 class="modal-title text-center">
						Choose a Time to Drive
				</h1>
			</div>
			<div class="modal-body">		
			<form method='post'>
				<div class="form-group">
					<label>Appointment Date: </label>
					<input type='date' class='form-control' name='reqsDate' onchange="checkDate()" required/>
				</div>
				<div class="form-group">
					<label>Appointment Time: </label>
					<input type='time' class='form-control' name='reqsTime' required />
				</div>
				<input type='hidden' name='carid' value="<?php echo $cid;?>"/>
				<button type='submit' class='btn btn-success btn-block'/>Submit</button>
			</form>
			</div>
		</div>	
	</div>
</div>
<script>
$(document).ready(setTimeToNow)
</script>
<?php
/**New test drive Requrest*/
	if(isset($_POST['reqsDate'])){
		if(!isset($_SESSION['user'])){ //If customer have no login
			redirect('index.php#footer','Please Login First!');
		}else{
			$res_cusinfo = $mysql->fetch($mysql->query("SELECT * FROM member WHERE id = {$_SESSION['userid']}"));
			if(empty($res_cusinfo['phone'])||empty($res_cusinfo['address'])){ //If customer have no detail profile informaiton
				redirect('index.php?page=profile','Please fill in your Phone and Address first,\\nSo we could reach you!');
			}else{ //New test drive request insert
				$reqsDate = inputCheck($_POST['reqsDate']);
				$reqsTime = inputCheck($_POST['reqsTime']);
				$datetime = $reqsDate.' '.$reqsTime.':00';
				$mysql->query("INSERT drive(cus_id,car_id,appoint) VALUES({$_SESSION['userid']},{$_POST['carid']},'$datetime')");
				redirect('index.php?page=drive','Send test drive requrest successfully!\\nWe will contact you later!');
			}
		}
		
	}
}else{
?>
<dl class="container">
  	<h1 class="text-center text-danger">Ferrari Cars</h1>
	<dd class="row clearfix">
	<?php
		$sql_carlist = "SELECT id,name,ttm,thumb,price FROM car WHERE hide != 1 ORDER BY orders";
		$res_carlist = $mysql->query($sql_carlist);
		while($row_carlist = $mysql->fetch($res_carlist)){
	?>	
		<div class="col-sm-4">
			<a href='index.php?page=car&cid=<?php echo $row_carlist['id'];?>'>
			<img src="static/img/car/<?php echo $row_carlist['thumb']?>" width="100%"/>
			<p><?php echo "<b>".$row_carlist['name']."</b> ".$row_carlist['ttm']." RMB:".$row_carlist['price'];?></p></a>
		</div>
	<?php
		}
	?>
	</dd>
</dl>
<?php
}
?>
