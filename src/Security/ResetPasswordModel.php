<?php


namespace App\Security;


use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordModel
{

    /**
     * @var string
     * @Assert\Email(checkMX=true)
     */
    private string $email;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }



}
