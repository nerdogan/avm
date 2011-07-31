/*
 *  The MIT License
 * 
 *  Copyright (c) 2010 Radek Ježdík <redhead@email.cz>, Ondřej Brejla <ondrej@brejla.cz>
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
package org.netbeans.modules.php.nette.lexer.syntax;

import org.netbeans.spi.lexer.LexerInput;

/**
 * Syntax class
 * @author Radek Ježdík
 */
public abstract class Syntax {

	public static Syntax getSyntax(String name) {
		if(name.equals("double")) {
			return DoubleSyntax.getInstance();
		} else if(name.equals("asp")) {
			return AspSyntax.getInstance();
		} else if(name.equals("python")) {
			return PythonSyntax.getInstance();
		} else if(name.equals("off")) {
			return OffSyntax.getInstance();
		}
		return LatteSyntax.getInstance();
	}

	abstract public boolean isOpening(LexerInput input);

	abstract public boolean isClosing(LexerInput input);

	abstract public int closingLength();

	abstract public String opening();
}
