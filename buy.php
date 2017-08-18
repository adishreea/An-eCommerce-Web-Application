<!DOCTYPE html>
<html>
    <head>
        <style>
            table { border-collapse: collapse;
            } 
            table, th, td {
                border: 1px solid black;
            } 
        </style>
        <title>Buy Products</title>
    </head>
    <body>
        <?php   
            session_start();  
        ?>
        <div> 
            <p>Shopping Basket:</p>
            <table border=1>
                <?php  
                    if(isset($_SESSION['cart']))
                    { 
                        foreach($_SESSION['cart'] as $ke=>$val)
                        {    
                ?>	
                <tr>
                    <td>   
                        <?php 
                            echo '<img src="'.$val['img'].'" width="60" height="60" alt="word" />'
                        ?>
                    </td>
                    <td><?=$val['name']?></td>
                    <td><?=$val['min']?></td>
                    <td><a href="buy.php?delete=<?=$val['id']?>">remove</a></td>
                </tr>
                <?php    
                        } 
                    }
                    if(isset($_GET['buy']))
                    { 
                        foreach($_SESSION['hist'] as $key=>$value)
                        {  
                            if($_GET['buy'] == $value['id'])
                            { 
                                $_SESSION['cart'][$key]['id'] = $value['id'];
                                $_SESSION['cart'][$key]['name'] = $value['name'];
                                $_SESSION['cart'][$key]['min'] = $value['min'];
                                $_SESSION['cart'][$key]['img'] = $value['img'];
                                $_SESSION['total'] = $_SESSION['total'] + $value['min'];   		  
                            } 
                        } 
                        header('Refresh: 0; url=buy.php');
                    } 
                    else if(isset($_GET['clear']))
                    {
                        if($_GET['clear'] == 1)
                        {   
                            unset($_SESSION['cart']);
                            unset($_SESSION['total']);
                        } 
                        header('Refresh: 0; url=buy.php');	
                    } 
                    else if(isset($_GET['delete']))
                    {
                        foreach($_SESSION['cart'] as $k=>$v)
                        { 
                            if($_GET['delete'] == $v['id'])
                            { 
                                $_SESSION['total'] = $_SESSION['total'] - $v['min'];
                                unset($_SESSION['cart'][$k]);
                            } 
                        }
                        header('Refresh: 0; url=buy.php');	
                    } 
                ?>
            </table> 
            <p/>Total: 
                <?php  
                    if(isset($_SESSION['total']))
                    {  
                        echo $_SESSION['total'];
                    } 
                    else
                    {   
                        echo 0;  }  ?>  
            $<p/>
            <form action="buy.php" method="GET">
                <input type="hidden" name="clear" value="1"/>
                <input type="submit" value="Empty Basket"/>
            </form> 
            <p/>
                <form action="buy.php" method="GET" align="center">
                    <fieldset>
                        <legend>Find products:</legend>
                        <label>Category: 
                            <select name="category">
                                <?php  
                                    error_reporting(E_ALL);
                                    ini_set('display_errors','On');
                                    $xmlcat = file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/CategoryTree?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId=72&showAllDescendants=true');
                                    $xmlc = new SimpleXMLElement($xmlcat);
                                ?>
                                <option value= <?php echo $xmlc->category['id'];?> >
                                                <?php echo $xmlc->category->name;?>
                                </option>
                                <?php 
                                    foreach($xmlc->category->categories->category as $c)
                                    { 
                                ?>
                                        <option value= <?php echo $c['id']?> >
                                            <?php echo $c->name;?>
                                        </option>
                                <?php  
                                        foreach($c->categories->category as $sc)
                                        {	
                                ?>
                                            <option value= <?php echo $sc['id']?> >
                                                <?php echo $sc->name;?>
                                            </option>
                                <?php	
                                        }
                                    } 
                                ?>
                            </select>	
                        </label> &emsp; &emsp; &emsp; &emsp;
                        <label>Search keywords: 
                            <input type="text" name="search"/>
                        </label>
                        <input type="submit" value="Search"/>
                    </fieldset>
            </form>	
            <p/>
        </div>
        <div>
            <table> 
                <?php
                    if(isset($_GET['search'])&&isset($_GET['category']))
                    {  
                        error_reporting(E_ALL);
                        ini_set('display_errors','On');
                        $searchname = $_GET['search'];
                        $catname = $_GET['category'];
                        $searchname = str_replace(' ', '+', $searchname);
                        $xmlstr = file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&trackingId=7000610&categoryId='.$catname.'&keyword='.$searchname.'&numItems=20');
                        $xml = new SimpleXMLElement($xmlstr);
                        foreach($xml->categories->category->items->product as $b)
                        {  
                            $key = 'key'.(string)$b['id'];
                            $ids =  (string)$b['id'];
                            $na =   (string) $b->name;
                            $pri = intval($b->minPrice);
                            $im  = (string)$b->images->image->sourceURL;
                            $ofu = (string) $b->productOffersURL;
                            $_SESSION['hist'][$key]['id'] = $ids;
                            $_SESSION['hist'][$key]['name'] = $na;
                            $_SESSION['hist'][$key]['min'] = $pri;
                            $_SESSION['hist'][$key]['img'] = $im;
                            $_SESSION['hist'][$key]['off'] = $ofu;
                ?>
                            <tr>
                                <td>
                                    <a href="buy.php?buy= <?php echo $b['id'] ?>" >
                                        <?php 
                                            echo '<img src="'.$b->images->image->sourceURL.'" width="60" height="60" alt="word" />'
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $b->name;?>
                                </td>	
                                <td>
                                    <?php echo $b->minPrice?>
                                </td>
                                <td>
                                    <?php echo $b->fullDescription?>
                                </td>
                            </tr>
                    <?php 
                            } 
                        } 
                    ?>
            </table>
        </div>
    </body>
</html>