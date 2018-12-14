package main

import (
	"fmt"
	"html/template"
	"log"
	"net/http"
	"strings"
)

func sayHelloName(w http.ResponseWriter, r *http.Request) {
	r.ParseForm() //解析url传递的参数，对于POST则解析响应包的主体request body
	fmt.Println(r.Form)
	fmt.Println("path", r.URL.Path)
	fmt.Println("scheme", r.URL.Scheme)
	fmt.Println(r.Form["url_long"])
	for k, v := range r.Form {
		fmt.Println("key:", k)
		fmt.Println("val:", strings.Join(v, ""))
	}
	fmt.Fprint(w, "Hello Chenxj")
}

func login(w http.ResponseWriter, r *http.Request){
	fmt.Println("method:",r.Method)
	if r.Method == "GET" {
		t,_ := template.ParseFiles("login.html")
		t.Execute(w,nil)
	} else{
		r.ParseForm()
		fmt.Println("username:",r.Form["username"])
		fmt.Println("password:",r.Form["password"])
	}
}

func main() {
	http.HandleFunc("/", sayHelloName)       //设置访问的路由
	http.HandleFunc("/login",login)
	err := http.ListenAndServe(":9090", nil) //设置监听的端口
	if err != nil {
		log.Fatal("ListenAndServe: ", err)
	}
}
