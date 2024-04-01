<?php

namespace App\Controller;
use App\Entity\Postjob;
use App\Entity\Publishpost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\PublishpostRepository;
class PublishpostController extends AbstractController
{
    /**
     * @Route("/publishpost", name="all_publishpost")
     */
    public function index(PublishpostRepository $publishRepository,PaginatorInterface $paginator,Request $request,SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        //$repository=$this->getDoctrine()->getRepository(Publishpost::class);
        $allAppointmentsQuery = $publishRepository->createQueryBuilder('p')
            ->where("p.user_id = $val")
            ->getQuery();
        $users = $paginator->paginate(
            // Doctrine Query, not results
            $allAppointmentsQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            2
        );
        //$users=$repository->findAll();

        // dd($users);
        return $this->render('publishpost/index.html.twig', [
            'users' => $users,
        ]);
        }
        else{
             return $this->redirectToRoute('app_login');
        }
    }

     /**
     * @Route("/publishpostjob{id}", name="publish_postjob")
     */
    public function publishpost(EntityManagerInterface $entityManager,int $id,SessionInterface $session): Response
    {
        $val = $session->get('key');
        if($val){
        $post = $entityManager->getRepository(Postjob::class)->find($id);
        $fullname=$post->getName();
        $email=$post->getEmail();
        $location=$post->getLocation();
        $jobtitle=$post->getJobtitle();
        $image=$post->getImage();
        //dd($image);
        $entityManager->remove($post);
        $entityManager->flush();
        $entityManager = $this->getDoctrine()->getManager();
        $publish_post=new publishpost();
        $val = $session->get('key');
        $publish_post->setUserId($val);
        $publish_post->setName($fullname);
        $publish_post->setEmail($email);
        $publish_post->setLocation($location);
        $publish_post->setJobtitle($jobtitle);
        $publish_post->setImage($image);
        $entityManager->persist($publish_post);
        $entityManager->flush();
        //dd($image);
         // dd($post);
         // $repository=$this->getDoctrine()->getRepository(Postjob::class);
         // $users=$repository->findOneBy(['id' => $id]);
         // dd($users);
         return $this->redirectToRoute('all_publishpost');
        }
        else{
            return $this->redirectToRoute('app_login');
        }
    }
}
