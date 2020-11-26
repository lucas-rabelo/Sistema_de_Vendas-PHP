<?php
abstract class Logger {
    protected $filename;

    public function __construct($filename){
        $this->finename = $filename;
        file_put_contents($filename, '');
    }
    abstract function write ($message);
}