<?php
namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

//    public function getDependencies()
//    {
//        return [
//            City::class,
//            Country::class,
//        ];
//    }

    public function loadData(ObjectManager $manager)
    {

//        $city = new City();
//        $this->addReference('Atlanta', $city);
//        $manager->persist($city);

        $this->createMany(1, 'main_users', function ($i) {
            $user = new User();
            $user->setEmail(sprintf('test4@example.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'authenticate'));
            $user->setRoles([])
                ->setFirstname('Amy')
                ->setLastname('Kalan')
                ->setAge(54)
                ->setAvailStartDate(new \DateTime())
                ->setAvailEndDate(new \DateTime())
                ->setIsTourist(true)
                ->setIsTutor(false)
                ->setMeetupType('park');

            return $user;
        });

        $manager->flush();
    }

}
