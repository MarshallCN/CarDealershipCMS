		<div class='helptip1' id='helptip' style="display:none;">
			<a class='label label-danger'>H</a> Hide /
			<a class='label label-default'>H</a> Not Hide
		</div>	
		<table class='table table-striped'>
				<thead>
					<tr>
						<th>
							Name
						</th>
						<th>
							URL
						</th>
						<th>
							Parent Menu
						</th>
						<th class='text-center'>
							Operation <a href='javascript:void(0);' onclick="$('#helptip').toggle()" class="glyphicon glyphicon-question-sign icona"></a>
						</th>
					</tr>
				</thead>
				<tbody>
	<?php
				//Show all menus of backend
				$sql_menuList = "SELECT s.id,s.name,p.name AS parent,s.url,s.hide FROM admin_menu AS s LEFT JOIN admin_menu AS p ON s.pid = p.id;";
				$res_menuList = $mysql->query($sql_menuList);
				while($row_aL = $mysql->fetch($res_menuList)){
					echo "<tr>
							<td>{$row_aL['name']}
							</td>
							<td>{$row_aL['url']}
							</td>
							<td>{$row_aL['parent']}
							</td>";
	?>
						<td class='text-center'>
							<a class='label label-<?php echo $row_aL['hide']==1? 'danger':'default';?>' href='index.php?page=system&action=menu&hide=<?php echo $row_aL['id'];?>'>H</a>
						</td>
					</tr>
	<?php
				}
	?>
				</tbody>
			</table>
	<?php
/**Hide Car*/
	if(isset($_GET['hide'])){
		$hideId = inputCheck($_GET['hide']);
		$curStatus = $mysql->oneQuery("SELECT hide FROM admin_menu WHERE id=$hideId");
		if($curStatus==1){
			$mysql->query("UPDATE admin_menu SET hide = 0 WHERE id = $hideId");
			redirect('index.php?page=system&action=menu','This menu will show in Navigation Bar!');
		}else{
			$mysql->query("UPDATE admin_menu SET hide = 1 WHERE id = $hideId");
			redirect('index.php?page=system&action=menu','This menu will be hidden in Navigation Bar!');
		}
	}
	?>