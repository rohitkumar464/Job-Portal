<?php

namespace App\Controller;

use App\Entity\Signup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SignupController extends AbstractController
{
    /**
     * @Route("/signup", name="app_signup")
     */
    public function index(SessionInterface $session): Response
    {
        //$val = $session->get('key');
        //if($val){
        return $this->render('signup/index.html.twig', [
            'controller_name' => 'SignupController',
        ]);
       }
       //else{
       //    return $this->redirectToRoute('app_login');
       //}
    //}
    /**
     * @Route("/show", name="show")
     */
    public function show(request $request,SessionInterface $session): Response
    {       
        //$val = $session->get('key');
        //if($val){
        $fullname = $request->request->get('fullname');
        $username = $request->request->get('uname');
        $email = $request->request->get('uemail');
        $country = $request->request->get('country');
        $state = $request->request->get('state');
        $city = $request->request->get('city');
        $gender = $request->request->get('gender');
        $phone = $request->request->get('phone');
        $password = $request->request->get('password');
        $confirm_password = $request->request->get('confirm-password');
        $image = $request->files->get('image');

        $entityManager = $this->getDoctrine()->getManager();

        $user_signup = new Signup();




        $fileName = $this->generateUniqueFileName().'.'.$image->guessExtension();
        $image->move(
            $this->getParameter('image'),
            $fileName
        );
        $user_signup->setImage($fileName);



    
       
        // $file = $request->request->get('image');
        // // $file = $user_signup->getImage(); 
        // $fileName = md5(uniqid()).'.'.$file->guessExtension();
        // $file->move($this->getParameter('photos_directory'), $fileName);
        // $user_signup->setImage($fileName); 

        $user_signup->setFullname($fullname);
        $user_signup->setUsername($username);
        $user_signup->setEmail($email);
        $user_signup->setCountry($country);
        $user_signup->setState($state);
        $user_signup->setCity($city);
        $user_signup->setGender($gender);
        $user_signup->setContact($phone);
        //$user_signup->setImage($image);
        $user_signup->setPassword($password);
        $user_signup->setConfirmpassword($confirm_password);
     
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user_signup);
        //$id=$user_signup->getId();
       // echo $id;
        // actually executes the queries (i.e. the INSERT query)
       $entityManager->flush();
       return $this->redirectToRoute('app_login1');
    }
    //else{
     //   return $this->redirectToRoute('app_login');
    //}
       // return new Response('Saved new product with id '.$user_signup->getId().$user_signup->getEmail());
    //}
    
      /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
