<div class="tabbable" id="tabs-car" style='padding-top:10px;'>
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#panel-showcar" data-toggle="tab" id='showcartab'>Manage Car</a>
		</li>
		<li>
			<a href="#panel-newcar" data-toggle="tab" id='editcartab'><span class="glyphicon glyphicon-plus"></span>&nbsp;New Car</a>
		</li>
	</ul>
<!-- Manage Car -->		
	<div class="tab-content">
		<div class="tab-pane active" id="panel-showcar">
			<div class='helptip' id='helptip' style="display:none;">
				<a class='label label-primary'>E</a> Edit /
				<a class='label label-success'>F</a> Flag(on Homepage) /
				<a class='label label-default'>F</a> Not on Homepage /
				<a class='label label-warning'>O</a> Order /
				<a class='label label-danger'>H</a> Hide /
				<a class='label label-default'>H</a> Not Hide /
			</div>		
		<table class='table table-striped'>
				<thead>
					<tr>
						<th>
							Orders
						</th>
						<th>
							Name
						</th>
						<th>
							Displacement
						</th>
						<th>
							Time to Market
						</th>
						<th>
							Price
						</th>
						<th width='13%'>
							Operation <a href='javascript:void(0);' onclick="$('#helptip').toggle()" class="glyphicon glyphicon-question-sign icona"></a>
						
						</th>
					</tr>
				</thead>
				<tbody>
	<?php
				//Get all car detail information
				$sql_carList = "SELECT id,name,displacement,ttm,price,flag,hide,orders FROM car ORDER BY orders";
				$res_carList = $mysql->query($sql_carList);
				while($row_aL = $mysql->fetch($res_carList)){
					echo "<tr>
							<td>{$row_aL['orders']}
							</td>
							<td>{$row_aL['name']}
							</td>
							<td>{$row_aL['displacement']} L
							</td>
							<td>{$row_aL['ttm']}
							</td>
							<td>RMB {$row_aL['price']}
							</td>";
	?>						<td>
							<a class='label label-primary' href="index.php?page=car&edit=<?php echo $row_aL['id'];?>">E</a>
							<a class='label label-<?php echo $row_aL['flag']==1? 'success':'default';?>' href='index.php?page=car&flag=<?php echo $row_aL['id'];?>'>F</a>
							<a class='label label-warning' href='index.php?page=car&order=<?php echo $row_aL['id'];?>'>O</a>
							<a class='label label-<?php echo $row_aL['hide']==1? 'danger':'default';?>' href='index.php?page=car&hide=<?php echo $row_aL['id'];?>'>H</a>
						</td>
					</tr>
	<?php
					
				}
	?>
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="panel-newcar">
			<form method='post' style='padding-top:20px;' enctype="multipart/form-data">
	<?php
		/*Create input form based on data type of car table*/
		$sql_carColumns = "SHOW FULL COLUMNS FROM car";//get all car columns information
		$res_carColumns = $mysql->query($sql_carColumns);
		$i=0;
		while($row_carColumns = $mysql->fetch($res_carColumns)){
			$i++;
			if($i>1&&$i<21){
				$fieldName[$i] =  $row_carColumns['Field'];
				$units = empty($row_carColumns['Comment'])?'':"&nbsp;[".$row_carColumns['Comment']."]";
				switch($row_carColumns['Type']){//different input limit based on different data type
					case 'varchar(150)':
						$inputType='text';$inputLimit="maxlength=150";
						break;
					case 'float':
					case 'year(4)':
						$inputType='number';$inputLimit="max=9999 min=1";
						break;
					case 'smallint(5) unsigned':
						$inputType='number';$inputLimit="max=65534 min=1";
						break;
					case 'double':
					case 'int(10) unsigned':
						$inputType='number';$inputLimit="max=99999999 min=1";
						break;
					default:
						$inputType='text';
						$inputLimit='';
				}
	?>
				<div class="form-group col-sm-6 carCols">
					 <label class="col-sm-6 control-label"><?php echo ucwords($row_carColumns['Field']).$units;?></label>
					<div class="col-sm-6">
						<input type="<?php echo $inputType;?>" class="form-control" name='<?php echo $row_carColumns['Field'];?>' <?php echo $inputLimit;?>/>
					</div>
				</div>
	<?php
			}
		}
		echo "<script>for(var i=0;i<3;i++){
						$('.carCols input').eq(i).attr('required',true);
						$('.carCols label').eq(i).html($('.carCols label').eq(i).html()+'&nbsp;<span class=\"req\">*</span>')
					}
			</script>";//Set required input
	?>
				<div class="form-group col-sm-6 carCols">
					 <label class="col-sm-6 control-label">Picture</label>
					<div class="col-sm-6">
						<input type="file" class="form-control" id='img' onchange="fileSelected('car')"/>
						<div class='progress progress-striped active' id='upres' style="display:none"><label style="position:absolute;width:90%;text-align:center"></label>
							<div class="progress-bar progress-bar-success"></div>
						</div>
						<img id="thumbnail" width='100%' style='display:none'>
						<input type="hidden" name='imgname' id="imgname">
					</div>
				</div>
				<div class="form-group col-sm-8 col-md-offset-2">
					<button type="submit" class="btn btn-block btn-success" name='newcar'>Submit</button>
					<button type="button" class="btn btn-danger btn-block" onclick="location.href='index.php?page=car'">Cancel</button>
				</div>	
			</form>
		</div>
	</div>
