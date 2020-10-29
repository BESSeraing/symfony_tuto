<?php


namespace App\Listeners\Doctrine;


use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class UserCreationListener
{

    private MailerInterface $mailer;

    private UrlGeneratorInterface $urlGenerator;

    /**
     * UserCreationListener constructor.
     * @param $mailer
     */
    public function __construct(MailerInterface $mailer, UrlGeneratorInterface $urlGenerator)
    {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param User $user
     * @ORM\PostPersist()
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function validateEmail(User $user) {
        $email = (new TemplatedEmail())
            ->from('student@bes-webdeveloper-seraing.be')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Activate your account')
            ->text('please follow this link ' . $this->urlGenerator->generate('activate_account', ['key' => $user->getTempSecretKey()]))
            ->htmlTemplate('emails/activate-account.html.twig')
            ->context([
                'user' => $user
            ])
        ;

        $this->mailer->send($email);
    }

}
