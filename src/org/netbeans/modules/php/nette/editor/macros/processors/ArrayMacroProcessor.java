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

package org.netbeans.modules.php.nette.editor.macros.processors;

import javax.swing.text.Document;
import org.netbeans.api.lexer.Token;
import org.netbeans.api.lexer.TokenSequence;
import org.netbeans.modules.php.nette.editor.Embedder;
import org.netbeans.modules.php.nette.editor.hints.HintFactory;
import org.netbeans.modules.php.nette.lexer.LatteTokenId;
import org.netbeans.modules.php.nette.lexer.LatteTopTokenId;

/**
 *
 * @author Ondřej Brejla
 */
public class ArrayMacroProcessor implements MacroProcessor {

	@Override
	public void process(TokenSequence<LatteTopTokenId> sequence, TokenSequence<LatteTokenId> sequence2, int start, String macro, boolean endMacro, Embedder embedder) {
		byte state = -1;									// -1,0 - variable; 1,2 - value
		int numOfBrackets = 0;								// counts nested brackets

		if(macro.equals("assign")) {
			int temp = sequence2.offset();
			sequence2.moveStart();
			sequence2.moveNext();
			createDeprecatedHint(embedder, sequence.offset() + sequence2.token().length(), "assign".length());
			sequence2.move(temp);
			sequence2.moveNext();
		}

		do {
			Token<LatteTokenId> t2 = sequence2.token();
			if (isVariable(state)) {								// var name
				if (state == -1 && t2.id() != LatteTokenId.WHITESPACE) {
					start = sequence2.offset() + sequence.offset();			// start of var name
					state = 0;												// don't search for var name start
				}
				if (t2.id() == LatteTokenId.ASSIGN || t2.id() == LatteTokenId.EQUALS) { // assign|equal found (equal added in nette 1.0)
					if(t2.id() == LatteTokenId.ASSIGN) {
						createSyntaxHint(embedder, sequence.offset(), sequence.token().length());
					}
					state = 1;												// search for value
					continue;
				}
			}

			if (isValue(state)) {
				if (state == 1) {
					start = sequence2.offset() + sequence.offset();			// start of value
					state = 2;
				}
				// left bracket or brace found (count it)
				if (t2.id() == LatteTokenId.LNB || t2.id() == LatteTokenId.LB) {
					numOfBrackets++;
				}
				// right bracket or brace found (remove it)
				if (t2.id() == LatteTokenId.RNB || t2.id() == LatteTokenId.RB) {
					numOfBrackets--;
				}
				if (t2.id() == LatteTokenId.RD								// right delim } found
						|| (t2.id() == LatteTokenId.COMA && numOfBrackets == 0)) {	// or comma found (out of brackets)
					state = -1;												// search for next variable name
					continue;
				}

			}
		} while (sequence2.moveNext());
	}

	private boolean isVariable(byte state) {
		return state == -1 || state == 0;
	}

	private boolean isValue(byte state) {
		return state == 1 || state == 2;
	}

	private void createSyntaxHint(Embedder embedder, int start, int length) {
		Document doc = embedder.getSnapshot().getSource().getDocument(false);
		HintFactory.add(doc, HintFactory.VAR_ASSIGN_SYNTAX, start, length);
	}

	private void createDeprecatedHint(Embedder embedder, int start, int length) {
		Document doc = embedder.getSnapshot().getSource().getDocument(false);
		HintFactory.add(doc, HintFactory.ASSIGN_MACRO_DEPRECATED, start, length);
	}

}
