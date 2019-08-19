package main

import "fmt"
// import "strconv"

func main() {
	var name string = "xijian"
	test(&name)

	// var p *int
	// p = &age
	fmt.Println("name = ",name)
}

func test(name *string) string{
	*name = "hello";
	return *name;
}