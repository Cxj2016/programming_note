#! /usr/local/bin/php
<?php
//注意: 需要在文件的一行指明php解释器路径，否则会报错
$query_string = getenv( 'QUERY_STRING' );

//
// 处理query_string,比如数据库交互，写文件这类操作。这里直接打印
//
echo $query_string;
?>
