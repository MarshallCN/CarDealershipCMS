<!-- User Dropdown Menu -->
<div class="btn-group" id='usernav'>
	<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
		<span class="glyphicon glyphicon-user"></span>
<?php
echo isset($_SESSION['user'])? $_SESSION['user']:"<script>$('#usernav').hide()</script>";
?>		
		<span class="caret"></span>
	</button>
		<ul class="dropdown-menu">
			<li>
				<a href="index.php?page=profile">My Profile</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href="index.php?page=drive">My Request</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href='index.php?logout'>Log Out</a>
			</li>
		</ul>
</div>
<!-- Navigation -->
   <nav class="navbar navbar-default nav" role="navigation">
	  <h1 class="corpname">Chengdu Ferrari Dealership</h1>
		<div class="container-fluid"> 
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#navbar-collapse">
				<span class="sr-only"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="./admin/login.php"><img src="static/img/ferrari_logo.jpg" class="logo"></a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul>
<?php
	//Dynamically show menu from database
	$sql_siteMenuCata = "SELECT id,name,url FROM site_menu WHERE pid=0 AND hide = 0 ORDER BY orders";
	$result = $mysql->query($sql_siteMenuCata);
	$rowNum=mysqli_num_rows($result);
	$eleNum=0; //count menu numbers
	$menuWidth = $rowNum==0 ? '':round(800/$rowNum); //calculate menu width, and auto align
	while($row_cata=$mysql->fetch($result)){
		$eleNum++;
		if($eleNum==1){
			$navliId='noborderl';//Hide border-left of the most left menu
		}else if($eleNum==$rowNum){
			$navliId='noborderr';//Hide border-right of the most right menu
		}
		$menuliclass=($row_cata['name']=='Cars')?'cars':'';//Special style for car menu
		echo "<li class='$menuliclass' style='width:{$menuWidth}px;'>
			<a href='{$row_cata['url']}' id='$navliId'>{$row_cata['name']}
		</a>";
		$sql_siteMenu = "SELECT name,url FROM site_menu WHERE pid = {$row_cata['id']} AND hide = 0 ORDER BY orders";//Get all menu information
		$result_detail = $mysql->query($sql_siteMenu);
		if(mysqli_num_rows($result_detail)){//show other menu
			echo "<ul>";
			while($row_menu=$mysql->fetch($result_detail)){
				echo "<li style='width:{$menuWidth}px;'><a href='{$row_menu['url']}'>{$row_menu['name']}</a></li>";
			}
			echo "</ul>";
		}else if($row_cata['name']=="Cars"){//show cars menu
			echo "<ul>";
			$sql_carlist = "SELECT * FROM car WHERE hide != 1 ORDER BY orders";//Get all cars basic information
			$result_car = $mysql->query($sql_carlist);
			while($row_car=$mysql->fetch($result_car)){
				echo "<li style='width:{$menuWidth}px;'><a href='index.php?page=car&cid={$row_car['id']}'>{$row_car['name']}</a>
						<ul>
						  <li>
						    <img src='static/img/car/{$row_car['thumb']}' onclick=\"location.href='index.php?page=car&cid={$row_car['id']}'\"/>
						    <h4><kbd>{$row_car['name']} {$row_car['displacement']}L {$row_car['ttm']} {$row_car['engine']}</kbd></h4>
						  </li>
						</ul>
				</li>";
			}
			echo "</ul>";
		}
	?>
			</li>
			
<?php
	}
?>			
			</ul>
		</div>
		</div>
	</nav>
