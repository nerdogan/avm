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
public class LatteSyntax extends Syntax {

	private static LatteSyntax instance = new LatteSyntax();

	private LatteSyntax() {
	}

	public static LatteSyntax getInstance() {
		return instance;
	}

	@Override
	public boolean isOpening(LexerInput input) {
//		input.backup(1);
//		if(input.read() == '{') {
//			int c = input.read();
//			input.backup(1);
//			if(c != ' ' && c != '\r' && c != '\n' && c != '\'' && c != '"' && c != '{' && c != '}') {
//				return true;
//			}
//		}
//		return false;
		input.backup(1);
		String del = "";
		del += (char) input.read();
		del += (char) input.read();
		input.backup(1);
		return isOpening(del);
	}

	@Override
	public boolean isOpening(String string) {
		boolean res = string.startsWith("{");

		if(string.length() != 2) {
			return res;
		}

		char c = string.charAt(1);
		if(c != ' ' && c != '\r' && c != '\n' && c != '\'' && c != '"' && c != '{' && c != '}') {
			return res;
		}
		return false;
	}

	@Override
	public boolean isClosing(LexerInput input) {
		input.backup(1);
		if(input.read() == '}') {
			return true;
		}
		return false;
	}

	@Override
	public boolean whitespaceAllowed() {
		return false;
	}

	@Override
	public boolean startsWith(String string) {
		return string.startsWith("{");
	}

	@Override
	public String opening() {
		return "{";
	}

	@Override
	public String closing() {
		return "}";
	}
}
