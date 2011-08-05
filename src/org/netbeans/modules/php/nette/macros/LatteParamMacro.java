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
package org.netbeans.modules.php.nette.macros;

import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.text.JTextComponent;
import javax.swing.text.StyledDocument;

/**
 * Represents parametrized macro for completion
 * (adds whitespace character after opening macro name and sets caret position there for instant writing of params)
 * @author Radek Ježdík
 */
public class LatteParamMacro extends LatteMacro {

	public LatteParamMacro(String macro, boolean isPair) {
		super(macro, isPair, false);
	}

	public LatteParamMacro(String macro, boolean isPair, boolean control) {
		super(macro, isPair, control);
	}

	@Override
	public void process(JTextComponent jtc, int dotOffset) {
		StyledDocument doc = (StyledDocument) jtc.getDocument();
		try {
			doc.insertString(dotOffset, getText(), null);			// adds space for macro params
			jtc.setCaretPosition(dotOffset + macro.length() + syntax.opening().length() + 1);		// moves caret to param position for user
		} catch(Exception ex) {
			Logger.getLogger(LatteCommentMacro.class.getName()).log(Level.SEVERE, null, ex);
		}
	}

	@Override
	public String getText() {				// adds space for macro params
		String text = syntax.opening() + macro + " " + syntax.closing();
		if(isPair) {
			text += syntax.opening() + "/" + macro + syntax.closing();
		}
		return text;
	}
}
