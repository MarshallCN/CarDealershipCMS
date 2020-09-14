<dl class="container">
<?php
	//Get article id, and query article content
	if(isset($_GET['aid'])){
		$aid = (int)$_GET['aid'];
		if(empty($aid))$aid=1;
	}else{
		$aid = 1;
	}
	$sql_articleContent = "SELECT c.htmls,c.view,l.id,l.name,l.author,CONCAT(u.fname,' ',u.lname) AS posted,l.cretime,l.updtime,l.coverimg FROM article_data AS c INNER JOIN article AS l ON c.article_id=l.id INNER JOIN user AS u ON u.id=l.user_id WHERE l.id=$aid";
	$res_content=$mysql->query($sql_articleContent);
	$articleContent = $mysql->fetch($res_content);
	if(mysqli_num_rows($res_content)){
		$viewnum = $articleContent['view']+1;
		$sql_updateView = "UPDATE article_data SET view=$viewnum WHERE id =$aid";
		$mysql->query($sql_updateView);
?>
	<dd class="row clearfix">
		<div class="col-md-10 col-md-offset-1">
			<div class="articleContent">
				<h2 class="title text-center">
			<?php echo $articleContent['name'];?>
				</h2>
				<div class="text-center">
					 <span><b>From: </b>Internet</span> 
					 <span><b>Author: </b><?php echo $articleContent['author'];?></span> 
					 <span><b>Posted by: </b><?php echo $articleContent['posted'];?></span> 
					 <span><b>Update:  </b><?php echo empty($articleContent['updtime'])? $articleContent['cretime']:$articleContent['updtime'];?></span> 
					 <span><b>View: </b><?php echo $articleContent['view'];?></span> 
					 <span>【Font Size：<a href="javascript:$('#contentTxt').css('font-size','1em');">Small</a> 
						<a style="font-size:1.2em" href="javascript:$('#contentTxt').css('font-size','1.2em');">Middle</a> 
						<a style="font-size:1.4em" href="javascript:$('#contentTxt').css('font-size','1.4em');">Big</a>
						】</span>
				</div>
				<article id="contentTxt">
					<img src="static/img/article/<?php echo $articleContent['coverimg'];?>" width="100%"/>
					 <?php echo htmlspecialchars_decode(nl2br($articleContent['htmls']));?>
					 <hr/>
				</article>
			</div>
		</div>
	</dd>
<?php
	}else{
		//Empty state	
		echo "<div class='alert alert-dismissable alert-danger text-center'>
				 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<h4>Something Wrong</h4>
				<strong>Warning: </strong>This article does not exsists!
			</div>";
	}
?>
</dl>