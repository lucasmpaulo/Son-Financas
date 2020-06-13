<?php

namespace SONFin\Auth;

use SONFin\Auth\JasnyAuth;

class Auth implements AuthInterface
{
    private $jasnyAuth;

    public function __construct(JasnyAuth $jasnyAuth)
    {
        $this->jasnyAuth = $jasnyAuth;
        $this->sessionStart();
    }

    public function login(array $credentials)
    {
        list('email' => $email, 'password' => $password) = $credentials;
        return $this->jasnyAuth->login($email, $password) !== null;
    }

    public function check()
    {
        // Verificar se usuário existe
        return $this->user()!== null;
    }

    public function logout()
    {
        $this->jasnyAuth->logout();
    }

    public function user()
    {
        return $this->jasnyAuth->user();
    }

    public function hashPassword(string $password)
    {
        return $this->jasnyAuth->hashPassword($password);
    }

    protected function sessionStart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

}
