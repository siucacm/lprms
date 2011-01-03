/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Panel_Checkin.java
 *
 * Created on Apr 26, 2010, 8:44:08 AM
 */

package lprms.panel;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import javax.swing.ImageIcon;
import javax.swing.table.DefaultTableModel;
import lprms.LPRMSApp;
import lprms.obj.ItemData;
import lprms.obj.User;
import lprms.sql.SQL_Library;
import org.jdesktop.application.Task;
import org.jdesktop.application.TaskMonitor;
import org.jdesktop.application.TaskService;

/**
 *
 * @author Sarah
 */
public class Panel_UserItemRental extends Panel {

    /** Creates new form Panel_Checkin */
    public Panel_UserItemRental() {
        data = new DefaultTableModel(COLS, 0) {
            @Override public boolean isCellEditable(int rowIndex, int mColIndex) { return false; } };

        initComponents();
    }

    /** This method is called from within the constructor to
     * initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is
     * always regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        img = new javax.swing.JLabel();
        id = new javax.swing.JLabel();
        username = new javax.swing.JLabel();
        name = new javax.swing.JLabel();
        status = new javax.swing.JLabel();
        dataView = new javax.swing.JScrollPane();
        jTable1 = new javax.swing.JTable();
        barcode = new javax.swing.JLabel();
        error = new javax.swing.JLabel();
        informative = new javax.swing.JLabel();

        setName("Panel_UserInfo"); // NOI18N
        setRequestFocusEnabled(false);
        setVerifyInputWhenFocusTarget(false);

        img.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        img.setMaximumSize(new java.awt.Dimension(256, 256));
        img.setMinimumSize(new java.awt.Dimension(256, 256));
        img.setName("img"); // NOI18N
        img.setPreferredSize(new java.awt.Dimension(256, 256));

        id.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        id.setName("id"); // NOI18N

        username.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        username.setName("username"); // NOI18N

        name.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        name.setName("name"); // NOI18N

        status.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        status.setName("status"); // NOI18N

        dataView.setName("dataView"); // NOI18N

        jTable1.setModel(data);
        jTable1.setName("jTable1"); // NOI18N
        dataView.setViewportView(jTable1);

        barcode.setBorder(javax.swing.BorderFactory.createLineBorder(new java.awt.Color(0, 0, 0)));
        barcode.setMaximumSize(new java.awt.Dimension(256, 128));
        barcode.setMinimumSize(new java.awt.Dimension(256, 128));
        barcode.setName("barcode"); // NOI18N
        barcode.setPreferredSize(new java.awt.Dimension(256, 128));

        org.jdesktop.application.ResourceMap resourceMap = org.jdesktop.application.Application.getInstance(lprms.LPRMSApp.class).getContext().getResourceMap(Panel_UserItemRental.class);
        error.setFont(resourceMap.getFont("error.font")); // NOI18N
        error.setForeground(resourceMap.getColor("error.foreground")); // NOI18N
        error.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        error.setName("error"); // NOI18N

        informative.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        informative.setName("informative"); // NOI18N

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(this);
        this.setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                    .addComponent(informative, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, 661, Short.MAX_VALUE)
                    .addComponent(error, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, 661, Short.MAX_VALUE)
                    .addComponent(dataView, javax.swing.GroupLayout.Alignment.LEADING, javax.swing.GroupLayout.DEFAULT_SIZE, 661, Short.MAX_VALUE)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(img, javax.swing.GroupLayout.PREFERRED_SIZE, 256, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 149, Short.MAX_VALUE)
                        .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING, false)
                            .addComponent(status, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(name, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(username, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(id, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                            .addComponent(barcode, javax.swing.GroupLayout.DEFAULT_SIZE, 256, Short.MAX_VALUE))))
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(img, javax.swing.GroupLayout.PREFERRED_SIZE, 256, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(barcode, javax.swing.GroupLayout.PREFERRED_SIZE, 128, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(id)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(username)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(name)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(status)))
                .addGap(18, 18, 18)
                .addComponent(error, javax.swing.GroupLayout.PREFERRED_SIZE, 30, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(informative, javax.swing.GroupLayout.PREFERRED_SIZE, 30, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(4, 4, 4)
                .addComponent(dataView, javax.swing.GroupLayout.DEFAULT_SIZE, 200, Short.MAX_VALUE)
                .addContainerGap())
        );
    }// </editor-fold>//GEN-END:initComponents


    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JLabel barcode;
    private javax.swing.JScrollPane dataView;
    private javax.swing.JLabel error;
    private javax.swing.JLabel id;
    private javax.swing.JLabel img;
    private javax.swing.JLabel informative;
    private javax.swing.JTable jTable1;
    private javax.swing.JLabel name;
    private javax.swing.JLabel status;
    private javax.swing.JLabel username;
    // End of variables declaration//GEN-END:variables

    private javax.swing.table.DefaultTableModel data;

    public void processInput(String input)
    {
        if (input.charAt(0) == 'I') processItem(input.substring(1));
        else processUser(input);
    }

    private void processUser(String input)
    {
        int tuid = 0;
        try { tuid = Integer.parseInt(input); } catch (NumberFormatException e) {}
        if (SQL_Library.userExists(tuid)) uid = tuid;
        refresh();
    }

    private void processItem(String input)
    {
        int iid = 0;
        try { iid = Integer.parseInt(input); } catch (NumberFormatException e) {}
        String result = SQL_Library.rentItem(iid, uid);
        error.setText(result);
        if (!result.equals(""))
            informative.setText("Please contact either Blake or Kevin!");
        else
        {
            informative.setText("");
        }
        refreshItems();
    }

    public void refresh()
    {
        refreshUser();
        refreshItems();
    }

    private class RefreshUserTask extends Task {
        RefreshUserTask() {
            super(LPRMSApp.getApplication());
        }
        @SuppressWarnings("unchecked")
        @Override protected Void doInBackground() {
            setMessage("Loading User");
            int row = SQL_Library.findUser(uid);
            if (row == -1) return null;
            User user = SQL_Library.getUsers().get(row);
            try {img.setIcon(new ImageIcon(new URL(user.img()))); } catch (MalformedURLException e) {}
            username.setText(user.username());
            id.setText(user.IDD());
            name.setText(user.name());
            status.setText(user.status());
            try {barcode.setIcon(new ImageIcon(new URL(user.barcode()))); } catch (MalformedURLException e) {}
            return null;
        }
        @Override protected void finished() {
            setMessage("Done");
        }
    }

    public void refreshUser()
    {
        RefreshUserTask task = new RefreshUserTask();
        TaskService ts = LPRMSApp.getInstance().getContext().getTaskService();
        TaskMonitor tm = LPRMSApp.getInstance().getContext().getTaskMonitor();
        tm.setForegroundTask(task);
        ts.execute(task);
    }

    private class RefreshItemTask extends Task {
        RefreshItemTask() {
            super(LPRMSApp.getApplication());
        }
        @SuppressWarnings("unchecked")
        @Override protected Void doInBackground() {
            setMessage("Loading Items");
            int row = SQL_Library.findUser(uid);
            if (row == -1) return null;
            SQL_Library.load_itemdata();
            ArrayList<ItemData> itemdata = SQL_Library.getUsers().get(row).getItemData();
            data.setRowCount(0);
            data.setDataVector(null, COLS);
            for (int i = 0; i < itemdata.size(); i++)
                data.addRow(itemdata.get(i).getInfo());
            return null;
        }
        @Override protected void finished() {
            setMessage("Done");
        }
    }

    public void refreshItems()
    {
        RefreshItemTask task = new RefreshItemTask();
        TaskService ts = LPRMSApp.getInstance().getContext().getTaskService();
        TaskMonitor tm = LPRMSApp.getInstance().getContext().getTaskMonitor();
        tm.setForegroundTask(task);
        ts.execute(task);
    }

    private int uid = 0;
    public static final String[] COLS = {"ID", "Check-in", "Check-out", "Duration (min)", "Owner"};
}