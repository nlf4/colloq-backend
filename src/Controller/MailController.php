<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController
{

    /**
     * @Route("/api/contact", name="app_contact", methods={"POST"})
     */

    function sendContactMail(Request $request, EntityManagerInterface $em)
    {
        //get data from request
        $reqData = json_decode($request->getContent(), false);
        $email = $reqData->email;
        $name = $reqData->name;
        $date = new \DateTime();
        $messageBody = $reqData->message;

        $message = "
                    <html>
                    <body>
                    <p>User $name has sent you the following message: </p>
                       <p>$messageBody</p>
                    </body>
                    </html>
                    ";



        $to = 'nlfurtado4@gmail.com';
        $subject = 'Colloq - Contact Form';
        $headers = "From: admin@gmail.com";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        if (mail($to,$subject,$message,$headers)) {
            return new Response(sprintf('Mail sent successfully'));
        } else {
            return new Response(sprintf('Something went wrong'));

        }







//    $this->view->render('hello/send_mail');
    }

}