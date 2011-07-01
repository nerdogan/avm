/*
 *  The MIT License
 * 
 *  Copyright (c) 2011 Radek Ježdík <redhead@email.cz>, Ondřej Brejla <ondrej@brejla.cz>
 * 
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 * 
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 * 
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

package org.netbeans.modules.php.nette;

import java.util.Collections;
import java.util.List;
import javax.swing.Action;
import org.netbeans.modules.php.nette.actions.NetteGoToActionAction;
import org.netbeans.modules.php.nette.actions.NetteGoToViewAction;
import org.netbeans.modules.php.nette.utils.EditorUtils;
import org.netbeans.modules.php.spi.actions.GoToActionAction;
import org.netbeans.modules.php.spi.actions.GoToViewAction;
import org.netbeans.modules.php.spi.phpmodule.PhpModuleActionsExtender;
import org.openide.filesystems.FileObject;
import org.openide.util.NbBundle;

/**
 *
 * @author Ondřej Brejla <ondrej@brejla.cz>
 */
public class NettePhpModuleActionsExtender extends PhpModuleActionsExtender {

	@Override
	public String getMenuName() {
		return NbBundle.getMessage(NettePhpModuleActionsExtender.class, "LBL_MenuName");
	}

	@Override
	public List<? extends Action> getActions() {
		return Collections.<Action>emptyList();
	}

    @Override
    public boolean isViewWithAction(FileObject fo) {
        return EditorUtils.isViewWithAction(fo);
    }

    @Override
    public boolean isActionWithView(FileObject fo) {
        return EditorUtils.isAction(fo);
    }

    @Override
    public GoToActionAction getGoToActionAction(FileObject fo, int offset) {
        return new NetteGoToActionAction(fo);
    }

    @Override
    public GoToViewAction getGoToViewAction(FileObject fo, int offset) {
        return new NetteGoToViewAction(fo, offset);
    }

}
