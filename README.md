# Test

This is a Microservice called “Order Service”.

## Start & Stop environment 
```
$ docker-compose up -d

$ docker-compose stop
```

## Install vendors
```
$ docker-compose exec php composer install
```

## Create database
```
$ docker-compose exec php bin/console doctrine:mongodb:schema:create
```

## Run tests

```
$ docker-compose exec php ./bin/phpunit
```

## Example

### Create Order

```
POST /

Payload: 

{
	"order_id": 460,
	"status": "Pending Confirmation",
	"amount": 385,
	"lines": [
		{
			"sku": "sku-1",
			"price": 1,
			"quantity": 1
		},
		{
			"sku": "sku-2",
			"price": 10,
			"quantity": 5
		}
	],
	"shipping_address": "address",
	"billing_address": "address"
}
```

### Get Order

```
GET /460

Response:

{
    "status": "ok",
    "data": {
        "order_id": 460,
        "status": "Pending Confirmation",
        "amount": 850,
        "lines": [
            {
                "sku": "sku-1",
                "price": 1,
                "quantity": 1
            },
            {
                "sku": "sku-2",
                "price": 10,
                "quantity": 5
            }
        ],
        "shipping_address": "address",
        "billing_address": "address"
    }
}
```

### Update Order

```
PUT /460

Payload: 
{	
	"status": "Shipped",
}

Response:
{
    "status": "ok",
    "message": ""
}


** Check /var/log/dev.log for see the Order Status Event fired. ( app.INFO: Order status updated [] [] )

```

## TODO

- Input validations
- Method PUT only updates the status of the Order. Should allow update other Order data like Lines
- OrderId should be auto-generated? That depends of who has this responsability. I assumed the OrderId comes from the client of this service.
- Create address shipping and billing as Collections and threat with DTOs and VOs (email, street, name...)
- Create Repository for extract this responsability from the OrderService
- Tests over OrderService (unit and functional)
