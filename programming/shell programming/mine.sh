#! /bin/bash
SOURCE_PATH=/home/game/pc_site #源代码所在位置
BACKUP_PATH=/home/game #备份目录
DIRS_CAN_DEPLOY=("game" "wiki_game") #支持发布的项目文件夹，如果后续有需要，需要在后面追加
TARGET=/var/www/html #目标文件夹
DESTINATION_MACHINE=("cn_tx_ofw_web01" "cn_tx_ofw_web02") #目标机器群

#校验要发布的项目是否合理
if [ 0 -eq $# ] #传递的参数为空
then
       echo "请输入要发布的项目,[${DIRS_CAN_DEPLOY[@]}]中的一个或多个项目"
       kill $$
fi

#检查要发布的项目是否在支持列表
dirs_to_deploy=$@
for dir in ${dirs_to_deploy[@]}
do
        echo ${DIRS_CAN_DEPLOY[@]} | grep -wq $dir || (echo "不支持 $dir 项目的发布 " && kill $$)
done

#开始发布
for machine in ${DESTINATION_MACHINE[@]}
do
        for dir in $dirs_to_deploy
        do
                command=`rsync -az $SOURCE_PATH/$dir $machine:$TARGET`
                sleep 5
                echo $command
        done
done
echo "发布成功"