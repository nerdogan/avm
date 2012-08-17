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
package org.netbeans.modules.php.nette.editor.completion;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import javax.swing.text.Document;
import javax.swing.text.JTextComponent;
import org.netbeans.api.lexer.Token;
import org.netbeans.api.lexer.TokenSequence;
import org.netbeans.modules.php.api.util.Pair;
import org.netbeans.modules.php.nette.lexer.LatteTokenId;
import org.netbeans.modules.php.nette.lexer.LatteTopTokenId;
import org.netbeans.modules.php.nette.lexer.syntax.LatteSyntax;
import org.netbeans.modules.php.nette.lexer.syntax.Syntax;
import org.netbeans.modules.php.nette.macros.LatteMacro;
import org.netbeans.modules.php.nette.macros.MacroDefinitions;
import org.netbeans.modules.php.nette.utils.LexUtils;
import org.netbeans.spi.editor.completion.CompletionProvider;
import org.netbeans.spi.editor.completion.CompletionResultSet;
import org.netbeans.spi.editor.completion.CompletionTask;
import org.netbeans.spi.editor.completion.support.AsyncCompletionQuery;
import org.netbeans.spi.editor.completion.support.AsyncCompletionTask;


/**
 * Provides completion window Is context-dependent (in-macro completion,
 * out-side macro completion) by token where caret is positioned at
 * (LatteTopTokenId and LatteTokenId)
 * @author Radek Ježdík
 */
public class LatteCompletionProvider implements CompletionProvider {

	/**
	 * Stores hash map of <String, Pair<LatteMacro, Integer>> of pair macros
	 * (used for finding unmatched macros for completion of their end/friend
	 * macros)
	 */
	MacroCounterMap paired;

	/**
	 * Stores text written by user for auto-showing completion box (see
	 * getAutoQueryTypes method)
	 */
	private String autoShowText;


	@Override
	public CompletionTask createTask(int type, JTextComponent jtc) {

		if(type != CompletionProvider.COMPLETION_QUERY_TYPE) {
			return null;
		}

		return new AsyncCompletionTask(new AsyncCompletionQuery() {

			@Override
			protected void query(CompletionResultSet completionResultSet, Document document, int caretOffset) {
				TokenSequence<LatteTopTokenId> sequence = LexUtils.getTopSequence(document);

				sequence.move(caretOffset);

				// pair macros (Int > 0 == unclosed macro) see below
				preprocessUnclosedMacros(sequence);

				sequence.move(caretOffset);
				if(sequence.moveNext() || sequence.movePrevious()) {
					Token<LatteTopTokenId> token = sequence.token();

					if(token.id() == LatteTopTokenId.LATTE) {
						//inside macro completion
						InsideMacroResolver.resolve(completionResultSet, sequence, document, caretOffset);

						TokenSequence<LatteTokenId> sequence2 = LexUtils.getSequence(token);
						sequence2.move(caretOffset - sequence.offset());
						if(sequence2.movePrevious()) {
							LatteTokenId id = sequence2.token().id();
							if(id == LatteTokenId.MACRO
									|| id == LatteTokenId.END_SLASH) {
								OutsideMacroResolver.resolve(completionResultSet, sequence, document, caretOffset, getFriendMacros());
							}
						}
					} else {
						// fills up list with possible endMacros and their friend macros
						List<LatteMacro> endMacros = getFriendMacros();
						// outside macro completion
						OutsideMacroResolver.resolve(completionResultSet, sequence, document, caretOffset, endMacros);
					}
				}
				// must be called before return;
				completionResultSet.finish();
			}

		}, jtc);
	}


