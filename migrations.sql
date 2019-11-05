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
    sku char(8) PRIMARY KEY NOT NULL,
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