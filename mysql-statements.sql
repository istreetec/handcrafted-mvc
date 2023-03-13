create database my_db;

use my_db;

drop table users;

create table users(
	id int unsigned primary key auto_increment,
    email varchar(255) not null,
    full_name varchar(255) not null,
    is_active boolean default 0 not null,
    created_at datetime not null,
    
    -- set is active as index
    key `is_active`(`is_active`),
    
    -- no duplicate email addresses
    unique key `email`(`email`)
);

describe users;

-- change something on the table
alter table users add column foo varchar(150), 
drop column is_active, 
modify full_name varchar(100);

-- Add data into the table
insert into users (email, full_name, is_active, created_at) 
values('will@smith.com', 'Will Smith', 0, NOW()), ('jane@doe.com', 'Jane Doe', 1, NOW());

-- fetch data from a table
select * from users;

select id, email 
from users 
where id >= 1 and email like '%doe%'
order by created_at desc;

-- change existing records
update users
set is_active = 0
where id = 1;

-- remove existing records
delete from users
where id = 3;


-- Relationships and foreign keys
create table invoices(
	id int unsigned primary key auto_increment,
    
    -- 10 digit value but with 4 decimal places
    amount decimal(10, 4),
    
    -- FK type must match the related key on parent table.
    -- on delete set null i.e. when a user is deleted the invoice record should remail
    -- on update cascade i.e. when a user is updated their invoices should be updated as well
    user_id int unsigned,
    foreign key (user_id) references users(id)
    on delete set null
    on update cascade
);

-- insert into a table which has relations.
-- e.g. a user with many invoices
insert into invoices (amount, user_id)
values (536.50, 1), (350.40, 1), (115, 1);

select * from invoices;

-- join other tables to get information from them 
-- e.g. resolve full_name on invoices table

-- INNER JOIN;;
-- Returns rows where there is a match in both of the tables i.e. users and invoices tables.

-- LEFT JOIN;;
-- Returns records from the left table even when there are no matches on the right table

-- RIGHT JOIN
-- Returns rows from the right table even when there are no matches on the left table

-- NB:: Specify conflicting columns by prefixing with table name
select invoices.id, amount, full_name
from invoices
inner join users on users.id = user_id
where amount <= 150;
