<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 10)]
    private $Contact;

    #[ORM\Column(type: 'text')]
    private $Address;

    // #[ORM\Column(type: 'integer')]
    // private $salary;

    #[ORM\Column(type: 'string', length: 255)]
    private $Designation;

    #[ORM\OneToOne(mappedBy: 'Employee', targetEntity: Salary::class, cascade: ['persist', 'remove'])]
    private $salary;

    #[ORM\ManyToOne(targetEntity: Department::class)]
    private $Department;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->Contact;
    }

    public function setContact(string $Contact): self
    {
        $this->Contact = $Contact;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    // public function getSalary(): ?int
    // {
    //     return $this->salary;
    // }

    // public function setSalary(int $salary): self
    // {
    //     $this->salary = $salary;

    //     return $this;
    // }

    public function getDesignation(): ?string
    {
        return $this->Designation;
    }

    public function setDesignation(string $Designation): self
    {
        $this->Designation = $Designation;

        return $this;
    }

    public function getSalary(): ?Salary
    {
        return $this->salary;
    }

    public function setSalary(Salary $salary): self
    {
        // set the owning side of the relation if necessary
        if ($salary->getEmployee() !== $this) {
            $salary->setEmployee($this);
        }

        $this->salary = $salary;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->Department;
    }

    public function setDepartment(?Department $Department): self
    {
        $this->Department = $Department;

        return $this;
    }
}
