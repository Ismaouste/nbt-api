<?php


namespace App\Controller;

use App\Form\ConcertType;
use App\Entity\Concert;
use App\Repository\ConcertRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/concerts")
 */
class ConcertController extends AbstractController
{
    private $entityManager;
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ConcertRepository $repository
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
        $concerts = $this->repository->findAll();

        return $this->json($concerts);
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function getOneById(int $id)
    {
        $concert = $this->repository->find($id);
        if ($concert == null) {
            return $this->json("Not found", 404);
        }

        return $this->json($concert);
    }
    /**
     * @Rest\Post("")
     */
    public function add(Request $request)
    {

        $concert = new Concert();

        $form = $this->createForm(ConcertType::class, $concert);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // checking if there is no other concert with the same title
            $existingConcert = $this->repository->findOneBy(
                [
                    'title' => $concert->getTitle(),
                ]
            );
            if ($existingConcert != null) {
                return $this->json("Concert already exists", 409);
            }

            $this->entityManager->persist($concert);
            $this->entityManager->flush();

            return $this->json($concert);

        } else {
            return $this->json($form, 400);
        }
    }
    /**
     * @Rest\Delete("/{id}")
     */
    public function delete(int $id){

        $concert = $this->repository->find($id);
        if ($concert == null) {
            return $this->json("Not found", 404);
        }

        $this->entityManager->remove($concert);
        $this->entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Rest\Patch("/{id}")
     */
    public function edit(Request $request, int $id)
    {
        $concert = $this->repository->find($id);
        if ($concert == null) {
            return $this->json("Not found", 404);
        }

        $form = $this->createForm(ConcertType::class, $concert);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // Can't add new concert if title already exists

            // VERSION 1 AVEC LES METHODES DU REPOSITORY DE BASE
            $existingConcert = $this->repository->findOneBy(
                [
                    'title' => $concert->getTitle(),
                ]
            );
            // si c'est le même livre ce n'est pas une erreur
            if ($existingConcert != null && $existingConcert->getId()!=$concert->getId()) {
                return $this->json("Duplicate title",409);
            }

        } else {
            return $this->json($form, 400);
        }
    }
}
