/*
 * The MIT license
 *
 * Copyright (c) 2010 Radek Ježdík <redhead@email.cz>, Ondřej Brejla <ondrej@brejla.cz>
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

package org.netbeans.modules.php.nette;

import java.io.IOException;
import java.util.Set;
import javax.swing.JComponent;
import javax.swing.event.ChangeListener;
import org.netbeans.modules.php.api.phpmodule.PhpModule;
import org.netbeans.modules.php.nette.wizards.NewNetteProjectPanel;
import org.netbeans.modules.php.spi.phpmodule.PhpModuleExtender;
import org.openide.filesystems.FileObject;
import org.openide.util.Exceptions;
import org.openide.util.HelpCtx;

/**
 *
 * @author Radek Ježdík, Ondřej Brejla
 */
public class NettePhpModuleExtender extends PhpModuleExtender {

    private NewNetteProjectPanel netteProjectPanel;

    @Override
    public void addChangeListener(ChangeListener cl) {
        getPanel().addChangeListener(cl);
    }

    @Override
    public void removeChangeListener(ChangeListener cl) {
        getPanel().removeChangeListener(cl);
    }

    @Override
    public JComponent getComponent() {
        return getPanel();
    }

    @Override
    public HelpCtx getHelp() {
        return null;
    }

    @Override
    public boolean isValid() {
        return getErrorMessage() == null;
    }

    @Override
    public String getErrorMessage() {
        return getPanel().getErrorMessage();
    }

    @Override
    public String getWarningMessage() {
        return null;
    }

    @Override
    public Set<FileObject> extend(PhpModule pm) throws ExtendingException {
        try {
            String projectDir = pm.getSourceDirectory().getPath();

			NetteSandboxCreator nsc = new NetteSandboxCreator(projectDir);
			nsc.create();

			if (getPanel().isCopyNetteCheckboxSelected()) {
                nsc.copyFrameworkFiles();
            }

			return nsc.getCreatedFileObjects();
        } catch (IOException ex) {
            Exceptions.printStackTrace(ex);
            throw new ExtendingException(ex.getMessage());
        }
    }

    private NewNetteProjectPanel getPanel() {
        if (netteProjectPanel == null) {
            netteProjectPanel = new NewNetteProjectPanel();
        }

        return netteProjectPanel;
    }

}
