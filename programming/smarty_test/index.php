<?php
require "/usr/local/lib/smarty/libs/Smarty.class.php";

$smarty = new Smarty(); //实例化Smarty对象

$smarty->setTemplateDir( dirname( __FILE__ ) . '/templates/' ); //设置模板路径，
$smarty->setCompileDir( dirname( __FILE__ ) . '/templates_compile/' ); //设置编译模板的路径

$smarty->assign('what','Smarty 模板引擎测试'); //模板赋值

$smarty->display('index.tpl'); //模板渲染


//smarty 模板引擎测试
//echo "smarty 模板引擎测试";