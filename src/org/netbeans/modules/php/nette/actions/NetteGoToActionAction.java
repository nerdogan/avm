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

package org.netbeans.modules.php.nette.actions;

import org.netbeans.modules.csl.api.UiUtils;
import org.netbeans.modules.php.api.editor.EditorSupport;
import org.netbeans.modules.php.api.editor.PhpClass;
import org.netbeans.modules.php.nette.NetteFramework;
import org.netbeans.modules.php.nette.utils.EditorUtils;
import org.netbeans.modules.php.spi.actions.GoToActionAction;
import org.openide.filesystems.FileObject;
import org.openide.util.Lookup;

/**
 *
 * @author Ondřej Brejla <ondrej@brejla.cz>
 */
public class NetteGoToActionAction extends GoToActionAction {

    private static final int NO_OFFSET = -1;
    
    private FileObject fo;
    
    private int methodOffset = NO_OFFSET;
    
    public NetteGoToActionAction(FileObject fo) {
        this.fo = fo;
    }
    
    @Override
    public boolean goToAction() {
        FileObject action = EditorUtils.getAction(fo);
        if (action != null) {
            UiUtils.open(action, getActionMethodOffset(action));
            return true;
        }
        return false;
    }
    
    private int getActionMethodOffset(FileObject action) {
        String actionMethodName = EditorUtils.getActionName(fo);
        String renderMethodName = EditorUtils.getRenderName(fo);
        EditorSupport editorSupport = Lookup.getDefault().lookup(EditorSupport.class);
        for (PhpClass phpClass : editorSupport.getClasses(action)) {
            if (phpClass.getName().endsWith(NetteFramework.NETTE_PRESENTER_SUFFIX)) {
                methodOffset(actionMethodName, phpClass);
                methodOffset(renderMethodName, phpClass);
                
                return methodOffset == NO_OFFSET ? phpClass.getOffset() : methodOffset;
            }
        }
        return DEFAULT_OFFSET;
    }
    
    private void methodOffset(String methodName, PhpClass phpClass) {
        if (methodName != null && methodOffset == NO_OFFSET) {
            for (PhpClass.Method method : phpClass.getMethods()) {
                if (methodName.equals(method.getName())) {
                    methodOffset = method.getOffset();
                }
            }
        }
    }

}
