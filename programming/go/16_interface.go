package main 

import "fmt"

type Phone interface{
	call()
}

type iPhone struct{

}

type androidPhone struct{

}

func (iphone iPhone) call(){
	fmt.Println("I am iPhone")
}

func (androidphone androidPhone) call(){
	fmt.Println("I am androidPhone")
}

func main() {
	var phone Phone
	phone = new(iPhone)
	phone.call()
	phone = new(androidPhone)
	phone.call()
}