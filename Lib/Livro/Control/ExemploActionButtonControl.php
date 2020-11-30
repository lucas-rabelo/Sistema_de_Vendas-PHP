<?php
use Livro\Control\Page;
use Livro\Control\Action;
use Livro\Widgets\Base\Elements;

class ExemploActionButtonControl extends Page
{
    public function __construct()
    {
        parent::__construct();

        $button = new Elements('a');
        $button->add('Ação');
        $buttun->class = 'btn btn-success';

        $action = new Action( [$this, 'executaAcao'] );
        $action->setParameter('codigo', 4);

        $button->href = $action->serialize();

        parent::add($button);
    }

    public function executeAcao($param)
    {
        echo '<pre>';
        var_dump($param);
        echo '</pre>';
    }
}