<?php
	//Get article menu id and query menu name
	if(isset($_GET['mid'])){
		$mid = (int)mysqli_real_escape_string($mysql->conn, $_GET['mid']);
		if(empty($mid))$mid=5;
	}else{
		$mid = 5;
	}
	$sql_getMenu = "SELECT name FROM site_menu WHERE id = $mid AND pid != 0";
	$res_mid = $mysql->query($sql_getMenu);
	$title = $mysql->fetch($res_mid)[0];

?>	
	<dl class="container">
		<h1 class="text-center text-danger"><?php echo $title;?></h1>
		<dd class="row clearfix">
			<div class="col-md-10 col-md-offset-1">
				<div>
					<ul class="newsList">
<?php
	//Get sub menu content
	$sql_articleList = "SELECT * FROM article WHERE smenu_id=$mid ORDER BY orders"; 
	$res_articleList = $mysql->query($sql_articleList);
	while($row=$mysql->fetch($res_articleList)){
		$artTime = date("d M,Y",strtotime(empty($row['updtime']) ? $row['cretime']:$row['updtime']));
		echo "<li>
				<span class='date'>{$artTime}</span>
				<a href='index.php?page=article&aid={$row['id']}'>{$row['name']}</a>
		</li>";
	}
	//Empty state
	if(!mysqli_num_rows($res_articleList)){
		echo "<div class='alert alert-dismissable alert-danger text-center'>
				 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<h4>Something Wrong</h4>
				<strong>Empty list! </strong>There's no article in the menu!
			</div>";
	}
?>
						<li class="split"></li>
					</ul>
				</div>
			
		</div>
	</dd>
</dl> 