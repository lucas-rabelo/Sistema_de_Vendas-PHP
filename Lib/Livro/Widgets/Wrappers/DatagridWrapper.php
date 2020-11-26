<?php
namespace Livro\Widgets\Wrapper;

use Livro\Widgets\Container\Panel;
use Livro\Widgets\Datagrid\Datagrid;
use Livro\Widgets\Base\Elements;

class DatagridWrapper
{
    private $decorated;

    public function __construct( Datagrid $datagrid )
    {
        $this->decorated = $datagrid;
    }

    public function __call($method, $parameters)
    {
        call_user_func_array( [$this->decorated, $method], $parameters );
    }

    public function __set($attribute, $value)
    {
        $this->decorated->$attribute = $value;
    }

    public function show()
    {
        $element = new Elements('table');
        $element->class = 'table table-striped table-hover';

        $thead = new Elements('thead');
        $element->add($thead);

        $this->createHeaders( $thead );

        $tbody = new Elements('tbody');
        $element->add($tbody);

        $item = $this->decorated->getItems();
        foreach ($items as $item)
        {
            $this->createItem( $tbody, $item );
        }

        $panel = new Panel;
        $panel->add($element);
        $panel->show();
    }

    public function createHeaders( $thead )
    {
        $row = new Elements('tr');
        $thead->add($row);

        $actions = $this->decorated->getActions();
        $columns = $this->decorated->getColumns();

        if ( $actions )
        {
            foreach( $actions as $action )
            {
                $cell = new Elements('th');
                $cell->width = '40px';
                $row->add($cell);
            }
        }

        if ( $columns )
        {
            foreach( $columns as $column )
            {
                $label = $column->getLabel();
                $align = $column->getAlign();
                $width = $column->getWidth();

                $cell = new Elements('th');
                $cell->add($label);
                $cell->style= "text-align: $align";
                $cell->width = "$width";

                if( $column->getAction() )
                {
                    $url = $column->getAction()->serialize();
                    $cell->onclick = "document.location='$url'";
                }
            }
        }
    }

    public function createItem($tbody, $item)
    {
        $row = new Elements('tr');
        $tbody->add($row);

        $actions = $this->decorated->getActions();
        $columns = $this->decorated->getColumns();

        if ($actions)
        {
            foreach ( $action as $action )
            {
                $url   = $action['action']->serialize();
                $label = $action['label'];
                $image = $action['image'];
                $field = $action['field'];

                $key = $item->$field;

                $link = new Elements('a');
                $link->href = "$url&key={$key}&{$field}={$key}";

                if( $image )
                {
                    $i = new Elements('i');
                    $i->class = $image;
                    $i->title = $label;
                    $i->add('');
                    $link->add($i);
                }
                else
                {
                    $link->add($label);
                }

                $element = new Elements('td');
                $element->add($link);
                $element->align = 'center';
                
                $row->add($element);
            }
        }

        if( $columns )
        {
            foreach( $columns as $column )
            {
                $name     = $column->getName();
                $align    = $column->getAlign();
                $width    = $column->getWidth();
                $function = $column->getTransformer();

                $data = $item->$name;

                if( $function )
                {
                    $data = call_user_func($function, $data);
                }

                $element = new Elements('td');
                $element->add($data);
                $element->align = $align;
                $element->width = $width;

                $row->add($element);
            }
        }
    }
}