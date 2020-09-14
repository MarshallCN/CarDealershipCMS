<?php
	//Get all the contact informatiom from database
	$sql_contact = "SELECT s.name,s.value,p.name AS cata FROM contact AS s INNER JOIN contact AS p ON s.pid=p.id";
	$result = $mysql->query($sql_contact);
	$corpInfo=[];
	$openTime=[];
	while($row=$mysql->fetch($result)){
		if($row['cata']=='info'){
			$corpInfo[$row['name']]=$row['value'];
		}else if($row['cata']=='time'){
			$openTime[$row['name']]=$row['value'];
		}
	}
?>
<dl class="container"><center>
  <h1 class="text-center text-danger" id='contact'>Contact Us</h1></center>
	<dd class="row clearfix">
		<div class="col-sm-6" style="font-size:1.2em">
			<dl class="dl-horizontal">
<?php
	//Show contact informatiom
	foreach($corpInfo as $key => $value){
		echo "<dt>
				$key
			</dt>
			<dd>
				$value
			</dd>";
	}
?>
			<dl>
		</div>
		<div class="col-sm-6">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							Week
						</th>
						<th>
							Opening Time
						</th>
					</tr>
				</thead>
				<tbody>
<?php
	//Show opening Time
	foreach($openTime as $key => $value){
		echo "<tr>
			<td>
				$key
			</td>
			<td>
				$value
			</td>
		</tr>";
	}
?>			
				</tbody>
			</table>
		</div>
	</dd>
</dl>