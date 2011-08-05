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
package org.netbeans.modules.php.nette.lexer;

import org.netbeans.modules.php.nette.lexer.syntax.LatteSyntax;

/**
 * Resolves nested tags and syntax switching with n:syntax attribute
 * @author Radek Ježdík
 */
class TagResolver {

	private final String tag;
	private final int nested;
	private final boolean syntaxe;

	public TagResolver(CharSequence readText) {
		this(readText.toString(), 0, false);
	}

	public TagResolver(String tag, int nested, boolean syntaxe) {
		this.tag = (tag.startsWith("<") ? tag.substring(1) : tag);
		this.nested = nested;
		this.syntaxe = syntaxe;
	}

	public void nest(LatteTopLexer lexer) {
		if(syntaxe) {
			lexer.tagResolver = new TagResolver(tag, nested + 1, syntaxe);
		}
	}

	public void unnest(LatteTopLexer lexer) {
		if(nested - 1 == 0) {
			lexer.syntax = LatteSyntax.getInstance();
			return;
		}
		if(syntaxe) {
			lexer.tagResolver = new TagResolver(tag, nested - 1, syntaxe);
		}
	}

	public void setSyntax(LatteTopLexer lexer) {
		lexer.tagResolver = new TagResolver(tag, nested, true);
	}

	public boolean hasSyntax() {
		return syntaxe;
	}
}