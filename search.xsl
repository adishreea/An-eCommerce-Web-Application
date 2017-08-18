<?xml version="1.0"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <head>  
                <style>
                    table{
                        border-collapse : collapse;
                    }  
                    td,th{
                        width: 1000px;  
                    }
                </style>  
            </head>
            <body>
                <table border="1" style="width:100%">
                    <thead>  
                        <th>Id</th>
                        <th>Source Url</th>
                        <th>Name</th>
                        <th>Minimum Price</th>
                        <th>Full Description</th>
                    </thead>  
                    <tbody>
                        <xsl:for-each select="GeneralSearchResponse/categories/category/items/product">
                            <tr> 
                                <td><xsl:value-of select="@id"/></td>
                                <td><xsl:value-of select="images/image/sourceURL"/></td>
                                <td><xsl:value-of select="name"/></td>
                                <td><xsl:value-of select="minPrice"/></td>
                                <td><xsl:value-of select="fullDescription"/></td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>