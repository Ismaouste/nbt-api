<?php


namespace App\Controller;

use App\Form\ArtistType;
use App\Entity\Artist;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/artists")
 */
class ArtistController extends AbstractController
{
    private $entityManager;
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ArtistRepository $repository
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
        $artists = $this->repository->findAll();

        return $this->json($artists);
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function getOneById(int $id)
    {
        $artist = $this->repository->find($id);
        if ($artist == null) {
            return $this->json("Not found", 404);
        }

        return $this->json($artist);
    }
    /**
     * @Rest\Post("")
     */
    public function add(Request $request)
    {

        $artist = new Artist();

        $form = $this->createForm(ArtistType::class, $artist);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // checking if there is no other artist with the same name
            $existingArtist = $this->repository->findOneBy(
                [
                    'name' => $artist->getName(),
                ]
            );
            if ($existingArtist != null) {
                return $this->json("Artist already exists", 409);
            }

            $this->entityManager->persist($artist);
            $this->entityManager->flush();

            return $this->json($artist);

        } else {
            return $this->json($form, 400);
        }
    }
    /**
     * @Rest\Delete("/{id}")
     */
    public function delete(int $id){

        $artist = $this->repository->find($id);
        if ($artist == null) {
            return $this->json("Not found", 404);
        }

        $this->entityManager->remove($artist);
        $this->entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Rest\Put("/{id}")
     */
    public function edit(Request $request, int $id)
    {
        $data=
        $artist = $this->repository->find($id);

        if ($artist == null) {
            return $this->json("Not found", 404);
        }

        $form = $this->createForm(ArtistType::class, $artist);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // on n'autorise pas un livre avec un couple title/author déja existant

            // VERSION 1 AVEC LES METHODES DU REPOSITORY DE BASE
             $existingArtist = $this->repository->findOneBy(
                [
                    'name' => $artist->getName(),
                ]
            );
            // si c'est le même livre ce n'est pas une erreur
            if ($existingArtist != null && $existingArtist->getId()!=$artist->getId()) {
                return $this->json("Duplicate name",409);
            }

        } else {
            return $this->json($form, 400);
        }
    }
}
