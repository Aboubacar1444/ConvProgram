<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Repository\BankRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DirectoryIterator;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use DateTimeImmutable;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{

    
    #[Route('/data', name: 'app_data', methods:['GET'])]
    public function index(BankRepository $bankRepository, MailerInterface $mailerInterface)
    {
            
        $sentDate = isset($_GET["date"]) ? 
            $_GET["date"][6].$_GET["date"][7].
            $_GET["date"][8].$_GET["date"][9].'-'.
            $_GET["date"][3].$_GET["date"][4].'-'.
            $_GET["date"][0].$_GET["date"][1]
        :
            false;

        if ($sentDate) { 
            $sentDate =  date('d-m-Y', strtotime($sentDate));
            $date = new \DateTimeImmutable($sentDate);
            $pastWeek = date("d-m-Y",strtotime($sentDate . " -1 week "));
            // return new JsonResponse([$pastWeek, $date]);
           
        }else{

            $date = date("d-m-Y", strtotime("yesterday"));
            $date = new \DateTimeImmutable($date);
            $date = $date->format('d-m-Y');
            
        }
        
        
        $data = [];
        
        
        $filename ="SAMAMONEY_B2W_".date('d_m_Y_H_i_s', strtotime('yesterday')).'.csv';
        $filepath = "./assets/files/".$filename;
        $filesystem = new Filesystem();
        $f = fopen($filepath, 'w+'); 
        $d = ',';
        $fields = array('Mnoid', 'Bankname', 'TransactionId', 'ReferenceNumber', 'TransfertOn', 'ServiceName', 'EntryType', 'TransfertValue', 'PostBalance', 'IssuerMsisdn', 'ReceiverMsisdn', 'TransfertState');
        fputcsv($f, $fields, $d); 
        // $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/assets/files/';
                
        $email = (new Email());
        foreach ($bankRepository->findAll() as $bank) {
            if ($sentDate) { 
                if ($bank->getTransfertAt()->format('d-m-Y') >= $pastWeek && $bank->getTransfertAt()->format('d-m-Y') <= $date ) {
                    $rows = [
                        "0".$bank->getMnoid(),
                        'Bankname' => $bank->getBanque(),
                        'TransactionId' =>$bank->getIdusersama(),
                        'ReferenceNumber'=>$bank->getIdtransBanque(),
                        'transfert_on'=>$bank->getTransfertAt()->format('d-m-Y H:i'),
                        'Service_name'=>$bank->getServiceName(),
                        'Entry_type'=>$bank->getEntryType(),
                        'Transfert Value'=>$bank->getMontant(),
                        'Post Balance'=>$bank->getPostBalance(),
                        'Issuer Msisdn'=>$bank->getPhoneuser(),
                        'Receiver Msisdn'=>$bank->getReceveirMsisdn(),
                        'Transfert state'=>$bank->isStatus() ? : 0,
                    ];
                    $data = $rows;
                    
                    fputcsv($f, $data, $d);
                    $filesystem->dumpFile("./assets/files/$filepath",fputcsv($f, $data, $d));
                    $email
                        ->from("sama@example.com")
                        ->to("contact@wenovate-ml.com")
                        ->subject("Daily Crone task")
                        ->html("<h1>Veuillez trouver ci-joint le fichier CSV.<h1>")
                        ->attach("./assets/files/$filename");
                    

                }
            }else{
                // if($bank->getTransfertAt()->format('d-m-Y') == $date ){
                    $rows = [
                        "0".$bank->getMnoid(),
                        'Bankname' => $bank->getBanque(),
                        'TransactionId' =>$bank->getIdusersama(),
                        'ReferenceNumber'=>$bank->getIdtransBanque(),
                        'transfert_on'=>$bank->getTransfertAt()->format('d-m-Y H:i'),
                        'Service_name'=>$bank->getServiceName(),
                        'Entry_type'=>$bank->getEntryType(),
                        'TransfertValue'=>$bank->getMontant(),
                        'PostBalance'=>$bank->getPostBalance(),
                        'IssuerMsisdn'=>$bank->getPhoneuser(),
                        'ReceiverMsisdn'=>$bank->getReceveirMsisdn(),
                        'Transfertstate'=>$bank->isStatus() ? : 0,
                        // 'date'=>$bank->getSaveAt()->format('d-m-Y H:i'),
                    ];
                    $data = $rows;
                    
                     fputcsv($f, $data, $d);
                     
                     $filesystem->dumpFile("./assets/files/$filepath",fputcsv($f, $data, $d));
                    $email = (new Email())
                        ->from("contact@wenovate-ml.com")
                        ->to("contact@wenovate-ml.com")
                        ->subject("Daily Crone task")
                        ->html("<h1>Veuillez trouver ci-joint le fichier CSV.<h1>")
                        ->attachFromPath("./assets/files/$filename");
                    
                  

                // }else{
                   //return false;
                // }
            }
        }
        $filesystem->remove("./assets/files/assets");
        $mailerInterface->send($email);
        return new JsonResponse([
            "status"=>1,
            "Message"=>"Fichier envoyé avec succès."
        ]);
        // $response = new Response();
        // $response->headers->set("content-type", "application/force-download");
        // $response->headers->set('Content-Type', 'application/csv');
        // $response->headers->set('Pragma',' no-cache');
        // $response->headers->set('Content-Disposition', 'attachment; filename=' . $filename);
        // return $response;
        
    }
    
    #[Route('/sent/{process}', name:'app_sent', methods:['POST'])]
    public function getsheet(Request $request, ManagerRegistry $manager, BankRepository $bankRepository): Response 
    {
        $em = $manager->getManager();
        if ($request->get('process')) {
            
                // $data = $request->files->get('file');
                if($_FILES["file"]["name"] != ""){
                // return new JsonResponse("Ok");
                
                $allowed_extension = array('xls', 'csv', 'xlsx');
                $file_array = explode(".", $_FILES["file"]["name"]);
                $file_extension = end($file_array); 
                
                if(in_array($file_extension, $allowed_extension)){
                    $file_name = date('Y').'-'.uniqid(). '.' . $file_extension;
                    // dd($file_name);
                    $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/assets/files/transfertfiles/';
                    $sheetFilepath =  $publicDirectory . $file_name;
                    move_uploaded_file($_FILES['file']['tmp_name'], $sheetFilepath);
                    
                    $file_type =\PhpOffice\PhpSpreadsheet\IOFactory::identify($sheetFilepath);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

                    $spreadsheet = $reader->load($sheetFilepath);
                    
                    unlink($sheetFilepath);
                    
                    $data = $spreadsheet->getActiveSheet()->toArray();

                    foreach ($data as $row) {
                        if(!is_null($row[1]) && !empty($row[1]) && $row[1]!=="type"){
                            // $init = $row[15];
                            $isSaved = $bankRepository->findOneByIdExcel($row[0]); 
                            $row[8] = $row[8][3].$row[8][4].'-'.$row[8][0].$row[8][1].'-'.$row[8][6].$row[8][7].$row[8][8].$row[8][9]
                                    .' '.$row[8][11].$row[8][12].':'.$row[8][14].$row[8][15].':'.$row[8][17].$row[8][18]
                                    .' '.$row[8][20].$row[8][21]
                            ;

                            $row[15] = $row[15][0].$row[15][1].'-'.$row[15][3].$row[15][4].'-'.$row[15][6].$row[15][7].$row[15][8].$row[15][9]
                                    .' '.$row[15][11].$row[15][12].':'.$row[15][14].$row[15][15]
                                    
                            ;
                            $transfert_on = $row[8];
                            $saveAt = $row[15];
                            $transfert_on = new \DateTimeImmutable($transfert_on);
                            $saveAt = new \DateTimeImmutable($saveAt);
                            // date_format( new \DateTime($row[15]),'Y-m-d H:i:s A');
                            if (!$isSaved) {
                                $bank = new Bank();
                                    $bank->setIdExcel($row[0]?$row[0]:false);
                                    $bank->setType($row[1]?$row[1]:"");
                                    $bank->setIdusersama($row[2]?$row[2]:"");
                                    // $bank->setReceveirMsisdn($row[2]?$row[2]:"");
                                    $bank->setPhoneuser($row[3]?$row[3]:"");
                                    $bank->setMnoid($row[4]?$row[4]:false);
                                    $bank->setBanque($row[5]?$row[5]:"");
                                    $bank->setIdtransSama($row[6]?$row[6]:"");
                                    $bank->setIdtransBanque($row[7]?$row[7]:"");
                                    $bank->setTransfertAt($transfert_on);
                                    $bank->setServiceName($row[9]?$row[9]:"");
                                    $bank->setEntryType($row[10]?$row[10]:"");
                                    $bank->setMontant($row[11]?$row[11]:false);
                                    $bank->setPostBalance($row[12]?$row[12]:false);
                                    $bank->setFrais($row[13]?$row[13]:false);
                                    $bank->setImei($row[14]?$row[14]:"");
                                    $bank->setSaveAt($saveAt);
                                    $bank->setErreur($row[16]?$row[16]:"");
                                    $bank->setStatus($row[17]?$row[17]:"");
                                    $bank->setMclientsama($row[18]?$row[18]:"");
                                    $bank->setAversclient($row[19]?$row[19]:"");
                                    $bank->setCreatedAt(new DateTimeImmutable());
                                set_time_limit(2000);
                                $em->persist($bank);
                                $em->flush();
                                $message = '<div class="alert alert-success">Rapport importé avec succès</div>';
                            }
                            else    
                                $message = '<div class="alert alert-danger">Les données existent déjà.</div>';
                              

                        }       
                    }

                }else{
                    $message = '<div class="alert alert-danger">Seul les fichiers  d\'extension .xls, .csv ou .xlsx sont autorisés </div>';
                }
            }else{
                $message = '<div class="alert alert-danger">Selectionnez un fichier s\'il vous plaît.</div>';
            }   
            
        }
        return $this->redirectToRoute('api_app_data');
    }
}
