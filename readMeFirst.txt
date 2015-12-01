This currency calculator was created in order to work dynamically.
The admin has to add only the new currency and only one exchange rate relation
with an existing currency. So the main aspect was to find every time the 
correct path that a base currency leads to a target currency, calculate the total 
exhange rate of the path and calculate the final value of the target currency.
So, this app is based in creation of a Tree that is full of currency objects. 



In order to run this currency calculator app, you should have in mind that:

- The input currency and exchange rates arrays 
  are in InteractiveData\mvc\model\inputDynamicArrays file and 
  they have the following format:
		
		$curencies_dynamic_array      = array(
		                                      "EUR"=>"Euro",
       		                                  "USD"=>"US Dollar",
											  "SWF"=>"Swiss Franc", "BRP"=>"British Pound",
											  "JPY"=>"Japanese Yen", "CAD"=>"Canadian Dollar"
											  );

		$exchange_rates_dynamic_array = array(
											  "EUR2USD"=>1.3764, "EUR2SWF"=>1.2079,
											  "EUR2BRP"=>0.8731, "USD2JPY"=>76.7200,
											  "SWF2USD"=>1.1379, "BRP2CAD"=>1.5648
											  );
											  
							
- The file of currency calculator app is the 
  InteractiveData\mvc\controller\currency_calculator_controller.php
  
- I tried to use MVC concept and so there is a 
	*model folder: Classes and input data
	*view folder: view of main page, css, javascript
	*controller folder: main app controller, functions
  
- I used Notepad++ as an editor and WAMP as a server


***For any further information do not hesitate to contact me