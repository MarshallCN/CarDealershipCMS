<div class="tabbable" id="tabs-role" style='padding-top:10px;'>
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#panel-newacc" data-toggle="tab" id='editcartab'><span class="glyphicon glyphicon-cog"></span>&nbsp;Access Rule</a>
		</li>
		<li>
			<a href="#panel-showrole" data-toggle="tab" id='showcartab'>User Role</a>
		</li>
	</ul>	
	<div class="tab-content">
	<!-- Show all roles -->	
		<div class="tab-pane" id="panel-showrole">	
		<table class='table table-striped'>
				<thead>
					<tr>
						<th>
							ID
						</th>
						<th>
							Role Name
						</th>
						<th>
							Available Menu
						</th>
						<th>
							Toltal Users
						</th>
					</tr>
				</thead>
				<tbody>
	<?php
				//Show all user roles information
				$sql_roleList = "SELECT r.id,r.name,COUNT(a.id) AS menus FROM role AS r INNER JOIN access AS a ON a.role_id = r.id WHERE a.access = 1 GROUP BY a.role_id";
				$res_roleList = $mysql->query($sql_roleList);
				while($row_aL = $mysql->fetch($res_roleList)){
					$totalusers=$mysql->oneQuery("SELECT COUNT(*) FROM user WHERE role_id ={$row_aL['id']}");
					echo "<tr>
							<td>{$row_aL['id']}
							</td>
							<td>{$row_aL['name']}
							</td>
							<td>{$row_aL['menus']}
							</td>
							<td>$totalusers
							</td>";
	?>						<td>
						</td>
					</tr>
	<?php
					
				}
	?>
				</tbody>
			</table>
		</div>
	<!-- Manage role -->
		<div class="tab-pane active" id="panel-newacc">
				<div class="form-group col-sm-6" style='padding-top:20px;'>
					<label class="col-sm-4 col-md-offset-1 control-label">Parent Menu </label>
					<div class="col-sm-6">
						<select class="form-control" name='roleid' onchange="location.href='index.php?page=system&action=role&roleid='+this.value">
							
			<?php
				$sql_queryRole = "SELECT * FROM role";
				$sql_queryRole = $mysql->query($sql_queryRole);
				while($row_queryRole = $mysql->fetch($sql_queryRole)){
					echo "<option value='{$row_queryRole['id']}'>{$row_queryRole['name']}</option>";
				}
			?>
						</select>
					</div>
				</div>
			<table class='table table-striped'>
				<thead>
					<tr>
						<th>
							Menu Name
						</th>
						<th>
							Menu URL
						</th>
						<th>
							Parent Menu
						</th>
						<th width='12%'>
							Available
						
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
				//automatically select the role
				if(isset($_GET['roleid'])){
					$roleid = inputCheck($_GET['roleid']);
					echo "<script>$('[name=\"roleid\"]').val($roleid)</script>";
				}
				if(empty($roleid))$roleid=1;//default select first one
				//Show all access information of a user
				$sql_accessList = "SELECT a.id,m.name,m.url,mp.name AS parent,a.access FROM access AS a INNER JOIN admin_menu AS m ON a.menu_id = m.id LEFT JOIN admin_menu AS mp ON m.pid=mp.id WHERE role_id = '$roleid' ORDER BY a.access,m.id";
				$res_accessList = $mysql->query($sql_accessList);
				while($row_accessList = $mysql->fetch($res_accessList)){
					echo "<tr>
						<td>{$row_accessList['name']}
						</td>
						<td>{$row_accessList['url']}
						</td>
						<td>{$row_accessList['parent']}
						</td>";
						
			?>			
							<td>
							<a class='label label-<?php echo $row_accessList['access']==1? 'success':'default';?>' href='index.php?page=system&action=role&access=<?php echo $row_accessList['id'];?>'>A</a>
						</td>
						</tr>
			<?php
				}
			?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
/**Edit Role*/
	if(isset($_GET['access'])){
		$accessid = inputCheck($_GET['access']);
		$curaccess = $mysql->fetch($mysql->query("SELECT * FROM access WHERE id = $accessid"));
		if($curaccess['role_id']==1){
			echo "<script>alert('You cannot edit Super Administrator :)')</script>";
		}else{
			$newAccess = $curaccess['access']==0 ? 1:0;
			$mysql->query("UPDATE access SET access = $newAccess WHERE id = $accessid");
			redirect('index.php?page=system&action=role','Edit Successfully!');
		}
	}
?>