#! /bin/bash
# 列出目录下的所有文件
# 如果是文件，则开始统计。如果是文件夹，则递归
totalFileNum=0
totalLineNum=0
function count(){
	dir=$1
	for file in `ls $dir`
	do 
		echo $dir/$file
		if [ -d $dir/$file ]
		then
			count $dir/$file
		else
			let totalFileNum=$totalFileNum+1
			declare i number
			number=`sed -n "$=" $dir/$file`
			let totalLineNum=$totalLineNum+number
		fi
	done
}

count "./over"
echo $totalLineNum
echo $totalFileNum

