<?php
namespace App\BackendBundle\Repository;
namespace App\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use App\Entity\Postjob;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\PostjobRepository;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

// Include paginator interface
use Knp\Component\Pager\PaginatorInterface;

class PostjobController extends AbstractController
{
    /**
     * @Route("/postjob", name="app_postjob")
     */
    public function index(SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        return $this->render('postjob/index.html.twig', [
            'controller_name' => 'PostjobController',
        ]);
        }
        else{
            return $this->redirectToRoute('app_login');
        }

    }

    // /**
    //  * @Route("/allpostjob", name="all_postjob")
    //  */
    // public function in(PostjobRepository $repository, Request $request): Response
    // {
    //     $currentPage = $request->query->getInt('page', 1);
    //     $limit = 3; // Number of items per page
    //     // dd($currentPage);
    //     // dd($limit);
    //     $paginator = $repository->findPaginated($currentPage, $limit);
    //     //dd($paginator);
    //     return $this->render('postjob/allpost.html.twig', [
    //         'paginator' => $paginator,
    //         'currentPage' => $currentPage,
    //         'limit' => $limit,
    //     ]);
    // }

    /**
     * @Route("/allpostjob", name="all_postjob")
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
        $answers = $postjobRepository->findMostPopular(
            $request->query->get('q')
        );
       //dd($answers);
       // $appointmentsRepository = $this->getDoctrine()->getRepository(Postjob::class);
        //dd( $appointmentsRepository);
        $allAppointmentsQuery =  $postjobRepository->findpostjob($val);
        // $allAppointmentsQuery = $appointmentsRepository->createQueryBuilder('p')
        //     ->where("p.user_id = $val")
        //     ->getQuery();
         // dd($allAppointmentsQuery);
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
             'answers' => $answers
          
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

/**
     * @Route("/allpostjobs{id}", name="all_postjobs")
     */
    public function allpostjob(int $id,PostjobRepository $postjobRepository,PaginatorInterface $paginator,Request $request,SessionInterface $session,EntityManagerInterface $entityManager):Response
    {
       
       
        //dd($val);
      
        //$em = $this->getDoctrine()->getManager();
        
        //dd($val);
        $repository=$this->getDoctrine()->getRepository(Postjob::class);
        $allAppointmentsQuery=$repository->findBy(['user_id' => $id]);

        // dd( $allAppointmentsQuery);

        // $post = $entityManager->getRepository(Postjob::class)->find($val);
        // dd($post);
        // $answers = $postjobRepository->findMostPopular(
        //     $request->query->get('q')
        // );
       //dd($answers);
       // $appointmentsRepository = $this->getDoctrine()->getRepository(Postjob::class);
        //dd( $appointmentsRepository);
        // $allAppointmentsQuery =  $postjobRepository->findpostjob($val);
        // $allAppointmentsQuery = $appointmentsRepository->createQueryBuilder('p')
        //     ->where("p.user_id = $val")
        //     ->getQuery();
         // dd($allAppointmentsQuery);
            $appointments = $paginator->paginate(
                // Doctrine Query, not results
                $allAppointmentsQuery,
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                2
            );
            
           
              return $this->render('postjob/allpost.html.twig', [
             'appointments' => $appointments,
            
          
        ]);
      
   
    
}


     /**
     * @Route("/editpostjob{id}", name="edit_postjob")
     */
    public function editpostjob(int $id,SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        $repository=$this->getDoctrine()->getRepository(Postjob::class);
        $users=$repository->findOneBy(['id' => $id]);


        return $this->render('postjob/editpostjob.html.twig', [
            'users' => $users,
        ]);
        }
        else{
            return $this->redirectToRoute('app_login'); 
        }
    }

     /**
     * @Route("/deleteposts", name="delete_posts")
     */
    public function deletepostsjobs(EntityManagerInterface $entityManager,request $request,SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        $deleteMessages = $request->get('checked_id');
        //dd($deleteMessages);
        foreach ($deleteMessages as $value) {
           // echo $value;
            $post = $entityManager->getRepository(Postjob::class)->find($value);
           // dd($post);
            $entityManager->remove($post);
            $entityManager->flush();
      
          }
       
        
        return $this->redirectToRoute('all_postjob');
        }
        else{
            return $this->redirectToRoute('app_login'); 
        }
    }


     /**
     * @Route("/deletepost{id}", name="delete_postjob")
     */
    public function deletepostjob(EntityManagerInterface $entityManager,int $id,SessionInterface $session): Response
    {
        // $repository=$this->getDoctrine()->getRepository(Postjob::class);
        // $users=$repository->findOneBy(['id' => $id]);
        $val = $session->get('key');
        if($val){
        $post = $entityManager->getRepository(Postjob::class)->find($id);
        if (!$post) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('all_postjob');
    }
    else{
        return $this->redirectToRoute('app_login'); 
    }

        // return $this->render('postjob/editpostjob.html.twig', [
        //     'users' => $users,
        // ]);
    }


    





     /**
     * @Route("/updatepostjob{id}", name="update_postjob")
     */
    public function updatepostjob(EntityManagerInterface $entityManager, int $id,request $request,SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){

        $fullname = $request->request->get('fullname');
        $email = $request->request->get('email');
        $location = $request->request->get('location');
        $jobtitle = $request->request->get('jobtitle');
        $myfile = $request->files->get('myfile');
       // dd($myfile);
        $post = $entityManager->getRepository(Postjob::class)->find($id);
        if (!$post) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        //dd($myfile);
        $fileName = $this->generateUniqueFileName().'.'.$myfile->guessExtension();
        $myfile->move(
            $this->getParameter('file_directory'),
            $fileName
        );
        $post->setName($fullname);
        $post->setEmail($email);
        $post->setLocation($location);
        $post->setJobtitle($jobtitle);
        $post->setImage($fileName);
        $entityManager->flush();

        // $repository=$this->getDoctrine()->getRepository(Postjob::class);
        // $users=$repository->findOneBy(['id' => $id]);
        // return $this->redirectToRoute('edited_profile', [
        //     'id' => $post->getId()
        // ]);

        return $this->redirectToRoute('all_postjob');
        }
        else{
            return $this->redirectToRoute('app_login'); 
        }
    }


    /**
     * @Route("/createpostjob", name="createpostjob")
     */
    public function show(request $request,SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        $fullname = $request->request->get('fullname');
        $email = $request->request->get('email');
        $location = $request->request->get('location');
        $jobtitle = $request->request->get('jobtitle');
        $myfile = $request->files->get('myfile');
        //dd($myfile);
        $val = $session->get('key');
        //dd($val);
       //echo $myfile;

        $entityManager = $this->getDoctrine()->getManager();

        $user_postjob = new Postjob();
      //  dd($myfile);
//DD($request);
        $fileName = $this->generateUniqueFileName().'.'.$myfile->guessExtension();
        $myfile->move(
            $this->getParameter('file_directory'),
            $fileName
        );
        $user_postjob->setImage($fileName);
        $user_postjob->setUserId($val);
        // $file = $request->request->get('image');
        // // $file = $user_signup->getImage(); 
        // $fileName = md5(uniqid()).'.'.$file->guessExtension();
        // $file->move($this->getParameter('photos_directory'), $fileName);
        // $user_signup->setImage($fileName); 

        $user_postjob->setName($fullname);
        $user_postjob->setEmail($email);
        $user_postjob->setLocation($location);
        $user_postjob->setJobtitle($jobtitle);
        //$user_postjob->setImage($myfile);
             
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user_postjob);
        //$id=$user_signup->getId();
       // echo $id;
        // actually executes the queries (i.e. the INSERT query)
       $entityManager->flush();
       //$repository=$this->getDoctrine()->getRepository(Postjob::class);
       //$users=$repository->findAll();
    //    return $this->redirectToRoute('edited_profile', [
    //     'id' => $user_postjob->getId()
    // ]);
    return $this->redirectToRoute('all_postjob');
        }
        else{
            return $this->redirectToRoute('app_login'); 
        }
       // dd($users);
    //    return $this->render('postjob/allpost.html.twig', array(
    //     'users' => $users
        
    // ));
       // return new Response('Saved new product with id '.$user_signup->getId().$user_signup->getEmail());
    }

    
        /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

     /**
     * @Route("/answers/popular", name="app_popular_answers")
     */
    public function popularAnswers(PostjobRepository $postjobRepository, Request $request)
    {
        $answers = $postjobRepository->findMostPopular(
            $request->query->get('q')
        );
        return $this->render('postjob/allpost.html.twig', [
            'answers' => $answers
        ]);
    }


}
