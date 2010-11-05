<?php

class Form_LoginUser
{
    public static function render()
    {
        ?>
<div style="margin: 0 20%; text-align: center;">
<form method="post" action="<?php echo LPRMS::page('post'); ?>">
    <input type="hidden" name="form" value="account" />
    <input type="hidden" name="action" value="login" />
    <input type="hidden" name="async" value="0" />
    <table class="form" summary="Login" width="100%">
        <tr>
            <th><label for="username">Username</label></th>
            <td><input type="text" name="username" value="" /></td>
        </tr>
        <tr>
            <th><label for="password">Password</label></th>
            <td><input type="password" name="password" value="" /></td>
        </tr>
    </table>
    <br />
    <input type="submit" name="submit" value="Login!" />
</form>
    <a href="<?php echo LPRMS::page('account/register'); ?>">Register an account</a> | <a href="<?php echo LPRMS::page('account/forgot'); ?>">Forgot your password?</a>
</div>
        <?php
    }
}

?>