package main 

import (
	"fmt"
	"net/http"
)

func sayHello(w http.ResponseWriter, r *http.Request){
	fmt.Fprint(w,"hello world");
}

func main() {
	http.HandleFunc("/",sayHello)
	err := http.ListenAndServe(":9091",nil)

	if nil != err {
		fmt.Println(err)
	}
}