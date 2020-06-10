<?php
namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;

class AdminFixture extends BaseFixture
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

        $city = new City();
        $city->setName('Antwerp');
        $country = new Country();
        $country->setName('Belgium');
        $city->setCountry($country);
        $manager->persist($city);
        $manager->flush();

        $user = new User();
        $user->setEmail('admin@admin.com')
            ->setPassword($this->passwordEncoder->encodePassword($user, 'password1234'))
            ->setFirstname('admin')
            ->setLastname('admin')
            ->setAge(33)
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setCity($city)
            ->setMeetupCity($city)
            ->setAvailStartDate(new \DateTime())
            ->setAvailEndDate(new \DateTime())
            ->setIsTutor(true)
            ->setIsTourist(false)
            ->setMeetupType('n/a')
            ->setPublicMessage('n/a');



        $manager->persist($user);
        $manager->flush();
    }

}
