package main

import "fmt"

func main() {
	// if x := 0; x > 10 {
	// 	fmt.Println("x 大于10")
	// }else if x > 0 {
	// 	fmt.Println("x 大于0")
	// }
	// var people map[string] string
	// people = make(map[string] string)
	// people["chen"] = "xijian";
	// people["wang"] = "yu";
	// for __,v := range people{
	// 	fmt.Println("k = " + __,"v = " + v);
	// }
	var number = 10
	switch number{
		case 5:
			fmt.Println(5)
		case 10:
			fmt.Println(10)
			fallthrough
		default:
			fmt.Println("default")
	}
}