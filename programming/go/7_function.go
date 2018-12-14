package main

import "fmt"


func main() {
	var value int = test(1,2);
	fmt.Println(value);
	x,y := two();
	fmt.Println(two());
	fmt.Println(x + " " + y);
}

func test(num1,num2 int) int {
	return num1 + num2;
}

func two() (string,string){
	return "hello","world";
}