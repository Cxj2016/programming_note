<?php 
	class Node{
		private $id;
		public $next;
		public function __construct($id = 0){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}
	}

	class NodeList{
		public $header = null;
		public function create(){
			$this->header = new Node();
			$next = $this->header;
			for($i = 1; $i <= 10; $i++){
				$node = new Node($i);
				$next->next = $node;
				$next = $node;
			}
		}

		public function show(){
			$next = $this->header->next;
			while(null != $next){
				echo "值为: " . (string)$next->getId(), PHP_EOL;
				$next = $next->next;
			}
		}

		// public 
	}

	$nodeList = new NodeList();
	$nodeList->create();
	$nodeList->show();
?>