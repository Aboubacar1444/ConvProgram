<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Repository\BankRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DirectoryIterator;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(BankRepository $bankRepository): Response
    {
        
        return $this->render('index.html.twig',[
            'banks'=>$bankRepository->findAll(),
        ]);
    }

    

}
