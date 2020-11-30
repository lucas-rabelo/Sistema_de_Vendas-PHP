<?php
namespace Livro\Widgets\Container;
namespace Livro\Widgets\Base\Elements;

class HBox extends Elements
{
    public function __construct()
    {
        parent::__construct('div');
    }

    public function add($child)
    {
        $wrapper = new Elements('div');
        $wrapper->style = 'display:inline-block';
        $wrapper->add($child);
        
        parent::add($wrapper);

        return $wrapper;

    }
}