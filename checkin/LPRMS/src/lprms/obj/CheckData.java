/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package lprms.obj;

/**
 *
 * @author Sarah
 */
public class CheckData
{
    public CheckData(int id)
    {
        this.id = id;
    }

    public void setData(String username, String checkin, String checkout, int duration)
    {
        this.username = username;
        this.checkin = checkin;
        this.checkout = checkout;
        if (checkout.equals("")) in = true;
        this.duration = duration;
    }

    public String[] getCheckDataInfo()
    {
        String[] info = {id+"", username, checkin, checkout, 
            (in)?"":(Math.round(duration/60.0*1000)/1000.0+"")};
        return info;
    }

    public boolean isIn()
    {
        return in;
    }

    private int id = 0;
    private String username = "";
    private String checkin = "";
    private String checkout = "";
    private int duration = 0;
    private boolean in = false;
}
