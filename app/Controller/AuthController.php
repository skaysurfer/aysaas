<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/UserModel.php';

class AuthController
{
    private UserModel $userModel;

    public function __construct(?UserModel $userModel = null)
    {
        $this->userModel = $userModel ?? new UserModel();
    }

    public function login(): void
    {
        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');

        $user = $email !== '' ? $this->userModel->findByEmail($email) : null;

        if ($user === null || !password_verify($password, (string) $user['password_hash'])) {
            $this->render('login-result', [
                'message' => 'Login fehlgeschlagen. Bitte prüfen Sie Ihre Zugangsdaten.',
            ]);
            return;
        }

        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'tenant_id' => (int) $user['tenant_id'],
            'display_name' => (string) $user['display_name'],
            'role' => (string) $user['role_name'],
        ];

        header('Location: /dashboard');
        exit;
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

    public function logout(): void
    {
        unset($_SESSION['user']);
        header('Location: /');
        exit;
    }

    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../View/' . $view . '.php';
    }
}
