/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package lprms.obj;

/**
 *
 * @author Sarah
 */
public class ItemData
{
    public ItemData(int id)
    {
        this.id = id;
    }

    public void setData(String owner, String borrower, String checkin, String checkout, int duration)
    {
        this.owner = owner;
        this.borrower = borrower;
        this.checkin = checkin;
        this.checkout = checkout;
        if (checkout.equals("")) in = true;
        this.duration = duration;
    }

    public String[] getInfo()
    {
        String[] info = {id+"", checkin, checkout,
            (in)?"":(Math.round(duration/60.0*1000)/1000.0+""), owner};
        return info;
    }

    public boolean isIn()
    {
        return in;
    }

    private int id = 0;
    private String owner = "";
    private String borrower = "";
    private String checkin = "";
    private String checkout = "";
    private int duration = 0;
    private boolean in = false;
}
