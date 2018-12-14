package main

import "fmt"

func main() {
	//定义数组
	var a [5] int;
	a = [5]int{1,2,3,4,5};
	var balance [5]float32 = [5]float32{1000.0, 2.0, 3.4, 7.0, 50.0};
	testArray(balance,5);
	fmt.Println(a);
	for i := 0;i < 5;i++ {
		fmt.Println(a[i]);
	}
}

func testArray(arr [5]float32,size int) {
	for i := 0; i < size; i++ {
		fmt.Println(arr[i]);
	}
}