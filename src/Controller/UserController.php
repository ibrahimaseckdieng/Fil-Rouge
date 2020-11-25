<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\GroupeCompetences;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route(path="/api/admin/users", name="api_get_users", methods={"GET"})
     */
    public function getUsers(UserRepository $repo)
    {
        if ($this->isGranted('ROLE_Administrateur') || $this->isGranted('ROLE_Formateur') || $this->isGranted('ROLE_Cm')){
            $users= $repo->findAll();
            return $this->json($users,Response::HTTP_OK);
        }
        else{
            return $this->json("Acces Interdit !");
        }
    }

    /**
     * @Route(path="/api/admin/users", name="api_add_users", methods={"POST"})
     */
    public function addUser(SerializerInterface $serializer,ValidatorInterface $validator, Request $request,UserPasswordEncoderInterface $encoder)
    {
        // Get Body content of the Request
        $userJson = $request->getContent();

        // Deserialize and insert into dataBase
        $user = $serializer->deserialize($userJson, User::class,'json');

        // Data Validation
        $errors = $validator->validate($user);
        if (count($errors)>0) {
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $password = $user->getPassword();
        $user->setPassword($encoder->encodePassword($user, $password));
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse("success",Response::HTTP_CREATED,[],true);

    }

    /**
     * @Route(path="/api/admin/users/{id}", name="api_get_user", methods={"GET"})
     */
    public function getUtilisateur($id, UserRepository $userRepository)
    {
        if ($this->isGranted('ROLE_Administrateur') || $this->isGranted('ROLE_Formateur') || $this->isGranted('ROLE_Cm')){
            $user= $userRepository->find($id);
            if ($user){
                return $this->json($user,Response::HTTP_OK);
            }
            else{
                return $this->json("L'utilisateur n'existe pas !");
            }

        }
        else{
            return $this->json("Access denied!!!");
        }
    }

    /**
     * @Route(path="/api/admin/users/{id}", name="api_get_user", methods={"PUT"})
     */
    public function putUtilisateur(SerializerInterface $serializer, Request $request, $id, UserRepository $userRepository)
    {

        if ($this->isGranted('ROLE_Administrateur') || $this->isGranted('ROLE_Formateur') || $this->isGranted('ROLE_Cm')){
            $user= $userRepository->find($id);
            if ($user){
                // Get Body content of the Request

                $userJson = $request->getContent();

                // Deserialize and insert into dataBase
                $user = $serializer->deserialize($userJson, User::class,'json');
              $entityManager = $this->getDoctrine()->getManager();

                return $this->json($user,Response::HTTP_OK);
            }
            else{
                return $this->json("L'utilisateur n'existe pas !");
            }

        }
        else{
            return $this->json("Access denied!!!");
        }
    }
}