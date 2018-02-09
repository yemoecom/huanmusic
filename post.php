<?php
error_reporting(0);
function getUrlContent($url){  
        // 初始化一个curl会话  
        $ch = curl_init();  
        curl_setopt( $ch, CURLOPT_URL, $url);  
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5);  
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt( $ch, CURLOPT_REFERER, 'http://www.huanmusic.com');  
        curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5' );  
        curl_setopt( $ch, CURLOPT_POST, 1); //设置为POST方式  
        curl_setopt( $ch, CURLOPT_POSTFIELDS, array()); //数据传输  
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 ); //解决重定向问题  
        curl_setopt( $ch, CURLOPT_COOKIE, 's:hPvzSX5ItHJQTdha9ntEF2RBeqXH39cg.ispF2KR01c2AEAssKYA6+CPKXJCopYyZMXVknMafX1w');//抓包获取到的cookie值  
        // 执行一个curl会话  
        $contents = curl_exec($ch);  
        // 返回一个保护当前会话最近一次错误的字符串  
        $error = curl_error($ch);  
        if($error){  
            echo 'Error: '.$error;  
        }  
        // 关闭一个curl会话  
        curl_close( $ch );  
        return $contents;  
    }  
$ul='https://av.huanmusic.com/';
$id=$_GET['id'];
$a=json_decode(getUrlContent('http://www.huanmusic.com/music/info/'.$id));
//print_r($a);
if($a->avs[1]){
	$mp3=$ul.$a->avs[1]->key;
}else{
	$mp3=$ul.$a->avs[0]->key;
}

//header('content-type:audio/mp3');
?>
<!doctype html>
<html>
<head>
<style type="text/css">
.row{

	margin:0 auto;
	text-align:center;
    
}
.pic{
	margin:0 auto;
	background: linear-gradient(45deg,#020031 0,#6d3353 100%);
    background-image: linear-gradient(45deg, rgb(2, 0, 49) 0px, rgb(109, 51, 83) 100%);
    background-position-x: initial;
    background-position-y: initial;
    background-size: initial;
    background-repeat-x: initial;
    background-repeat-y: initial;
    background-attachment: initial;
    background-origin: initial;
    background-clip: initial;
    background-color: initial;
	box-shadow: inset 0 3px 7px rgba(0,0,0,.2), inset 0 -3px 7px rgba(0,0,0,.2);
	text-shadow: 0 1px 3px rgba(0,0,0,.4), 0 0 30px rgba(0,0,0,.075);
	background: #020031;
    background-image: linear-gradient(45deg, rgb(2, 0, 49) 0px, rgb(109, 51, 83) 100%);
    background-position-x: initial;
    background-position-y: initial;
    background-size: initial;
    background-repeat-x: initial;
    background-repeat-y: initial;
    background-attachment: initial;
    background-origin: initial;
    background-clip: initial;
    background-color: initial;
}
.pic:after{
	content: '';
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: url(https://static.bootcss.com/www/assets/img/bs-docs-masthead-pattern.png) repeat center center;
    opacity: .4;
}

</style>
</head>
<body>
<div class="row">
<p>
<div  class="audio">
<div class="pic">
<img src="<?php echo "https://net.huanmusic.com/".$a->pics[0]?>" width="300" height="260">
</div>
<audio controls="controls">
<source src="<?php echo $mp3;?>" />
</audio>
</p>
</div>
<p >
音乐名称：<?php echo $a->name;?>
</p>
<p>
歌手：<?php echo $a->singers[0]->name;?>(<?php echo $a->singers[0]->_id;?>)
</p>
音乐大小：<?php echo round($a->avs[0]->fsize/1024/1024,2)."MB" ?>|码率<?php echo substr($a->avs[1]->avInfo->bit_rate,0,3)."位" ?>
<hr>
<p>歌词：</p>
<p contenteditable="true">
<?php
 echo urldecode($a->lrc);
?>
</p>
</div>

<body>
</html>