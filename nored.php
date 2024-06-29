<?php

?><head><title>No Redirect </title></head> 
 <meta name=viewport content="width=device-width, initial-scale=1"/>
<link rel=stylesheet href="https://fonts.googleapis.com/css?family=Staatliches"/><style type="text/css">textarea{max-width:90%;width:100%;height:150px;resize:none;outline:none;overflow:auto;background:transparent;color:#fff}.asu{font-family:calibri}button{background:transparent;font-family:Staatliches;color:#fff;border-color:#fff;cursor:pointer}input{background:transparent;font-family:Staatliches;color:#fff;border-color:#fff;cursor:pointer;max-width:95%}font{font-family:Staatliches}body::-webkit-scrollbar{width:12px}body::-webkit-scrollbar-track{background: ##1e1e1e}body::-webkit-scrollbar-thumb{background-color: ##1e1e1e;border:3px solid gray}</style></head>
<body bgcolor="#1e1e1e" text=white><noscript><meta HTTP-EQUIV="refresh" content="0;url='?PageSpeed=noscript'" /><style><!--table,div,span,font,p{display:none} --></style><div style="display:block">Please click <a href="?PageSpeed=noscript">here</a> if you are not redirected within a few seconds.</div></noscript>
<body><center>
<br> 
<br> 
<br> 
<?php 
function xss($string){ 
return htmlspecialchars($string); 
 } 
function stripFile($in){ 
    $pieces = explode("/", $in); 
    if(count($pieces) < 4) return $in . "/"; 
    if(strpos(end($pieces), ".") !== false){ 
        array_pop($pieces); 
    }elseif(end($pieces) !== ""){ 
        $pieces[] = ""; 
    } 
    return implode("/", $pieces). "/"; 
} 
 
 
 function url_get_contents ($url) { 
    if (function_exists('curl_exec')){ 
        $conn = curl_init($url); 
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true); 
        curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true); 
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1); 
        $url_get_contents_data = (curl_exec($conn)); 
        curl_close($conn); 
    }elseif(function_exists('file_get_contents')){ 
        $url_get_contents_data = file_get_contents($url); 
    }elseif(function_exists('fopen') && function_exists('stream_get_contents')){ 
        $handle = fopen ($url, "r"); 
        $url_get_contents_data = stream_get_contents($handle); 
    }else{ 
        $url_get_contents_data = false; 
    } 
$data = str_replace('<a href="','<a href="'.$_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"].'?url='.stripFile($url),$url_get_contents_data); 
$data = str_replace('<head>','<head><base href="'.stripFile($url).'">',$data); 
return $data; 
} 
if(!isset($_GET['url'])){ ?> 
 
<center>  <h1><pre>Noredirect </pre></h1>
<form><span>URL: </span><input name="url" size="50" value="" type="text"><input value="GO" type="submit"></form> 
</center> 
<?php 
} 
else{ 
 
        if(substr($_GET['url'], 0, 4) == 'http'){ 
        echo '<center><form><span>URL: </span><input name="url" value="'.xss($_GET['url']).'" type="text"><input value="GO" type="submit"></form></center>'; 
        echo url_get_contents (xss($_GET['url'])); 
        } 
        else{ 
                ?> 
<center> 
<?php 
                echo '<form><span>URL: </span><input name="url" value="'.xss($_GET['url']).'" type="text"><input value="GO" type="submit"></form>'; 
                echo "Sorry Bro.<br> Check your URL<br>Only http or https protocols are allowed<br> NO SSRF Here :)<br>Enter Site with http:// or https:// </center>"; 
        } 
} 
 
?> 
<br> 
<br> 
<br>
