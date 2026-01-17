<?php

declare(strict_types=1);

class AuthController
{
    public function login(): void
    {
        $email = trim((string)($_POST['email'] ?? ''));
        $message = $email !== ''
            ? sprintf('Willkommen zurück, %s. (Demo-Login)', htmlspecialchars($email, ENT_QUOTES, 'UTF-8'))
            : 'Bitte geben Sie eine gültige E-Mail an.';

        $this->render('login-result', [
            'message' => $message,
        ]);
    }

    public function register(): void
    {
        $company = trim((string)($_POST['company'] ?? ''));
        $contact = trim((string)($_POST['contact_name'] ?? ''));
        $message = ($company !== '' && $contact !== '')
            ? sprintf('Vielen Dank, %s von %s. (Demo-Registrierung)',
                htmlspecialchars($contact, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($company, ENT_QUOTES, 'UTF-8')
            )
            : 'Bitte füllen Sie alle Pflichtfelder aus.';

        $this->render('register-result', [
            'message' => $message,
        ]);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../View/' . $view . '.php';
    }
}
