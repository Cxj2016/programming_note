package main

import "fmt"
// import "strconv"
type Skills []string

type Person struct{
	name string
	age int
}
type Student struct{
	Person
	Skills
	id int
	int
	string
}

func main() {
	var s1 Student
	s1 = Student{Person:Person{"xijian.chen",25},id:1}
	s1.Skills = append(s1.Skills,"php","golang")
	s1.int = 2
	s1.string = "wangyu"
	fmt.Println(s1)
}