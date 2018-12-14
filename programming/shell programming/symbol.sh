#! /bin/bash
array_value_exist(){
        value=$1
        array=$2
	grep "$value" "${array[@]}" && echo 1
}



ar=("aadmin" "game")
array_value_exist "game" "${ar[*]}"
#echo $?
