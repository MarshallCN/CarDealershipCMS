<!-- Show all the admin menu from databse -->
<dl class="adminnav">
	<dd class="row clearfix">
		<div class="col-sm-2 col-md-2">
			<div class="panel-group" id="panel-1">
			  <div class="panel panel-primary"><div class="panel-heading"><h4><img src='../static/img/ferrari_logo_sm.png' height='35px'> Ferrari CMS</h4></div>
			  </div>
<?php
//prompt user if it is invalidated
	if($_SESSION['role']==4){
		echo "<script>alert('Your account is not validated,\\n so you cannot use more management function\\n until super administrator give you permission!')</script>";
	}
/*Show all the admin menu that current user have access rights and not hide*/
	$sql_adminMenu = "SELECT * FROM admin_menu WHERE pid = 0 AND hide != 1 AND id IN (SELECT menu_id FROM access WHERE role_id = {$_SESSION['role']} AND access=1)";
	$res_menu1 = $mysql->query($sql_adminMenu);
	while($row_menu1 = $mysql->fetch($res_menu1)){
?>
				<div class="panel panel-default">
					<div class="panel-heading" onclick="$('#panele<?php echo $row_menu1['id'];?>')[0].click()">
					<a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-1" id='panele<?php echo $row_menu1['id'];?>' href="#panel-element-<?php echo $row_menu1['id'];?>" style='text-decoration:none;'>
							<?php echo $row_menu1['name']?>
						</a><span></span>
					</div>
	<?php
		//Show sub menu
		$sql_menu2 = "SELECT * FROM admin_menu WHERE pid = {$row_menu1['id']} AND hide != 1 AND id IN (SELECT menu_id FROM access WHERE role_id = {$_SESSION['role']} AND access=1)";
		$res_menu2 = $mysql->query($sql_menu2);
		if(mysqli_num_rows($res_menu2)){
	?>
					
					<div id="panel-element-<?php echo $row_menu1['id'];?>" class="panel-collapse collapse">
			<?php
				while($row_menu2 = $mysql->fetch($res_menu2)){
			?>
					  <a href="<?php echo $row_menu2['url'];?>" style='display:block;border-top: 1px solid #ddd'>
						<div class="panel-body">
							<?php echo $row_menu2['name'];?>
						</div>
					  </a>
			<?php
				}
			?>
					</div>
	<?php
			echo "<script>document.getElementById('panele{$row_menu1['id']}').nextSibling.className='caret'</script>";//if sub menu, add a icon
		}else{
			echo "<script>document.getElementById('panele{$row_menu1['id']}').parentNode.onclick=function(){location.href='{$row_menu1['url']}'}</script>";//make the div menu clickable
		}
	?>
				</div>
<?php 
	}
/**show user name*/	
	echo "<script>$('#panele13').html('".ucwords($_SESSION['admin'])."');$('#panele13').css('fontWeight','bold')</script>";//change "my count" menu into user's name
?>
			</div>
		</div>	
		
		<div class="main col-sm-10 col-md-10">
			<span>
<?php 
/**Show current path*/	
	if(isset($_GET['page']))echo '<i class="fa fa-home"></i>&nbsp;>&nbsp;'.ucwords(inputCheck($_GET['page'])).'&nbsp;>&nbsp;'; 
	if(isset($_GET['action'])){echo ucwords(inputCheck($_GET['action'])).'&nbsp;>';}
	$sql_currentMenu = "SELECT pid FROM admin_menu WHERE url = '$url'";
	$curentMenuId = $mysql->oneQuery($sql_currentMenu);
	echo "<script>if($('#panele$curentMenuId')[0])$('#panele$curentMenuId')[0].click()</script>";	
?>
			</span>
