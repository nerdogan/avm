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
package org.netbeans.modules.php.nette.editor;

import java.util.Collections;
import java.util.HashSet;
import java.util.Set;
import org.netbeans.api.lexer.Token;
import org.netbeans.api.lexer.TokenHierarchy;
import org.netbeans.api.lexer.TokenSequence;
import org.netbeans.modules.csl.api.InstantRenamer;
import org.netbeans.modules.csl.api.OffsetRange;
import org.netbeans.modules.csl.spi.ParserResult;
import org.netbeans.modules.php.nette.lexer.LatteTokenId;
import org.netbeans.modules.php.nette.lexer.LatteTopTokenId;
import org.netbeans.modules.php.nette.utils.LexUtils;

/**
 *
 * @author Radek Ježdík
 */
public class LatteInstantRenamer implements InstantRenamer {

	private Token originalToken = null;

	@Override
	public boolean isRenameAllowed(ParserResult pr, int caretOffset, String[] strings) {
		TokenSequence<LatteTopTokenId> ts = LexUtils.getTopSequence(pr.getSnapshot().getText().toString());
		ts.move(caretOffset);

		if(ts.moveNext()) {
			if(ts.token().id() != LatteTopTokenId.LATTE) {
				return false;
			}
			TokenHierarchy<CharSequence> th2 = TokenHierarchy.create(ts.token().text(), LatteTokenId.language());
			TokenSequence<LatteTokenId> ts2 = th2.tokenSequence(LatteTokenId.language());

			ts2.move(caretOffset - ts.offset());
			if(ts2.moveNext() || ts2.movePrevious()) {
				Token<LatteTokenId> t = ts2.token();
				if(t.id() == LatteTokenId.VARIABLE) {
					originalToken = t;
					return true;
				}
			}
		}
		return false;
	}

	@Override
	public Set<OffsetRange> getRenameRegions(ParserResult pr, int caretOffset) {
		Set<OffsetRange> regions = new HashSet<OffsetRange>();

		String ident = originalToken.toString();

		TokenSequence<LatteTopTokenId> ts = LexUtils.getTopSequence(pr.getSnapshot().getText().toString());
		ts.moveStart();
		while(ts.moveNext()) {
			if(ts.token().id() == LatteTopTokenId.LATTE) {
				TokenHierarchy<CharSequence> th2 = TokenHierarchy.create(ts.token().text(), LatteTokenId.language());
				TokenSequence<LatteTokenId> ts2 = th2.tokenSequence(LatteTokenId.language());

				ts2.moveStart();
				while(ts2.moveNext()) {
					Token token2 = ts2.token();
					if(token2.id() == LatteTokenId.VARIABLE && token2.toString().equals(ident)) {
						int offset = ts.offset() + ts2.offset();
						regions.add(new OffsetRange(offset + 1, offset + token2.length()));
					}
				}
			}
		}

		if(regions.isEmpty()) {
			return Collections.EMPTY_SET;
		}
		return regions;
	}
}
