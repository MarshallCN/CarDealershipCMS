<form method='post' style='padding-top:20px;'>
<?php
	//Get all contact information
	$sql_contactCata = "SELECT * FROM contact WHERE pid = 0";
	$result = $mysql->query($sql_contactCata);
	while($row = $mysql->fetch($result)){
		$sql_contact = "SELECT * FROM contact WHERE pid = {$row['id']}";
		$res_contact = $mysql->query($sql_contact);$i=0;
		echo "<div class='col-sm-12'><hr/><label>".ucwords($row['name'])."</label></div>";
		while($row_contact = $mysql->fetch($res_contact)){
			if($row['name']=='info')$info[$i]=$row_contact['id'];
			if($row['name']=='time')$time[$i]=$row_contact['id'];
			$i++;
?>
			<div class='form-group col-md-6'>
				<label class="col-md-6 control-label"><?php echo ucwords($row_contact['name']);?>: </label>
				<div class="col-md-6">
					<input type="text" class="form-control" name='<?php echo $row_contact['id'];?>' maxlength=200 value="<?php echo $row_contact['value'];?>"/>
				</div>
			</div>
<?php
		}
		echo "	<div class='form-group col-md-6 col-md-offset-2'>
			<button type='submit' class='btn btn-block btn-success' name='{$row['name']}'>Submit</button>
		</div>";
	}
?>

</form>
<?php
	//Update contact information
	if(isset($_POST['info'])){
		for($r=0;$r<count($info);$r++){
			$mysql->query("UPDATE contact SET value='".inputCheck($_POST[$info[$r]])."' WHERE id = {$info[$r]}");
		}
		redirect('index.php?page=contact');
	}
	//Update Opening time
	if(isset($_POST['time'])){
		for($r=0;$r<count($time);$r++){
			$mysql->query("UPDATE contact SET value='".inputCheck($_POST[$time[$r]])."' WHERE id = {$time[$r]}");
		}
		redirect('index.php?page=contact');
	} 


?>