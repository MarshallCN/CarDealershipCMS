<form method='get'>
URL：<input type='text' style="width:400px" id='url' name='url'></input><br/>
<?php
	require "include/db.php";
	$url = isset($_GET['url'])?$_GET['url']:"http://localhost/orig_htdoc/Ferrari/index.php";
	$url = mysqli_real_escape_string($mysql->conn, addslashes($url));
	$sql_orig = $mysql->Query("SELECT id,hash FROM test.crawl WHERE url = '$url'");
	$res = $mysql->fetch($sql_orig);
	$hash = $res['hash'];
	ob_start(); 
	readfile($url); 
	$data = ob_get_contents();
	$len = ob_get_length();
	ob_end_clean();
	$data = addslashes($data);
	$newhash = md5($data);
	if(mysqli_num_rows($sql_orig)==0){
		if($len>1000){
			$sql_new = "INSERT test.crawl(html,hash,url) VALUES('$data','$newhash','$url')";
			$mysql->query($sql_new);
			echo '新网页已经入库';
		}else{
			echo '网页不存在';
		}
	}else{
		if($hash == $newhash){
			echo "<script>alert('网站无变化')</script>";
		}else{
			$sql_upd = "UPDATE test.crawl set html = '$data', hash = '$newhash' WHERE id = ".$res['id'];
			$mysql->query($sql_upd);
			echo "<script>alert('网站有变化，已更新入库')</script>";
		}
		echo '旧网页内容哈希值：'.$hash.'<br/>新网页内容哈希值：'.$newhash;	
	}
	echo "<script>document.getElementById('url').value='$url'</script>";
?>
<br/><br/>
<button type='submit' style='width:400px;height:50px;border-radius:5px;cursor:pointer'>检查变化</button>
</form>