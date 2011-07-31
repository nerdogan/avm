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
 *
 * @author Radek Ježdík
 */
public class AspSyntax extends Syntax {

	private static AspSyntax instance = new AspSyntax();

	private AspSyntax() {
	}

	public static AspSyntax getInstance() {
		return instance;
	}

	@Override
	public boolean isOpening(LexerInput input) {
		input.backup(1);
		if(input.read() == '<') {
			if(input.read() == '%') {
				int c = input.read();
				while(Character.isWhitespace(c) && c != LexerInput.EOF) {
					c = input.read();
				}
				input.backup(1);
				return true;
			}
			input.backup(1);
		}
		return false;
	}

	@Override
	public boolean isClosing(LexerInput input) {
		input.backup(1);
		if(input.read() == '%') {
			if(input.read() == '>') {
				return true;
			}
			input.backup(1);
		}
		return false;
	}

	@Override
	public int closingLength() {
		return 2;
	}

	@Override
	public String opening() {
		return "<%";
	}
}
