<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
    public function get_Employee() : Response
    {

        return $this->employeeRepository->getAllEntries();
    }



    #[Route('/employee/{id}', name: 'app_employee_id',methods:'GET')]
    public function getById($id) : Response
    {   
        $em = $this->employeeRepository->find($id);
        if(!$em){
            return $this->json("No entry for given id exists");
        }
       
         
        return $this->employeeRepository->getEntryById($em);
    }

    #[Route('/employee', name: 'app_create',methods:'POST')]
    public function create(Request $request) : Response
    {
      
        return $this->employeeRepository->createEntry($request);

    }
  


    #[Route('/employee/{id}', name: 'app_delete',methods:'DELETE')]
    public function delete($id) : Response
    {
        

        $em = $this->employeeRepository->find($id);
        
       
        if(!$em){
            return $this->json("No entry for given id exists");
        }
        

        $this->employeeRepository->remove($em);

        return $this->json('Deleted Successfully');

    }
    #[Route('/employee/{id}', name: 'app_update',methods:'PUT')]
    public function update(Request $request,$id) : Response
    {
      
        return $this->employeeRepository->createEntry($request);
    }
}
