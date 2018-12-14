package main 

import "fmt"

type Human struct{
	name string
	phone string
}

type Student struct{
	Human
	school string
}

type Employee struct{
	Human
	company string
}

func (h Human) sayHi(){
	fmt.Printf("I am %s,you can call me on %s\n",h.name,h.phone)
}

func (e Employee) sayHi() {
	fmt.Printf("I am %s,you can call me on %s,or come here %s",e.name,e.phone,e.company)
}

func main() {
	s := Student{Human{name:"s_xijian",phone:"s_123"},"heshan"}
	e := Employee{Human{"e_xijian","e_123"},"dena"}
	s.sayHi()
	e.sayHi()
}