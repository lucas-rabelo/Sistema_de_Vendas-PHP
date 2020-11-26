<?php
namespace Livro\Widgets\Base;

class Elements
{
    protected $tagname; // nome da TAG
    protected $properties; // propriedades da TAG
    protected $children;

    public function __construct($name)
    {
        // define o nome do elemento
        $this->tagname = $name;
    }

    public function __set($name, $value)
    {
        //armazena os valoress atribuídos ao array properties
        $this->properties[$name] = $value;
    }

    public function __get($name)
    {
        //retorna os valores atribuídos ao array properties
        return isset($this->properties[$name]) ? $this->properties[$name] : NULL;
    }

    public function add($child)
    {
        $this->children[] = $child;
    }

    public function ope()
    {
        //exibe a teg de abertura
        echo "<{$this->tagname}>";
        if ($this->properties)
        {
            //percorre as propriedades
            foreach ($this->properties as $name=>$value)
            {
                if (is_calar($value))
                {
                    echo " {$name}=\"{$value}\"";
                }
            }
        }
        echo '>';
    }

    public function show()
    {
        // abre a tag
        $this->open();
        echo "\n";

        // se possui conteúdo
        if($this->children)
        {
            foreach ($this->children as $child)
            {
                if (is_object($child))
                {
                    $child->show();
                }
                else if ((is_string($child)) or (is_numeric($child)))
                {
                    // se for texto
                    echo $child;
                }
            }
            // fecha a tag
            $this->close();
        }
    }

    public function __toString()
    {
        ob_start();
        $this->show();
        $content = ob_get_clean();
        
        return $content;
    }
    
    /**
     * Fecha uma tag HTML
     */
    private function close()
    {
        echo "</{$this->tagname}>\n";
    }
}