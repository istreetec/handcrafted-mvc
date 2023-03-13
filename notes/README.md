#### Database Transactions

1. Banking Transaction Example::

- A sequence of one or more SQL statements or operations that are treated as 
a whole/unit.

- E.g. transfering from Checkings Account to Savings Account
    * query to decrease checkings account balance
    * query to increase savings account balance
    * query to log the activity in a transfers/transactions table


- That is

`$ update checkings_accounts 
set balance = balance - 2000 
where account_number = '3673723001';`

`
$ update savings_accounts
set balance = balance + 2000
where account_number = '3673723002';
`

`
$ insert into transfers ('from_acc', 'to_acc', 'amount', 'date')
values ('3673723001', '3673723002', 2000, NOW());
`


- Begin Transaction then and only then after all queries have executed
without any failing, you commit the transaction.

- In case a single query fails, the entire transaction should be rolled back
without effecting the tables.


2. Signup/Subscription Form Example ::

- After signup user is registered being inserted a record into users table.
- Another query inserts into subscriptions table thus adding them into mailing list.
- Another query logs this activity into a transaction_logs table for easier tracking
- An invoice is created if that was the reason the user signed up.

InnoDB(Default SQL Engine) and MyISAM are common SQL Database Engines.

- InnoDB supports FK and Transactions whilst MyISAM doesn't.
- InnoDB does row-level locking while MyISAM does table-level locking

