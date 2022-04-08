<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $department_name;

    #[ORM\Column(type: 'integer')]
    private $dept_no;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartmentName(): ?string
    {
        return $this->department_name;
    }

    public function setDepartmentName(string $department_name): self
    {
        $this->department_name = $department_name;

        return $this;
    }

    public function getDeptNo(): ?int
    {
        return $this->dept_no;
    }

    public function setDeptNo(int $dept_no): self
    {
        $this->dept_no = $dept_no;

        return $this;
    }
}
