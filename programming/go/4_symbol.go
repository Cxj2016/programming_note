package main 

import "fmt"

func main() {
	var a,b = 10,20;
	var ptr *int;
	ptr = &a;
	fmt.Println(b + a);
	fmt.Println(*ptr);
}