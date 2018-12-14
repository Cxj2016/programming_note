package main 

import "fmt"

const (
	WHITE = iota
	BLACK
	BLUE
	RED
	YELLOW
)

type Color byte
type Box struct{
	width,height,depth float64
	color Color
}
type BoxList []Box //传地址

func (b Box) Volume() float64{
	return b.width * b.height * b.depth
}

func (b *Box) setColor(c Color){
	b.color = c
}

func (bl BoxList) BiggestsColor() Color{
	v := 0.0
	k := Color(WHITE) //这个是什么声明方式
	for _,b := range bl{
		if b.Volume() > v {
			v = b.Volume()
			k = b.color
		}
	}
	return k
}

func (bl BoxList) PaintItBlack(){
	for i,_ := range bl{
		bl[i].setColor(BLACK)
	}
}

func (c Color) String() string{
	strings := []string{"WHITE","BLACK","BLUE","RED","YELLOW"}
	return strings[c]
}

func main() {
	boxes := BoxList{
		Box{4,4,4,RED},
		Box{10,10,1,YELLOW},
		Box{1,1,20,BLACK},
		Box{10,10,1,BLUE},
		Box{10,30,1,WHITE},
		Box{20,20,20,YELLOW},
	}

	fmt.Printf("%d boxes",len(boxes))
	fmt.Println("the volume of the first one is:",boxes[0].Volume(),"立方米")
	fmt.Println("last one color:",boxes[len(boxes) - 1].color.String())
	fmt.Println("biggest one:",boxes.BiggestsColor().String())

	boxes.PaintItBlack()
	fmt.Println("second one color:",boxes[1].color.String())
	fmt.Println("biggest one is:",boxes.BiggestsColor().String())
}





















