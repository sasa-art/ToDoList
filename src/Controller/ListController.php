<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\CreatetaskType;
use App\Repository\TacheRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListController extends AbstractController
{
    /**
     * @Route("/ajouter/new", name="createtask")
     */
    public function createtask(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tache = new Tache();

        $form = $this->createForm(CreatetaskType::class, $tache);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $tache->setCreatedAt(new \DateTime('now'));
            $entityManager->persist($tache);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->add('info', 'Tâche bien enregistrée !!');

            return $this->redirectToRoute('home');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Il y a un champs vide !!');
        }

        return $this->render('list/createtask.html.twig', [
                'formTache' => $form->createView(),
            ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifytask")
     */
    public function modifytask(Tache $tache, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tacheRepo = $this->getDoctrine()->getRepository(Tache::class);

        $form = $this->createForm(CreatetaskType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $tache->setUpdatedAt(new \DateTime('now'));
            $em->persist($tache);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Tâche bien modifiée !!');

            return $this->redirectToRoute('home');
        }

        return $this->render('list/modifytask.html.twig', [
                'form' => $form->createView(),
                'tache' => $tache,
            ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(TacheRepository $repo, Request $request)
    {
        $taches = $repo->myFindtasks();

        return $this->render('list/home.html.twig', [
                'taches' => $taches,
            ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteTask(Tache $tache)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($tache);
        $em->flush();

        $this->get('session')->getFlashBag()->add('info', 'Tâche bien supprimée !!');

        return $this->redirectToRoute('home');
    }
}
