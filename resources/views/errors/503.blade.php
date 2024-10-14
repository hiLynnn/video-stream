<html lang="en">
<head>
<meta name="theme-color" content="#ff0015">  
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="">
<title>{{getcong('maintenance_title')?stripslashes(getcong('maintenance_title')):"The Website Under Maintenance!"}} </title>
<!-- Favicon -->
<link rel="icon" href="{{ URL::asset('/'.getcong('site_favicon')) }}">
<style>
body {
    margin: 0;
    padding: 0;
   background:#000;
}
* {
    box-sizing: border-box;
}
.maintenance {
    background-image: url(https://demo.wpbeaveraddons.com/wp-content/uploads/2018/02/main-1.jpg);
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: scroll;
    background-size: cover;
}
.maintenance {
    width: 100%;
    height: 100%;
    min-height: 100vh;
}
.maintenance {
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    align-items: center;
}
.maintenance_contain {
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: center;
    width: 100%;  
    padding: 15px;  
}
.maintenance_contain img {
    width: auto;
    max-width: 100%;
}
.pp-infobox-title-prefix {
    font-weight: 700;
    font-size: 20px;
    color: #000000;
    margin-top: 30px;
    text-align: center;
}
.pp-infobox-title-prefix {
    font-family: sans-serif;
}
.pp-infobox-title {
    color: #000000;
    font-family: sans-serif;
    font-weight: 700;
    font-size: 36px;
    margin-top: 25px;
    margin-bottom: 10px;
    text-align: center;
    display: block;
    word-break: break-word;  
}
.pp-infobox-description {
    color: #000000;
    font-family: "Poppins", sans-serif;
    font-weight: 400;
	max-width: 65%;
    font-size: 18px;
    margin-top: 0px;
    margin-bottom: 0px;
    text-align: center;
}
.pp-infobox-description p a{
	color:#d02920
}
.pp-infobox-description p a:hover{
	color:#626262;
	text-decoration:none;
}
.pp-infobox-description p {
    margin: 0;
	color: #626262;
	font-weight: 500;
	line-height: 32px;
}
.title-text.pp-primary-title {
    color: #000000;
    padding-top: 0px;
    padding-bottom: 0px;
    padding-left: 0px;
    padding-right: 0px;
    font-family: sans-serif;
    font-weight: 500;
    font-size: 18px;
    line-height: 1.4;
    margin-top: 50px;
    margin-bottom: 0px;
}

@media only screen and (max-width: 991px) {
.pp-infobox-description{
	max-width:92%;
}
}

@media only screen and (max-width: 767px) {
.pp-infobox-description{
	max-width:100%;
}
.pp-infobox-title{
	font-size:32px;
	line-height:42px;
}
.pp-infobox-description p {
	line-height: 28px;
	font-size: 16px;
}
}
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body>

<div class="maintenance">
  <div class="maintenance_contain">
    <img src="https://demo.wpbeaveraddons.com/wp-content/uploads/2018/02/main-vector.png" alt="maintenance">
    <div class="pp-infobox-title-wrapper">
	  <h3 class="pp-infobox-title">
        @if(getcong('maintenance_title')) 
            {{stripslashes(getcong('maintenance_title'))}} 
        @else 
            The Website Under Maintenance!
        @endif
       </h3>
	</div> 
	<div class="pp-infobox-description">
		<p>
        @if(getcong('maintenance_description')) 
            {!!stripslashes(getcong('maintenance_description'))!!} 
        @else 
            Sorry for the inconvenience but we’re performing some maintenance at the moment. If you need to you can always <a href="mailto::{{getcong('site_email')}}">Contact Us</a>, otherwise we’ll be back online shortly!
        @endif
            </p>			
 
	</div>    
  </div>
</div>

</body>
</html>