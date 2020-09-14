<!-- Login log -->
	<div class="form-group col-sm-12">
		<div class="form-group col-sm-6" style='padding-top:20px;'>
		  <label class="col-sm-2 col-md-offset-1 control-label">Filter :</label>
			<div class="col-sm-6">
				<select class="form-control" name='filter' onchange="location.href='index.php?page=system&action=log&filter='+this.value">
					<option value='0'>Show All</option>
					<option value='1'>Only Failed</option>
					<option value='2'>Only Success</option>
				</select>
			</div>
		</div>
		<table class='table table-striped'>
			<thead>
				<tr>
					<th>
						ID
					</th>
					<th>
						Login IP
					</th>
					<th>
						tried Username
					</th>
					<th>
						tried Password
					</th>
					<th>
						Login Time
					</th>
					<th>
						Success
					</th>
				</tr>
			</thead>
			<tbody>
		<?php
			if(isset($_GET['filter'])){
				$filter = inputCheck($_GET['filter']);
				echo "<script>$('[name=\"filter\"]').val($filter)</script>";
			}else{
				$filter = 0;
			}
			switch($filter){
				case 0: $limit = '';break;
				case 1: $limit = 'WHERE success = 0';break;
				case 2: $limit = 'WHERE success = 1';break;
			}
			//Show all of loin log records
			$sql_loginlog = "SELECT * FROM loginlog $limit ORDER BY logintime DESC";
			$res_loginlog = $mysql->query($sql_loginlog);
			while($row_loginlog = $mysql->fetch($res_loginlog)){
				$statusClass = $row_loginlog['success']==1 ? 'check':'close';
				$colorClass = $row_loginlog['success']==1 ? 'alert-success':'alert-danger';
				$trypwdClass = $row_loginlog['success']==1 ? 'text-muted':'';
				echo "<tr>
					<td>{$row_loginlog['id']}
					</td>
					<td>{$row_loginlog['loginip']}
					</td>
					<td>{$row_loginlog['username']}
					</td>
					<td class='$trypwdClass'>{$row_loginlog['trypwd']}
					</td>
					<td>{$row_loginlog['logintime']}
					</td>
					<td><kbd class='$colorClass'><span class='fa fa-$statusClass'></span><kbd>
					</td>
				</tr>";
			}
		?>			
					
			</tbody>	
		</table>
		<form method='post' style='padding-top:20px;'>
			<div class="form-group col-sm-7">
				<label class="col-sm-4 col-md-offset-1 control-label">ID From: </label>
				<div class="col-sm-6">
					<input type="number" class="form-control" name='fromid' min=0 required/>
				</div>
			</div>
			<div class="form-group col-sm-7">
				 <label class="col-sm-4 col-md-offset-1 control-label">To: </label>
				<div class="col-sm-6">
					<input type="number" class="form-control" name='toid' min=0 required/>
				</div>
			</div>
			<div class="form-group col-sm-5 col-md-offset-1">
				<button type="submit" class="btn btn-block btn-danger" name='del'>Delete</button>
			</div>
		</form>
	</div>			
<?php

/**Delete log*/
	if(isset($_POST['del'])){
		$fromid = inputCheck($_POST['fromid']);
		$toid = inputCheck($_POST['toid']);
		if($toid >= $fromid){
			$sql_delLog = "DELETE FROM loginlog WHERE id >= $fromid AND id <= $toid";
			$mysql->query($sql_delLog);
			redirect('index.php?page=system&action=log','Delete log successfully!');
		}else{
			echo "<script>alert('First id must less than second one!')</script>";
		}
	}

?>