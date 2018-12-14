package main
import "fmt"
func main() {
	numbers := [6]int{1,2,3,4,5};
	for i := 0; i < 10; i++ {
		fmt.Println(i)
	}
	for i,x := range numbers{
		fmt.Printf("第%d位的数字是%d\n",i,x);
	}
}