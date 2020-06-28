<?php


namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/user")
 */
class UserController extends AbstractRestController
{
    private $entityManager;
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $repository
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Rest\Get("")
     */
    public function getAll()
    {
        $users = $this->repository->findAll();

        return $this->json($users);
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function getOneById(int $id)
    {
        $user = $this->repository->find($id);
        if ($user == null) {
            return $this->json("Not found", 404);
        }

        return $this->json($user);
    }
    /**
     * @Rest\Post("")
     */
    public function add(Request $request)
    {

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // checking if there is no other user with the same informations
            $existingUser = $this->repository->findOneBy(
                [
                    'firstname' => $user->getFirstname(),
                    'lastname' => $user->getLastname(),
                    'number' => $user->getNumber()
                ]
            );
            if ($existingUser != null) {
                return $this->json("User already exists", 409);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->json($user);

        } else {
            return $this->json($form, 400);
        }
    }
    /**
     * @Rest\Delete("/{id}")
     */
    public function delete(int $id){

        $user = $this->repository->find($id);
        if ($user == null) {
            return $this->json("Not found", 404);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Rest\Put("/{id}")
     */
    public function edit(Request $request, int $id)
    {
        $user = $this->repository->find($id);
        if ($user == null) {
            return $this->json("Not found", 404);
        }

        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // Can't add new user if number already exists

            // Using basic repository methods
            $existingUser = $this->repository->findOneBy(
                [
                    'number' => $user->getNumber()
                ]
            );
            if ($existingUser != null && $existingUser->getId()!=$user->getId()) {
                return $this->json("Number is already used",409);
            }

        } else {
            return $this->json($form, 400);
        }

    }
}
