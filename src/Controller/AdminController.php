<?php
namespace App\BackendBundle\Repository;
namespace App\Controller;
use App\Entity\Admin;
use App\Entity\Postjob;
use App\Entity\Signup;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\SignupRepository;
use App\Repository\PostjobRepository;
use Knp\Component\Pager\PaginatorInterface;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
        }
        else{
            return $this->redirectToRoute('app_login');
        }

    }








     /**
     * @Route("/deleteusers", name="delete_users")
     */
    public function deleteusers(EntityManagerInterface $entityManager,request $request,SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        $deleteMessages = $request->get('checked_id');
        //dd($deleteMessages);
        foreach ($deleteMessages as $value) {
           // echo $value;  position : relative ;
            $post = $entityManager->getRepository(Signup::class)->find($value);
           // dd($post);
            $entityManager->remove($post);
            $entityManager->flush();
      
          }
       
        
        return $this->redirectToRoute('admin_login');
        }
        else{
            return $this->redirectToRoute('app_login');
        }
    }


          /**
     * @Route("/checklogin", name="check_login")
     */
   public function admin(request $request,SessionInterface $session): Response
   {
    $val = $session->get('key');
    if($val){
    $user_login = new Admin();
    $email = $request->request->get('email');
    $password = $request->request->get('password');
    $repository=$this->getDoctrine()->getRepository(Admin::class);
    $users=$repository->findOneBy(['email' => $email,'password'=>$password]);

   // dd($users);
    if($users){
        return  $this->redirectToRoute('admin_login');
    }
    else{
        return new Response('please enter valid email or password');
    }
    }
    else{
        return $this->redirectToRoute('app_login');
    }

  
        //return new Response('Saved new product with id '.$user_login->getId());
    }

      /**
     * @Route("/adminlogin", name="admin_login")
     */
    public function adminlogin(SignupRepository $signupRepository,PaginatorInterface $paginator,request $request,SessionInterface $session): Response
     {
       
       
        $val = $session->get('admin_key');
         if($val){
      
        $allAppointmentsQuery =  $signupRepository->findusers();
     
            $appointments = $paginator->paginate(
               
                $allAppointmentsQuery,
             
                $request->query->getInt('page', 1),
             
                2
            );
       
              return $this->render('admin/superadmin.html.twig', [
             'appointments' => $appointments,
          
        ]);
    }
    else{
        return $this->redirectToRoute('app_login');
    }
   
       
    }

      /** 
     * @Route("/adminsignup", name="admin_signup")
     */
    public function adminsignup(request $request,SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        $fullname = $request->request->get('fullname');
        $username = $request->request->get('uname');
        $email = $request->request->get('uemail');
        $password = $request->request->get('password');
        $confirm_password = $request->request->get('confirm-password');
       


        $entityManager = $this->getDoctrine()->getManager();

        $admin = new Admin();


        $admin->setFullname($fullname);
        $admin->setUsername($username);
        $admin->setEmail($email);
        $admin->setPassword($password);
        $admin->setConfirmpassword($confirm_password);

        $entityManager->persist($admin);

        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
        }
        else{
            return $this->redirectToRoute('app_login');
        }

        // return $this->render('admin/adminsignup.html.twig', [
        //     'controller_name' => 'AdminController',
        // ]);
    }

      /**
     * @Route("/adminregister", name="admin_register")
     */
    public function adminregister(SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        return $this->render('admin/adminsignup.html.twig', [
            'controller_name' => 'AdminController',
        ]);
        }
        else{
            return $this->redirectToRoute('app_login');
        }

    }


      /**
     * @Route("/showuserpost{id}", name="show_userpost")
     */
    public function showuserpost(PostjobRepository $postjobRepository,EntityManagerInterface $entityManager,int $id,request $request,SessionInterface $session,PaginatorInterface $paginator): Response
    {
         //dd($id);
         $val = $session->get('admin_key');
         if($val){
        $admin = $request->request->get('activelink');
      //dd($admin);
      if($admin=="activelink"){
        return $this->redirectToRoute('admin_login');
      }
      else{
    
        //$appointmentsRepository = $this->getDoctrine()->getRepository(Postjob::class);
        $allAppointmentsQuery = $postjobRepository->createQueryBuilder('p')
        ->where("p.user_id = $id")
        ->getQuery();
        //dd($allAppointmentsQuery);
        $appointments = $paginator->paginate(
            // Doctrine Query, not results
            $allAppointmentsQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            2
        );
        //dd($appointments);
        return $this->render('postjob/allpost.html.twig', [
            'appointments' => $appointments,
           //  'images' => $images,
         
       ]);
            
        // return $this->redirectToRoute('all_user_postjob');
      }
    }
    else{
        return $this->redirectToRoute('app_login');
    }
    }

       /**
     * @Route("/alluserpostjob", name="all_user_postjob")
     */
    public function allpost(PostjobRepository $postjobRepository,PaginatorInterface $paginator,Request $request,SessionInterface $session,EntityManagerInterface $entityManager):Response
    {
        $val = $session->get('key');
       
        //dd($val);
        if($val){
        //$em = $this->getDoctrine()->getManager();
        
        //dd($val);
        // $repository=$this->getDoctrine()->getRepository(Postjob::class);
        // $appointmentsRepository=$repository->findBy(['user_id' => $val]);

        // dd( $appointmentsRepository);

        // $post = $entityManager->getRepository(Postjob::class)->find($val);
        // dd($post);
        $appointmentsRepository = $this->getDoctrine()->getRepository(Postjob::class);
   
        $allAppointmentsQuery =$postjobRepository->createQueryBuilder('p')
            ->where("p.user_id = $val")
            ->getQuery();
        
            $appointments = $paginator->paginate(
                // Doctrine Query, not results
                $allAppointmentsQuery,
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                2
            );
            
            // $images = array();
            //  foreach ($appointments as $key => $entity) {
            //   $images[$key] = base64_encode(stream_get_contents($entity->getImage()));
            // }
          //dd($appointments);
              return $this->render('postjob/allpost.html.twig', [
             'appointments' => $appointments,
            //  'images' => $images,
          
        ]);
        // $currentPage = $request->query->getInt('page', 1);
        //  $limit = 2; // Number of items per page
        // //dd($currentPage);
        // //dd($limit);
        // $paginator = $repository->findPaginated($currentPage, $limit);
      // dd($paginator);

        // $repository=$this->getDoctrine()->getRepository(Postjob::class);
        // $users=$repository->findAll();
  

        // return $this->render('postjob/allpost.html.twig', [
        //     // 'users' => $users,
        //     'paginator' => $paginator,
        //             'currentPage' => $currentPage,
        //             'limit' => $limit,
          
        // ]);
        
    }
    else{
        return $this->redirectToRoute('app_login');
    }
}


}
