<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        //get request data
        $reqdata = json_decode($request->getContent(), false);
        $email = $reqdata->get('email');
        $password = $request->request->get('password');
        $firstName = $reqdata->get('firstName');
        $lastName = $reqdata->get('lastName');
        $age = $reqdata->get('age');
        $city = $reqdata->get('city');
//        $nativeLang = $reqdata->get('nativeLang');
//        $targetLang = $reqdata->get('targetLang');
        $meetupCity = $reqdata->get('meetupCity');
        $meetupType = $reqdata->get('meetupType');
        $startDate = $reqdata->get('startDate');
        $endDate = $reqdata->get('endDate');
        $meetupRole = $reqdata->get('role');


        //set new user data
        if ($meetupRole === "tourist") {
            $isTourist = true;
            $isTutor = false;
        } else {
            $isTourist = false;
            $isTutor = true;
        }


        $user = new User();
        $user->setEmail($email)
            ->setPassword($encoder->encodePassword($user, $password))
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setAge($age)
            ->setCity($city)
            ->setMeetupCity($meetupCity)
            ->setMeetupType($meetupType)
            ->setAvailStartDate($startDate)
            ->setAvailEndDate($endDate)
            ->setIsTourist($isTourist)
            ->setIsTutor($isTutor);



        //to database
        $em->persist($user);
        $em->flush();

        return new Response(sprintf('User %s successfully created', $user->getEmail()));
    }

    public function api()
    {

        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));

    }
}