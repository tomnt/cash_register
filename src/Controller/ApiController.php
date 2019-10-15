<?php

namespace App\Controller;

use App\Lib\Denomination;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
  /** Controller method for the Cash Register API
   *
   * @param Request $symfonyRequest Request object
   *     Example; $symfonyRequest->getRequestUri() =
   *         http://localhost:8000/api/cash_register/?total_cost=87.66&amount_provided=100.00
   * @return Response Response object
   * @throws \Exception
   * @Route("/api/cash_register/", name="cash_register", requirements={"params"=".+"})
   */
  public function cash_register(Request $symfonyRequest): Response
  {
    $totalCostCent = self::getValidatedCurrency('total_cost', $symfonyRequest);
    $amountProvidedCent = self::getValidatedCurrency('amount_provided', $symfonyRequest);
    $changeDollar = $amountProvidedCent - $totalCostCent;
    $currencyRepository = $this->getDoctrine()->getRepository(\App\Entity\Currency::class);
    $aCurrency=$currencyRepository->findBy(['is_active'=>true],['amount'=>'DESC']);
    $changeDenominations = Denomination::getDenominations($changeDollar,$aCurrency);
    $arrReturnValues = [
      'change' => round($changeDollar,2),
      'denominations' => $changeDenominations
    ];
    $symfonyResponse = new Response(
      'Content',
      Response::HTTP_OK
    );
    $symfonyResponse->setContent(json_encode($arrReturnValues));
    return $symfonyResponse;
  }

  /**
   * Obtain currency value corresponding to given param name and Request object.
   * @param string $paramName Param name
   *     Example: total_cost
   * @param Request $symfonyRequest Request object
   *     Example; $symfonyRequest->getRequestUri() =
   *         http://localhost:8000/api/cash_register/?total_cost=87.66&amount_provided=100.00
   * @return float currency value
   *     Example: 87.66
   * @throws \Exception Throws an exception if the given currency value is not numeric or exceeds supported precision.
   */
  private static function getValidatedCurrency(string $paramName, Request $symfonyRequest): float{
    $sCurrencyValue = $symfonyRequest->get($paramName);
    $aNodeCurrencyValue = explode('.',$sCurrencyValue);
    if(isset($aNodeCurrencyValue[1])){
      $sAfterDecimalPoint=$aNodeCurrencyValue[1];
    }else{
      $sAfterDecimalPoint = '0';
    }
    if(!is_numeric($sCurrencyValue )){
      throw new \Exception('Given value for '.$paramName.' = '.$sCurrencyValue.' is not numeric');
    }elseif(strlen($sAfterDecimalPoint)>2){
      throw new \Exception('Precision for the given value for '.$paramName.' = '.$sCurrencyValue.' is supported.');
    }else{
      return (float)$sCurrencyValue;
    }
  }

}