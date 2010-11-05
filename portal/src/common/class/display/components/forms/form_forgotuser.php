<?php

class Form_ForgotUser
{
    public static function render()
    {
        ?>
<div style="margin: 0 20%; text-align: center;">
<form method="post" action="<?php echo LPRMS::page('post'); ?>">
    <input type="hidden" name="form" value="account" />
    <input type="hidden" name="action" value="forgot" />
    <input type="hidden" name="async" value="0" />
    <table class="form" summary="Forgot your password?" width="100%">
        <tr>
            <th><label for="username">Username</label></th>
            <td><input type="text" name="username" value="" /></td>
        </tr>
        <tr>
            <th><label for="email">E-mail</label></th>
            <td><input type="text" name="email" value="" /></td>
        </tr>
    </table>
    <br />
    <input type="submit" name="submit" value="Reset account" />
</form>
    <a href="<?php echo LPRMS::page('account/register'); ?>">Register an account</a> | <a href="<?php echo LPRMS::page('account/login'); ?>">Login</a>
</div>
        <?php
    }
}

?>