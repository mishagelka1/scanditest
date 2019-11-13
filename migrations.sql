CREATE TABLE products(
    sku char(8) PRIMARY KEY NOT NULL,
    name varchar(30) NOT NULL,
    price decimal(10,2) NOT NULL,
    type char(1) NOT NULL
    );
CREATE TABLE dvd_attr(
    sku_d char(8) PRIMARY KEY NOT NULL,
    size decimal(10,2) NOT NULL,
    FOREIGN KEY (sku_d) REFERENCES products(sku)
    );
CREATE TABLE book_attr(
    sku_b char(8) PRIMARY KEY NOT NULL,
    weight decimal(10,2) NOT NULL,
    FOREIGN KEY (sku_b) REFERENCES products(sku)
    );
CREATE TABLE furniture_attr(
    sku_f char(8) PRIMARY KEY NOT NULL,
    h decimal(5,2) NOT NULL,
    w decimal(5,2) NOT NULL,
    l decimal(5,2) NOT NULL,
    FOREIGN KEY (sku_f) REFERENCES products(sku)
    )

/*
CREATE TABLE products(
    sku char(8) PRIMARY KEY NOT NULL,
    name varchar(30) NOT NULL,
    price decimal(10,2) NOT NULL,
    type char(1) NOT NULL
    );
CREATE TABLE dvd_attr(
    sku char(8) PRIMARY KEY NOT NULL,
    size decimal(10,2) NOT NULL,
    FOREIGN KEY (sku) REFERENCES products(sku)
    );
CREATE TABLE book_attr(
    sku_b char(8) PRIMARY KEY NOT NULL,
    weight decimal(10,2) NOT NULL,
    FOREIGN KEY (sku) REFERENCES products(sku)
    );
CREATE TABLE furniture_attr(
    sku char(8) PRIMARY KEY NOT NULL,
    h decimal(5,2) NOT NULL,
    w decimal(5,2) NOT NULL,
    l decimal(5,2) NOT NULL,
    FOREIGN KEY (sku) REFERENCES products(sku)
    )
*/





/* Select elements for output:
"SELECT products.*, dvd_attr.*, book_attr.*, furniture_attr.* FROM products
LEFT OUTER JOIN dvd_attr ON products.sku = dvd_attr.sku
LEFT OUTER JOIN book_attr ON products.sku = book_attr.sku
LEFT OUTER JOIN furniture_attr ON products.sku = furniture_attr.sku";
*/