<?php

namespace App\Controller;

use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class DepartmentController extends AbstractController
{
    private $departmentRepository;
    private $emp;
    public function __construct(DepartmentRepository $departmentRepository, EntityManagerInterface $emp)
    {
        $this->departmentRepository =$departmentRepository;
        $this->emp=$emp;
    }

    

    #[Route('/department', name: 'app_department',methods:'GET')]
    public function index() : Response
    {

        return $this->departmentRepository->getAllEntries();
    }



    // #[Route('/employee/{
    #[Route('/department/{id}', name: 'app_department_id',methods:'GET')]
    public function getById($id) : Response
    {   
        $em = $this->departmentRepository->find($id);
        if(!$em){
            return $this->json("No entry for given id exists");
        }
       
         
        return $this->departmentRepository->getEntryById($em);
    }

    #[Route('/department', name: 'app_department_create',methods:'POST')]

    public function create(Request $request) : Response
    {
      
        return $this->departmentRepository->createEntry($request);

    }
  


    #[Route('/department/{id}', name: 'app_department_delete',methods:'DELETE')]

    public function delete($id) : Response
    {
        

        $em = $this->departmentRepository->find($id);
        
       
        if(!$em){
            return $this->json("No entry for given id exists");
        }
        

        $this->departmentRepository->remove($em);

        return $this->json('Deleted Successfully');

    }
    
    
    
    #[Route('/department/{id}', name: 'app_department_update',methods:'PUT')]
    public function update(Request $request,$id) : Response
    {
      
        return $this->departmentRepository->updateEntry($request,$id);
    }
}
