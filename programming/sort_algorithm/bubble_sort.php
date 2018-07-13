<?php 
	//从小到大冒泡排序
	function bubble_sort(&$arr){
		if(count($arr) <= 1){
			return $arr;
		}
		for ($i = 0; $i < count($arr); $i++) { 
			for ($j = count($arr) -1 ; $j > $i; $j--) { 
				if($arr[$j] < $arr[$j - 1]){
					$temp = $arr[$j];
					$arr[$j] = $arr[$j - 1];
					$arr[$j - 1] = $temp;
				}
			}
		}
	}

	$arr = array(1,3,5,6,8,9,7,2,4,0);
	bubble_sort($arr);
	var_export($arr);
?>