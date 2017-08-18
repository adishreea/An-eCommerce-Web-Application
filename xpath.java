package xpath;
import java.io.*;
import javax.xml.parsers.*;
import org.w3c.dom.*;
import java.net.URL;
import java.util.Scanner;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import javax.xml.xpath.XPath;
import javax.xml.xpath.XPathConstants;
import javax.xml.xpath.XPathFactory;
public class XPATH {
    static void print(Node e) 
    {
        if (e instanceof Text) {
            System.out.print(((Text) e).getData());
        } 
        else {
            NodeList c = e.getChildNodes();
            System.out.print("<" + e.getNodeName());
            NamedNodeMap attributes = e.getAttributes();
            for (int i = 0; i < attributes.getLength(); i++) {
                System.out.print(" " + attributes.item(i).getNodeName()
                        + "=\"" + attributes.item(i).getNodeValue() + "\"");
            }    
            System.out.print(">");
            for (int k = 0; k < c.getLength(); k++) {
                print(c.item(k));
            }
            System.out.print("</" + e.getNodeName() + ">");
        }
    }
    static void eval(String query, String document) throws Exception {
        XPathFactory xpathFactory = XPathFactory.newInstance();
        XPath xpath = xpathFactory.newXPath();
        Document doc = DocumentBuilderFactory.newInstance().newDocumentBuilder().parse(document);
        NodeList result = (NodeList) xpath.evaluate(query, doc, XPathConstants.NODESET);
        System.out.println("XPath query: " + query);
        for (int i = 0; i < result.getLength(); i++) {
            print(result.item(i));
        }    
        System.out.println();    
    }
    public static void print1(Document doc, OutputStream out) 
    {        
        try {
            Transformer transformer = TransformerFactory.newInstance().newTransformer();
            transformer.transform(new DOMSource(doc), new StreamResult(new OutputStreamWriter(out)));
        } 
        catch (Exception ex) {
            System.out.println(ex.getMessage());   
        }
    }
    public static void main(String args[]) throws Exception 
    {    
        DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
        DocumentBuilder db = dbf.newDocumentBuilder();
        Scanner scr = new Scanner(System.in);
        System.out.println("Enter keyword:  ");
        String keyword = scr.nextLine();
        Document doc = db.parse((new URL("http://sandbox.api.shopping.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId=72&keyword=" + keyword + "")).openStream());
        FileOutputStream fos = new FileOutputStream(new File("output.xml"));
        print1(doc, fos);      eval("//categories/category/items/offer[store/ratingInfo/rating>4.0]/description", "output.xml");
        eval("//categories/category/items/product[contains(name,'Sony')]/minPrice | //categories/category/items/product[contains(name,'Sony')]/name", "output.xml");
        eval("//categories/category/items/product[contains(name,'Sony') and minPrice>=10 and minPrice<=20000 ]/name", "output.xml");
    }	
}