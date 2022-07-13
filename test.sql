select * from products where category_id = 1;

select *
from products join categories c on c.id = products.category_id;
