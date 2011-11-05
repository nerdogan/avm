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
package org.netbeans.modules.php.nette.utils;

import javax.swing.text.BadLocationException;
import javax.swing.text.Document;
import org.netbeans.api.lexer.InputAttributes;
import org.netbeans.api.lexer.Language;
import org.netbeans.api.lexer.Token;
import org.netbeans.api.lexer.TokenHierarchy;
import org.netbeans.api.lexer.TokenSequence;
import org.netbeans.modules.php.nette.lexer.LatteTokenId;
import org.netbeans.modules.php.nette.lexer.LatteTopTokenId;
import org.netbeans.modules.php.nette.lexer.syntax.Syntax;
import org.openide.util.Exceptions;


/**
 *
 * @author Radek Ježdík
 */
public final class LexUtils {

	private final static TopSequenceCache topCache = new TopSequenceCache();

	private final static SequenceCache tokenCache = new SequenceCache();


	/**
	 * @author Ondřej Brejla <ondrej@brejla.cz>
	 */
	private LexUtils() {
	}


	public static TokenSequence<LatteTopTokenId> getTopSequence(Document document) {
		try {
			return getTopSequence(document.getText(0, document.getLength()));
		} catch(BadLocationException e) {
			Exceptions.printStackTrace(e);
		}
		return null;
	}


	public static TokenSequence<LatteTopTokenId> getTopSequence(String text) {
		if(topCache.has(text)) {
			return topCache.get(text);
		}
		TokenHierarchy<String> th = TokenHierarchy.create(text, LatteTopTokenId.language());
		TokenSequence<LatteTopTokenId> sequence = th.tokenSequence(LatteTopTokenId.language());

		topCache.save(text, sequence);
		return sequence;
	}


	public static TokenSequence<LatteTokenId> getSequence(Token<LatteTopTokenId> t) {
		if(tokenCache.has(t)) {
			return tokenCache.get(t);
		}

		InputAttributes attrs = new InputAttributes();

		Syntax syntax = (Syntax) t.getProperty("syntax");

		Language<LatteTokenId> language = LatteTokenId.language(syntax);

		TokenHierarchy<CharSequence> th2 = TokenHierarchy.create(t.text(), true, language, null, attrs);
		TokenSequence<LatteTokenId> sequence = th2.tokenSequence(language);

		tokenCache.save(t, sequence);
		return sequence;
	}


	private static class TopSequenceCache extends Cache<String, TokenSequence<LatteTopTokenId>> {

		public TopSequenceCache() {
			super(20);
		}

	}


	private static class SequenceCache extends Cache<Token, TokenSequence<LatteTokenId>> {

		public SequenceCache() {
			super(200);
		}

	}

}
