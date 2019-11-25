 <!--
 Some features not finished:
 
 - Somehow the "view products" webpage puts the "select" and two "button" elements a lot to the right, but it is still visible a bit. Once you press it, it comes to the right place.
 
 - I did not manage to do the JS validation for the fields that are empty, so nothing happens if the user presses the button "submit" with an empty input fields.
 
 - I was trying to output php validation error messages with the $_SESSION variable, but I did not succseed, so it is just echoed. 
 
 - The "select" element in the "view" page does not quite work correctly, because it has the "onchange" attribute. In order to uncheck the checkboxes that you've just checked, you have to choose any other options
 
 - I did not manage to write a proper borderColor change validation for dynamically created input fields in the "add" page.

 Notes:
 
 - I decided not to use jQuery and Bootstrap to get familiar with the plain JS and CSS. From now on, I believe I got used to the basics of them and can try to use jQuery and Bootstrap. 
 
 - I am still not sure, wether using the exceptions for php validation errorMessages is a good idea, but at least I know how "include" and "namespace" work. Also, unfortunately, I did not manage to write a validation function to a "furniture" attributes.
 
 - On delete cascade did not work with my SQL, so I made a twisted way to distinguish the products by their types and create separate delete queries for them.
 -->
