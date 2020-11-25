<?php


namespace App\DataFixtures;


use App\Entity\Admin;
use App\Entity\Cm;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formateur;
use App\Entity\Apprenant;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder= $encoder;

    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('en_EN');

        $admin= new  Admin();
        $admin->setUsername("bayeniass")
            ->setPrenom("Baye")
            ->setNom("Niass")
            ->setEmail("bayeniass@gmail.com")
            ->setPassword($this->encoder->encodePassword($admin,'password'))
            ->setTelephone(777888888)
            ->setAdresse("Sicap")
            ->setProfil($this->getReference(ProfilFixtures::PROFIL_AD))
            ->setAvatar($faker->imageUrl(300, 300));
        $manager->persist($admin);

        $formateur= new  Formateur();
        $formateur->setUsername("djiby")
            ->setPrenom("Djiby")
            ->setNom("Niang")
            ->setEmail("djiby@gmail.com")
            ->setPassword($this->encoder->encodePassword($formateur,'password'))
            ->setTelephone(777888888)
            ->setAdresse("Guediawaye")
            ->setProfil($this->getReference(ProfilFixtures::PROFIL_F))
            ->setAvatar($faker->imageUrl(300, 300));
        $manager->persist($formateur);

        $cm= new  Cm();
        $cm->setUsername("yankhoba")
            ->setPrenom("Yankoba")
            ->setNom("Mane")
            ->setEmail("yankoba@gmail.com")
            ->setPassword($this->encoder->encodePassword($cm,'password'))
            ->setTelephone(777888888)
            ->setAdresse("Liberte 6")
            ->setProfil($this->getReference(ProfilFixtures::PROFIL_CM))
            ->setAvatar($faker->imageUrl(300, 300));
        $manager->persist($cm);

        $apprenant= new  Apprenant();
        $apprenant->setUsername("maimouna")
            ->setPrenom("Maimouna")
            ->setNom("Wone")
            ->setEmail("seckdieng@gmail.com")
            ->setPassword($this->encoder->encodePassword($apprenant,'password'))
            ->setTelephone(777066602)
            ->setAdresse("Keur Massar")
            ->setProfil($this->getReference(ProfilFixtures::PROFIL_APP))
            ->setAvatar($faker->imageUrl(300, 300));
        $manager->persist($apprenant);


        $manager->flush();
    }
}