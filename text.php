<?php

class Text {
  public function __construct($texto) {
      $this->texto = $texto;
  }

  public function __invoke()
  {
    echo $this->texto;
    
  }
}


$objeto = Text::class . '(...["hola", 1,2 , 3])';
eval("(new $objeto)();");
