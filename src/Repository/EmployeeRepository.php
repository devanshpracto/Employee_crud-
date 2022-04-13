<?php

namespace App\Repository;

use App\Entity\Employee;
use App\Entity\Salary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    private $propertyInfo;
    private $salaryRepository;
    public function __construct(SalaryRepository $salaryRepository, ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
        $reflectionExtractor = new ReflectionExtractor();
        $listExtractors = [$reflectionExtractor];
        $propertyInfo = new PropertyInfoExtractor(
            $listExtractors
        );
        $this->salaryRepository=$salaryRepository;
       
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Employee $entity, bool $flush = true): void
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
    public function remove(Employee $entity, bool $flush = true): void
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
        $employee = $this->findAll();

        // if(!$employee){
        //     $response = new Response('No Entry Exists', Response::HTTP_NOT_FOUND);

        //     return $response;
        // }
        $data = [];
        foreach($employee as $em){
            $data[]=[
                'id'=> $em->getId(),
                'name'=> $em->getName(),
                'Contact' => $em->getContact(),
                'Address'=>  $em->getAddress() ,
                'salary' =>  $em->getSalary(),
                'Designation' => $em->getDesignation()
            ];
        }
        
        // dd(json_encode($employee));
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
        $employee = new Employee;
      

        $employee->setName($para['name'])
        ->setContact($para['Contact'])
        ->setAddress($para['Address'])
        ->setDesignation($para['Designation']);
        

        $columns =  $this->_em->getClassMetadata(Employee::class)->getColumnNames();
       foreach($para as $key => $value){
           if(!in_array(strtolower($key),$columns)){
           return  new Response($key." does not exist in our entity::Employee", Response::HTTP_NOT_ACCEPTABLE);
           }
       }
          $this->add($employee);
        
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

         $em->setName($para['name'])
         ->setContact($para['Contact'])
         ->setAddress($para['Address'])
         ->setDesignation($para['Designation']);

         $columns =  $this->_em->getClassMetadata(Employee::class)->getColumnNames();
         foreach($para as $key => $value){
             if(!in_array(strtolower($key),$columns)){
             return  new Response($key." does not exist in our entity::Employee", Response::HTTP_NOT_ACCEPTABLE);
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
    public function getEntryById(Employee $em) : Response
    {
       

        $data=[
            'id'=> $em->getId(),
            'name'=> $em->getName(),
            'Contact' => $em->getContact(),
            'Address'=>  $em->getAddress(),
            'Designation' => $em->getDesignation()
        ];
    
      
        // dd(json_encode($employee));
        $response = new Response(json_encode($data), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }


     /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function setEmployeeSalary(Request $request,$id): Response
    {
        $para = json_decode($request->getContent(),true);
        $Salary = new Salary;
        $Salary->setAmount($para['amount']);
        
        $employee = $this->find($id);
        if(!$employee){
            return  new Response("No employee for given id exist in our entity::Employee", Response::HTTP_NOT_FOUND);
        }
        $employee->setSalary($Salary);
        $Salary->setEmployee($employee);



        $columns =  $this->_em->getClassMetadata(Salary::class)->getColumnNames();
        foreach($para as $key => $value){
            if(!in_array(strtolower($key),$columns)){
            return  new Response($key." does not exist in our entity::Salary", Response::HTTP_NOT_ACCEPTABLE);
            }
        }
           $this->add($employee);
           $this->salaryRepository->add($Salary);
        
          $response = new Response("Inserted Successfully", Response::HTTP_OK);
          $response->headers->set('Content-Type', 'application/json');
          return $response;


       

    }


   

    // /**
    //  * @return Employee[] Returns an array of Employee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
