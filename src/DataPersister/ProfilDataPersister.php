<?php


namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity;
use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;


class ProfilDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->_entityManager = $entityManager;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Profil;
    }

    public function persist($data, array $context = [])
    {
        $this->_entityManager->persist($this);
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $archive=$data->setIsDeleted(true);
        $this->_entityManager->persist($archive);

        $users=$data->getUsers();
        foreach ($users as $user)
        {
            $archive=$user->setIsDeleted(true);
            $this->_entityManager->persist($archive);
        }
        $this->_entityManager->flush();
    }
}