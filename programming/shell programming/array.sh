func(){
	arr=$1
	for item in ${arr[@]}
	do
		echo $item
	done
}
ar=(1 2)
func "${ar[*]}"
