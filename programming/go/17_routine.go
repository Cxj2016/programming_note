package main 

import "fmt"
// import "time"

var ch chan int = make(chan int)

func test(){
    for i:=0; i<10 ;i++{
        fmt.Print(i," ")
    }
    ch <- 0
}

func main()  {
    go test()
    go test()
    <-ch
    <-ch
    // time.Sleep(time.Second)
}