<?php

namespace iutnc\deefy\action;

abstract class Action
{
    protected string $http_method;
    protected string $host;
    protected string $script_name;

    public function __construct()
    {
        $this->http_method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->host        = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $this->script_name = $_SERVER['SCRIPT_NAME'] ?? '';
    }

    abstract public function execute(): string;
}
