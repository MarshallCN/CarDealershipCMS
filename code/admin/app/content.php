	<script>
		$(document).ready(function () {
			$("#texthtml").mouseup(function() {
				txt = window.getSelection().toString();
			});
		});
	</script>
	<div class="tabbable" id="tabs-article" style='padding-top:10px;'>
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#panel-editarticle" data-toggle="tab">Manage Articles</a>
			</li>
			<li>
				<a href="#panel-newarticle" data-toggle="tab" id='newartlab'><span class="glyphicon glyphicon-plus"></span>&nbsp;New Article</a>
			</li>
		</ul>
<!-- Manage Article -->		
		<div class="tab-content">
			<div class="tab-pane active" id="panel-editarticle">
			<div class='helptip' id='helptip' style="display:none;">
				<a class='label label-primary'>E</a> Edit /
				<a class='label label-success'>F</a> Flag(on Homepage) /
				<a class='label label-default'>F</a> Not on Homepage /
				<a class='label label-warning'>O</a> Order /
				<a class='label label-danger'>X</a> Delete /
			</div>	
			<table class='table table-striped'>
				<thead>
					<tr>
						<th>
							Order
						</th>
						<th class='text-center'>
							Article Title
						</th>
						<th>
							Last Edited Time
						</th>
						<th>
							View
						</th>
						<th width='12%'>
							Operation <a href='javascript:void(0);' onclick="$('#helptip').toggle()" class="glyphicon glyphicon-question-sign icona"></a>
						</th>
					</tr>
				</thead>
				<tbody>
	<?php
		//Show all article menu
		$sql_articleCata = "SELECT id,name FROM site_menu WHERE pid = 3";
		$res_atCata = $mysql->query($sql_articleCata);
		while($row_atCata = $mysql->fetch($res_atCata)){
			//Show all articles in current menu
			$sql_articleList = "SELECT l.*,a.view FROM article AS l INNER JOIN article_data AS a ON l.id=article_id WHERE smenu_id={$row_atCata['id']} ORDER BY l.orders";
			$res_articleList = $mysql->query($sql_articleList);
			if(mysqli_num_rows($res_articleList)){
				echo "<tr>
					<th colspan=5>{$row_atCata['name']}</th>
				</tr>";
				while($row_aL = $mysql->fetch($res_articleList)){
				$lastEditTime = empty((int)$row_aL['updtime']) ? $row_aL['cretime']:$row_aL['updtime'];
					echo "<tr>
							<td>{$row_aL['orders']}
							</td>
							<td>{$row_aL['name']}
							</td>
							<td>$lastEditTime
							</td>
							<td>{$row_aL['view']}
							</td>";
	?>						<td>
							<a class='label label-primary' href="index.php?page=content&action=article&edit=<?php echo $row_aL['id'];?>">E</a>
							<a class='label label-<?php echo $row_aL['flag']==1? 'success':'default';?>' href='index.php?page=content&action=article&flag=<?php echo $row_aL['id'];?>'>F</a>
							<a class='label label-warning' href='index.php?page=content&action=article&order=<?php echo $row_aL['id'];?>'>O</a>
							<a class='label label-danger' onclick="if(confirm('Do you want to Delete this Article'))location.href='index.php?page=content&action=article&del=<?php echo $row_aL['id'];?>'">X</a>
						</td>
					</tr>
	<?php
				}
			}else{
				echo "<tr>
					<th colspan=3>{$row_atCata['name']}</th><td colspan=2 class='text-muted'>Empty</td>
				</tr>";//empty state
			}
		}
	?>
				</tbody>
			</table>	
<!-- Article Order Form -->	
			<input type='hidden' id='modal-1' href='#modal-container-1' data-toggle='modal'></input>	
			<div class="modal fade" id="modal-container-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h1 class="modal-title text-center">
								Change Article Order
							</h1>
						</div>
						<div class="modal-body">		
							<form method='post' action='index.php?page=content&action=article'>
			<?php
				/*Change article order*/
				if(isset($_GET['order'])){
					$orderId = inputCheck($_GET['order']);
					$changeord = $mysql->query("SELECT orders,smenu_id FROM article WHERE id = $orderId");
					if(mysqli_num_rows($changeord)){
						$res_order = $mysql->fetch($changeord);
						$totalnum = $mysql->oneQuery("SELECT COUNT(*) AS total FROM article;");
						echo "<input type='number' class='form-control' min=1 max={$totalnum} value='{$res_order['orders']}' name='newOrder' />
							<input type='hidden' name='origOrder' value='{$res_order['orders']}'/>
							<input type='hidden' name='orderId' value='$orderId'/>";
					}else{
						redirect('index.php?page=content&action=article');
					}
				}
			?>
								<br/><button type='submit' class='btn btn-success btn-block' style='padding-right:0;'/>Submit</button>
							</form>
						</div>
					</div>	
				</div>
			</div>
					</div>
