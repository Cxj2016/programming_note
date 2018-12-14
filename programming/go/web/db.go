package main

import (
	_ "github.com/go-sql-driver/mysql"
	"database/sql"
	"fmt"
)

func main() {
	db, err := sql.Open("mysql","root:root@tcp(localhost:3306)/go_test?charset=utf8")
	checkErr(err)

	//插入数据
	// stmt,err := db.Prepare("INSERT userinfo SET username=?,department=?,created=?")
	// checkErr(err)
	// res,err := stmt.Exec("xijian.chen","研发部","2018-07-22")
	// checkErr(err)
	// id,err := res.LastInsertId()
	// checkErr(err)
	// fmt.Println("LastInsertId:",id)

	//更新数据
	// stmt,err = db.Prepare("UPDATE userinfo SET username=? WHERE uid=?")
	// checkErr(err)
	// res,err = stmt.Exec("xiaochen",1)
	// checkErr(err)
	// affect,err := res.RowsAffected()
	// fmt.Println("affect rows:",affect)

	//查询数据
	// rows,err := db.Query("SELECT * FROM userinfo")
	// checkErr(err)
	// for rows.Next(){
	// 	var uid int 
	// 	var username string
	// 	var department string
	// 	var created string
	// 	err = rows.Scan(&uid,&username,&department,&created)
	// 	checkErr(err)

	// 	fmt.Println(uid,username,department,created)
	// }

	//删除数据
	stmt,err := db.Prepare("DELETE FROM userinfo WHERE uid=?")
	checkErr(err)
	res,err := stmt.Exec(3)
	checkErr(err)
	affect,err := res.RowsAffected()
	fmt.Println(affect)

	db.Close()
}

func checkErr(err error){
	if err != nil{
		panic(err)
	}
}

