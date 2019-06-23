<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Form\UserSigninType;
use App\Form\UserLoginType;
use App\Entity\User;

class SecurityController extends Controller
{
    /**
     * @Route("/signin", name="signin")
     */
    public function signinAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        // Building form
        $user = new User();
        $form = $this->createForm(UserSigninType::class, $user);

        // Handle POST submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode password
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setIsActive(true);
            // $user->addRole("ROLE_ADMIN");

            // Save user
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $this->addFlash('success', 'Votre compte à bien été enregistré.');
            //return $this->redirectToRoute('login');
        }
        return $this->render('security/signin.html.twig', ['form' => $form->createView(), 'mainNavRegistration' => true, 'title' => 'Inscription']);
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User();
        $form = $this->createForm(UserLoginType::class, $user);
        


        return $this->render('security/login.html.twig', [
                    'mainNavLogin' => true, 
                    'title' => 'Connexion',
                    'form' => $form->createView(),
                    'last_username' => $lastUsername,
                    'error' => $error,
        ]);
        return $this->render('login.html.twig');
    }
}