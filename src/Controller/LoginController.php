<?php

namespace App\Controller;
use App\Repository\SignupRepository;
use App\Entity\Signup;
use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\ProductCreateEvent;
use App\EventSubscriber\ProductEventSubscriber;

class LoginController extends AbstractController
{


    public $eventDispatcher;
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }


    /**
     * @Route("/login", name="app_login1")
     */
    public function index(): Response
    { 
        
        //dd($val);
        //$session->invalidate();
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
    /**
     * @Route("/logout1", name="logout1")
     */
    public function logout(SessionInterface $session): Response
    { 
        $val = $session->get('key');
        $session->invalidate();
        //dd($val);
       
        
        return $this->redirectToRoute('app_login1');
    }

    /**
     * @Route("/adminlogout", name="admin_logout")
     */
    public function adminlogout(SessionInterface $session): Response
    { 
        $val = $session->get('admin_key');
        $session->invalidate();
        //dd($val);
       
        
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/getlogin", name="get_login")
     */
   public function show(request $request,SessionInterface $session): Response
   {
    $email = $request->request->get('email');
    $password = $request->request->get('password');
    $admin = $request->request->get('admin');
   
    
        //$session->invalidate();
    if($admin=="admin"){
    $repository=$this->getDoctrine()->getRepository(Admin::class);
    $users=$repository->findOneBy(['email' => $email,'password'=>$password]);
        if($users){
            $id=$users->getId();
            //dd($id);
            $session->set('admin_key', $id);
           
            return  $this->redirectToRoute('admin_login');
        }
        else{
            return new Response('please enter valid email or password');
        }
    }else{    
   
            //if($admin=="admin")

                $user_login = new Signup();
                $email = $request->request->get('email');
                $password = $request->request->get('password');
                $repository=$this->getDoctrine()->getRepository(Signup::class);
                $users=$repository->findOneBy(['email' => $email,'password'=>$password]);
                

            //dd($users);
                if($users){
                    //dd($users);
                    $id=$users->getId();
                    //dd($id);
                    $session->set('key', $id);
                    // $event = new ProductCreateEvent();
                    // $this->eventDispatcher->addSubscriber(new ProductEventSubscriber());
                    // $this->eventDispatcher->dispatch($event, ProductCreateEvent::NAME);
                    
                    //dd($val);
                    //  return $this->redirectToRoute('company');
                    return $this->redirectToRoute('user_profile',['id'=>$id]);
                    // return $this->render('profile/index.html.twig', array(
                    //     'users' => $users
                    // ));
                }
                else{
                    return new Response('please enter valid email or password');
                }
    }
        //return new Response('Saved new product with id '.$user_login->getId());
    }
    
    /**
     * @Route("/userprofile{id}", name="user_profile")
     */
    public function userprofile(SessionInterface $session,int $id): Response
    { 
        //$val = $session->get('admin_key');
        //$session->invalidate();
        //dd($val);
        $val = $session->get('key');
        
        if($val){
        //dd($id);
        $repository=$this->getDoctrine()->getRepository(Signup::class);
        $users=$repository->findOneBy(['id' => $id]);
      // dd($users);
      // dd($val);
        return $this->render('profile/index.html.twig', array(
                        'users' => $users
                    ));
    }
    
    else{
        return $this->redirectToRoute('app_login1'); 
    }
}

}
