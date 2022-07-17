select * from products where category_id = 1;

select *
from products join categories c on c.id = products.category_id;


INSERT INTO example_app.products (id, name, price, category_id) VALUES (2, '바지', 15000, 1)
