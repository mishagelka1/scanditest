<?php

// here are messages for custom exceptions for extra php validation

namespace sku {
    class characterAmount extends \Exception {
        public function errorMessage() {
            return "SKU must be exactly 8 characters long!";
        }
    }
    class correctSymbols extends \Exception {
        public function errorMessage() {
            return "You must use only letters or numbers!";
        }
    }
}


namespace name {
    class characterAmount extends \Exception {
        public function errorMessage() {
            return "Name is less than 30 characters long!";
        }
    }
}

namespace price {
    class correctSymbols extends \Exception {
        public function errorMessage() {
            return "Price is a decimal number and cannot be longer than 10 symbols!";
        }
    }
}


namespace productType {
    class isEmpty extends \Exception {
        public function errorMessage() {
            return "Product type cannot be empty!";
        }
    }
}

namespace size {
    class correctSymbols extends \Exception {
        public function errorMessage() {
            return "Size is a decimal number and cannot be longer than 10 symbols!";
        }
    }
}

namespace weight {
    class correctSymbols extends \Exception {
        public function errorMessage() {
            return "Weight is a decimal number and cannot be longer than 10 symbols!";
        }
    }
}
?>