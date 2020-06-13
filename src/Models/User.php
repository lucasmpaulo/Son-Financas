<?php
declare(strict_types=1);

namespace SONFin\Models;

use Jasny\Auth\User as JasnyUser;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements JasnyUser, UserInterface
{
    // Mass Assignment
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password'
    ];

    public function getId()
    {
        return (int)$this->id;
    }

    public function getUserName()
    {
        return $this->email;
    }

    public function getHashedPassword()
    {
        return $this->password;
    }

    public function onLogin()
    {
        // 
    }

    public function onLogout()
    {
        // 
    }

    public function getFullname()
    {
        return " {$this->first_name} {$this->last_name}";
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
