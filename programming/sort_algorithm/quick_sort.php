<?php 
	//快速排序
	function quick_sort($arr){
		if(count($arr) <= 1){//1个或者0个元素直接返回
			return $arr;
		}
		$key = $arr[0];
		$left_arr = $right_arr = array();
		for($i = 1; $i < count($arr);$i++){
			if($key > $arr[$i]){
				$left_arr[] = $arr[$i];
			}else{
				$right_arr[] = $arr[$i];
			}
		}
		$left_arr = quick_sort($left_arr);
		$right_arr = quick_sort($right_arr);
		return array_merge($left_arr,array($key),$right_arr);
	}

	$arr = [5,1,3,6,8,0,7,9,4,2];
	var_export(quick_sort($arr));
?>