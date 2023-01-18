<?php

namespace App\Controller;

use App\Entity\Denomination;
use App\Entity\Transaction;
use App\Entity\User;
//use App\Repository\UserRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserController extends AbstractApiController
{

//   public function __construct(private UserRepository $doctrine) {}
    public function __construct(private EntityManagerInterface $entityManager) {}
    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/user', name: 'users',methods: 'GET')]
    public function index( Request $request): JsonResponse
    {
        $serializer = new Serializer([new ObjectNormalizer()]);
        $repository =  $this->entityManager->getRepository(User::class);
        $users = $repository->findAll();
        $array_result = [];
        foreach ($users as $user) {
            $array =  $serializer->normalize($user, 'json', [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object) {
                    return $object->getId();
                }
            ]);
            unset($array["timestamp"]);
            $array_result[] =  $array;

        }


        return $this->json($array_result);
    }


    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/user_login', name: 'user_login', methods: 'POST')]
    public function login( Request $request): JsonResponse
    {
        $email = $request->get('email');
        // validate the email from request body

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // invalid emailaddress
            return $this->json(["status"=> false, "message"=>"Invalid email address provided"])->setStatusCode(500);
        }

       $repository =  $this->entityManager->getRepository(User::class);
       $user = $repository->findOneBy(['email'=>$email]);
        $data  = null;
           if($user !== null){
               $data = ["user_id"=>$user->getId(),"name"=>$user->getName(),"balance"=>$user->getBalance(), "email"=>$user->getEmail() ];
           }

        return $this->json(["status"=>$data!==null, "user"=>$data]);

    }


    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/user_withdraw', name: 'user_withdraw', methods: 'POST')]
    public function user_withdraw( Request $request): JsonResponse
    {
        $id = $request->get('id');
        $amount = $request->get('amount');
        // validate the user entries

        if(!isset($id) && $amount <= 0){
            return $this->json(["status"=> false, "message"=>"Invalid user_id and amount"])->setStatusCode(500);
//        }
        }

//        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            // invalid emailaddress
//            return $this->json(["status"=> false, "message"=>"Invalid email address provided"])->setStatusCode(500);
//        }

        $repository =  $this->entityManager->getRepository(User::class);
        $denomination_repository =  $this->entityManager->getRepository(Denomination::class);

        $user = $repository->findOneBy(['id'=>$id]);


        $data  = null;
        if($user !== null){
            $balance = $user->getBalance();
            $new_balance = $balance - $amount;
            $user->setBalance($new_balance);
            $notes = $this->dispense_notes($amount);


                foreach ($notes as $note => $count) {
                 //   echo "$count notes of $note\n";
                    $transaction = new Transaction();
                    $transaction->setUser($user);
                    $transaction->setDenomination($denomination_repository->findOneBy(['value'=>$note])) ;
                    $transaction->setAmount($note);
                    $transaction->setNotesDispensed($count);
                    $transaction->setTimestamp(new \DateTime());
                    // tell Doctrine you want to (eventually) save the User (no queries yet)
                    $this->entityManager->persist($transaction);

                    // actually executes the queries (i.e. the INSERT query)
                    $this->entityManager->flush();
                   // echo "$count notes of $note\n";
                }

            $this->entityManager->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();
            // echo "$count notes of $note\n";
            $data = ["user_id"=>$user->getId(),"name"=>$user->getName(),"balance"=>$user->getBalance(), "email"=>$user->getEmail() ];
        }

        return $this->json(["status"=>$data!==null, "user"=>$data]);

    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/user_registration', name: 'user_registration', methods: 'POST')]
    public function user_registration( Request $request): JsonResponse
    {
        $email = $request->get('email');
        $name = $request->get('name');
        $balance = $request->get('balance');

        // validate the email from request body

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // invalid emailaddress
            return $this->json(["status"=> false, "message"=>"Invalid email address provided"])->setStatusCode(500);
        }

        if (!isset($name) || trim($name) == '') {
            // invalid emailaddress
            return $this->json(["status"=> false, "message"=>"name is a required field"])->setStatusCode(500);
        }

        if (!is_numeric($balance) ) {
            // invalid emailaddress
            return $this->json(["status"=> false, "message"=>"account balance is a required field"])->setStatusCode(500);
        }



        $repository =  $this->entityManager->getRepository(User::class);

        $user = new User();
        $user->setName($name);
        $user->setBalance($balance);
        $user->setEmail($email);
        $user->setTimestamp(new \DateTime());

        // tell Doctrine you want to (eventually) save the User (no queries yet)
        $this->entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $this->entityManager->flush();


        $user = $repository->findOneBy(['email'=>$email]);
        $data  = null;
        if($user !== null){
            $data = ["user_id"=>$user->getId(),"name"=>$user->getName(),"balance"=>$user->getBalance(), "email"=>$user->getEmail() ];
        }

        return $this->json(["status"=>true, "user"=>$data]);

    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/get_userinfo_by_id', name: 'get_userinfo_by_id', methods: 'GET')]
    public function get_userinfo_by_id( Request $request): JsonResponse
    {
        $id = $request->get('id');
        if ($id == null) {
            return $this->json(["status"=> false, "message"=>"Invalid User ID  provided"])->setStatusCode(500);
        }

        $repository =  $this->entityManager->getRepository(User::class);
        $user = $repository->findOneBy(['id'=>$id]);
        $data  = null;
        if($user !== null){
            $data = ["user_id"=>$user->getId(),"name"=>$user->getName(),"balance"=>$user->getBalance(), "email"=>$user->getEmail() ];
        }



        $transactions= $this->cleaner($user->getTransactions());
        $transactions_array = [];
        foreach ($transactions as $transaction){
            $transactions_array[] = ["date_time"=>$transaction["timestamp"]["timestamp"], "transaction_amount"=>$transaction["amount"],"transaction_note_dispensed"=>$transaction['notesDispensed'], "denomination"=>$transaction['denomination']["denomination"],"denomination_value"=>$transaction['denomination']["value"] ];
        }

        return $this->json(["status"=>$data!==null, "user"=>$data, "transactions"=>  $transactions_array]);

    }

    function dispense_notes($amount) {
        $notes = array(1000, 500, 100, 50, 20, 10);
        $note_count = array();

        for ($i = 0; $i < count($notes); $i++) {
            if ($amount >= $notes[$i]) {
                $note_count[$notes[$i]] = floor($amount / $notes[$i]);
                $amount = $amount - ($note_count[$notes[$i]] * $notes[$i]);
            }
        }

        return $note_count;
    }

    public function cleaner($items){

        $serializer = new Serializer([new ObjectNormalizer()]);
        $array_result = [];

        foreach ($items as $item) {

            $array =  $serializer->normalize($item, 'json', [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object) {
             //   print_r($object);
                    return $object->getId();
                }
            ]);
            $array_result[] =  $array;

        }
        return  $array_result;
    }
}
