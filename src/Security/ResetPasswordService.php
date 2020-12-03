<?php


namespace App\Security;


use App\Entity\User;
use App\Flash\FlashType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordService
{

    private UserRepository $userRepository;
    private EntityManagerInterface $em;
    private SessionInterface $session;
    private UserPasswordEncoderInterface $userPasswordEncoder;
    private UrlGeneratorInterface $urlGenerator;
    private MailerInterface $mailer;

    /**
     * ResetPasswordService constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param UrlGeneratorInterface $urlGenerator
     * @param MailerInterface $mailer
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, SessionInterface $session, UserPasswordEncoderInterface $userPasswordEncoder, UrlGeneratorInterface $urlGenerator, MailerInterface $mailer)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->session = $session;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->urlGenerator = $urlGenerator;
        $this->mailer = $mailer;
    }


    public function isResetValid(User $user) {
        // 2 heures pour resetter son email
        return $user->getSecretKeyDate()->diff(new \DateTime())->h < 2;
    }


    public function startResetPasswordByEmail(string $email) {
        $user = $this->userRepository->findOneBy(["email" => $email]);
        if ($user !== null) {
            $this->startResetPassword($user);
        }
    }

    public function startResetPassword(User $user) {
        $user ->setTempSecretKey(self::generateRandomToken())
            ->setSecretKeyDate(new \DateTime());

        $this->em->persist($user);
        $this->em->flush();

        $this->sendEmail($user);
    }

    public function savePassword(User $user)
    {
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword()))
            ->setSecretKeyDate(null)
            ->setTempSecretKey(null)
            ->eraseCredentials()
        ;
        $this->em->persist($user);
        $this->em->flush();
        $this->session->getFlashBag()->add(FlashType::SUCCESS, "Your password has been updated");

    }

    /**
     * @param User $user
     * @ORM\PostPersist()
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    private function sendEmail(User $user) {
        $email = (new TemplatedEmail())
            ->from('student@bes-webdeveloper-seraing.be')
            ->to($user->getEmail())
            ->subject('You asked to reset your password')
            ->text('please follow this link to reset your password' . $this->urlGenerator->generate('resetPasswordToken', ['token' => $user->getTempSecretKey()]))
            ->htmlTemplate('emails/reset-password.html.twig')
            ->context([
                'user' => $user
            ])
        ;

        $this->mailer->send($email);
    }


    private static function generateRandomToken() {
        return bin2hex(random_bytes(26));
    }

}
