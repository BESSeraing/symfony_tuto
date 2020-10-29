<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="register")
     * @throws \Exception
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder) {
        $user = new User();
        $user->setRoles(['ROLE_USER'])
            ->setActive(false)
            ->setSecretKeyDate(new \DateTime())
            ->setTempSecretKey(bin2hex(random_bytes(10)))
        ;

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordEncoder->encodePassword($user, $user->getPlainPassword()))
                ->eraseCredentials()
            ;

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('security/register.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @param User $user
     * @Route("/activate/{key}", name="activate_account")
     */
    public function activateAccount(string $key, UserRepository $repository, EntityManagerInterface $entityManager, GuardAuthenticatorHandler $guardAuthenticatorHandler, Request $request, AppCustomAuthenticator $authenticator) {
        /**
         * @var User $user
         */
        $user = $repository->findOneBy(['tempSecretKey' => $key]);

        if ($user !== null) {
            $user->setActive(true)
                ->setTempSecretKey(null)
                ->setSecretKeyDate(null);

            $entityManager->flush();

        }

        return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
        );



    }
}
