<?php

namespace App\Domain\Controller;

use App\Domain\Service\CompanyService;
use App\Domain\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

/**
 * Class PostController
 * @package App\Domain\Controller
 */
class HomepageController extends Controller
{
    /**
     * @var CompanyService
     */
    protected $companyService;
    
    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * PostController constructor.
     * @param CompanyService $companyService
     */
    public function __construct(CompanyService $companyService, MailService $mailService)
    {
        $this->companyService = $companyService;
        $this->mailService = $mailService;
    }

    /**
     * @Route("/", name="searchView", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchView(Request $request) {
        $data = !empty($request->query->all()) ? $request->query->all() : [];
        $symbol = $this->companyService->getNasdaqListing();
        return $this->render('stock/search.html.twig', ['symbol' => $symbol, 'data'=>$data]);
    }
    
    /**
     * @Route("/search", name="searchAction", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchAction(Request $request) {
        
        $data = $request->request->all();
        $validator = Validation::createValidator();
        $groups = new Assert\GroupSequence(['Default', 'custom']);
    
        $constraint = new Assert\Collection([
          'email' => new Assert\Email(['message'=>'The field Email is incorrect']),
          'symbol' => new Assert\Length(['min' => 4]),
          'dateStart' => new Assert\Date(['message'=>'The field dateStart is incorrect']),
          'dateEnd' => new Assert\Date(['message'=>'The field dateEnd is incorrect'])
        ]);
    
        $errors = $validator->validate($data, $constraint, $groups);
        if ($errors->count()>0) {
            foreach( $errors as $error ) {
                // data - $errors[0]->getRoot()
                $this->addFlash("error", $error->getMessage());
            }
            return $this->redirectToRoute(
              'searchView',
              array('data' => $data),
              301
            );
        }
        
        $prices = $this->companyService->getCompanyGraphData($data);
        $tableData = $this->companyService->getCompanyStock($data);
        
        $subject = 'for submitted Company Symbol = '.$data['symbol'];
        $from = 'test@gmail.com';
        $to = $data['email'];
        $body = 'From '.$data['dateStart'].' to '.$data['dateEnd'];
        
        $this->mailService->send($subject, $from, $to, $body); // should be sent to a queue :)

        return $this->render('stock/graph.html.twig', ['prices' => $prices, 'data' => $data, 'tableData' => $tableData['prices']]);
    }
}
