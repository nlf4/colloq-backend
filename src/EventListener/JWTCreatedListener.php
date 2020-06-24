<?php


namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class JWTCreatedListener
{

    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

//        $payload       = $event->getData();
//        $payload['ip'] = $request->get;
//
//        $event->setData($payload);

//        $header        = $event->getHeader();
//        $header['cty'] = 'JWT';
//
//        $event->setHeader($header);
//
//
        $userName = $event->getUser()->getUsername();


        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $userName]);
        $payload        = $event->getData();
        $payload['id'] = $user->getId();
        $payload['email'] = $user->getEmail();
        $payload['firstName'] = $user->getFirstname();
        $payload['lastName'] = $user->getLastname();
        $payload['age'] = $user->getAge();
        $payload['city'] = $user->getCity()->getName();
        $payload['cityId'] = $user->getCity()->getId();
        $payload['meetupCity'] = $user->getMeetupCity()->getName();
        $payload['meetupCityId'] = $user->getMeetupCity()->getId();
        $payload['availStartDate'] = $user->getAvailStartDate();
        $payload['availEndDate'] = $user->getAvailEndDate();
        $payload['isTourist'] = $user->getIsTourist();
        $payload['isTutor'] = $user->getIsTutor();
        $payload['nativeLanguage'] = $user->getNativeLanguage()->getName();
        $payload['targetLanguage'] = $user->getTargetLanguage()->getName();
        $payload['meetupType'] = $user->getMeetupType();
        $payload['publicMessage'] = $user->getPublicMessage();
        $payload['images'] = $user->getImages();
        if ($user->getImage()) {
            $payload['image'] = $user->getImage()->getFilePath();
        }




        $event->setData($payload);
    }

}