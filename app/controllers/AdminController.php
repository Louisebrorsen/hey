<?php

class AdminController
{
    public function index(): array
    {
        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => []
        ];
    }
}