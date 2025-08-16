<?php

namespace Src\Services\Students;

use Src\Repositories\StudentsRepository;

class StudentsService
{
    private StudentsRepository $studentsRepository;

    public function __construct()
    {
        $this->studentsRepository = new StudentsRepository();
    }

    public function index(): array
    {
        $students = [];
        $data = $this->studentsRepository->getAll();

        if (!empty($data)) {
            foreach($data as $student)
            {
                $students[] = [
                    'id' => base64_encode($student['id']),
                    'name' => $student['name'],
                    'email' => $student['email'],
                    'date_of_birth' => date('d/m/Y', strtotime($student['date_of_birth'])),
                    'document' => format_cpf($student['document']),

                ];
            }
        }


        return $students;
    }
}
