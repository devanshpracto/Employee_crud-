<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
// use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Serializer\Encoder\JsonEncoder;
// use Symfony\Component\Serializer\Encoder\XmlEncoder;
// use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
// use Symfony\Component\Serializer\Serializer;



class EmployeeController extends AbstractController
{
    private $employeeRepository;
    private $emp;
    public function __construct(EmployeeRepository $employeeRepository, EntityManagerInterface $emp)
    {
        $this->employeeRepository =$employeeRepository;
        $this->emp=$emp;
    }



    #[Route('/employee', name: 'app_employee',methods:'GET')]
    public function getAll() : Response
    {
        $employee = $this->employeeRepository->findAll();
        // dd($employee);
        // $jsonContent = $employee->serialize($employee,'json');


        if(!$employee){
            return $this->json("No entry exists");
        }
        foreach($employee as $em){
            $data[]=[
                'id'=> $em->getId(),
                'name'=> $em->getName(),
                'Contact' => $em->getContact(),
                'Address'=>  $em->getAddress() ,
                // 'salary'=>  $em->getSalary(),
                'Designation' => $em->getDesignation()
            ];
        }
        
        // dd(json_encode($employee));

        return $this->json($data);
        // return new JsonResponse($data);
    }



    #[Route('/employee/{id}', name: 'app_employee_id',methods:'GET')]
    public function getById($id) : Response
    {   
        $em = $this->employeeRepository->find($id);
        if(!$em){
            return $this->json("No entry for given id exists");
        }
       
            $data=[
                'id'=> $em->getId(),
                'name'=> $em->getName(),
                'Contact' => $em->getContact(),
                'Address'=>  $em->getAddress() ,
                // 'salary'=>  $em->getSalary(),
                'Designation' => $em->getDesignation()
            ];
        
        return $this->json($data);
    }

    #[Route('/employee', name: 'app_create',methods:'POST')]
    public function create(Request $request) : Response
    {
        $para = json_decode($request->getContent(),true);
        // dd($para);

        $employee = new Employee;
         $employee->setName($para['name'])
         ->setContact($para['Contact'])
         ->setAddress($para['Address'])
        //  ->setSalary($para['salary'])
         ->setDesignation($para['Designation']);

        $this->emp->persist($employee);
        $this->emp->flush();

        return $this->json('Inserted Successfully');

    }
  


    #[Route('/employee/{id}', name: 'app_delete',methods:'DELETE')]
    public function delete($id) : Response
    {
        

        $em = $this->employeeRepository->find($id);
        
        // $employee = new Employee;
        if(!$em){
            return $this->json("No entry for given id exists");
        }
        

        $this->emp->remove($em);
        $this->emp->flush();

        return $this->json('Deleted Successfully');

    }
    #[Route('/employee/{id}', name: 'app_update',methods:'PUT')]
    public function update(Request $request,$id) : Response
    {
        $para = json_decode($request->getContent(),true);

        $em = $this->employeeRepository->find($id);
        
        // $employee = new Employee;
        if(!$em){
            return $this->json("No entry for given id exists");
        }
         $em->setName($para['name'])
         ->setContact($para['Contact'])
         ->setAddress($para['Address'])
        //  ->setSalary($para['salary'])
         ->setDesignation($para['Designation']);

        $this->emp->persist($em);
        $this->emp->flush();
        return $this->json('Updated Successfully');

    }
}
