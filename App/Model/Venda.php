<?php
use Livro\Database\Transaction;
use Livro\Database\Record;
use Livro\Database\Criteria;
use Livro\Database\Repository;

class Venda extends Record
{
    const TABLENAME = 'venda';
    private $items, $cliente;

    public function set_cliente(Pessoa $c)
    {
        $this->cliente = $c;
        $this->id_cliente = $c->id;
    }

    public function get_cliente()
    {
        if(empty($this->cliente))
        {
            $this->cliente = new Pessoa($this->id_cliente);
        }
        return $this->cliente;
    }

    public function addItem(Produto $p, $quantidade)
    {
        $item = new ItemVenda;
        $item->produto = $p;
        $item->preco = $p->preco_venda;
        $item->quantidade = $quantidade;

        $this->itens[] = $item;
        $this->valor_venda += ($item->preco * $quantidade);
    }

    public function store()
    {
        parent::store();
        foreach($this->itens as $item)
        {
            $item->id_venda = $this->id;
            $item->store();
        }
    }

    public function get_itens()
    {
        $repository = new Repository('ItemVenda');

        $criterio = new Criteria;
        $criterio->add('id_venda', '=', $this->id);

        $this->itens = $repository->load($criterio);
        return $this->itens;
    }

    public static function getVendaMes()
    {
        $meses = array();
        $meses[1]  = 'Janeiro';
        $meses[2]  = 'Fevereiro';
        $meses[3]  = 'Março';
        $meses[4]  = 'Abril';
        $meses[5]  = 'Maio';
        $meses[6]  = 'Junho';
        $meses[7]  = 'Julho';
        $meses[8]  = 'Agosto';
        $meses[9]  = 'Setembro';
        $meses[10] = 'Outubro';
        $meses[11] = 'Novembro';
        $meses[12] = 'Dezembro';

        $conn = Transaction::get();
        $result = $conn->query("select strftime('%m', data_venda) as mes, sum(valor_final) as valor from venda group by 1");

        $dataset = [];
        foreach($result as $row)
        {
            $mes = $meses[ (int) $row['mes'] ];
            $dataset[$mes] = $row[ 'valor' ];
        }

        return $dataset;
    }

    public static function getvendasTipo()
    {
        $conn = Transaction::get();
        $result = $conn->query(" SELECT tipo.nome as tipo, sum(item_venda.quantidade*item_venda.preco) as total FROM venda, item_venda, produto, tipo WHERE venda.id = item_venda;id_venda and item_venda.id_produto = produto.id and produto.id_tipo = tipo.id group by 1");

        $dataset = [];
        foreach($result as $row)
        {
           $dataset[ $row['tipo'] ] = $row['total'];
        }
        return $dataset;
    }
}