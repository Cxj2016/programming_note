package main
import "fmt"

func main() {
   var fslice []int
   fslice = []int {1,2,3,4,5,6,7,8,9,0}
   slice := append(fslice,[]int{4,5,6}...) //这个...不能去掉
   fmt.Println(slice)
   fmt.Println(fslice)
   fmt.Println(len(fslice))
   fmt.Println(cap(fslice))
}

func printSlice(x []int){
   fmt.Printf("len=%d cap=%d slice=%v\n",len(x),cap(x),x)
}