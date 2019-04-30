# P2P-Exchange-Server
This server will allow the advanced client to connect and get trading date

Create a New User

https://www.cloudcoin.exchange/api/users/create.php/?ticket=cb9db1c1b622bebde6ae7958c924f1fc9c7dec24cc00&raida=0&email=username@email.com&username=usernamevalue


Create a New Sell Order 


https://www.cloudcoin.exchange/api/sellorder/create.php/?raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&qty=25000&price=0.035&currency=AUD&paymentmethod=Paypal

Creates a New Buy Order

https://www.cloudcoin.exchange/api/buyorder/create.php/?raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&qty=25000&price=0.035&currency=AUD&paymentmethod=Paypal&sellorderid=1

Sell Order id is the ID of the order against which buy order is being placed. if its not put against any particular sell order, then sellorderid can be left out.

Get Sell Orders List

https://www.cloudcoin.exchange/api/sellorder/list.php/?offset=0&pagesize=10&opt=all&raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00

Lists the Sell orders with offset and pagesizes. By defalt it shows sell orders posted by the current user.
If the optional parameter opt=all is used then it shows all the sell orders. The list is given in descending orders of sell orders timestamp.

Get Buy Orders List

https://www.cloudcoin.exchange/api/buyorder/list.php/?offset=0&pagesize=10&opt=all&raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00

Lists the Buy orders with offset and pagesizes. By defalt it shows buy orders posted by the current user.
If the optional parameter opt=all is used then it shows all the buy orders. The list is given in descending orders of buy orders timestamp.


Delete Sell Order

https://www.cloudcoin.exchange/api/sellorder/delete.php/?opt=all&raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&id=101

A sell order can only be deleted if its in Open state. That means if a transaction has not been executed against the sell order it can be deleted. you can pass the id parameter to delete a sell order.

Delete Buy Order

https://www.cloudcoin.exchange/api/buyorder/delete.php/?opt=all&raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&id=101

A byu order can only be deleted if its in Open state. That means if a transaction has not been executed against the buy order it can be deleted. you can pass the id parameter to delete a buy order.

Post a Transaction

https://www.cloudcoin.exchange/api/transaction/post.php/?raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&qty=25000&price=0.035&currency=AUD&paymentmethod=Paypal&sellorderid=1&buyorderid=2&buyerid=1&sellerid=2&buyercomment=buyercomment&sellercomment=sellercomment&buyerrating=3.0&sellerrating=4.0&transactionno=trnno&recieptno=recno


Rate a Transaction

https://www.cloudcoin.exchange/api/transaction/post.php/?raida=0&ticket=6511a0cbb4c3d6576d62c8a51dc532187be49b5d0b00&rating=4.0&comment=comment

Rate a transaction after its posted. It can be used for both seller and buyer. there is no need for separate parameters for buyer rating and seller rating. Same goes for buyer comment and seller comments.







