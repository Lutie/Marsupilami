<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Marsupilami;
use AppBundle\Form\Type\MarsupilamiType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    /**
     * @Route("/connexion")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'username' => $username,
        ]);
    }

    /**
     * @Route("/inscription")
     */
    public function inscriptionAction(Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {

        $marsupilami = new Marsupilami();

        $form = $this->createForm(MarsupilamiType::class, $marsupilami);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $userPasswordEncoder->encodePassword($marsupilami, $marsupilami->getRawPassword());
            $marsupilami->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($marsupilami);
            $em->flush();

            $this->addFlash('success', 'Votre Marsupilami a bien été enregistré. Vous pouvez désormais vous connecter.');

            return $this->redirectToRoute('app_main_index');
        }

        return $this->render('security/signup.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}