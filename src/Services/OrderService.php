<?php

namespace App\Services;

use App\Document\Order;
use App\Document\OrderLine;
use App\DTO\OrderDTO;
use App\Repository\RateRepository;
use App\VO\OrderStatusVO;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;

class OrderService {

    private $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function get($orderId)
    {
        //TODO: move to repository
        $items = $this->dm->getRepository(Order::class)->findBy(
            ['order_id' => (int) $orderId]
        );

        if($items) {
            return new OrderDTO($items[0]->toArray());
        }
        else
        {
            return false;
        }
    }

    public function create(OrderDTO $orderDTO)
    {
        try {
            $entity = new Order();
            $entity->setOrderId($orderDTO->getOrderId());
            $entity->setAmount($orderDTO->getAmount());
            $entity->setStatus(new OrderStatusVO($orderDTO->getStatus()));
            $entity->setBillingAddres($orderDTO->getBillingAddress());
            $entity->setShippingAddress($orderDTO->getShippingAddress());

            foreach($orderDTO->getLines() as $line){
                $entityLine = new OrderLine();
                $entityLine->setPrice($line->getPrice());
                $entityLine->setSku($line->getSku());
                $entityLine->setQuantity($line->getQuantity());

                $entity->addLine($entityLine);
            }

            $this->dm->persist($entity);
            $this->dm->flush();

            return $entity->getOrderId();
        }
        catch (\Exception $e){
            return false;
        }
    }

    public function update($orderId, OrderStatusVO $status)
    {

        //TODO: move to repository
        $items = $this->dm->getRepository(Order::class)->findBy(
            ['order_id' => (int) $orderId]
        );

        //TODO: validate
        try {

            $items[0]->setStatus($status);

            //TODO: move to repository
            $this->dm->persist($items[0]);
            $this->dm->flush();
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }


}