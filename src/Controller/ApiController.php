<?php

namespace App\Controller;

use App\Lib\CurrencyValidator;
use App\Lib\Denomination;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
  /**
   * Controller method for the Cash Register API
   *
   * @param Request $request Request object
   *     Example; $request->getRequestUri() =
   *         http://localhost:8000/api/cash_register/?total_cost=87.66&amount_provided=100.00
   * @return Response Response object
   * @throws \Exception
   * @Route("/api/cash_register/", name="cash_register", requirements={"params"=".+"})
   */
  public function cash_register(Request $request): Response
  {
    //Obtain return values
    $change = self::getChange($request);
    $changeDenominations = self::getDenominations($change, $this->getDoctrine());
    $arrReturnValues = [
      'change' => round($change, 2),
      'denominations' => $changeDenominations
    ];
    //Response
    $response = new Response();
    $response->setContent(json_encode($arrReturnValues));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  /**
   * Obtain Change corresponding given parameters
   *
   * @param Request $request Request object
   * @return float Change
   * @throws \Exception
   */
  private static function getChange(Request $request): float
  {
    $totalCost = self::getValidatedCurrency('total_cost', $request);
    $amountProvided = self::getValidatedCurrency('amount_provided', $request);
    return $amountProvided - $totalCost;
  }

  /**
   * Obtains an array of count and type of currency corresponding to given dollar amount.
   * @param float $amount Amount
   * @param ManagerRegistry $managerRegistry ManagerRegistry object
   * @return array An array of count and currency
   */
  private static function getDenominations(float $amount, ManagerRegistry $managerRegistry): array{
    $currencyRepository = $managerRegistry->getRepository(\App\Entity\Currency::class);
    $aCurrency = $currencyRepository->findBy(['is_active' => true], ['amount' => 'DESC']);
    return Denomination::getDenominations($amount, $aCurrency);
  }

  /**
   * Obtain currency value corresponding to given param name and Request object.
   *
   * @param string $paramName Param name
   *     Example: total_cost
   * @param Request $request Request object
   *     Example; $symfonyRequest->getRequestUri() =
   *         http://localhost:8000/api/cash_register/?total_cost=87.66&amount_provided=100.00
   * @return float currency value
   *     Example: 87.66
   * @throws \Exception Throws an exception if the given currency value is not numeric or exceeds supported precision.
   */
  private static function getValidatedCurrency(string $paramName, Request $request): float
  {
    try {
      return CurrencyValidator::validate($request->get($paramName));
    } catch (\Exception $e) {
      throw new \Exception("Error on value for paramName = '" . $paramName . "':  " . $e->getMessage());
    }
  }

}