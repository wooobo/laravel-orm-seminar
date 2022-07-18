INSERT INTO example_app.categories (id, name, created_at, updated_at) VALUES (1, '의류', DEFAULT, DEFAULT);
INSERT INTO example_app.categories (id, name, created_at, updated_at) VALUES (2, '식품', DEFAULT, DEFAULT);
INSERT INTO example_app.products (id, name, price, created_at, updated_at, category_id) VALUES (1, '티셔츠', 1000, DEFAULT, DEFAULT, 1);
INSERT INTO example_app.products (id, name, price, created_at, updated_at, category_id) VALUES (2, '바지', 15000, DEFAULT, DEFAULT, 1);
INSERT INTO example_app.products (id, name, price, created_at, updated_at, category_id) VALUES (3, '도시락', 3500, DEFAULT, DEFAULT, 2);
INSERT INTO example_app.products (id, name, price, created_at, updated_at, category_id) VALUES (4, '양말', 1000, DEFAULT, DEFAULT, 1);
