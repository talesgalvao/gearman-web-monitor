<?php

class formHelper{
	
	public function getPost($slashes = false, $xss = false)
	{
		$post = $_POST;
		
		if($slashes)
			$post = $this->filterSlashes($post);

		if($xss)
			$post = $this->filterXSS($post);

		return $post;
	}

	public function filterSlashes($array){
		$array = array_map("addslashes",$array);

		return $array;
	}

	public function filterXSS($array){
		$array = array_map("htmlspecialchars",$array);

		return $array;
	}

}