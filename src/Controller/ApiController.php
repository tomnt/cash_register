<?php

namespace App\Controller;

use App\Lib\Denomination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Entity\Currency as Currency;

class ApiController extends AbstractController
{
  /**
   * http://localhost:8000/api/cash_register/12300/20000/
   * @Route("/api/cash_register/{total_cost}/{amount_provided}/", name="cash_register", requirements={"params"=".+"})
   */
  public function cash_register(Request $symfonyRequest): Response
  {
    $total_cost = (int)$symfonyRequest->get('total_cost');
    $amount_provided = (int)$symfonyRequest->get('amount_provided');
    $change = (float)($amount_provided - $total_cost);
    $currencyRepository = $this->getDoctrine()->getRepository(\App\Entity\Currency::class);
    $aCurrency=$currencyRepository->findBy(['is_active'=>true],['amount'=>'DESC']);
    $changeDenominations = Denomination::getDenominations($change,$aCurrency);
    $arrReturnValues = [
      'change' => $change,
      'denominations' => $changeDenominations
    ];
    $symfonyResponse = new Response(
      'Content',
      Response::HTTP_OK
    );
    $symfonyResponse->setContent(json_encode($arrReturnValues));
    return $symfonyResponse;
  }
}