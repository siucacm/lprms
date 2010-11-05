/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package lprms.panel;

import lprms.LPRMSView;

/**
 *
 * @author Sarah
 */
public abstract class Panel extends javax.swing.JPanel {

    public abstract void processInput(String input);
    public abstract void refresh();
    public void setWindow(LPRMSView view)
    {
        window = view;
    }

    protected LPRMSView window;
}
