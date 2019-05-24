<?php

namespace App\Services;

use App\Document\Order;
use App\Document\OrderLine;
use App\DTO\OrderDTO;
use App\Events\OrderEvent;
use App\Listeners\OrderStatusListener;
use App\Repository\RateRepository;
use App\VO\OrderStatusVO;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class OrderService {

    private $dm;
    private $logger;

    public function __construct(DocumentManager $dm, LoggerInterface $logger)
    {
        $this->dm = $dm;
        $this->logger = $logger;
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

            // init event dispatcher
            $dispatcher = new EventDispatcher();

            // register listener for the 'order.event' event
            $listener = new OrderStatusListener($this->logger);
            $dispatcher->addListener('order.event', array($listener, 'onStatusChangeEvent'));

            // dispatch
            $dispatcher->dispatch(OrderEvent::NAME, new OrderEvent());

            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }


}