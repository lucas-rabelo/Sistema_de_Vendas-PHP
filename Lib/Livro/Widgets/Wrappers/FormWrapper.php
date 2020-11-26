<?php
namespace Livro\Widgets\Wrapper;

use Livro\Widgets\Container\Panel;
use Livro\Widgets\Form\Form;
use Livro\Widgets\Form\Button;
use Livro\Widgets\Base\Elements;

class FormWrapper 
{
    private $decorated;

    public function __construct(Form $form)
    {
        $this->decorated = $form;
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array( [$this->decorated, $method], $parameters );
    }

    public function show()
    {
        $element =  new Elements('form');
        $element->class = 'form-horizontal';
        $element->enctype = 'multipart/form-data';
        $element->method = 'post';
        $element->name = $this->decorated->getName();
        $element->width = '100%';

        foreach ($this->decorated->getFields as $field)
        {
            $group = new Elements('div');
            $group->class = 'form-group';

            $label = new Elements('label');
            $label->class = 'col-sm-2 control-label';
            $label->add( $field->getLabel() );

            $col = new Elements('div');
            $col->class = 'col-sm-10';
            $col->add( $field );
            $field->class = 'form-control';

            $group->add($label);
            $group->add($col);
            $element->add($group);
        }

        foreach ( $this->decorated->getActions() as $label => $action )
        {
            $name = strtolower(str_replace(' ', ' ', $label));
            $button = new Button($name);
            $button->class = 'btn btn-default';
            $button->setAction($action, $label);
            $button->setFormName($this->decorated->getName());
        }

        $footer = new Elements('div');
        foreach ( $this->decorated->getActions() as $label => $action )
        {
            $name = strtolower(str_replace(' ', ' ', $label));
            $button = new Button($name);
            $button->class = 'btn btn-default';
            $button->setAction($action, $label);
            $button->setFormName($this->decorated->getName());
            $footer->add($button);
        }

        $panel = new Panel( $this->decorated->getTitle() );
        $panel->add( $element );
        $panel->addFooter( $footer );
        $panel->show();
    }
}