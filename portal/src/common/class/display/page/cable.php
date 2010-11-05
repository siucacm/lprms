<?php
class Page {
    public static final function render()
    {
        Display::header();
        echo '<h1 class="title">Order LAN cables</h1>';
        echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7DTQVHEFWJ2RJ">
<table>
<tr><td><input type="hidden" name="on0" value="Name Registered at
LAN">Name Registered at LAN</td></tr><tr><td><input type="text"
name="os0" maxlength="60"></td></tr>
<tr><td><input type="hidden" name="on1"
value="Phone">Phone</td></tr><tr><td><input type="text" name="os1"
maxlength="60"></td></tr>
</table>
<input type="image"
src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif"
border="0" name="submit" alt="PayPal - The safer, easier way to pay
online!">
<img alt="" border="0"
src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1"
height="1">
</form>';
        Display::footer();
    }
}
?>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
