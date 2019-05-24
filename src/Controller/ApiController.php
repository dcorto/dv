<?php

namespace App\Controller;

use App\Document\Order;
use App\Document\OrderLine;
use App\DTO\OrderDTO;
use App\Services\OrderService;
use App\VO\Enum\OrderStatusEnum;
use App\VO\OrderStatusVO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;


/**
 * Controller used to manage API
 *
 * @Route("/")
 *
 */
class ApiController extends AbstractController
{
    protected $orderService;
    private $dm;

    public function __construct(OrderService $orderService, DocumentManager $dm)
    {
        $this->orderService = $orderService;
        $this->dm = $dm;
    }

    /**
     * @Route("/wtf", methods={"GET"}, name="wtf")
     * @return Response
     */
    public function wtf(): Response
    {




        $line = new OrderLine();
        $line->setPrice(1);
        $line->setSku("WTF");
        $line->setQuantity(1);

        $order = new Order();
        $order->setStatus(new OrderStatusVO(OrderStatusEnum::PENDING_CONFIRMATION));
        $order->setAmount(rand(1,1000));
        $order->addLine($line);


        $this->dm->persist($order);
        $this->dm->flush();

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="order_get")
     * @param string $id
     * @return Response
     */
    public function orderGet(string $id): Response
    {
        $order_data = $this->orderService->get($id)->toArray();

        return new JsonResponse(
           [
               'status' => 'ok',
               'data' => $order_data

           ],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="order_update")
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function orderUpdate(Request $request, string $id): Response
    {

        try {

            $data = json_decode(
                $request->getContent(),
                true
            );

            $status = new OrderStatusVO($data['status']);

            $result = $this->orderService->update($id, $status); //Use DTO for update the service.

            if($result) {   //TODO: Refactor for use Action Object from service for avoid this logic.
                return new JsonResponse(
                    [
                        'status' => 'ok',
                        'message' => '',
                    ],
                    JsonResponse::HTTP_OK
                );
            }
            else {
                return new JsonResponse(
                    [
                        'status' => 'error',
                        'message' => 'message of the error',
                    ],
                    JsonResponse::HTTP_OK
                );
            }

        } catch (\Exception $e) {

            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    /**
     * @Route("/", methods={"POST"}, name="order_create")
     * @param Request $request
     * @return Response
     */
    public function exchangeCreate(Request $request): Response
    {

        try {

            $data = json_decode(
                $request->getContent(),
                true
            );

            $orderDTO = new OrderDTO($data);

            $result = $this->orderService->create($orderDTO); //Use DTO for update the service.

            if($result) {   //TODO: Refactor for use Action Object from service for avoid this logic.
                return new JsonResponse(
                    [
                        'status' => 'ok',
                        'message' => '',
                    ],
                    JsonResponse::HTTP_CREATED
                );
            }
            else {
                return new JsonResponse(
                    [
                        'status' => 'error',
                        'message' => 'message of the error',
                    ],
                    JsonResponse::HTTP_CREATED
                );
            }

        } catch (\Exception $e) {

            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }
}