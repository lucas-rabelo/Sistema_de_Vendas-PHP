<?php
namespace Livro\Widgets\Container;
use Livro\Widgets\Base\Elements;

class Panel extends Elements
{
    private $body;
    private $footer;

    public function __construct($panel_title = null)
    {
        parent::__contruct('div');
        $this->class = 'panel panel-default';

        if($panel_title)
        {
            $head = new Elements('div');
            $head->class = 'panel-heading';

            $title = new Elements('div');
            $title->class = 'panel-title';

            $label = new Elements('h4');
            $label->add( $panel_title );

            $head->add($title);
            $title->add($label);

            parent::add($head);
        }

        $this->body   = new Elements('div');
        $this->body->class = 'panel-body';
        parent::add($this->body);

        $this->footer = new Elements('div');
        $this->footer->class = 'panel-footer';
        
    }

    public function add($content)
    {
        $this->body->add($content);
    }

    public function addFooter($footer)
    {
        $this->footer->add($footer);
        parent::add($this->footer);
    }
}