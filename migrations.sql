CREATE TABLE products (
    sku varchar(20) PRIMARY KEY NOT NULL,
    name varchar(30) NOT NULL,
    price decimal(10,2) NOT NULL	
    );
    
CREATE TABLE dvd_attr (
    sku_disc varchar(20) PRIMARY KEY NOT NULL,
    size int NOT NULL,
    FOREIGN KEY (sku_disc) REFERENCES products (sku)
    );
    
CREATE TABLE book_attr (
    sku_book varchar(20) PRIMARY KEY NOT NULL,
    weight int NOT NULL,
    FOREIGN KEY (sku_book) REFERENCES products (sku)
    );
    
CREATE TABLE furniture_attr (
    sku_furniture varchar(20) PRIMARY KEY NOT NULL,
    dimensions varchar(30) NOT NULL,
    FOREIGN KEY (sku_furniture) REFERENCES products (sku)
    );