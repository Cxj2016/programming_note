package main

import (
        "os"
        "fmt"
)

func main() {
        query_string := os.Getenv("QUERY_STRING");//获取查询字符串
        //处理查询字符串，这里直接打印
        fmt.Println("query_string:" + query_string);
}
