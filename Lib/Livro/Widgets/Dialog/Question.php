<?php
namespace Livro\Widgets\Dialog;

use Livro\Control\Action;
use Livro\Widgets\Base\Elements;

class Question
{
    public function __construct($message, Action $action_yes, Action $action_no = NULL)
    {
        $div = new Elements('div');
        $div->class = 'alert alert-warning question';
        
        // converte os nomes de métodos em URL's
        $url_yes = $action_yes->serialize();

        $links_yes = new Elements('a');
        $links_yes->href = $url_yes;
        $links_yes->class = 'btn btn-default';
        $link_yes->style = 'float:right';
        $link_yes->add('Sim');

        $message .= '&nbsp' . $link_yes;
        if( $action_no )
        {
            $url_no = $action_no->serialize();

            $links_no = new Elements('a');
            $links_no->href = $url_no;
            $links_no->class = 'btn btn-default';
            $link_no->style = 'float:right';
            $link_no->add('Não');

            $message .= $link_no;
        }
        
    }
}