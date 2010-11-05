/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package lprms.obj;

import java.util.ArrayList;

/**
 *
 * @author Sarah
 */
public class User
{
    public User(int id)
    {
        this.id = id;
        img = "http://portal.salukilan.com/content/cache/user/"+id+"/avatar_256.png";
        barcode = "http://portal.salukilan.com/content/cache/user/"+id+"/barcode.png";
    }

    public void setUserInfo(String ausername, String af_name, String al_name, String aemail)
    {
        username = ausername;
        email = aemail;
        f_name = af_name;
        l_name = al_name;
    }

    public void setSeatInfo(String seat)
    {
        this.seat = seat;
    }

    public void setPrefix(String aprefix)
    {
        prefix = aprefix;
    }

    public String[] getUserListInfo()
    {
        String[] info = {id+"", username, f_name, l_name, designation, seat};
        return info;
    }

    public void setClass(String prefix, String name)
    {
        this.prefix = prefix;
        designation = name;
    }

    public void toggle()
    {
        status = !status;
    }

    public void setOnline(boolean online)
    {
        status = online;
    }

    public int ID()
    {
        return id;
    }

    public String username()
    {
        return username;
    }

    public String IDD()
    {
        return prefix+String.format("%06d", id);
    }

    public String name()
    {
        return f_name+" "+l_name;
    }

    public String status()
    {
        return (status)?"On Site":"Not Present";
    }

    public String img()
    {
        return img;
    }

    public String barcode()
    {
        return barcode;
    }

    public void clearItems()
    {
        items.clear();
    }

    public void addItem(Item i)
    {
        items.add(i);
    }

    public ArrayList<Item> getItems()
    {
        return items;
    }

    public void clearItemData()
    {
        itemdata.clear();
    }

    public void addItemData(ItemData i)
    {
        itemdata.add(i);
    }

    public ArrayList<ItemData> getItemData()
    {
        return itemdata;
    }

    private int id = 0;
    private String username = "";
    private String f_name = "";
    private String l_name = "";
    private String seat = "";
    private String email = "";
    private String prefix = "";
    private String designation = "";
    private boolean status = false;

    private ArrayList<Item> items = new ArrayList<Item>();
    private ArrayList<ItemData> itemdata = new ArrayList<ItemData>();

    private String img = "";
    private String barcode = "";
}
