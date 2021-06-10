<?php


namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            'kernel.exception' => 'onKernelException'
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $message = sprintf(
            $exception->getMessage(),
            $exception->getCode()
        );

        // Customize your response object to display the exception details
        $response = new JsonResponse();
        $response->setContent(json_encode($message));

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpException) {
            switch ($exception) {
                case $exception instanceof NotFoundHttpException :
                    $response->setStatusCode($exception->getStatusCode());
                    $response->setContent(json_encode("Resource not Found"));
                    break;

                case $exception instanceof UnauthorizedHttpException :
                    $response->setStatusCode($exception->getStatusCode());
                    $response->setContent(json_encode("Unauthorized - you need to authenticate"));
                    break;

                default:
                    $response->setStatusCode($exception->getStatusCode());
                    $response->headers->replace($exception->getHeaders());
                    break;
            }
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}