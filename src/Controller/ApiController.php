<?php

namespace App\Controller;

use App\Lib\Denomination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
  /**
   * Example;
   * http://localhost:8000/api/cash_register/8766/10000/
   * @Route("/api/cash_register/{total_cost}/{amount_provided}/", name="cash_register", requirements={"params"=".+"})
   */
  public function cash_register(Request $symfonyRequest): Response
  {
    $totalCostCent = (int)$symfonyRequest->get('total_cost');
    $amountProvidedCent = (int)$symfonyRequest->get('amount_provided');
    $changeDollar = (float)($amountProvidedCent - $totalCostCent)/100;
    $currencyRepository = $this->getDoctrine()->getRepository(\App\Entity\Currency::class);
    $aCurrency=$currencyRepository->findBy(['is_active'=>true],['amount'=>'DESC']);
    $changeDenominations = Denomination::getDenominations($changeDollar,$aCurrency);
    $arrReturnValues = [
      'change' => $changeDollar,
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