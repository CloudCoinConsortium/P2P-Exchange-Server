# P2P-Exchange-Server
This server will allow the advanced client to connect and get trading data.

[Create a New User](README.md#create-a-new-user)
[Create a New Sell Order](README.md#create-a-new-sell-order)
[Create a New Buy Order](README.md#create-a-new-buy-order)
[List Buy Orders](README.md#list-buy-orders)
[List Sell Orders](README.md#list-sell-orders)
[Delete Buy Order](README.md#delete-buy-order)
[Delete Sell Order](README.md#delete-sell-order)
[Post a Transaction](README.md#post-a-transaction)
[List Transactions](README.md#list-a-transaction)
[Rate a Transaction](README.md#rate-a-transaction)


## Create a New User
This service allows a user to create or update their information. 
The ticket and RAIDA number are required to allow the user to establish their identity. The email and username is not required. 

Sample Get Request
```html
https://www.cloudcoin.exchange/api/users/create.php/?ticket=cb9db1c1b622bebde6ae7958c924f1fc9c7dec24cc00&raida=0&email=username@email.com&username=usernamevalue

```
## Create a New Sell Order 
Advertises to others that the user wants to sell CloudCoins.

qty: How many cloudcoins the user wants to sell. 

price: the price in the currency specified

currence: Which currency the person has listed the price in. 

Payment Method: May be many payment methods seperated by commas. 

url: The location of the sales page that the seller is using (usually their local machine)

```html
https://www.cloudcoin.exchange/api/sellorder/create.php/?raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&qty=25000&price=0.035&currency=AUD&paymentmethod=Paypal&url=http%3A%2F%2Fmyserver.com%2Findex.html%0D%0A
```

## Create New Buy Order
Allows the user to advertise their willingness to buy. 

Sell Order id is the ID of the order against which buy order is being placed. if its not put against any particular sell order, then sellorderid can be left out.

```html
https://www.cloudcoin.exchange/api/buyorder/create.php/?raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&qty=25000&price=0.035&currency=AUD&paymentmethod=Paypal&sellorderid=1
```


## List Sell Orders
Lists the Sell orders with offset and pagesizes. By defalt it shows sell orders posted by the current user.
If the optional parameter opt=all is used then it shows all the sell orders. The list is given in descending orders of sell orders timestamp.

```html
https://www.cloudcoin.exchange/api/sellorder/list.php/?offset=0&pagesize=10&opt=all&raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00
```


## List Buy Orders
Lists the Buy orders with offset and pagesizes. By defalt it shows buy orders posted by the current user.
If the optional parameter opt=all is used then it shows all the buy orders. The list is given in descending orders of buy orders timestamp.

```html
https://www.cloudcoin.exchange/api/buyorder/list.php/?offset=0&pagesize=10&opt=all&raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00
```



## Delete Sell Order
Allows user to delete their sell order. 
A sell order can only be deleted if its in Open state. That means if a transaction has not been executed against the sell order it can be deleted. you can pass the id parameter to delete a sell order.
```html
https://www.cloudcoin.exchange/api/sellorder/delete.php/?opt=all&raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&id=101
```


## Delete Buy Order
A byu order can only be deleted if its in Open state. That means if a transaction has not been executed against the buy order it can be deleted. you can pass the id parameter to delete a buy order.

```html
https://www.cloudcoin.exchange/api/buyorder/delete.php/?opt=all&raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&id=101
```

## Post a Transaction
This will be plugged into the sellers webpage on their webserver. When someone buys, the page will post the transaction. 
```html
https://www.cloudcoin.exchange/api/transaction/post.php/?raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&qty=25000&price=0.035&currency=AUD&paymentmethod=Paypal&sellorderid=1&buyorderid=2&buyerid=1&sellerid=2&buyercomment=buyercomment&sellercomment=sellercomment&buyerrating=3.0&sellerrating=4.0&transactionno=trnno&recieptno=recno
```

## List Transactions
The user can sell all the transactions that happened recently so that they can be rated by the people involved. 

```html
https://www.cloudcoin.exchange/api/transaction/list.php/?raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00
```


## Rate a Transaction

Rate a transaction after its posted. It can be used for both seller and buyer. there is no need for separate parameters for buyer rating and seller rating. Same goes for buyer comment and seller comments.

```html
https://www.cloudcoin.exchange/api/transaction/post.php/?raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&rating=4.0&comment=comment
```








