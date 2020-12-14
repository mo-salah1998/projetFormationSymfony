<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{

    private $manager ;
    public $passwordEncoder ;
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($registry, Participant::class);
        $this->passwordEncoder=$passwordEncoder;
        $this->manager = $manager;
    }


    public function saveUser($firstName,$lastName,$email,$password){

        $user = new Participant() ;

        $user->setNomP($firstName);
        $user->setPrenomP($lastName);
        $user->setEmail($email);
        $plainepassword = $password ;

        $user->setPassword($this->passwordEncoder->encodePassword($user,$plainepassword));

        $this->manager-> persist($user);
        $this->manager->flush();

    }


    // /**
    //  * @return Participant[] Returns an array of Participant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Participant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
