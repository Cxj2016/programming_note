package main 

import "fmt"
//特殊常量iota
func main() {
	const (
    a = iota
    b = iota
    c = iota
	)	
	const d = iota
	fmt.Println(a,b,c,d)
}