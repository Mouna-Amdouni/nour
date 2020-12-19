<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Repository\ParticipantRepository;
use App\Repository\UserRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
/**
 * @Route("/messages", name="messages.")
 */
class MessageController extends AbstractController
{

    const ATTRIBUTES_TO_SERIALIZE=['id','content','createdAt','mine'];

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MessageRepository
     *
     */
    private $messageRepository;
    /**
     * @var UtilisateurRepository
     */
    private $utilistaeurRepository;
    public function __construct(EntityManagerInterface $entityManager , MessageRepository $messageRepository

        ,UtilisateurRepository $utilisateurRepository
    )
    {
        $this->entityManager=$entityManager;
        $this->messageRepository=$messageRepository;
        $this->utilistaeurRepository=$utilisateurRepository;
    }

    /**
     * @Route("/{id}",name="getMessages", methods={"GET"})

     * @param Request $request
     * @param Conversation $conversation
     * @return Response
     */
    public function index(Request $request,Conversation $conversation)
    {
        //je peux voir la conversation?

        $this->denyAccessUnlessGranted('VIEW',$conversation);
        $messages=$this->messageRepository->findMessagesByConversationId(
            $conversation->getId()
        );

      //  dd($messages);

     /*   return $this->render('message/index.html.twig',[
            'controller_name'=>'Meassagecontroller'
        ]);
     */
   /*  /**
         * @var $message Message
         */
     /*   array_map(function ($message) {
            $message->setMine(
                $message->getUtilisateur()->getId() === $this->getUser()->getId()
                    ? true : false
            );
        }, $messages);
*/
//dd($message);
        return $this->json($messages, Response::HTTP_OK, [], [
            'attributes' => self::ATTRIBUTES_TO_SERIALIZE
        ]);

    }
    /**
     * @Route("/{id}",name="NewMessage",methods={"POST"})
     * @param Request $request
     * @param Conversation $conversation
     * @return JsonResponse
     * @throws \Exception
     */
    public function newMessage(Request $request , Conversation $conversation){
        $user= $this->getUser();
        $content= $request->get('content',null);
//dd($content);
        $message=new Message();
        $message->setContent($content);
        $message->setUtilisateur($this->utilistaeurRepository->findOneBy(['id'=>1]));
        $message->setMine(true);
        $conversation->addMessage($message);
$conversation->setLastMessage($message);
        $this->entityManager->getConnection()->beginTransaction();

        try{
            $this->entityManager->persist($message);
            $this->entityManager->persist($conversation);
            $this->entityManager->flush();
            $this->entityManager->commit();
        }catch(\Exception $e){
            $this->entityManager->rollback();

            throw $e;
        }
        return $this->json($message,Response::HTTP_CREATED,[],[
            'attributes' =>self::ATTRIBUTES_TO_SERIALIZE
        ]);
    }


}
