<?php

class Styles {

	private $list = [];

	function __construct($view) {

		$this->root();

		//load framework styles
		$files = glob(__ROOT__.'/system/styles/*.css');
		foreach ($files as $file) $this->add($file, 1);

		//load app styles
		$files = glob(__ROOT__.'/app/styles/*.css');
		foreach ($files as $file) $this->add($file, 2);

		//load page styles
		if (file_exists($file = __ROOT__.'/pages/styles/'.$view->name.'.css')) $this->add($file, 4);

		//load styles in the page css folder, if present
		$files = glob(__ROOT__.'/pages/styles/'.$view->name.'/*.css');
		foreach ($files as $file) $this->add($file, 5);
	}

	//make the root
	private function root() {

		$root = "<style type=\"text/css\">".PHP_EOL;
		$root .= "	@import url('https://fonts.googleapis.com/css2?family=".sysData('main-font-url')."&display=swap');".PHP_EOL;
		if (sysData('side_font_url')) $root .= "	@import url('https://fonts.googleapis.com/css2?family=".sysData('side-font-url')."&display=swap');".PHP_EOL;
		$root .= "	@import url('https://fonts.googleapis.com/css2?family=".sysData('text-font-url')."&display=swap');

	:root {
		--c1: ".sysData('c1').";
		--c1-h: ".sysData('c1-hover').";

		--c2: ".sysData('c2').";
		--c2-h: ".sysData('c2-hover').";
		
		--c3: ".sysData('c3').";
		--c3-h: ".sysData('c3-hover').";
		
		--c4: ".sysData('c4').";
		--c4-h: ".sysData('c4-hover').";
		
		--c5: ".sysData('c5').";
		--c5-h: ".sysData('c5-hover').";

		--font-main: '".sysData('main-font-name')."', sans-serif;
		--font-side: '".sysData('side-font-name')."', sans-serif;
		--font-text: '".sysData('text-font-name')."', sans-serif;
	}
</style>".PHP_EOL.PHP_EOL;

		$this->list[] = '0'.$root;
		
	}

	//load a style
	public function add($file, $priority = 3) {

		$file .= '?v='.filemtime($file); 
			
		$this->list[] = $priority.'<link href="'.parse_html($file).'" rel="stylesheet" type="text/css">'.PHP_EOL;

	}

	//make the string of styles
	public function make() {

		$list = [];

		asort($this->list);

		foreach ($this->list as $style) $list[] = substr($style, 1);
		
		return implode('', $list);

	}
}