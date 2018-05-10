<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Marsupilami;
use AppBundle\Form\Type\EditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("")
     */
    public function indexAction()
    {
        return $this->render('index/index.html.twig');
    }

    /**
     * @Route("voir")
     */
    public function viewSelfAction()
    {
        return $this->render('marsupilami/view.html.twig');
    }

    /**
     * @Route("listeami")
     */
    public function friendAction()
    {
        {
            return $this->render('marsupilami/friendlist.html.twig');
        }
    }

    /**
     * @Route("liste")
     */
    public function viewAllAction()
    {
        {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository(Marsupilami::class);

            $marsupilami = $repository->findAll();

            return $this->render('marsupilami/viewall.html.twig', [
                'marsupilamis' => $marsupilami,
            ]);
        }
    }

    /**
     * @Route("modifier")
     */
    public function editAction(Request $request)
    {
        $marsupilami = $this->getUser();

        $form = $this->createForm(EditType::class, $marsupilami);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($marsupilami);
            $em->flush();

            $this->addFlash('success', 'Votre Marsupilami a a bien été modifié.');

            return $this->redirectToRoute('app_main_index');
        }

        return $this->render('marsupilami/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ajouter/{id}", requirements={"id":"\d+"})
     */
    public function addAction(Request $request, Marsupilami $marsupilami)
    {
        $token = $request->query->get('token');

        if ($token === null) {
            throw $this->createAccessDeniedException('token not found');
        }

        if (!$this->isCsrfTokenValid('FRIEND_TOKEN', $token)) {
            throw $this->createAccessDeniedException('token invalid');
        }

        $this->getUser()->addFriends($marsupilami);
        $marsupilami->addFriends($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $this->addFlash('success', 'L\'ami a bien été ajouté.');

        return $this->redirectToRoute('app_main_viewall');
    }

    /**
     * @Route("/supprimer/{id}", requirements={"id":"\d+"})
     */
    public function deleteAction(Request $request, Marsupilami $marsupilami)
    {

        $token = $request->query->get('token');
        $location = $request->query->get('location');

        if ($token === null) {
            throw $this->createAccessDeniedException('token not found');
        }

        if (!$this->isCsrfTokenValid('FRIEND_TOKEN', $token)) {
            throw $this->createAccessDeniedException('token invalid');
        }

        $this->getUser()->removeFriends($marsupilami);
        $marsupilami->removeFriends($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $this->addFlash('success', 'L\'ami a bien été supprimé.');

        return $this->redirectToRoute($location);
        // return $this->redirectToRoute('app_main_viewall');
    }

}
