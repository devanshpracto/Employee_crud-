<?php

namespace App\Controller;

use App\Repository\SalaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalaryController extends AbstractController
{
    private $salaryRepository;
    private $emp;
    public function __construct(SalaryRepository $salaryRepository, EntityManagerInterface $emp)
    {
        $this->salaryRepository =$salaryRepository;
        $this->emp=$emp;
    }

    

    #[Route('/salary', name: 'app_salary',methods:'GET')]
    public function index() : Response
    {

        return $this->salaryRepository->getAllEntries();
    }



    // #[Route('/employee/{
    #[Route('/salary/{id}', name: 'app_salary_id',methods:'GET')]
    public function getById($id) : Response
    {   
        $em = $this->salaryRepository->find($id);
        if(!$em){
            return $this->json("No entry for given id exists");
        }
       
         
        return $this->salaryRepository->getEntryById($em);
    }

    #[Route('/salary', name: 'app_salary_create',methods:'POST')]

    public function create(Request $request) : Response
    {
      
        return $this->salaryRepository->createEntry($request);

    }
  


    #[Route('/salary/{id}', name: 'app_salary_delete',methods:'DELETE')]

    public function delete($id) : Response
    {
        

        $em = $this->salaryRepository->find($id);
        
       
        if(!$em){
            return $this->json("No entry for given id exists");
        }
        

        $this->salaryRepository->remove($em);

        return $this->json('Deleted Successfully');

    }
    
    
    
    #[Route('/salary/{id}', name: 'app_salary_update',methods:'PUT')]
    public function update(Request $request,$id) : Response
    {
      
        return $this->salaryRepository->updateEntry($request,$id);
    }
}
