<?php

class Form_RegisterUser
{
    public static function render()
    {
        ?>
<div style="margin: 0 20%; text-align: center;">
<form method="post" action="<?php echo LPRMS::page('post'); ?>">
    <input type="hidden" name="form" value="account" />
    <input type="hidden" name="action" value="register" />
    <input type="hidden" name="async" value="0" />
    <table class="form" summary="Register an account">
        <tr>
            <th><label for="username">Username</label></th>
            <td><input type="text" name="username" value="" /></td>
        </tr>
        <tr>
            <th><label for="email">E-mail</label></th>
            <td><input type="text" name="email" value="" /></td>
        </tr>
        <tr>
            <th><label for="password">Password</label></th>
            <td><input type="password" name="password" value="" /></td>
        </tr>
        <tr>
            <th><label for="passwordc">Retype to confirm</label></th>
            <td><input type="password" name="passwordc" value="" /></td>
        </tr>
        <tr><td colspan="2"><hr /></td></tr>
        <tr>
            <th><label for="first_name">First Name</label></th>
            <td><input type="text" name="first_name" value="" /></td>
        </tr>
        <tr>
            <th><label for="last_name">Last Name</label></th>
            <td><input type="text" name="last_name" value="" /></td>
        </tr>
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td><input type="text" name="phone" value="" /></td>
        </tr>
        <tr>
            <th><label for="day">Birthday</label></th>
            <td>
                <select name="day">
                    <?php for ($i = 1; $i <= 31; $i++) echo '<option value="'.$i.'">'.$i.'</option>'; ?>
                </select>
                <select name="month">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <select name="year">
                    <?php for ($i = 2010; $i >= 1950; $i--) echo '<option value"'.$i.'">'.$i.'</option>'; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <textarea readonly cols="60" rows="10"><?php echo Settings::getInstance()->terms; ?></textarea>
                <br />
                <input type="checkbox" name="agreement" /> I agree to these Terms and Conditions
            </td>
        </tr>
    </table>
    <br />
    <input type="submit" name="submit" value="Register!" />
</form>
</div>
        <?php
    }
}

?>