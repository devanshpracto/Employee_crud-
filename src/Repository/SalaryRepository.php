<?php

namespace App\Repository;

use App\Entity\Employee;
use App\Entity\Salary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Salary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salary[]    findAll()
 * @method Salary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalaryRepository extends ServiceEntityRepository
{ 
    private $employeeRepository;
    public function __construct(EmployeeRepository $employeeRepository,ManagerRegistry $registry)
    {
        parent::__construct($registry, Salary::class);
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Salary $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Salary $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
 /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getAllEntries() : Response
    {
        $Salary = $this->findAll();

        // if(!$Salary){
        //     $response = new Response('No Entry Exists', Response::HTTP_NOT_FOUND);

        //     return $response;
        // }
        $data = [];
        foreach($Salary as $em){
            $data[]=[
                'id'=> $em->getId(),
                'amount'=> $em->getAmount(),
                'Employee'=> $em->getEmployee()
            ];
        }
        
        // dd(json_encode($Salary));
        $response = new Response(json_encode($data), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }


    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createEntry(Request $request): Response
    {
        $para = json_decode($request->getContent(),true);
        $Salary = new Salary;
      

        $Salary->setAmount($para['amount']);
        $employee = new Employee();
        $employee = $this->employeeRepository->find($para['employee']);
        if(!$employee){
            return  new Response("No employee for given id exist in our entity::Employee", Response::HTTP_NOT_FOUND);
        }
        $Salary->setEmployee($employee);

        $columns =  $this->_em->getClassMetadata(Salary::class)->getColumnNames();
       foreach($para as $key => $value){
           if(!in_array(strtolower($key),$columns)){
           return  new Response($key." does not exist in our entity::Salary", Response::HTTP_NOT_ACCEPTABLE);
           }
       }
          $this->add($Salary);
        
          $response = new Response("Inserted Successfully", Response::HTTP_OK);
          $response->headers->set('Content-Type', 'application/json');
          return $response;

    }
     /**
     * @throws ORMException
     * @throws OptimisticLockException
     */

    public function updateEntry(Request $request,$id): Response
    {
        $para = json_decode($request->getContent(),true);

        $em = $this->find($id);
        
        if(!$em){
            return  new Response("No entry for given id exists", Response::HTTP_NOT_FOUND);
        }

       

        $em->setAmount($para['amount']);
        $employee = new Employee();
        $employee = $this->employeeRepository->find($para['employee']);
        if(!$employee){
            return  new Response("No employee for given id exist in our entity::Employee", Response::HTTP_NOT_FOUND);
        }
        $em->setEmployee($employee);
         

         $columns =  $this->_em->getClassMetadata(Salary::class)->getColumnNames();
         foreach($para as $key => $value){
             if(!in_array(strtolower($key),$columns)){
             return  new Response($key." does not exist in our entity::Salary", Response::HTTP_NOT_ACCEPTABLE);
             }
         }

        $this->add($em);
                
          $response = new Response('Updated Successfully', Response::HTTP_OK);
          $response->headers->set('Content-Type', 'application/json');
          return $response;

    }


 /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getEntryById(Salary $em) : Response
    {
       

        $data=[
            'id'=> $em->getId(),
            'amount'=> $em->getAmount(),
            'employee' => $em->getEmployee()
        ];
    
      
        // dd(json_encode($Salary));
        $response = new Response(json_encode($data), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
    // /**
    //  * @return Salary[] Returns an array of Salary objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Salary
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