</div>
<!-- Car Order Form -->	
			<input type='hidden' id='modal-2' href='#modal-container-2' data-toggle='modal'></input>	
			<div class="modal fade" id="modal-container-2" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h1 class="modal-title text-center">
								Change Car Order
							</h1>
						</div>
						<div class="modal-body">		
							<form method='post' action='index.php?page=car'>
			<?php
				/*Change car order*/
				if(isset($_GET['order'])){
					$orderId = inputCheck($_GET['order']);
					$res_order = $mysql->fetch($mysql->Query("SELECT id,orders FROM car WHERE id = $orderId"));
					$totalnum = $mysql->oneQuery("SELECT COUNT(*) AS total FROM car");
					echo "<input type='number' class='form-control' min=1 max={$totalnum} value='{$res_order['orders']}' name='newOrder' />
						<input type='hidden' name='origOrder' value='{$res_order['orders']}'/>
						<input type='hidden' name='orderId' value='$orderId'/>";
				}
			?>
								<br/><button type='submit' class='btn btn-success btn-block' style='padding-right:0;'/>Submit</button>
							</form>
						</div>
					</div>	
				</div>
			</div>
<?php
/**Create a New Car*/
	if(isset($_POST['newcar'])){
		$newCarInfo='';
		$filename = empty($_POST['imgname']) ? 'noimg.jpg':inputCheck($_POST['imgname']);
		for($i=2;$i<21;$i++){
			$newCarVal = inputCheck($_POST[$fieldName[$i]]);
			$newCarInfo .= "'".$newCarVal."',";
		}
		$countCar = $mysql->oneQuery("SELECT COUNT(id) FROM car")+1;
		$sql_newCar = "INSERT car VALUES ('',$newCarInfo'$filename','0','','0')";
		$mysql->query($sql_newCar);
		$mysql->query("UPDATE car SET orders = '$countCar' WHERE id = ".mysqli_insert_id($mysql->conn));
		redirect('index.php?page=car','Create a new car successfully!');
	}
/**Edit Car Infomation*/
	if(isset($_GET['edit'])){
		$editId = inputCheck((int)$_GET['edit']);
		$result = $mysql->query("SELECT * FROM car WHERE id = $editId");
		if(mysqli_num_rows($result)){
			$origData = $mysql->fetchassoc($result);
			unset($_GET['edit']);
			echo "<script>
					$('#editcartab').click()
					$('[name=\"newcar\"]').attr('name','editcar')
					$('#editcartab').html('<span class=\"glyphicon glyphicon-edit\"></span>&nbsp;Edit Car');
					$('#thumbnail').show()
					$('#thumbnail').attr('src','../static/img/car/{$origData['thumb']}')
			</script>";
			$i=0;
			foreach($origData as $key => $value){
				$i++;
				if($i>1&&$i<21){
				echo "<script>
						$('[name=\"$key\"]').val('".inputCheck($value)."')	
					</script>";
				}
			}
		}
	}
	if(isset($_POST['editcar'])){
		$editCarInfo='';
		$filename = empty($_POST['imgname']) ? $origData['thumb']:inputCheck($_POST['imgname']);
		for($i=2;$i<21;$i++){
			$newCarVal = inputCheck($_POST[$fieldName[$i]]);
			$editCarInfo .= "{$fieldName[$i]} = '$newCarVal',";
		}
		$sql_editCar = "UPDATE car SET {$editCarInfo}thumb='$filename' WHERE id = $editId ";
		$mysql->query($sql_editCar);
		redirect('index.php?page=car');
	}
/**Recommend car to homepage*/		
		if(isset($_GET['flag'])){
			$flagId = inputCheck($_GET['flag']);
			$curFlag = $mysql->oneQuery("SELECT flag FROM car WHERE id=$flagId");
			if($curFlag==0){
				$totalFlag = $mysql->oneQuery("SELECT COUNT(flag) FROM car WHERE flag=1");
				if($totalFlag < 3){
					$mysql->query("UPDATE car SET flag = 1 WHERE id = $flagId");
					redirect('index.php?page=car','This car will show in the homepage!');
				}else{
					echo "<script>alert('You can only Show 3 cars in homepage at most!');</script>";
				}
			}else{
				$mysql->query("UPDATE car SET flag = 0 WHERE id = $flagId");
				redirect('index.php?page=car');
			}
		}
/**Edit Order of Car*/
	if(isset($_GET['order'])){
		echo "<script>$('#modal-2').click();</script>";
	}
	if(isset($_POST['newOrder'])){
		$newOrder = inputCheck((int)$_POST['newOrder']);
		$orderId = inputCheck($_POST['orderId']);
		$origOrder = inputCheck($_POST['origOrder']);
		if($origOrder!=$newOrder){
			$replaceId = $mysql->oneQuery("SELECT id FROM car WHERE orders = $newOrder");
			$mysql->query("UPDATE car SET orders = $newOrder WHERE id = $orderId");
			$mysql->query("UPDATE car SET orders = $origOrder WHERE id = $replaceId");
			redirect('index.php?page=car',"Exchange No.$origOrder for No.$newOrder Successfully!");
		}	
	}
/**Hide Car*/
	if(isset($_GET['hide'])){
		$hideId = inputCheck($_GET['hide']);
		$curStatus = $mysql->oneQuery("SELECT hide FROM car WHERE id=$hideId");
		if($curStatus==1){
			$mysql->query("UPDATE car SET hide = 0 WHERE id = $hideId");
			redirect('index.php?page=car','This Car will show in Car list!');
		}else{
			$mysql->query("UPDATE car SET hide = 1 WHERE id = $hideId");
			redirect('index.php?page=car','This Car will hide in Car list!');
		}
	}
?>

