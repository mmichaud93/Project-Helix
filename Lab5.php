<?php
// This document includes an HTML form and associated PHP script in one file.
// The PHP script tests whether the form has been submitted.
//	- if yes, it processes the posted values;
//  - if not, it displays the form.
//
// NB this method does not rely on the user completing the form correctly

// Print HTML header

print '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Simple HTML form</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>

  <body>';

// PHP script

// Check if post variable 'done' has a value
$widgets_total=0;
$gadgets_total=0;
$wotsits_total=0;
$dongles_total=0;
if (isset($_POST['submit'])) {

// if yes, print table with updated values
    if(isset($_POST["widgets"])){
        $widgets_total += $_POST["widgets"]; 
    }else{$widgets_total=0;}
    if(isset($_POST["gadgets"])){
        $gadgets_total += $_POST["gadgets"]; 
    }else{$gadgets_total=0;}
    if(isset($_POST["wotsits"])){
        $wotsits_total += $_POST["wotsits"]; 
    }else{$wotsits_total=0;}
    if(isset($_POST["dongles"])){
        $dongles_total += $_POST["dongles"]; 
    }else{$dongles_total=0;}
$total = $widgets_total+$gadgets_total+$wotsits_total+$dongles_total;
print '<form action="Lab5.php" method="post"><table border="1px"><tr><th>Item</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
          <td>Widgets</td><td>13.75</td><td><input type="text" name="widgets" id="widgets" value="0" /></td><td><div id="widget_total">'.$widgets_total.'</div></td></tr>
          <td>Gadgets</td><td>15.99</td><td><input type="text" name="gadgets" id="gadgets" value="0" /></td><td><div id="gadget_total">'.$gadgets_total.'</div></td></tr>
          <td>Wotsits</td><td>1.35</td><td><input type="text" name="wotsits" id="wotsits" value="0" /></td><td><div id="wotsit_total">'.$wotsits_total.'</div></td></tr>
          <td>Dongles</td><td>249.99</td><td><input type="text" name="dongles" id="dongles" value="0" /></td><td><div id="dongle_total">'.$dongles_total.'</div></td></tr>
          <tr><th>Grand Total</th><td></td><td></td><td>'.$total.'</td></tr>
          </table>
          <p><input type="submit" value="Click"
          name="submit" /></p></form>
  </form>';
		} else

// if not, display the form
		{
print  '<form action="Lab5.php" method="post"><table border="1px"><tr><th>Item</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
          <td>Widgets</td><td>13.75</td><td><input type="text" name="widgets" id="widgets" value="0" /></td><td><div id="widget_total">0</div></td></tr>
          <td>Gadgets</td><td>15.99</td><td><input type="text" name="gadgets" id="gadgets" value="0" /></td><td><div id="gadget_total">0</div></td></tr>
          <td>Wotsits</td><td>1.35</td><td><input type="text" name="wotsits" id="wotsits" value="0" /></td><td><div id="wotsit_total">0</div></td></tr>
          <td>Dongles</td><td>249.99</td><td><input type="text" name="dongles" id="dongles" value="0" /></td><td><div id="dongle_total">0</div></td></tr>
          <tr><th>Grand Total</th><td></td><td></td><td>0</td></tr>
          </table>
          <p><input type="submit" value="Set"
          name="submit" /></p></form>
  </form>';
		}

// Print HTML footer

print '</body>
</html>';

?>
