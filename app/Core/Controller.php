<?php

namespace App\Core;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        view($template, $data);
    }

    protected function redirect(string $path): never
    {
        redirect($path);
    }
}
