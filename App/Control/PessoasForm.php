<?php
use Livro\Control\Page;
use Livro\Widgets\Form\Form;
use Livro\Widgets\Wrapper\FormWrapper;
use Livro\Widgets\Form\Entry;
use Livro\Widgets\Form\Combo;
use Livro\Widgets\Form\CheckGroup;

use Livro\Database\Transaction;
use Livro\Control\Action;
use Livro\Widgets\Dialog\Message;

class PessoasForm extends Page
{
    public function __construct()
    {
        parent::__construct();

        $this->form = new FormWrapper(new Form('form_pessoas'));
        $this->setTitle('Pessoa');

        $codigo   = new Entry('id');
        $nome     = new Entry('nome');
        $endereco = new Entry('endereco');
        $bairro   = new Entry('bairro');
        $telefone = new Entry('telefone');
        $email    = new Entry('email');
        $cidade   = new Combo('id_cidade');
        $grupo    = new CheckGroup('ids_grupos');

        $grupo->setLayout('horizontal');

        Transaction::open('livro');
        $cidades = Cidade::all();
        $items = [];
        foreach ($cidades as $obj_cidade)
        {
            $item[ $obj_cidade->id ] = $obj_cidade->nome;
        }
        $cidade->addItems($itens);

        $grupos = Grupo::all();
        $items = [];
        foreach ($grupos as $obj_grupo)
        {
            $item[ $obj_grupo->id ] = $$obj_grupo->nome;
        }
        $grupo->addItems($itens);

        Transaction::close();

        $this->form->addField('Código',   $codigo,   '30%');
        $this->form->addField('Nome',     $nome,     '70%');
        $this->form->addField('Endereço', $endereco, '70%');
        $this->form->addField('Bairro',   $bairro,   '70%');
        $this->form->addField('Email',    $email,    '70%');
        $this->form->addField('Telefone', $telefone, '70%');
        $this->form->addField('Cidade',   $cidade,   '70%');
        $this->form->addField('Grupo',    $grupo,    '70%');

        $codigo->setEditable(FALSE);

        $this->form->addAction('Salvar', new Action([$this, 'onSave']));

        parent::add($this->form);
    }

    public function onSave()
    {

    }

    public function onEdit($param)
    {
        try
        {
            if(!empty($param['id']))
            {
                Transaction::open('livro');

                $pessoa = Pessoa::find( $param['id'] );
                $this->form->setData($pessoa);

                Transction::close();
            }
        }
        catch (Exception $e)
        {
            new Message('error', $e->getMessage());
            Transaction::rolback();
        }
    }
}