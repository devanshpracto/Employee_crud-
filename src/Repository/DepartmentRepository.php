<?php

namespace App\Repository;

use App\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Department|null find($id, $lockMode = null, $lockVersion = null)
 * @method Department|null findOneBy(array $criteria, array $orderBy = null)
 * @method Department[]    findAll()
 * @method Department[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Department $entity, bool $flush = true): void
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
    public function remove(Department $entity, bool $flush = true): void
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
           $Department = $this->findAll();
   
           // if(!$Department){
           //     $response = new Response('No Entry Exists', Response::HTTP_NOT_FOUND);
   
           //     return $response;
           // }
           $data = [];
           foreach($Department as $em){
               $data[]=[
                   'id'=> $em->getId(),
                   'department_name'=> $em->getDepartmentName(),
                   'dept_no'=> $em->getDeptNo()
               ];
           }
           
           // dd(json_encode($Department));
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
           $Department = new Department;
         
   
           $Department->setDepartmentName($para['department_name'])
           ->setDeptNo($para['dept_no']);
          
           $columns =  $this->_em->getClassMetadata(Department::class)->getColumnNames();
          foreach($para as $key => $value){
              if(!in_array(strtolower($key),$columns)){
              return  new Response($key." does not exist in our entity::Department", Response::HTTP_NOT_ACCEPTABLE);
              }
          }
             $this->add($Department);
           
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
   
          
   
           $em->setDepartmentName($para['department_name'])
           ->setDeptNo($para['dept_no']);
          
            $columns =  $this->_em->getClassMetadata(Department::class)->getColumnNames();
            foreach($para as $key => $value){
                if(!in_array(strtolower($key),$columns)){
                return  new Response($key." does not exist in our entity::Department", Response::HTTP_NOT_ACCEPTABLE);
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
       public function getEntryById(Department $em) : Response
       {
          
   
           $data=[
               'id'=> $em->getId(),
               'department_name'=> $em->getDepartmentName(),
               'dept_no'=> $em->getDeptNo()
           ];
       
         
           // dd(json_encode($Department));
           $response = new Response(json_encode($data), Response::HTTP_OK);
           $response->headers->set('Content-Type', 'application/json');
   
           return $response;
   
       }

    // /**
    //  * @return Department[] Returns an array of Department objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Department
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
