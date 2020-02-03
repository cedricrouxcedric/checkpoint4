<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ticket;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function game()
    {
        return $this->render('game.html.twig');
    }
    /**
     * @Route("/win", name="win")
     */
    public function win()
    {
        $ticket = new Ticket();
        $user = $this->getUser();
        $ticket->setUser($user);
        $user->addTicket($ticket);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($ticket,$user);
        $entityManager->flush();


        return $this->render('win.html.twig');
    }
    /**
     * @Route("/leaderboard", name="leaderboard")
     */
    public function leaderBoard()
    {   $users = $this->getDoctrine()->getRepository(User::class)->leaderBoard();


        return $this->render('leaderBoard.html.twig',[
            'users'=> $users,
        ]);
    }

}
