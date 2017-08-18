package xpath;
import javax.xml.parsers.*;
import org.w3c.dom.*;
import javax.xml.transform.*;
import javax.xml.transform.dom.*;
import javax.xml.transform.stream.*;
import java.io.*;
class ReadXMLFile 
{
    public static void main ( String argv[] ) throws Exception 
    {	
        File stylesheet = new File("search.xsl");
        File xmlfile  = new File("sample.xml");
        DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
        DocumentBuilder db = dbf.newDocumentBuilder();
        Document document = db.parse(xmlfile);
        StreamSource stylesource = new StreamSource(stylesheet);
        TransformerFactory tf = TransformerFactory.newInstance();
        Transformer transformer = tf.newTransformer(stylesource);
        DOMSource source = new DOMSource(document);
        FileOutputStream fos = new FileOutputStream(new File("xsltOutput.html"));
        StreamResult result = new StreamResult(fos);
        transformer.transform(source,result); 
    }
}