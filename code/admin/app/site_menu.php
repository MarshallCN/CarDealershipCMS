<div class="tabbable" id="tabs-menu" style='padding-top:10px;'>
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#panel-showmenu" data-toggle="tab" id='editmenutab'>Manage Menu</a>
		</li>
		<li>
			<a href="#panel-newmenu" data-toggle="tab" id='newmenutab'><span class="glyphicon glyphicon-plus"></span>&nbsp;New Menu Category</a>
		</li>
	</ul>
	<div class="tab-content">
		<!-- Manage Mneu -->	
		<div class="tab-pane active" id="panel-showmenu">
			<!-- Help tips -->
			<div class='helptip' id='helptip' style="display:none;">
				<a class='label label-primary'>E</a> Edit /
				<a class='label label-warning'>O</a> Order /
				<a class='label label-danger'>H</a> Hide /
				<a class='label label-default'>H</a> Not Hide /
			</div>	
		<table class='table table-striped'>
				<thead>
					<tr>
						<th>
							Order
						</th>
						<th>
							Menu Name
						</th>
						<th>
							Last Edited Time
						</th>
						<th>
							URL
						</th>
						<th>
							Parent Menu
						</th>
						<th width='12%'>
							Operation <a href='javascript:void(0);' onclick="$('#helptip').toggle()" class="glyphicon glyphicon-question-sign icona"></a>
						</th>
					</tr>
				</thead>
				<tbody>
	<?php
				//Show all menus of fontend
				$sql_menuList = "SELECT s.*,p.name AS parent FROM site_menu AS s LEFT JOIN site_menu AS p ON s.pid=p.id ORDER BY s.orders";
				$res_menuList = $mysql->query($sql_menuList);
				while($row_aL = $mysql->fetch($res_menuList)){
				$lastEditTime = empty((int)$row_aL['updtime']) ? $row_aL['cretime']:$row_aL['updtime'];
					echo "<tr>
							<td>{$row_aL['orders']}
							</td>
							<td>{$row_aL['name']}
							</td>
							<td>$lastEditTime
							</td>
							<td>{$row_aL['url']}
							</td>
							<td>{$row_aL['parent']}
							</td>";
	?>
						<td>
							<a class='label label-primary' href="index.php?page=content&action=menu&edit=<?php echo $row_aL['id'];?>">E</a>
							<a class='label label-warning' href='index.php?page=content&action=menu&order=<?php echo $row_aL['id'];?>'>O</a>
							<a class='label label-<?php echo $row_aL['hide']==1? 'danger':'default';?>' onclick="if(confirm('Do you want to Hide this Menu?')){location.href='index.php?page=content&action=menu&hide=<?php echo $row_aL['id'];?>'}">H</a>
						</td>
					</tr>
	<?php
				}
	?>
				</tbody>
			</table>
		</div>
		<!-- New Mneu -->
		<div class="tab-pane" id="panel-newmenu">
			<form method='post' style='padding-top:20px;'>
				<div class="form-group col-sm-7">
					 <label class="col-sm-4 col-md-offset-1 control-label">Menu Name</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name='menuName' maxlength=20 required/>
					</div>
				</div>
				<div class="form-group col-sm-7">
					<label class="col-sm-4 col-md-offset-1 control-label" >Parent Menu </label>
					<div class="col-sm-6">
						<select class="form-control" name='menuPar' required>
							<option value="">Select a Menu...</option> 
			<?php
				$sql_queryMenu = "SELECT * FROM site_menu WHERE pid = 0 AND id != 2";//Get all root menus
				$sql_queryMenu = $mysql->query($sql_queryMenu);
				while($row_queryMenu = $mysql->fetch($sql_queryMenu)){
					echo "<option value='{$row_queryMenu['id']}'>{$row_queryMenu['name']}</option>";
				}
			?>
						</select>
					</div>
				</div>
				<div class="form-group col-sm-5 col-md-offset-1">
					<button type="submit" class="btn btn-block btn-success" name='newmenu'>Submit</button>
					<button type="button" class="btn btn-danger btn-block" onclick="location.href='index.php?page=content&action=menu'">Cancel</button>
				</div>	
			</form>
		</div>
	</div>