	/**
	 * Shows completion box automaticaly, if text written starts with opening
	 * Latte delimiter or with n: chars
	 *
	 * @param JTextComponent
	 * @param written text
	 * @return
	 */
	@Override
	public int getAutoQueryTypes(JTextComponent jtc, String string) {
		if(string.equals(":") && autoShowText != null) {
			autoShowText += string;
		}

		if(string.equals("n")) {
			autoShowText = string;
		} else {
			Syntax syntax = getSyntax(jtc);
			if(string.length() == 1 && Syntax.CHARS.indexOf(string) != -1) {
				autoShowText = (autoShowText == null ? "" : autoShowText);

				if(syntax.startsWith(autoShowText + string)) {
					if(syntax.isOpening(autoShowText + string)) {
						return COMPLETION_QUERY_TYPE;
					} else {
						autoShowText += string;
					}
				} else {
					autoShowText = null;
				}
			} else if(Syntax.CHARS.indexOf(string) == -1) {
				autoShowText = null;
			}
		}
		return (string.startsWith("n:")
				|| ("n:".equals(autoShowText))) ? COMPLETION_QUERY_TYPE : 0;
	}


	/**
	 * Returns map of macros which are not closed (int > 0) until caret position
	 * @param sequence
	 * @return
	 */
	private MacroCounterMap preprocessUnclosedMacros(TokenSequence<LatteTopTokenId> sequence) {
		paired = new MacroCounterMap();

		// find all pair macros
		for(LatteMacro macro : MacroDefinitions.macros) {
			if(macro.isPair()) {
				paired.put(macro.getMacroName(), Pair.of(macro, 0));
			}
		}

		while(sequence.movePrevious()) {
			Token<LatteTopTokenId> token = sequence.token();

			if(token.id() == LatteTopTokenId.LATTE) {
				TokenSequence<LatteTokenId> sequence2 = LexUtils.getSequence(token);

				sequence2.moveStart();

				boolean isEndMacro = false;

				while(sequence2.moveNext()) {
					Token<LatteTokenId> token2 = sequence2.token();

					// is end macro?
					if(token2.id() == LatteTokenId.END_SLASH && sequence2.offset() <= 2) {
						isEndMacro = true;
					}

					String text = token2.text().toString();
					//for comletion of end macros (preparation)
					if(token2.id() == LatteTokenId.MACRO && paired.containsKey(text)) {
						Pair<LatteMacro, Integer> p = paired.get(text);
						Pair newP;
						Integer i;
						if(!isEndMacro) {
							// increment with open pair macro
							i = (p.second == null ? 1 : p.second + 1);
							newP = Pair.of(p.first, i);
						} else {
							// decrement with close pair macro
							i = (p.second == null ? -1 : p.second - 1);
							newP = Pair.of(p.first, i);
						}
						paired.put(text, newP);
					}
				}
			}
		}
		return paired;
	}


	private ArrayList<LatteMacro> getFriendMacros() {
		ArrayList<LatteMacro> endMacros = new ArrayList<LatteMacro>();
		for(String key : paired.keySet()) {
			Pair<LatteMacro, Integer> p = paired.get(key);
			if(p.second != null && p.second > 0) {
				endMacros.add(p.first);
				if(MacroDefinitions.FRIEND_MACROS.containsKey(key)) {
					endMacros.addAll(Arrays.asList(MacroDefinitions.FRIEND_MACROS.get(key)));
				}
			}
		}
		return endMacros;
	}


	private Syntax getSyntax(JTextComponent jtc) {
		TokenSequence<LatteTopTokenId> sequence = LexUtils.getTopSequence(jtc.getDocument());
		sequence.move(jtc.getCaretPosition());

		Syntax syntax = LatteSyntax.getInstance();

		if(sequence.moveNext() || sequence.movePrevious()) {
			Token<LatteTopTokenId> token = sequence.token();
			if(token != null) {
				Syntax s = (Syntax) token.getProperty("syntax");
				if(s != null) {
					syntax = s;
				}
			}

		}

		return syntax;
	}


	private class MacroCounterMap extends HashMap<String, Pair<LatteMacro, Integer>> {
	}

}
