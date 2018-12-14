package main 

import "fmt"
import "math"

type Rectangle struct{
	width,height float64
}

type Circle struct{
	radius float64
}

func (r Rectangle) area() float64 {
	return r.width * r.height
}

func (c Circle) area(rate float64) float64 {
	return rate * c.radius * c.radius * math.Pi
}

func main() {
	r1 := Rectangle{12,2}
	c1 := Circle{1}
	fmt.Println("area is ",r1.area())
	fmt.Println("area is ",c1.area(3))
}