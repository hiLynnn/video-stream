<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
<meta name="description" content="">
<meta name="msapplication-tap-highlight" content="yes" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Email Template</title>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style type="text/css">
@import url(https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap);
body {margin: 0; padding: 0; min-width: 100%!important;}
img {height: auto;}
a {transition: 0.4s;}
a:active, a:hover {outline: 0;transition: 0.4s;}
.content {width: 100%; max-width: 520px;}
.header {padding: 40px 30px 20px 30px;}
.innerpadding {padding:25px 30px;}
body[yahoo] .unsubscribe {width:170px;display: block; margin-top: 15px; padding: 8px 20px; background: #fe0531; color:#ffffff; border-radius: 4px; text-decoration: none!important; font-weight: 500;}
body[yahoo] .unsubscribe:hover {background: #2f3942;color:#acb1b5;}

@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
.innerpadding {padding:30px 20px;}
body[yahoo] .hide {display: none!important;}
body[yahoo] .buttonwrapper {background-color: transparent!important;}
body[yahoo] .button {padding: 0px!important;}
body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
body[yahoo] .unsubscribe {display: block; margin-top: 15px; padding: 10px 20px; background: #2f3942; border-radius: 4px; text-decoration: none!important; font-weight: 500;}
.h1 {font-size: 26px;line-height: 36px;}
}
</style>
</head>

<body yahoo bgcolor="#ffffff">
<div style="word-spacing:normal;background-color:#efefef"><div class="adM">
</div><div style="background-color:#efefef"><div class="adM">
</div><div style="margin:0px auto;max-width:600px"><div class="adM">
</div><table style="width:100%" role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="direction:ltr;font-size:0px;padding:0;text-align:center">
<div style="margin:0px auto;max-width:600px">
<table style="width:100%" role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="direction:ltr;font-size:0px;padding:0;text-align:center">
<div style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
<table style="vertical-align:top" role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td style="font-size:0px;padding:0;word-break:break-word" align="center">
<table style="min-width:100%;max-width:100%;border-collapse:collapse;border-spacing:0px" role="presentation" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td><a href="{{ url('/') }}" target="_blank"><img style="border:0;display:block;outline:none;text-decoration:none;height:auto;min-width: 20%;width: 20%;max-width: 100%;font-size: 13px;margin: 0 auto;padding: 25px;" src="{{ URL::asset('/'.getcong('site_logo')) }}" width="200" height="25" style="width:200px;height:25px"></a></td> 
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>

<div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px">
<table style="background:#ffffff;background-color:#ffffff;width:100%" role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="direction:ltr;font-size:0px;padding:5px 5px 5px 5px;text-align:center">
<div style="margin:0px auto;max-width:590px">
<table style="width:100%" role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="direction:ltr;font-size:0px;padding:5px 5px 5px 5px;text-align:center">
<div style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
<table style="vertical-align:top" role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
 
<tr>
<td dir="ltr" style="font-size:0px;padding:5px 5px 5px 5px;word-break:break-word" align="left">
<div style="font-family:Helvetica Neue, Helvetica, Arial;font-size:16px;line-height:24px;text-align:left;color:#282828">Hello Admin,</div>
</td>
</tr> 
<tr>
<td dir="ltr" style="font-size:0px;padding:5px 5px 5px 5px;word-break:break-word" align="left">
<div style="font-family:Helvetica Neue, Helvetica;font-size:16px;line-height:24px;text-align:left;color:#282828"> 

       Contact details below...<br/><br/>

        Name: <?php echo $name?><br/>
        Email: <?php echo $email ?><br/>
        Phone: <?php echo $phone ?><br/>    
        Subject: <?php echo $subject ?><br/>
        Message: <?php echo $user_message ?><br/>

</div>

 
</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>

<div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px">
<table style="background:#ffffff;background-color:#ffffff;width:100%" role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="direction:ltr;font-size:0px;padding:5px 5px 5px 5px;text-align:center">
<div style="margin:0px auto;max-width:590px">
<table style="width:100%" role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="direction:ltr;font-size:0px;padding:0 0 0 0px;padding-bottom:0;padding-right:0;padding-top:0;text-align:center">
<div style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
<table style="vertical-align:top" role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td style="font-size:0px;padding:0;word-break:break-word" align="center">
<p style="border-top:solid 1px #1e2026;font-size:1px;margin:0px auto;width:100%">&nbsp;</p>
</td>
</tr>
<tr>
<td dir="ltr" style="font-size:0px;padding:5px 5px 5px 5px;word-break:break-word" align="center">
<div style="font-family:BinancePlex,Arial,PingFangSC-Regular,'Microsoft YaHei',sans-serif;font-size:18px;font-weight:800;line-height:30px;text-align:center;color:#343565">Stay Connected</div>
</td>
</tr>
<tr>
<td style="font-size:0px;padding:0;word-break:break-word" align="center">

<table style="float:none;display:inline-table" role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="padding:4px;vertical-align:middle">
<table style="" role="presentation" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td style="font-family:Helvetica Neue, Helvetica;color:#1e2026;font-weight:500;font-size: 14px;">
<a href="{{stripslashes(getcong('footer_fb_link'))}}" target="_blank" style="color:#1e2026">Facebook</a> | 
<a href="{{stripslashes(getcong('footer_instagram_link'))}}" target="_blank" style="color:#1e2026">Instagram</a> | 
<a href="{{stripslashes(getcong('footer_twitter_link'))}}" target="_blank" style="color:#1e2026">Twitter</a>  
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>

<div style="margin:0px auto;max-width:590px">
<table style="width:100%" role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="direction:ltr;font-size:0px;padding:5px 5px 5px 5px;text-align:center">
<div style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
<table style="vertical-align:top" role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td dir="ltr" style="font-size:0px;padding:25px 5px 15px 5px;word-break:break-word" align="center">
<div style="font-family:Helvetica Neue, Helvetica;font-size:14px;font-weight:500;line-height:16px;text-align:center;color:#1e2026">© {{date('Y')}} {{getcong('site_name')}}, All Rights Reserved.</div>
</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>

</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</body>
</html>