# An-eCommerce-Web-Application
Search and display product results returned as XML on eBay, and query the XML data using XPath and XSLT.

A plain Java program xpath.java that reads some search keywords from input, searches the eBay API for items in the category with id=72 (the computers category) that match these keywords, and displays information about these products by evaluating the following XPath queries over the returned XML data:
1.	Print the full description of all products that have a rating 4.50 or higher.
2.	Print the name and the minimum price of all products whose name contains the word Sony.
3.	Print the names of all products whose name contains the word Sony and the price is between $1000 and $2000, inclusive.

An XSLT program search.xsl to display the search results by transforming the XML result to XHTML using XSLT that contains the components you generated for the search results in Project #3: the id, sourceURL, name, minPrice, and fullDescription. Use the Java program xslt.java to test the XSLT file and then load the resulting html output file on the web browser.
