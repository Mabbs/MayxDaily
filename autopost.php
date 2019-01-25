<?php
function curl_post_https($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    $backdata = json_decode($tmpInfo,true);
    return $backdata['text']; // 返回数据，json格式
}
function w_get(){
        $url = 'https://yuri.gear.host/talk.php';
        $data['info']       = '银川天气';
        $data['userid']      = 'Mayx_Mail';
        $retdata=curl_post_https($url,$data);
        $data['info']       = '银川明天天气';
        $retdata = $retdata . "<br>" .curl_post_https($url,$data);
        $data['info']       = '银川后天天气';
        $retdata=$retdata . "<br>" .curl_post_https($url,$data);
        return $retdata;//返回json
}
function xh_get(){
        $url = 'https://yuri.gear.host/talk.php';
        $data['info']       = '讲个笑话';
        $data['userid']      = 'Mayx_Mail';
        $retdata=curl_post_https($url,$data);
        return $retdata;//返回json
}
function img_get(){
 $data = file_get_contents('https://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');
 $file = json_decode($data,true);
 $imgdata = '![Bing Background](https://cn.bing.com'.$file[images][0][url].' "'.$file[images][0][copyright].'")';
 return $imgdata;
}
function xw_get(){
//RSS源地址列表数组 
$rssfeed = array("http://www.people.com.cn/rss/it.xml"); 
 
for($i=0;$i<sizeof($rssfeed);$i++){//分解开始 
    $buff = ""; 
    $rss_str=""; 
    //打开rss地址，并读取
    $fp = fopen($rssfeed[$i],"r") or die("Can not open $rssfeed");  
    while ( !feof($fp) ) { 
        $buff .= fgets($fp,4096); 
    } 
    //关闭文件打开 
    fclose($fp); 
 
    //建立一个 XML 解析器 
    $parser = xml_parser_create(); 
    //xml_parser_set_option -- 为指定 XML 解析进行选项设置 
    xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1); 
    //xml_parse_into_struct -- 将 XML 数据解析到数组$values中 
    xml_parse_into_struct($parser,$buff,$values,$idx); 
    //xml_parser_free -- 释放指定的 XML 解析器 
    xml_parser_free($parser); 
    $j = 0;
    foreach ($values as $val) { 
        $tag = $val["tag"]; 
        $type = $val["type"]; 
        $value = $val["value"]; 
        //标签统一转为小写 
        $tag = strtolower($tag); 
 
        if ($tag == "item" && $type == "open"){ 
            $is_item = 1; 
        }else if ($tag == "item" && $type == "close") { 
            //构造输出字符串 
            $rss_str .= "[".$title."](".$link.")   
"; 
            $j++;
            $is_item = 0; 
        } 
        //仅读取item标签中的内容 
        if($is_item==1){ 
            if ($tag == "title") {$title = $value;}         
            if ($tag == "link") {$link = $value;} 
        } 
    if($j == 20){
        break;
    }
    } 
    //输出结果 
    return $rss_str."<br />"; 
} 
}
$txt = "---
layout: post
title: " . date("Y-m-d") . "-Mayx的日报
---

Hi,今天是" . date("Y-m-d") . "，以下是今天的日报：<br><small>
" . file_get_contents("https://yuri.gear.host/hitokoto/") . "</small><!--more-->
## 天气预报
" . w_get() . "
## 每日笑话
" . xh_get() . "
## 每日壁纸
" . img_get() . "
## 今日新闻

" . xw_get() . "

***

<small>" . file_get_contents("https://api.gushi.ci/all.txt") . "</small>
";
$markout = fopen("./_posts/" . date("Y-m-d") . "-MayxDaily.md", "w") or die("Unable to open file!");
fwrite($markout, $txt);
fclose($markout);
 function curl($url){
 $headers = array();
 $headers[] = 'Accept: */*';
 $headers[] = 'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3';
 $headers[] = 'Accept-Encoding: gzip, deflate, br';
 $headers[] = 'Referer: https://www.pixiv.net/';
 $headers[] = 'Connection: keep-alive';
 $headers[] = 'Cache-Control: max-age=0';
 $curl = curl_init();
 curl_setopt($curl,CURLOPT_URL,$url);
 curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
 curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,60);
 curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
 curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 iHuan Firefox/54.0");
 $src = curl_exec($curl);
 curl_close($curl); 
 return $src;
 }
 $data = file_get_contents('https://www.pixiv.net/');
 preg_match_all('/value=\'(.*?)\'>/is',$data,$reg);
 $img = json_decode($reg[1][0],true);
 $num = 0;
 $imageso = "---
layout: default
title: Pixiv 背景
---

";
 foreach($img['pixivBackgroundSlideshow.illusts']['landscape'] as $data){
 file_put_contents('images/'.$num.'.jpg',curl(str_replace('https','http',$data['url']['1200x1200'])));
 $imageso = $imageso.'![Pixiv](images/'.$num.'.jpg "Pixiv ID:'.$data['illust_id'].'")<br />
 ';
 $num++;
 }
$markout = fopen("DailyPic.md", "w");
fwrite($markout, $imageso);
fclose($markout);
file_get_contents("https://mappi.000webhostapp.com/mail.mayx.php");
?>
