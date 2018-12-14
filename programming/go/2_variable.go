package main

import "fmt"

var age int = 25;
var success = true;
// c := 10 会出错，这种不带声明格式的只能在函数体中出现
func main() {
	fmt.Println(age);
	fmt.Println(success);
	var a int = 10
	var b = 10
	c := 10
	e,f,g := "chen","xi","jian"
	fmt.Println(a,b,c)
	fmt.Println(e,f,g)
}
