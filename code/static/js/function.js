	/* admin Login Page */
	function showSignForm(){
		$('#signInput').show()
		$('#signInput .form-control').attr("required",true)
		$('[name="formlabel"]').html('Already Had Account')
		$('[name="log"]').html('Sign up')
		$('[name="log"]').attr('name','sign')
		$('[name="pwd"]').change(function(){checkpwd()})
		$('[name="formlabel"]').click(function(){location.href="login.php"})
		$('[name="pwd"]').val('')
		checkNewName('admin')
	}
	/* Show member's avatar when edit */
	function showthumb(){
		if($('[name="avatar"]').val()!=''){
			$('#avatarthum').attr('src','static/img/avatar/'+$('[name="avatar"]').val())
		}
	}
	/* Show real password */
	function seepwd(i){
		pwd = document.getElementsByName(i)[0];
		pwd.type='text';
		this.onmouseup = function(){
			pwd.type='password';
		};
	}
	/* Set time stamp to now */
	function setTimeToNow(){
		document.getElementsByName('reqsDate')[0].valueAsDate = new Date(new Date().setDate(new Date().getDate()+2))
	}
	/* Date must later than tomorrow */
	function checkDate(){
		reqDate = document.getElementsByName('reqsDate')[0].valueAsDate
		reqDate = reqDate.setDate(reqDate.getDate()-2)
		if(reqDate < new Date().getTime()){
			alert("The test drive request time must later than today");
			setTimeToNow();
		}
	}
	/* Add 0 in date time when it less than 10*/
	function add0(e){
		if(e.toString().length==1){
			return '0'+e;
		}else{
			return e
		}
	}
	/* Print current time */
	function printTime(){
		var d = new Date();
		var year = d.getFullYear();
		var day = add0(d.getDate());
		var month = add0(d.getMonth()+1);
		var hours = add0(d.getHours());
		var mins = add0(d.getMinutes());
		var secs = add0(d.getSeconds());
		$('#curtime').html(year+'-'+month+'-'+day+'&nbsp;'+hours+':'+mins+':'+secs);
	}
	/* add class */
	function changeStyle(name,classname){
		var ele = document.getElementsByName(name)[0];
		ele.className = ele.className+' '+classname;
	}
	/* use ajax to Check username if exist */
	function checkNewName(pg){
		$('[name="username"]').val($('[name="username"]').val().replace(" ",""))
		if($('[name="username"]').val().length>0 && $('[name="sign"]').length>0){
			var ajaxurl = pg=='cus'? 'ajax.php':'../ajax.php'
			$.ajax({
				url:ajaxurl,
				data:{"usercheck":encodeURI(encodeURI($('[name="username"]').val())),"page":pg},
				success:function(data){
					if(data.used=='used'){
						alert('Username has been used!')
						$('[name="username"]').attr('class','form-control alert-danger')
						$('[name="username"]').next().attr('class','seepwd alert-danger')
						$('[name="username"]').next().children('i').attr('class','fa fa-close')
						$('[name="sign"]').attr('disabled','true')
					}else if(data.used=='ok'){
						$('[name="username"]').attr('class','form-control alert-success')
						$('[name="username"]').next().attr('class','seepwd alert-success')
						$('[name="username"]').next().children('i').attr('class','fa fa-check')
					}else if(data.used=='empty'){
						$('[name="username"]').attr('class','form-control')
						$('[name="username"]').next().attr('class','seepwd hidden')
					}
				},
				type:'POST',
				dataType:'json',
				beforeSend:function(){
					$('[name="username"]').next().attr('class','seepwd btn-warning')
					$('[name="username"]').next().children('i').attr('class','fa fa-spinner fa-spin')
				}
			});
		}else{
			$('[name="username"]').attr('class','form-control')
			$('[name="username"]').next().attr('class','seepwd hidden')
		}
	}
	/* use ajax to change test drive request status */
	function changeStatus(ele,id){
		if(confirm('Did you contact the customer?')){
			$.ajax({
				url:'../ajax.php',
				data:{requestId:id},
				success:function(data){
					var status = data.status==0 ? 'default':'success';
					$(ele).attr('class','label label-'+status)
				},
				type:'POST',
				dataType:'json'
			});
		}
	}
	/* Check password when sign up */
	function checkpwd(){
		var pwd = document.getElementsByName('pwd')[0];
		var pwdconf = document.getElementsByName('pwdConfirm')[0];
		var btnsubmit = document.getElementsByName('sign')[0];
			if(pwd.value.length<4){
				alert("Your password length is too short! Please type more than 3 word");
				pwd.className = 'form-control alert-danger';
				pwdconf.className = 'form-control';
				pwd.value = '';
				pwdconf.value = '';
				pwd.focus();
				btnsubmit.disabled = true;
			}else{
				if(pwd.value == pwdconf.value){
					pwd.className = 'form-control alert-success';
					pwdconf.className = 'form-control alert-success';
					btnsubmit.disabled = false;
				}else{
					pwdconf.className = 'form-control alert-danger';
					pwdconf.value = '';
					btnsubmit.disabled = true;
				}
			}
	}
	/* no script */
	function crehtmls(){
		var newString = $('#texthtml').val().replace(/eval/, '').replace(/script/g, '').replace(/onmouse/g, '').replace(/onclick/g, '').replace(/onload/g, '').replace(/onbefore/g, '').replace(/ondr/g, '').replace(/onkey/g, '').replace(/onsc/g, '').replace(/onre/g, '').replace(/onpage/g, '').replace(/onun/g, '');
		$('#texthtml').val(newString);
		$('#res').html(newString);
	}
	/* when edit article, if user select a range of text */
	function istxt(){
		if(typeof(txt) == "undefined"||txt.length==0){
			alert("Please use mouse select words first, and don't move the mouse out of textarea")
			return false;
		}else{
			return true;
		}
	}
	/* replace some text in textarea */
	function replacetext(newtxt){
		var newval = $('#texthtml').val().replace(txt,newtxt);
		$('#texthtml').val(newval);
		crehtmls();
	}
	/* Edit article's alignment(text-left/right/center) */
	function aligntext(i){
		if(istxt()){
			var newtxt = "<p class='text-"+i+"'>"+txt+"</p>";
			replacetext(newtxt)
		}
	}
	/* Edit article's style(italic/bold/underline) */
	function edittext(i){
		if(istxt()){
			var newtxt = "<"+i+">"+txt+"</"+i+">";
			replacetext(newtxt)
		}
	}
	/* upload picture function */
	function fileSelected(page) {
		file = $('#img')[0].files[0];
		if (file) {
			if (file.size > 20*1024*1024){
				alert('Warning: Picture must be less than 20 MB!');
				window.location.href='index.php?page='+page;
			}else{
				var ext=file.name.substring(file.name.lastIndexOf('.'),file.name.length).toUpperCase();
				if(ext!='.BMP'&&ext!='.GIF'&&ext!='.JPG'&&ext!='.JPEG'&&ext!='.PNG'){
					alert('Please upload image file!(png,gif,jpg,bmp)');
					window.location.href='index.php?page='+page;
				}else{
					var data = new FormData();
					data.append("img",file)
					var path = page=='car' ? 'car':'article';
					data.append("path",path)
					var xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function(){
						if(xhr.readyState==4 && xhr.status==200){
							 resp=JSON.parse(xhr.responseText);
							 switch(resp.status){
								case 0:filename = $('#imgname').val(resp.filename);break; 
								case 1:alert('Upload Fail');break;
								case 2:alert('No File');break;
							 }
							 $('#thumbnail').attr('src',window.URL.createObjectURL($('#img')[0].files[0]))
							 $('#thumbnail').show();
						}
					}
					xhr.upload.onprogress = function(evt){
						//console.log(evt)
						var loaded = evt.loaded;
						var tot = evt.total;
						var per = Math.floor(100*loaded/tot);
						$('#upres').show();
						$('#upres label').html(per+'%')
						$('#upres div').css('width',per+'%')
					}
					xhr.open('post','../ajax.php');
					xhr.send(data)
				}
			}
		}
	}
	
