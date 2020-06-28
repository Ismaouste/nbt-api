<?php


namespace App\Controller;

use App\Form\LineUpType;
use App\Entity\LineUp;
use App\Repository\LineUpRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


    /**
     * @Rest\Route("/api/lineup")
     */
class LineUpController extends AbstractRestController
{
    private $entityManager;
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        LineUpRepository $repository
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
        $lineups = $this->repository->findAll();

        return $this->json($lineups);
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function getOneById(int $id)
    {
        $lineup = $this->repository->find($id);
        if ($lineup == null) {
            return $this->json("Not found", 404);
        }

        return $this->json($lineup);
    }
    /**
     * @Rest\Post("")
     */
    public function add(Request $request)
    {

        $lineup = new LineUp();

        $form = $this->createForm(LineUpType::class, $lineup);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // checking if there is no other lineup with the same references
            $existingLineUp = $this->repository->findOneBy(
                [
                    'concertId' => $lineup->getConcertId(),
                    'position' => $lineup->getPosition(),
                ]
            );
            if ($existingLineUp != null) {
                return $this->json("Same LineUp already exists", 409);
            }

            $this->entityManager->persist($lineup);
            $this->entityManager->flush();

            return $this->json($lineup);

        } else {
            return $this->json($form, 400);
        }
    }
    /**
     * @Rest\Delete("/{id}")
     */
    public function delete(int $id){

        $lineup = $this->repository->find($id);
        if ($lineup == null) {
            return $this->json("Not found", 404);
        }

        $this->entityManager->remove($lineup);
        $this->entityManager->flush();

        return $this->json("OK");
    }

    /**
     * @Rest\Put("/{id}")
     */
    public function edit(Request $request, int $id)
    {
        $lineup = $this->repository->find($id);
        if ($lineup == null) {
            return $this->json("Not found", 404);
        }

        $form = $this->createForm(LineUpType::class, $lineup);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // Can't add new lineup if title already exists

            // Using basic repository methods
            $existingLineUp = $this->repository->findOneBy(
                [
                    'concertId' => $lineup->getConcertId(),
                    'artistId' => $lineup->getArtistId(),
                    'position' => $lineup->getPosition(),
                ]
            );
            if ($existingLineUp != null && $existingLineUp->getId()!=$lineup->getId()) {
                return $this->json("Duplicate LineUp",409);
            }

        } else {
            return $this->json($form, 400);
        }

    }
}
