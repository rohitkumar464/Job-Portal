<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\EmailFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
      private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }






    /**
     * @Route("/", name="app_login")
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
    public function logout(): void
    { 
        
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

     /**
     * @Route("/success", name="success")
     */
    public function signin(): Response
    {
        return $this->render('security/signin.html.twig', [
            'controller_name' => 'Login Successful',
        ]);
    }

     /**
     * @Route("/register", name="register")
     */
    public function register(): Response
    { 
       //dd("hii");
        return $this->render('security/signup.html.twig', [
            'controller_name' => 'Login Successful',
        ]);
    }
    /**
     * @Route("/getregister", name="get_register")
     */
    public function signup(Request $request)
    { 
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $repository=$this->getDoctrine()->getRepository(User::class);
        $users=$repository->findBy(['email' => $email]);
        
        if ($users) {
            return new Response('Email already exist please login.');
        }
        //dd($users);
        $entityManager = $this->getDoctrine()->getManager();
        
        $user = new User();
  
         $user->setEmail($email);
         //$user->setPassword($password);
         
         $user->setPassword($this->passwordEncoder->encodePassword($user,$password));
         dd($user);
         $entityManager->persist($user);
         $entityManager->flush();
     



        return $this->redirectToRoute('app_login');
    }
}