<!-- New or Edit Article -->						
					<div class="tab-pane" id="panel-newarticle">
					<form method='post' enctype="multipart/form-data">
						<div class="form-group col-sm-12">
							<label>Title</label><input type="text" class="form-control" name='title' maxlength='300' required />
						</div>
						<div class="form-group col-sm-4">
							 <label>Menu</label> 
							 <select class="form-control" name='menu' required> 
								<option value="">Select a Category...</option> 
					<?php
						//Get all article menu, so users can select
						$sql_articleMenu = "SELECT id,name FROM site_menu WHERE pid = 3";
						$res_articleMenu = $mysql->query($sql_articleMenu);
						while($row_aM = $mysql->fetch($res_articleMenu)){
							echo "<option value='{$row_aM['id']}'>{$row_aM['name']}</option>";
						}
					?>			
							 </select>
						</div>
						<div class="form-group col-sm-4">
							<label>Author</label><input type="text" class="form-control" name='author' maxlength='50' required />
						</div>
						<div class="form-group col-sm-4">
							<label for="img">Upload a Cover Picture</label>
							<input type="file" id="img" onchange="fileSelected('content&action=article')"/>
							<div class='progress progress-striped active' id='upres' style="display:none"><label style="position:absolute;width:90%;text-align:center"></label>
								<div class="progress-bar progress-bar-success"></div>
							</div>
							<img src='' style='display:none;' id='thumbnail' height=100>
							<input type="hidden" name='imgname' id="imgname">
						</div>
						<div class="btn-group col-sm-12">
							<button class="btn btn-default" type="button" onclick="aligntext('left')"><em class="glyphicon glyphicon-align-left"></em> Left</button>
							<button class="btn btn-default" type="button" onclick="aligntext('center')"><em class="glyphicon glyphicon-align-center"></em> Center</button>
							<button class="btn btn-default" type="button" onclick="aligntext('right')"><em class="glyphicon glyphicon-align-right"></em> Right</button> 
							<button class="btn btn-default" type="button" onclick="aligntext('justify')"><em class="glyphicon glyphicon-align-justify"></em> Justify</button>
							<button class="btn btn-default" type="button" onclick="edittext('b')"><em class="glyphicon glyphicon-bold"></em> Bold</button>
							<button class="btn btn-default" type="button" onclick="edittext('i')"><em class="glyphicon glyphicon-italic"></em> Italic</button>
							<button class="btn btn-default" type="button" onclick="edittext('u')"><em class="fa fa-underline"></em> Underline</button>
						</div>
<?php
/**Get orig data when edit an article*/
		if(isset($_GET['edit'])){
			$editId = inputCheck($_GET['edit']);
			$sql_queryArticle = "SELECT c.htmls,l.id,l.name,l.author,l.coverimg,l.smenu_id FROM article_data AS c INNER JOIN article AS l ON c.article_id=l.id WHERE l.id=$editId";
			$res_origdata = $mysql->query($sql_queryArticle);
			if(mysqli_num_rows($res_origdata)){
				$origData = $mysql->fetch($res_origdata);
			}else{
				redirect('index.php?page=content&action=article');
			}
		}
?>
						<textarea style='width:100%;min-height:350px;' name='htmls' id='texthtml' oninput='crehtmls()' required><?php if(isset($origData['htmls']))echo htmlspecialchars_decode($origData['htmls']);?></textarea>
						<button type="submit" class="btn btn-success btn-block" onmouseover='crehtmls()'>Submit</button>
						<button type="button" class="btn btn-danger btn-block" onclick="location.href='index.php?page=content&action=article'">Cancel</button>
						<input type='hidden' id='editid' name='isedit'/>
					</form>
						<pre id='res'>Preview</pre>
