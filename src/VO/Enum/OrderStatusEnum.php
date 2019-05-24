<?php
/**
 * Created by PhpStorm.
 * User: thedavis
 * Date: 23/05/19
 * Time: 18:40
 */

namespace App\VO\Enum;


class OrderStatusEnum
{
    const PENDING_CONFIRMATION = "Pending Confirmation";
    const CONFIRMED = "Confirmed";
    const SENT_WAREHOUSE = "Sent to Warehouse";
    const SHIPPED = "Shipped";
    const IN_TRANSIT = "In Transit";
    const DELIVERED = "Delivered";
}