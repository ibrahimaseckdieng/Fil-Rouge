<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Profil;

class ProfilFixtures extends Fixture
{
    public const PROFIL_F ='formateur';
    public const PROFIL_APP ='apprenant';
    public const PROFIL_CM ='cm';
    public const PROFIL_AD ='administrateur';
    public function load(ObjectManager $manager)
    {
        $profilFor= new Profil();
        $profilFor->setLibelle('Formateur');
        $profilFor->setIsDeleted(false);
        $this->addReference(self::PROFIL_F,$profilFor);
        $manager->persist($profilFor);

        $profilCm= new Profil();
        $profilCm->setLibelle('Cm');
        $profilCm->setIsDeleted(false);
        $this->addReference(self::PROFIL_CM,$profilCm);
        $manager->persist($profilCm);

        $profilAd= new Profil();
        $profilAd->setLibelle('Administrateur');
        $profilAd->setIsDeleted(false);
        $this->addReference(self::PROFIL_AD,$profilAd);
        $manager->persist($profilAd);

        $profilApp= new Profil();
        $profilApp->setLibelle('Apprenant');
        $profilApp->setIsDeleted(false);
        $this->addReference(self::PROFIL_APP,$profilApp);
        $manager->persist($profilApp);


        $manager->flush();
    }

}