<?php 	
/**New Article*/		
		if(isset($_POST['htmls'])){
			$_POST['menu'] = inputCheck($_POST['menu']);
			$_POST['title'] = inputCheck($_POST['title']);
			$_POST['author'] = inputCheck($_POST['author']);
			$_POST['htmls'] = nl2br(inputCheck($_POST['htmls']));
			$ordernum = $mysql->oneQuery("SELECT COUNT(id) FROM article")+1;
			if(empty($_POST['isedit'])){
				$filename = empty($_POST['imgname']) ? 'noimg.jpg':inputCheck($_POST['imgname']);
				$sql_newArticle = "INSERT article(smenu_id,name,user_id,author,cretime,coverimg,orders) VALUES ({$_POST['menu']},'{$_POST['title']}',{$_SESSION['adminid']},'{$_POST['author']}',NOW(),'$filename',$ordernum)";
				$mysql->query($sql_newArticle);
				$article_id = mysqli_insert_id($mysql->conn);
				$sql_addHtmls = "INSERT article_data VALUES ('','{$_POST['htmls']}','',$article_id)";
				$mysql->query($sql_addHtmls);
				redirect('index.php?page=content&action=article');
			}else{//if update article
				$filename = empty($_POST['imgname']) ? $origData['coverimg']:inputCheck($_POST['imgname']);
				$sql_updateArt = "UPDATE article SET smenu_id='{$_POST['menu']}',name='{$_POST['title']}',updtime=NOW(),user_id='{$_SESSION['adminid']}',author='{$_POST['author']}',coverimg='$filename' WHERE id={$_POST['isedit']}";
				$mysql->query($sql_updateArt);
				$sql_updateArtData = "UPDATE article_data SET htmls = '{$_POST['htmls']}' WHERE id={$_POST['isedit']}";
				$mysql->query($sql_updateArtData);
				redirect('index.php?page=content&action=article');
			}
		}
/**Edit an Article*/
		if(isset($_GET['edit'])){
			echo "<script>$('#newartlab').click();
				$('input[name=\"title\"]').val('".inputCheck($origData['name'])."');
				$('select[name=\"menu\"]').val('{$origData['smenu_id']}');
				$('input[name=\"author\"]').val('".inputCheck($origData['author'])."');crehtmls();
				$('#newartlab').html('<span class=\"glyphicon glyphicon-edit\"></span>&nbsp;Edit Article');
				$('#thumbnail').attr('src','../static/img/article/{$origData['coverimg']}');$('#thumbnail').show();
				$('#editid').val('$editId');
			</script>";
		}
/**Recommend aritlce to homepage*/		
		if(isset($_GET['flag'])){
			$flagId = inputCheck($_GET['flag']);
			$curFlag = $mysql->oneQuery("SELECT flag FROM article WHERE id=$flagId");
			if($curFlag==0){
				$totalFlag = $mysql->oneQuery("SELECT COUNT(flag) FROM article WHERE flag=1");
				if($totalFlag < 3){
					$mysql->query("UPDATE article SET flag = 1 WHERE id = $flagId");
					redirect('index.php?page=content&action=article','This article will show in the homepage!');
				}else{
					echo "<script>alert('You can only Show 3 articles in homepage at most!');</script>";
				}
			}else{
				$mysql->query("UPDATE article SET flag = 0 WHERE id = $flagId");
				redirect('index.php?page=content&action=article','This article will NOT SHOW in the homepage!');
			}
		}
/**Delete Article*/
		if(isset($_GET['del'])){
			$delId = inputCheck($_GET['del']);
			$origord = $mysql->oneQuery("SELECT orders FROM article WHERE id = $delId");
			$mysql->query("DELETE FROM article_data WHERE article_id = $delId");
			$mysql->query("DELETE FROM article WHERE id = $delId");
			$mysql->query("UPDATE article SET orders = orders-1 WHERE orders > $origord");
			redirect('index.php?page=content&action=article','Delete Successfully!');
		}
/**Article Order Exchange*/		
		if(isset($_GET['order'])){
			echo "<script>$('#modal-1').click();</script>";
		}
		if(isset($_POST['newOrder'])){
			$newOrder = inputCheck((int)$_POST['newOrder']);
			$orderId = inputCheck($_POST['orderId']);
			$origOrder = inputCheck($_POST['origOrder']);
			if($origOrder!=$newOrder){
				$replaceId = $mysql->oneQuery("SELECT id FROM article WHERE orders = $newOrder");
				//use one sql to exchange to rows' value
				$mysql->query("UPDATE article AS a JOIN article AS b ON (a.id=$orderId AND b.id=$replaceId) OR (a.id=$replaceId AND b.id=$orderId) SET a.orders =b.orders, b.orders=a.orders");
				redirect('index.php?page=content&action=article',"Exchange No.$origOrder for No.$newOrder Successfully!");
			}	
		}
?>
					</div>
				</div>
			</div>