</div>
<!-- Menu Order Form -->	
			<input type='hidden' id='modal-2' href='#modal-container-2' data-toggle='modal'></input>	
			<div class="modal fade" id="modal-container-2" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h1 class="modal-title text-center">
								Change Menu Order
							</h1>
						</div>
						<div class="modal-body">		
							<form method='post' action='index.php?page=content&action=menu'>
			<?php
				//Change menu order
				if(isset($_GET['order'])){
					$orderId = inputCheck($_GET['order']);
					$res_order = $mysql->fetch($mysql->query("SELECT id,orders FROM site_menu WHERE id = $orderId"));
					$totalnum = $mysql->oneQuery("SELECT COUNT(*) AS total FROM site_menu");
					echo "<input type='number' class='form-control' min=1 max={$totalnum} value='{$res_order['orders']}' name='newOrder' />
						<input type='hidden' name='origOrder' value='{$res_order['orders']}'/>
						<input type='hidden' name='orderId' value='$orderId'/>";
				}
			?>
								<br/><button type='submit' class='btn btn-success btn-block'/>Submit</button>
							</form>
						</div>
					</div>	
				</div>
			</div>
<?php
/**Create a New Menu*/
	if(isset($_POST['newmenu'])){
		$menuName = inputCheck($_POST['menuName']);
		$pid = mysqli_real_escape_string($mysql->conn, $_POST['menuPar']);
		$countMenu = $mysql->oneQuery("SELECT COUNT(*) FROM site_menu")+1;
		$sql_newMenu = "INSERT site_menu(name,pid,cretime,url,hide,orders) VALUES ('$menuName','$pid',NOW(),'index.php?page=list&mid=$countMenu',0,'$countMenu')";
		$mysql->query($sql_newMenu);
		redirect('index.php?page=content&action=menu','Create Menu Successfully!');
	}
/**Edit Menu*/
	if(isset($_GET['edit'])){
		$editId = inputCheck($_GET['edit']);
		$res_orig = $mysql->query("SELECT id,name,pid FROM site_menu WHERE id = $editId");
		if(mysqli_num_rows($res_orig)){
			$origData = $mysql->fetch($res_orig);
			if($origData['pid']==0){
				echo "<script>$('[name=\"menuPar\"]').attr('required','false');$('[name=\"menuPar\"]').attr('disabled','true')</script>";
			}else{
				echo "<script>$('[name=\"menuPar\"]').val({$origData['pid']})</script>";
			}
			echo "<script>
						$('#newmenutab').click()
						$('[name=\"menuName\"]').val('".inputCheck($origData['name'])."')
						$('[name=\"newmenu\"]').attr('name','editmenu')
						$('#newmenutab').html('<span class=\"glyphicon glyphicon-edit\"></span>&nbsp;Edit Menu');
				</script>";
			unset($_GET['edit']);
		}else{
			redirect('index.php?page=content&action=menu');
		}
	}
	if(isset($_POST['editmenu'])){
		$menuName = inputCheck($_POST['menuName']);
		$pid = isset($_POST['menuPar']) ? inputCheck($_POST['menuPar']):0;
		$sql_updateMenu = "UPDATE site_menu SET name = '$menuName',pid = '$pid',updtime = NOW() WHERE id = $editId";
		$mysql->query($sql_updateMenu);
		redirect('index.php?page=content&action=menu','Edit Menu Successfully!');
	}
/**Edit Order of Menu*/
	if(isset($_GET['order'])){
		echo "<script>$('#modal-2').click();</script>";
	}
	if(isset($_POST['newOrder'])){
		$newOrder = inputCheck((int)$_POST['newOrder']);
		$orderId = inputCheck($_POST['orderId']);
		$origOrder = inputCheck($_POST['origOrder']);
		if($origOrder!=$newOrder){
			$replaceId = $mysql->oneQuery("SELECT id FROM site_menu WHERE orders = $newOrder");
			$mysql->query("UPDATE site_menu SET orders = $newOrder WHERE id = $orderId");
			$mysql->query("UPDATE site_menu SET orders = $origOrder WHERE id = $replaceId");
			redirect('index.php?page=content&action=menu',"Exchange No.$origOrder for No.$newOrder Successfully!");
		}	
	}
/**Hide Menu*/
	if(isset($_GET['hide'])){
		$hideId = inputCheck($_GET['hide']);
		$curStatus = $mysql->oneQuery("SELECT hide FROM site_menu WHERE id=$hideId");
		if($curStatus==1){
			$mysql->query("UPDATE site_menu SET hide = 0 WHERE id = $hideId");
			redirect('index.php?page=content&action=menu','This Menu will show in the homepage!');
		}else{
			$mysql->query("UPDATE site_menu SET hide = 1 WHERE id = $hideId");
			redirect('index.php?page=content&action=menu','This Menu will NOT show in the homepage!');
		}
	}
?>

