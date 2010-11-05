/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package lprms.sql;

import java.sql.Connection;
import java.sql.DriverManager;

/**
 *
 * @author Sarah
 */
public class SQL {

    protected final static void connect()
    {
        try
        {
            String url = "jdbc:mysql://"+HOST+"/"+DATABASE;
            Class.forName("com.mysql.jdbc.Driver").newInstance();
            link = DriverManager.getConnection (url, USERNAME, PASSWORD);
            //System.out.println ("Database connection established");
        }
        catch (Exception e)
        {
            System.err.println ("Cannot connect to database server: "+e);
            link = null;
        }
    }

    protected final static void disconnect()
    {
        if (link == null) return;
        try
        {
            link.close ();
            //System.out.println ("Database connection terminated");
        }
        catch (Exception e) { /* ignore close errors */ }
    }

    protected final static String table(String name)
    {
        return PREFIX+name;
    }

    protected static Connection link;

    
    public static final String HOST = "lambda.0x08.org";
    public static final String DATABASE = "lprms";
    public static final String USERNAME = "salukilan";
    public static final String PASSWORD = "35debfd48d62a653e2414ccdaaa3ef05";
    public static final String PREFIX = "";


    /*
    public static final String HOST = "localhost";
    public static final String DATABASE = "lprms";
    public static final String USERNAME = "lprms";
    public static final String PASSWORD = "lprms";
    public static final String PREFIX = "";
    */
    
    public static final int ID_EVENT = 2;

}
