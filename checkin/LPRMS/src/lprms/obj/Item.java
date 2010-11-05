/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package lprms.obj;

/**
 *
 * @author Sarah
 */
public class Item
{
    public Item(int id)
    {
        this.id = id;
    }

    public void setData(String owner, String checkin, String checkout, String borrower, int duration)
    {
        this.owner = owner;
        this.checkin = checkin;
        this.checkout = checkout;
        if (checkout.equals("")) in = true;
        this.duration = duration;
        this.borrower = borrower;
    }

    public String[] getInfo()
    {
        String[] info = {id+"", checkin, checkout,
            (in)?"":(Math.round(duration/60.0*1000)/1000.0+""), borrower};
        return info;
    }

    public String[] getFullInfo()
    {
        String[] info = {id+"", checkin, checkout,
            (in)?"":(Math.round(duration/60.0*1000)/1000.0+""), owner, borrower};
        return info;
    }

    public String[] getItemInfo()
    {
        String[] info = {id+"", owner, borrower, (in)?"Here":"Not Here"};
        return info;
    }

    public void setBorrower(String b)
    {
        borrower = b;
    }

    public void setOwner(String o)
    {
        owner = o;
    }

    public void setIn(boolean i)
    {
        in = i;
    }

    public boolean isIn()
    {
        return in;
    }

    public int ID()
    {
        return id;
    }

    private int id = 0;
    private String owner = "";
    private String checkin = "";
    private String checkout = "";
    private int duration = 0;
    private boolean in = false;
    private String borrower = "";
}
