package main 

import(
	"fmt"
)

func main() {
	//两种赋值方式
	// var numbers map[string] int
	numbers := make(map[string] int)
	numbers["one"] = 1
	numbers["two"] = 2
	numbers["three"] = 3

	fmt.Println(numbers["two"])
}