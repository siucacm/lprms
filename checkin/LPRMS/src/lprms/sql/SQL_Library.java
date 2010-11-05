/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package lprms.sql;
import java.sql.Statement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import lprms.obj.*;

/**
 *
 * @author Sarah
 */
public class SQL_Library extends SQL
{
    public final static void load()
    {
        load_users();
        loadCheckData();
        load_items();
    }

    public final static void load_users()
    {
        users.clear();
        connect();
        
        Statement s = null;
        ResultSet rs = null;
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT t2.id, t2.username, t2.first_name, t2.last_name, t2.email, t1.seat, (SELECT t3.description FROM `"+table("type_attendees")+"` AS t3 WHERE t3.id = t1.id_designation) as designation, (SELECT t3.prefix FROM `"+table("type_attendees")+"` AS t3 WHERE t3.id = t1.id_designation) AS prefix FROM `"+table("ref_user_event")+"` as t1 LEFT JOIN (`"+table("core_users")+"` as t2) ON (t1.id_user = t2.id) ORDER BY id ASC;");
            while (rs.next())
            {
                User user = new User(rs.getInt("id"));
                user.setSeatInfo(rs.getString("seat"));
                user.setClass(rs.getString("prefix"), rs.getString("designation"));
                user.setUserInfo(rs.getString("username"), rs.getString("first_name"), rs.getString("last_name"), rs.getString("email"));
                users.add(user);
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
    }

    public final static void load_items()
    {
        items.clear();
        clearAllItems();
        connect();

        Statement s = null;
        ResultSet rs = null;
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT t1.id_item, t3.id_owner, t2.username, t1.checkin, t1.checkout, " +
                    "TIMESTAMPDIFF(SECOND,t1.checkin,t1.checkout) AS duration, " +
                    "(SELECT CONCAT(ta2.first_name, ' ', ta2.last_name, ' (', ta3.id_borrower, ')') FROM `"+table("status_rental")+"` AS ta3 LEFT JOIN (`"+table("core_users")+"` AS ta2, `"+table("core_items")+"` AS ta1) ON (ta3.id_borrower = ta2.id AND ta1.id = ta3.id_item) WHERE ta3.id_item = t1.id_item ORDER BY ta3.id DESC LIMIT 0,1) as borrower FROM `"+table("status_items")+"` AS t1 LEFT JOIN (`"+table("core_users")+"` AS t2, `"+table("core_items")+"` AS t3) ON (t1.id_item = t3.id AND t3.id_owner = t2.id);");
            while (rs.next())
            {
                int iid = rs.getInt("id_item");
                Item item = new Item(iid);
                String checkout = rs.getString("checkout");
                if (checkout.equals(BASEDATE+".0")) checkout = "";
                item.setData(rs.getString("username"), rs.getString("checkin"), checkout, rs.getString("borrower"), rs.getInt("duration"));
                items.add(item);
                int row = findUser(rs.getInt("id_owner"));
                if (row != -1)
                    getUsers().get(row).addItem(item);
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
    }

    public final static void load_actualItems()
    {
        actualItems.clear();
        connect();

        Statement s = null;
        ResultSet rs = null;
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT t1.id, t1.id_owner, t2.username, " +
                    "(SELECT CONCAT(ta2.first_name, ' ', ta2.last_name, ' (', ta3.id_borrower, ')') FROM `"+table("status_rental")+"` AS ta3 LEFT JOIN (`"+table("core_users")+"` AS ta2, `"+table("core_items")+"` AS ta1) ON (ta3.id_borrower = ta2.id AND ta1.id = ta3.id_item) WHERE ta3.id_item = t1.id ORDER BY ta3.id DESC LIMIT 0,1) AS borrower, " +
                    "(SELECT CONCAT(ta2.first_name, ' ', ta2.last_name, ' (', ta2.id, ')') FROM `"+table("core_items")+"` AS ta1 LEFT JOIN (`"+table("core_users")+"` AS ta2) ON (ta1.id_owner = ta2.id) WHERE ta1.id = t1.id) AS owner, " +
                    "(CASE (SELECT COUNT(*) FROM `"+table("status_items")+"` AS ta1 WHERE ta1.id_item = t1.id AND ta1.checkout = '1970-01-01 00:00:00') WHEN 0 THEN '0' ELSE '1' END) AS isin " +
                    "FROM `"+table("core_items")+"` AS t1 LEFT JOIN (`"+table("core_users")+"` AS t2) ON (t1.id_owner = t2.id);");
            while (rs.next())
            {
                int iid = rs.getInt("id");
                Item item = new Item(iid);
                item.setData(rs.getString("owner"), "", "", rs.getString("borrower"), 0);
                item.setIn((rs.getInt("isin") == 1));
                actualItems.add(item);
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
        /*
        for (int i = 0; i < actualItems.size(); i++)
        {
            Item item = actualItems.get(i);
            String borrower = itemRentedToWhoU(item.ID());
            item.setBorrower(borrower);
            String owner = itemBelongsToWho(item.ID());
            item.setOwner(owner);
            item.setIn(itemIn(item.ID()));
        }
         *
         */
    }

    public final static void load_itemdata()
    {
        itemdata.clear();
        clearAllItemData();
        connect();

        Statement s = null;
        ResultSet rs = null;
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT t1.id_item, t3.id_owner, t2.username AS owner, t1.id_borrower, t4.username AS borrower, t1.checkin, t1.checkout, TIMESTAMPDIFF(SECOND,t1.checkin,t1.checkout) AS duration FROM `"+table("status_rental")+"` AS t1 LEFT JOIN (`"+table("core_users")+"` AS t2, `"+table("core_items")+"` AS t3, `"+table("core_users")+"` AS t4) ON (t1.id_item = t3.id AND t3.id_owner = t2.id AND t1.id_borrower = t4.id);");
            while (rs.next())
            {
                ItemData itemd = new ItemData(rs.getInt("id_item"));
                String checkout = rs.getString("checkout");
                if (checkout.equals(BASEDATE+".0")) checkout = "";
                itemd.setData(rs.getString("owner"), rs.getString("borrower"), rs.getString("checkin"), checkout, rs.getInt("duration"));
                itemdata.add(itemd);
                getUsers().get(findUser(rs.getInt("id_borrower"))).addItemData(itemd);
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
    }

    public static ArrayList<User> getUsers()
    {
        return users;
    }

    public static ArrayList<Item> getItems()
    {
        return items;
    }

    public static ArrayList<Item> getActualItems()
    {
        return actualItems;
    }

    public static void clearAllItems()
    {
        for (int i = 0; i < users.size(); i++)
            users.get(i).clearItems();
    }

    public static void clearAllItemData()
    {
        for (int i = 0; i < users.size(); i++)
            users.get(i).clearItemData();
    }

    public static int findUser(int uid)
    {
        for (int i = 0; i < users.size(); i++)
            if (users.get(i).ID() == uid) return i;
        return -1;
    }

    public static boolean userExists(int uid)
    {
        boolean result = false;
        connect();

        Statement s = null;
        ResultSet rs = null;
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT COUNT(*) FROM `"+table("core_users")+"` WHERE id = "+uid+";");
            while (rs.next())
            {
                result = (rs.getInt("COUNT(*)") > 0)?true:false;
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
        return result;
    }

    public final static void loadCheckData()
    {
        checkdata.clear();
        connect();

        Statement s = null;
        ResultSet rs = null;
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT t1.id AS rid, t2.id, t2.username, t1.checkin, t1.checkout, TIMESTAMPDIFF(SECOND,t1.checkin,t1.checkout) AS duration, t3.id_event FROM `"+table("status_users")+"` AS t1 LEFT JOIN (`"+table("core_users")+"` AS t2, `"+table("ref_user_event")+"` AS t3) ON (t1.id_ref = t3.id AND t3.id_user = t2.id);");
            while (rs.next())
            {
                int uid = rs.getInt("id");
                //int rid = rs.getInt("rid");
                CheckData cdata = new CheckData(uid);
                Timestamp tsi = rs.getTimestamp("checkin");
                Timestamp tso = rs.getTimestamp("checkout");
                //System.out.println(rid+"tsi =" +tsi);
                //System.out.println(rid+"tso =" +tso);
                String tsos = ((BASEDATE+".0").equals(tso.toString()))?"":tso.toString();
                

                int duration = (tsos.equals(""))?0:rs.getInt("duration");
                int row = findUser(uid);
                if (row == -1)
                {
                    System.err.println("Error finding user!");
                    break;
                }
                users.get(row).setOnline(tsos.equals(""));
                cdata.setData(rs.getString("username"), tsi.toString(), tsos, duration);
                checkdata.add(cdata);
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
    }

    public final static boolean toggle(int uid)
    {
        if (!userExists(uid)) return false;
        connect();

        Statement s = null;
        ResultSet rs = null;
        String tsos = null;
        Date now = new Date(Calendar.getInstance().getTimeInMillis());
        SimpleDateFormat parse = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.S");
        String dateNow = parse.format(now);
        int rid = 0;
        int entid = 0;
        boolean result = true;
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT t1.id_ref AS rid, t1.id, t1.checkout, t3.id_event FROM `"+table("status_users")+"` AS t1 LEFT JOIN (`"+table("core_users")+"` AS t2, `"+table("ref_user_event")+"` AS t3) ON (t1.id_ref = t3.id AND t3.id_user = t2.id) WHERE t2.id = "+uid+" AND t3.id_event = "+ID_EVENT+" ORDER BY t1.id DESC LIMIT 0,1;");
            while (rs.next())
            {
                rid = rs.getInt("rid");
                entid = rs.getInt("id");
                Timestamp tso = rs.getTimestamp("checkout");
                tsos = ((BASEDATE+".0").equals(tso.toString()))?"":tso.toString();
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        if (tsos == null)
        {
            //System.out.println("tsos is null");
            if (findUser(uid) == -1)
            {
                //System.out.println("id not found");
                try {
                    s = link.createStatement();
                    s.executeUpdate("INSERT INTO `"+table("ref_user_event")+"` (id_user, id_event, id_designation, seat) VALUE ("+uid+", "+ID_EVENT+", 4, '');");
                    s.close();

                } catch (SQLException e) { System.err.println("error executing query: "+e); }
            }

            try {
                s = link.createStatement();
                rs = s.executeQuery("SELECT id FROM `"+table("ref_user_event")+"` WHERE id_user = "+uid+";");
                while (rs.next())
                {
                    rid = rs.getInt("id");
                }
                rs.close();
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }

            try {
                s = link.createStatement();
                s.executeUpdate("INSERT INTO `"+table("status_users")+"` (id_ref, checkin, checkout) VALUE ('"+rid+"', '"+dateNow+"', '"+BASEDATE+"');");
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }
        }
        else if (tsos.equals(""))
        {
            //System.out.println("tsos is empty");
            try {
                s = link.createStatement();
                s.executeUpdate("UPDATE `"+table("status_users")+"` SET checkout = '"+dateNow+"' WHERE id = "+entid+";");
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }
            result = false;
        }
        else
        {
            //System.out.println("tsos is full");
            try {
                s = link.createStatement();
                s.executeUpdate("INSERT INTO `"+table("status_users")+"` (id_ref, checkin, checkout) VALUE ('"+rid+"', '"+dateNow+"', '"+BASEDATE+"');");
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }
        }

        disconnect();
        return result;
    }

    public static ArrayList<CheckData> getCheckData()
    {
        return checkdata;
    }

    public static int findItem(int uid)
    {
        for (int i = 0; i < items.size(); i++)
            if (items.get(i).ID() == uid) return i;
        return -1;
    }

    public static boolean itemExists(int iid)
    {
        boolean result = false;
        connect();

        Statement s = null;
        ResultSet rs = null;
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT COUNT(*) FROM `"+table("core_items")+"` WHERE id = "+iid+";");
            while (rs.next())
            {
                result = (rs.getInt("COUNT(*)") > 0)?true:false;
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
        return result;
    }

    public static String itemBelongsToWho(int iid)
    {
        connect();

        Statement s = null;
        ResultSet rs = null;
        String user = "";
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT t2.first_name, t2.last_name, t2.id FROM `"+table("core_items")+"` AS t1 LEFT JOIN (`"+table("core_users")+"` AS t2) ON (t1.id_owner = t2.id) WHERE t1.id = "+iid+";");
            while (rs.next())
            {
                user = rs.getString("first_name")+" "+rs.getString("last_name")+" ("+rs.getInt("id")+")";
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
        return user;
    }

    public static String itemRentedToWho(int iid)
    {
        connect();
        Statement s = null;
        ResultSet rs = null;
        String user = "";
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT t2.first_name, t2.last_name, t1.id AS id_owner, t3.id_borrower FROM `"+table("status_rental")+"` AS t3 LEFT JOIN (`"+table("core_users")+"` AS t2, `"+table("core_items")+"` AS t1) ON (t3.id_borrower = t2.id AND t1.id = t3.id_item) WHERE t3.id_item = "+iid+" ORDER BY t3.id DESC LIMIT 0,1;");
            while (rs.next())
            {
                user = rs.getString("first_name")+" "+rs.getString("last_name")+" ("+rs.getInt("id_borrower")+")";
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
        return user;
    }

    public static String itemRentedToWhoU(int iid)
    {
        connect();

        Statement s = null;
        ResultSet rs = null;
        String user = "";
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT t2.username, t2.first_name, t2.last_name, t1.id AS id_owner, t3.id_borrower FROM `"+table("status_rental")+"` AS t3 LEFT JOIN (`"+table("core_users")+"` AS t2, `"+table("core_items")+"` AS t1) ON (t3.id_borrower = t2.id AND t1.id = t3.id_item) WHERE t3.id_item = "+iid+" ORDER BY t3.id DESC LIMIT 0,1;");
            while (rs.next())
            {
                user = rs.getString("username")+" ("+rs.getInt("id_borrower")+")";
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        disconnect();
        return user;
    }

    public static boolean itemBelongsToUser(int iid, int uid)
    {
        Statement s = null;
        ResultSet rs = null;
        boolean result = false;
        connect();
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT COUNT(*) FROM `"+table("core_items")+"` WHERE id_owner = '"+uid+"' AND id = '"+iid+"';");
            while (rs.next())
            {
                result = rs.getInt("COUNT(*)") > 0;
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }
        disconnect();
        return result;
    }

    public static boolean itemRented(int iid)
    {
        Statement s = null;
        ResultSet rs = null;
        boolean result = false;
        connect();
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT COUNT(*) FROM `"+table("status_rental")+"` WHERE id_item = '"+iid+"' AND checkout = '1970-01-01 00:00:00';");
            while (rs.next())
            {
                result = rs.getInt("COUNT(*)") > 0;
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }
        disconnect();
        return result;
    }

    public static boolean itemIn(int iid)
    {
        Statement s = null;
        ResultSet rs = null;
        boolean result = false;
        connect();
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT COUNT(*) FROM `"+table("status_items")+"` WHERE id_item = '"+iid+"' AND checkout = '1970-01-01 00:00:00';");
            while (rs.next())
            {
                result = rs.getInt("COUNT(*)") > 0;
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }
        disconnect();
        return result;
    }

    public static void associateItemWithUser(int iid, int uid)
    {
        if (itemExists(iid)) return;
        System.out.println("Associating Items");
        connect();
        Statement s = null;
        try {
            s = link.createStatement();
            s.executeUpdate("INSERT INTO `"+table("core_items")+"` (id, id_type, id_owner) VALUE ("+iid+", 11, "+uid+");");
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }
        disconnect();
    }

    public final static String toggleItem(int iid, int uid)
    {
        if (!itemBelongsToUser(iid, uid) && itemExists(iid)) return "Item belongs to user: "+itemBelongsToWho(iid);
        if (itemRented(iid)) return "Item is being rented out";
        if (!itemExists(iid))
        {
            associateItemWithUser(iid, uid);
            load_items();
        }
        connect();

        Statement s = null;
        ResultSet rs = null;
        String tsos = null;
        int rid = 0;
        Date now = new Date(Calendar.getInstance().getTimeInMillis());
        SimpleDateFormat parse = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.S");
        String dateNow = parse.format(now);
        String result = "";
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT id, id_item, checkin, checkout FROM `"+table("status_items")+"` WHERE id_item = '"+iid+"';");
            while (rs.next())
            {
                Timestamp tso = rs.getTimestamp("checkout");
                tsos = ((BASEDATE+".0").equals(tso.toString()))?"":tso.toString();
                rid = rs.getInt("id");
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        if (tsos == null)
        {
            try {
                s = link.createStatement();
                s.executeUpdate("INSERT INTO `"+table("status_items")+"` (id_item, checkin, checkout) VALUE ('"+iid+"', '"+dateNow+"', '"+BASEDATE+"');");
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }
        }
        else if (tsos.equals(""))
        {
            //System.out.println("tsos is empty");
            try {
                s = link.createStatement();
                s.executeUpdate("UPDATE `"+table("status_items")+"` SET checkout = '"+dateNow+"' WHERE id = "+rid+";");
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }
            
        }
        else
        {
            //System.out.println("tsos is full");
            try {
                s = link.createStatement();
                s.executeUpdate("INSERT INTO `"+table("status_items")+"` (id_item, checkin, checkout) VALUE ('"+iid+"', '"+dateNow+"', '"+BASEDATE+"');");
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }
        }

        disconnect();
        return result;
    }

    public final static String rentItem(int iid, int uid)
    {
        if (!itemExists(iid)) return "Item does not exist!";
        if (itemBelongsToUser(iid, uid)) return "You cannot rent your own item!";
        if (!itemIn(iid)) return "Item is not onsite!";
        connect();

        Statement s = null;
        ResultSet rs = null;
        String tsos = null;
        int rid = 0;
        Date now = new Date(Calendar.getInstance().getTimeInMillis());
        SimpleDateFormat parse = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.S");
        String dateNow = parse.format(now);
        String result = "";
        try {
            s = link.createStatement();
            rs = s.executeQuery("SELECT id, id_item, id_borrower, checkin, checkout FROM `"+table("status_rental")+"` WHERE id_item = '"+iid+"';");
            while (rs.next())
            {
                Timestamp tso = rs.getTimestamp("checkout");
                tsos = ((BASEDATE+".0").equals(tso.toString()))?"":tso.toString();
                if (rs.getInt("id_borrower") != uid && tsos.equals(""))
                {
                    System.out.println(tsos);
                    result = "Item is already checked out to: ";
                    break;
                }
                rid = rs.getInt("id");
            }
            rs.close();
            s.close();

        } catch (SQLException e) { System.err.println("error executing query: "+e); }

        if (!result.equals(""))
        {
            disconnect();
            result += itemRentedToWho(iid);
            return result;
        }

        if (tsos == null)
        {
            try {
                s = link.createStatement();
                s.executeUpdate("INSERT INTO `"+table("status_rental")+"` (id_item, id_borrower, checkin, checkout) VALUE ('"+iid+"', '"+uid+"', '"+dateNow+"', '"+BASEDATE+"');");
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }
        }
        else if (tsos.equals(""))
        {
            //System.out.println("tsos is empty");
            try {
                s = link.createStatement();
                s.executeUpdate("UPDATE `"+table("status_rental")+"` SET checkout = '"+dateNow+"' WHERE id = "+rid+";");
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }

        }
        else
        {
            //System.out.println("tsos is full");
            try {
                s = link.createStatement();
                s.executeUpdate("INSERT INTO `"+table("status_rental")+"` (id_item, id_borrower, checkin, checkout) VALUE ('"+iid+"', '"+uid+"', '"+dateNow+"', '"+BASEDATE+"');");
                s.close();

            } catch (SQLException e) { System.err.println("error executing query: "+e); }
        }

        disconnect();
        return result;
    }

    private static ArrayList<Item> items = new ArrayList<Item>();
    private static ArrayList<Item> actualItems = new ArrayList<Item>();
    private static ArrayList<ItemData> itemdata = new ArrayList<ItemData>();
    private static ArrayList<User> users = new ArrayList<User>();
    private static ArrayList<CheckData> checkdata = new ArrayList<CheckData>();

    public static final String BASEDATE = "1970-01-01 00:00:00";
    
}
