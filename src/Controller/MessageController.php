<?php


namespace App\Controller;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MessageController extends AbstractController
{

    public function postMessage(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //get request data
        $reqdata = json_decode($request->getContent(), false);
        $subject = $reqdata->subject;
        $text = $reqdata->text;
        $messageAuthor = $reqdata->messageAuthor;
        $messageRecipient = $reqdata->messageRecipient;
//        $createdAt = $reqdata->date('Y-m-d H:i:s');



        //set new message data

        $message = new Message();

        $message->setSubject($subject)
            ->setText($text)
            ->setMessageAuthor($messageAuthor)
            ->setMessageRecipient($messageRecipient);
//            ->setCreatedAt(new \DateTime("Y-m-d H:i:s", $createdAt));

        //to database
        $em->persist($message);
        $em->flush();

        return new Response(sprintf('Message %s successfully created', $message->getSubject()));
    }
}