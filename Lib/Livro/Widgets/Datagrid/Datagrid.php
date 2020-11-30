<?php
namespace Livro\Widgets\Datagrid;

use Livro\Control\Actioninterface;

class Datagrid
{
    private $columns;
    private $actions;
    private $items;

    public function __construct()
    {
        $this->columns = [];
        $this->actions = [];
        $this->items = [];
    }

    public function addColumn( DatagridColumn $object )
    {
        $this->columns[] = $object;
    }

    public function addActions( $label, Actioninterface $action, $field, $image = null )
    {
        $this->actions[] = ['label' => $label,
                            'action' => $action,
                            'field' => $field,
                            'image' => $image];
    }

    public function addItem( $object )
    {
        $this->items[] = $object;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function clear()
    {
        $this->items = [];
    }
}