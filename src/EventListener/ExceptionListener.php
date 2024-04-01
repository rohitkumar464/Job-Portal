<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    // public function onKernelException(ExceptionEvent $event)
    // {
    //     // You get the exception object from the received event
    //     $exception = $event->getThrowable();
    //     // $message = sprintf(
    //     //     'My Error says: Route not found:',
    //     //     $exception->getMessage(),
    //     //     $exception->getCode()
    //     // );

    //     // Customize your response object to display the exception details
    //     $response = new Response();
    //     //$response->setContent($message);

    //     // HttpExceptionInterface is a special type of exception that
    //     // holds status code and header details
    //     if ($exception instanceof HttpExceptionInterface) {
    //         $response->setStatusCode($exception->getStatusCode());
    //         $response->headers->replace($exception->getHeaders());
    //     } else {
    //         $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }

    //     // sends the modified response object to the event
    //     $event->setResponse($response);
    // }
    private $router;
    private $redirectRouter = 'error_404';
    private $redirectRouter1 = '';
 
    public function __construct($router)
    {
        $this->router = $router;
    }
 
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event-> getThrowable();
        //dd($exception);
        //$statusCode = $exception->getStatusCode();
       
        //if($statusCode==404){   
            $response = new Response();
            if ($exception instanceof NotFoundHttpException) {
           
               if ($event->getRequest()->get('_route') == $this->redirectRouter) {
                   return;
                }
                // $request = $event->getRequest();
                // $routeName = $request->attributes->get('_route');
                // $route = $this->router->getRouteCollection()->get($routeName);
                // $options = $route->getOptions();
                // dd($options['response_type']);
                //dd($route);
                //$hd=$event->getRequest()->get('_route');
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
                //$url = $this->router->generate($this->redirectRouter);
               // dd($hd);
                //$response = new RedirectResponse($url);
                $event->setResponse($response);
            }
        //}
       else{
        $this->redirectRouter1=$event->getRequest()->get('_route');
           //dd($this->redirectRouter1);
            $url = $this->router->generate($this->redirectRouter1);
           // dd($url);
            $response = new RedirectResponse($url);
            $event->setResponse($response);
       }
   }
//    public function __invoke(ExceptionEvent $event): void
//    {
//        // You get the exception object from the received event
//        $exception = $event->getThrowable();
//        $message = sprintf(
//            'My Error says: %s with code: %s',
//            $exception->getMessage(),
//            $exception->getCode()
//        );

//        // Customize your response object to display the exception details
//        $response = new Response();
//        $response->setContent($message);

//        // HttpExceptionInterface is a special type of exception that
//        // holds status code and header details
//        if ($exception instanceof HttpExceptionInterface) {
//            $response->setStatusCode($exception->getStatusCode());
//            $response->headers->replace($exception->getHeaders());
//        } else {
//            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
//        }

//        // sends the modified response object to the event
//        $event->setResponse($response);
//    }

}