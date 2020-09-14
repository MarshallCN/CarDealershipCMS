<?php
	session_start();
	require "include/db.php";
	/**Check if username have been used when sign up*/
	if(isset($_POST['usercheck'])){
		$usercheck = inputCheck(strtolower(preg_replace("/\s/","",$_POST['usercheck'])));
		if(empty($usercheck)){
			$isNameUsed= 'empty';
		}else{
			$querytable = $_POST['page']=='cus'? 'member':'user';
			$res = $mysql->query("SELECT id FROM $querytable WHERE username = '$usercheck'");
			$isNameUsed = mysqli_num_rows($res)? 'used':'ok';
		}
		$resp = ['used'=>$isNameUsed];
		echo json_encode($resp);
	}
	/**Change request status*/
	if(isset($_POST['requestId'])){
		$doneid = inputCheck($_POST['requestId']);
		$curStatus = $mysql->oneQuery("SELECT status_id FROM drive WHERE id=$doneid");
		$newStatus = $curStatus==1 ? 0:1; 
		$mysql->query("UPDATE drive SET status_id = '$newStatus' WHERE id = '$doneid'");
		$mysql->query("UPDATE drive SET emp_id = '{$_SESSION['adminid']}' WHERE id = '$doneid'");
		$status = ['status'=>$newStatus];
		echo json_encode($status);
	}
	/**Upload picture*/
	if(isset($_FILES['img'])&&isset($_POST['path'])){
		$filename = 'file'.date('Y_m_d_h_i_s',time()).'.jpg';
		$path = $_POST['path'];
		if(is_uploaded_file($_FILES['img']['tmp_name'])){
			if(move_uploaded_file($_FILES['img']['tmp_name'], "./static/img/$path/$filename")){
				$status = 0;
			}else{
				$status = 1;
			}
		}else{
			$status = 2;
		}
		echo json_encode(['status'=>$status,'filename'=>$filename]);
	}
?>	