<?php

declare(strict_types=1);

class UserController
{
    public function profile(): void
    {
        $this->render('profile');
    }

    public function settings(): void
    {
        $this->render('settings');
    }

    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../View/' . $view . '.php';
    }
}
