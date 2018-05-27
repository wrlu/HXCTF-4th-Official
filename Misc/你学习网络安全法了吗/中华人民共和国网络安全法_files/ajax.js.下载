var xmlHttp = null;

var __ajax_ok=true;
var __ajax_dns = "";

function CreatexmlHttp()
{
	try {
	   xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {
	   try {
	  xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	   } catch (e2) {
	  xmlHttp = new XMLHttpRequest();
	   }
	 }
}

function SendRequest(url,send,callback)
{
	if(xmlHttp==null)
		CreatexmlHttp();
		
	if(send==null)
		xmlHttp.open("GET", url, true);
	else
		xmlHttp.open("POST", url, true);
		
   	xmlHttp.onreadystatechange = function ()
	{
		if( xmlHttp.readyState == 4 )
			eval(callback(xmlHttp));
	}
	
	if(send==null)
   		xmlHttp.send(send);
	else
	{
		xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xmlHttp.send(send)
	}
}

function Ok3w_Ajax_Alert(Str,Err)
{
	var tmp = Str.split("--")
	if(tmp[0]=="Ok3w.Net")
	{
		alert(tmp[1]);
	}
	else
	{
		if(Err==1)
		{
			alert("你当前的测试环境不支持此功能。建议在Windows自带的IIS下测试；或是直接上传至虚拟主机测试。");
		}
	}
}
////////////////////////////////////////////////////

var __login_frm = null;

function Ok3w_UserLogin(__frm, dns)
{
	__login_frm = __frm;
	var __u = __frm.User_Name.value.trim();
	var __p = __frm.User_Password.value.trim();
	var __v = __frm.ValidCode.value;
	
	var patrn=/^[a-zA-Z0-9_\u4E00-\u9FA5]{4,20}$/;
	if(!patrn.test(__u))
	{
		alert("用户名不正确：\n\n它应该是由4-20位的中文、英文、数字及下划线组成的字符");
		__frm.User_Name.focus();
		return false;
	}
	
	var patrn=/^[a-zA-Z0-9_]{6,20}$/;
	if(!patrn.test(__p))
	{
		alert("密码不正确：\n\n它应该是由6-20位的英文、数字及下划线组成的字符");
		__frm.User_Password.focus();
		return false;
	}

	if(__v.length!=4)
	{
		alert("验证码输错误，请重新输入。");
		__frm.ValidCode.focus();
		return false;
	}
	
	if(__ajax_ok)
	{
		__login_frm.bntSubmit.disabled = true;
		__ajax_ok = false;
		__ajax_dns = dns;
		var url = dns + "c/ajax.asp?rnd=" + Math.random();
		var send = "action=Login&User_Name=" + escape(__u) + "&User_Password=" + escape(__p) + "&ValidCode=" + __v;
		SendRequest(url,send,Ok3w_UserLogin_Ok);
	}	
}

function Ok3w_UserLogin_Ok(xmlHttp)
{
	var ok = xmlHttp.responseText;
	if(ok=="-1")
	{
		location.href = "User_Index.asp";
	}
	else
	{
		 Ok3w_Ajax_Alert(ok,1);
	}
	__login_frm.bntSubmit.disabled = false;
	__ajax_ok=true;
}

///////////////////////////////////////////////////////

function Ok3w_Article_Hits_Mood(dns,ID,mood)
{
	if(__ajax_ok)
	{
		__ajax_ok = false;
		__ajax_dns = dns;
		var __id = ID;
		var __mood = mood;
		var url = dns + "c/ajax.asp?rnd=" + Math.random();
		var send = "action=Article_Hits&ID=" + __id + "&mood=" + __mood;
		SendRequest(url,send,Ok3w_Article_Hits_Mood_Ok);
	}	
}

function Ok3w_Article_Hits_Mood_Ok(xmlHttp)
{
	var ok = xmlHttp.responseText;
	if(ok.indexOf("|")>-1)
	{
		var tmp = ok.split("|");
		var hits = tmp[0];
		var mTmp = tmp[1].split(",");
		var mITmp = tmp[2].split(",");
		
		document.getElementById("News_Hits").innerHTML = hits;
		
		for(var i=1;i<=8;i++)
		{
			if(mITmp[i-1]==0)
				mITmp[i-1]=1
			document.getElementById("moodimg" + i).style.height = mITmp[i-1] + "px";
			document.getElementById("moodnum" + i).innerHTML = mTmp[i-1];
		}
	}
	else
	{
		 Ok3w_Ajax_Alert(ok,0);
	}
	__ajax_ok=true;
}

///////////////////////////////////////////////////////

function Ok3w_Soft_Hits(dns,id,ac)
{
	if(__ajax_ok)
	{
		__ajax_ok = false;
		__ajax_dns = dns;
		var url = dns + "c/ajax.asp?id=" + id + "&ac=" + ac + "&type=display&rnd=" + Math.random();
		var send = "action=Soft_Hits";
		SendRequest(url,send,Ok3w_Soft_Hits_Ok);
	}	
}

function Ok3w_Soft_Hits_Ok(xmlHttp)
{
	var ok = xmlHttp.responseText;
	if(ok.indexOf(",")>-1)
	{
		var tmp = ok.split(",");
		
		document.getElementById("downCount").innerHTML = tmp[0];
		document.getElementById("s1").innerHTML = tmp[1];
		document.getElementById("s2").innerHTML = tmp[2];
		document.getElementById("sp1").innerHTML = tmp[3]+"%";
		document.getElementById("sp2").innerHTML = tmp[4]+"%";
		document.getElementById("eimg1").style.width = tmp[5] + "px";
		document.getElementById("eimg2").style.width = tmp[6] + "px";
	}
	else
	{
		Ok3w_Ajax_Alert(ok,0);
	}
	__ajax_ok=true;
}

//////////////////////////////////////////////

var __book_form = null;

function Ok3w_Book_Save(__frm,dns,TypeID,TableID)
{
	__book_form = __frm;
	var __p = 0;
	if(TableID==0)
	{
		for(var i=0;i<__frm.pID.length;i++)
		{
			if(__frm.pID[i].checked)
			{
				__p = __frm.pID[i].value;
				break;
			}
		}
	}
	var __u = __frm.UserName.value.trim();
	var __q = __frm.QQ.value.trim();
	var __m = __frm.Mail.value.trim();
	var __h = __frm.Homepage.value.trim();
	var __c = __frm.Content.value.trim();
	var __v = __frm.ValidCode.value.trim();
	
	if(__u=="")
	{
		alert("姓名不能为空，请重新输入。");
		__frm.UserName.focus();
		return false;
	}
	if(__c=="")
	{
		alert("留言内容不能为空，请重新输入。");
		__frm.Content.focus();
		return false;
	}
	if(__c.length>2000)
	{
		alert("留言内容不能超过2000个字符，请重新输入。");
		__frm.Content.focus();
		return false;
	}
	
	if(__v.length!=4)
	{
		alert("验证码输错误，请重新输入。");
		__frm.ValidCode.focus();
		return false;
	}
	
	if(__ajax_ok)
	{
		__ajax_ok = false;
		__ajax_dns = dns;
		__book_form.bntSubmit.disabled = true;
		var url = dns + "c/ajax.asp?rnd=" + Math.random();
		var send = "action=Message&pID=" + escape(__p) + "&UserName=" + escape(__u) + "&QQ=" + escape(__q) + "&Mail=" + escape(__m) + "&Homepage=" + escape(__h) + "&Content=" + escape(__c) + "&ValidCode=" + escape(__v) + "&TypeID=" + escape(TypeID) + "&TableID=" + escape(TableID);
		SendRequest(url,send,Ok3w_Book_Save_Ok);
	}	
}

function Ok3w_Book_Save_Ok(xmlHttp)
{
	var ok = xmlHttp.responseText;
	if(ok=="-1")
	{
		alert("非常感谢！你的留言已经成功提交，请等待管理员审核。");
		__book_form.reset();
	}
	else
	{
		Ok3w_Ajax_Alert(ok,1);
	}
	__book_form.bntSubmit.disabled = false;
	__ajax_ok = true;
}

////////////////////////////////////////////////////////////

function chkuser(str)
{
	var patrn=/^[a-zA-Z0-9_\u4E00-\u9FA5]{4,20}$/;
	if(!patrn.test(str))
	{
		alert("用户名不正确：\n\n它应该是由4-20位的中文、英文、数字及下划线组成的字符");
		return false;
	}
	else
		return true;
}

function chkpass(str)
{
	var patrn=/^[a-zA-Z0-9_]{6,20}$/;
	if(!patrn.test(str))
	{
		alert("密码不正确：\n\n它应该是由6-20位的英文、数字及下划线组成的字符");
		return false;
	}
	else
		return true;
}

function chkemail(str)
{
	var patrn= /^[_a-zA-Z0-9\-]+(\.[_a-zA-Z0-9\-]*)*@[a-zA-Z0-9\-]+([\.][a-zA-Z0-9\-]+)+$/;
	if(!patrn.test(str))
	{
		alert("邮箱地址格式错误，请重新输入");
		return false;
	}
	else
		return true;
}

//////////////////////////////////////////////////////

var __reg_form = null;

function Ok3w_User_Reg(__frm,dns)
{
	__reg_form = __frm;
	var __User_Name = __frm.User_Name.value.trim();
	var __User_Password = __frm.User_Password.value.trim();
	var __Mail = __frm.Mail.value.trim();
	var __Name = __frm.Name.value.trim();
	var __Sex = "保密";
	for(var i=0;i<__frm.Sex.length;i++)
	{
		if(__frm.Sex[i].checked)
		{
			__Sex = __frm.Sex[i].value;
			break;
		}
	}
	var __Birthday = __frm.Birthday.value.trim();
	var __Tel = __frm.Tel.value.trim();
	var __QQ = __frm.QQ.value.trim();
	var __Address = __frm.Address.value.trim();
	var __Zip = __frm.Zip.value.trim();
	var __Content = __frm.Content.value.trim();
	var __ValidCode = __frm.ValidCode.value.trim();
	
	if(!chkuser(__User_Name))
	{
		__frm.User_Name.focus();
		return false;
	}
	if(!chkpass(__User_Password))
	{
		__frm.User_Password.focus();
		return false;
	}
	if(__User_Password!=__frm.User_Password2.value)
	{
		alert("两次输入的密码不一致，请重新输入");
		__frm.User_Password2.focus();
		return false;
	}
	if(!chkemail(__Mail))
	{
		__frm.Mail.focus();
		return false;
	}
	if(__ValidCode.length!=4)
	{
		alert("验证码输错误，请重新输入。");
		__frm.ValidCode.focus();
		return false;
	}
	
	if(__ajax_ok)
	{
		__reg_form.bntSubmit.disabled = true;
		__ajax_ok = false;
		__ajax_dns = dns;
		var url = dns + "c/ajax.asp?rnd=" + Math.random();
		var send = "action=Reg&User_Name=" + escape(__User_Name) + "&User_Password=" + escape(__User_Password) + "&ValidCode=" + escape(__ValidCode) + "&Mail=" + escape(__Mail) + "&Name=" + escape(__Name) + "&Sex=" + escape(__Sex) + "&Birthday=" + escape(__Birthday) + "&Tel=" + escape(__Tel) + "&QQ=" + escape(__QQ) + "&Address=" + escape(__Address) + "&Zip=" + escape(__Zip)  + "&Content=" + escape(__Content);
		SendRequest(url,send,Ok3w_User_Reg_Ok);
	}
}

function Ok3w_User_Reg_Ok(xmlHttp)
{
	var ok = xmlHttp.responseText;
	if(ok=="-1")
	{
		alert("非常感谢！你已经成功注册成为本站会员。");
		
		location.href = "User_Index.asp";
	}
	else
	{
		Ok3w_Ajax_Alert(ok,1);
		__reg_form.bntSubmit.disabled = false;
	}
	__ajax_ok = true;
}