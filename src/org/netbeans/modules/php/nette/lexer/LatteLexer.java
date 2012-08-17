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

package org.netbeans.modules.php.nette.lexer;

import java.util.ArrayList;
import java.util.List;
import org.netbeans.api.lexer.Token;
import org.netbeans.modules.php.nette.lexer.syntax.LatteSyntax;
import org.netbeans.modules.php.nette.lexer.syntax.Syntax;
import org.netbeans.spi.lexer.Lexer;
import org.netbeans.spi.lexer.LexerInput;
import org.netbeans.spi.lexer.LexerRestartInfo;
import org.netbeans.spi.lexer.TokenFactory;

/**
 * Lexer for inside-macro tokenizing (must be parsed out by LatteTopLexer as LatteTopTokenId.LATTE)
 * @author Radek Ježdík
 */
class LatteLexer implements Lexer<LatteTokenId> {

    private static final int EOF = LexerInput.EOF;

    private final LatteColoringLexer scanner;

    private LexerInput input;

	private Syntax syntax = LatteSyntax.getInstance();

    private TokenFactory<LatteTokenId> tokenFactory;

    State state;

    LatteLexer(LexerRestartInfo<LatteTokenId> info, Syntax syn) {
        state = info.state() == null ? State.OUTER : (State) info.state();
        if(syn != null) {
            syntax = syn;
		}
        this.input = info.input();
        this.tokenFactory = info.tokenFactory();
        this.scanner = new LatteColoringLexer(info, state);
    }

    /**
     * Calls tokenizer and creates Token by token factory
     * @return Token<LatteTokenId>
     */
	@Override
    public Token<LatteTokenId> nextToken() {
        LatteTokenId tokenId = scanner.nextToken();

		if(tokenId == null) {
			return null;
		}

        return (tokenId.fixedText() != null)
            ? tokenFactory.getFlyweightToken(tokenId, tokenId.fixedText())
            : tokenFactory.createToken(tokenId);
    }

    /** keywords which will be highlited differently (like in PHP) */
    private final static List<String> keywords = new ArrayList<String>();
    static {
        keywords.add("true");
        keywords.add("false");
        keywords.add("array");
        keywords.add("null");
        keywords.add("new");
        keywords.add("as");
        keywords.add("or");
        keywords.add("and");
        keywords.add("xor");
        keywords.add("isset");
        keywords.add("instanceof");
        keywords.add("expand");
    };

    /** State of the lexer - where in tokenizing the macro the lexer ended */
    enum State {
        OUTER,				// out of macro
        AFTER_LD,			// after left delimiter {
        AFTER_MACRO,		// after macro name {macroName
        IN_FIRST_PARAM,		// in the first parameter of macro {macroName first_param
        IN_VAR,				// after $ character
        IN_INDEX,			// between [] for array index/key
        IN_HELPER,			// after helper delimiter |
        IN_HELPER_PARAM,	// after |helper:
        IN_PARAMS,			// macro parameters (except the first one)
        AFTER_INNER_LD,
        BEFORE_INNER_BRACKETS
    }

	private class LatteColoringLexer {

        private State state;
        private final LexerInput input;
        private int closingQuote;

        public LatteColoringLexer(LexerRestartInfo<LatteTokenId> info, State state) {
            this.input = info.input();
            this.state = state;
        }

		/**
		 * Tokenizes the input. In this lexer the input must be a latte macro (latte mime-type).
		 * For each character (or sequence) returns its LattteTokenId representative
		 *
		 * @return LattteTokenId token of LattteTokenId enum
		 */
		public LatteTokenId nextToken() {
			while(true) {
				int ch = input.read();								// next character from the input
				char chr = (char)ch;								// actual character (for debugging purpouse)
				CharSequence s = input.readText();					// whole text read (for debugging purpouse)
				if(ch == EOF) {
					return null;
				}									//end of file
				switch(state) {
					case OUTER:
						if(syntax.isOpening(input)) {				// start of the macro
							state = State.AFTER_LD;					// new state after left delimiter
							return LatteTokenId.LD;
						} else {
							input.backup(1);						// if no left delimiter it is a n:attribute value
							state = State.AFTER_MACRO;				// so start with after macro state
							continue;
						}
                    case BEFORE_INNER_BRACKETS:
                        if (ch == '{') {
                            state = State.AFTER_INNER_LD;
                            return LatteTokenId.LD;
                        }
                    case AFTER_INNER_LD:
                        while (true) {
                            if(ch == '$') {								// possible variable
                                int c = input.read();
                                if(Character.isLetter(c) || c == '_') {	// deals with valid names of php var
                                    while(true) {
                                        c = input.read();
                                        if((!Character.isLetterOrDigit(c) && c != '_') || ch == EOF) {
                                            input.backup(1);			// found char which is not valid char for php var
                                            return LatteTokenId.VARIABLE;
                                        }
                                    }
                                } else {
                                    return LatteTokenId.ERROR;	// else variable error
                                }
                            }
                            switch(ch) {
                                case '\'':								// string literal
                                case '"':
                                    int q = ch;							// saves type of a quote (double x single)
                                    boolean escape = false;				// is quote char escaped?
                                    while(true) {
                                        int c = input.read();
                                        if(c == q && escape == false) {	// if char is the closing quote and is not escaped
                                            return LatteTokenId.STRING;
                                        }
                                        escape = false;
                                        if(c == '\\') { // next char is escaped
											escape = true;
										}
                                        if(c == EOF) {
                                            return LatteTokenId.STRING;
                                        }
                                    }
                            }
                            LatteTokenId returnedToken = checkCommonCharacter(ch);
                            if (returnedToken != null) {
                                return returnedToken;
                            }
                            if (ch == '}') {
                                state = State.AFTER_MACRO;
                                return LatteTokenId.RD;
                            }

                            ch = input.read();
                        }
					case AFTER_LD:
						if(ch == '*') {								// comment
							while(true) {
								ch = input.read();
								if(ch == EOF) {						// comment macro not closed
									input.backup(1);
									state = State.OUTER;
									return LatteTokenId.COMMENT;
								}
								if(ch == '*') {						// finds closing comment delimiter *}
									ch = input.read();
									input.backup(1);				// right delim should not be tokenized as comment
									if(ch == '}' || ch == EOF) {
										state = State.AFTER_MACRO;
										return LatteTokenId.COMMENT;
									}
								}
							}
						}
						if(ch == '!') {								// no escaping
							ch = input.read();
							if(ch == '=' || ch == '_' || ch == '$') {	// macros which support ! char
								if(ch == '$') { // except $ char (will be used for variable)
									input.backup(1);
								}
								state = State.AFTER_MACRO;
								return LatteTokenId.MACRO;
							}
							return LatteTokenId.ERROR;
						}
						if(ch == '?' || ch == '=' || ch == '_' || ch == '#') {	// for all other macros see default: at the end
							state = State.AFTER_MACRO;
							return LatteTokenId.MACRO;
						}
						if(ch == '/') {
							return LatteTokenId.END_SLASH;
						}
					case AFTER_MACRO:
                        if (closingQuote != 0) { // after inner brackets {macro "string{innerBrackets} string"}
                            boolean escape = false;
                            while(true) {
                                if(ch == closingQuote && escape == false) {
                                    closingQuote = 0;
                                    return LatteTokenId.STRING;
                                }
                                escape = false;
                                if(ch == '\\') { // next char is escaped
									escape = true;
								}
                                if(ch == EOF) {
                                    return LatteTokenId.STRING;
                                }
                                ch = input.read();
                            }
                        }
						if(ch == '$') {								// possible variable
							int c = input.read();
							if(Character.isLetter(c) || c == '_') {	// deals with valid names of php var
								while(true) {
									c = input.read();
									if((!Character.isLetterOrDigit(c) && c != '_') || ch == EOF) {
										input.backup(1);			// found char which is not valid char for php var
										state = State.AFTER_MACRO;
										return LatteTokenId.VARIABLE;
									}
								}
							} else {
								return LatteTokenId.ERROR;	// else variable error
							}
						}
						switch(ch) {
							case '\'':								// string literal
							case '"':
								closingQuote = ch;							// saves type of a quote (double x single)
								boolean escape = false;				// is quote char escaped?
								while(true) {
									int c = input.read();
                                    if (c == '{') {
                                        input.backup(1);
                                        state = State.BEFORE_INNER_BRACKETS;
										return LatteTokenId.STRING;
                                    }
									if(c == closingQuote && escape == false) {	// if char is the closing quote and is not escaped
                                        closingQuote = 0;
										return LatteTokenId.STRING;
									}
									escape = false;
									if(c == '\\') { // next char is escaped
										escape = true;
									}
									if(c == EOF) {
										return LatteTokenId.STRING;
									}
								}
						}
                        LatteTokenId returnedToken = checkCommonCharacter(ch);
                        if (returnedToken != null) {
                            return returnedToken;
                        }
					// if nothing of above did not matched
					default:
						if(syntax.isClosing(input)) {				// closing delimiter
							state = State.OUTER;
							return LatteTokenId.RD;
						}
						if(Character.isWhitespace(ch)) {			// whitespace
							ch = input.read();
							while (ch != EOF && Character.isWhitespace((char)ch)) {
								ch = input.read();
							}
							input.backup(1);
							return LatteTokenId.WHITESPACE;
						}
						if(Character.isLetter(ch) || ch == '_') {	// any text
							while(true) {
								ch = input.read();
								if(!Character.isLetterOrDigit(ch) && ch != '_' && ch != '.' && ch != ':') {
									input.backup(1);
									if(state == State.AFTER_LD) {	// after left delim, so it is a macro name!
										state = State.AFTER_MACRO;
										return LatteTokenId.MACRO;
									}
									state = State.AFTER_MACRO;		// all else is after macro

									// if read text is one of php keywords, return KEYWORD token
									if(keywords.contains(input.readText().toString().toLowerCase())) {
										return LatteTokenId.KEYWORD;
									}

									// all else is just text (action name in plink, template name in include, ...)
									return LatteTokenId.TEXT;
								}
							}
						}
						// anything else that didn't mach is a syntax error!!
						return LatteTokenId.ERROR;
				}
			}
		}

        private LatteTokenId checkCommonCharacter(int ch) {
            switch (ch) {
                case '/':
                    //inside macro php comment /* */
                    if(input.read() == '*') {
                        while(true) {
                            int c = input.read();
                            if((c == '*' && input.read() == '/') || c == EOF) {
                                return LatteTokenId.COMMENT;
                            }
                            if(c == '*') {
                                input.backup(1);
                            }
                        }
                    } else {	// slash as operator
                        input.backup(1);
                        return LatteTokenId.SLASH;
                    }
                // number literal
                case '0': case '1': case '2': case '3': case '4':
                case '5': case '6': case '7': case '8': case '9':
                case '.':
                    return finishIntOrFloatLiteral(ch);

                // equals sign or php array assign =>
                case '=':
                    if(input.read() == '>') {
						return LatteTokenId.ASSIGN;
					}
                    input.backup(1);
                    return LatteTokenId.EQUALS;

                case ':':
                    return LatteTokenId.COLON;

                case '+': return LatteTokenId.PLUS;

                // minus sign or object access (accessing field or method..)
                case '-':
                    if(input.read() == '>') {
						return LatteTokenId.ACCESS;
					}
                    input.backup(1);
                    return LatteTokenId.MINUS;

                // all other characters
                case '*': return LatteTokenId.STAR;
                case '|': return LatteTokenId.PIPE;
                case ',': return LatteTokenId.COMA;
                case '(': return LatteTokenId.LNB;
                case ')': return LatteTokenId.RNB;
                case '[': return LatteTokenId.LB;
                case ']': return LatteTokenId.RB;
                case '!': return LatteTokenId.NEGATION;
                case '<': return LatteTokenId.LT;
                case '>': return LatteTokenId.GT;
                case ';': return LatteTokenId.SEMICOLON;
                case '&': return LatteTokenId.AND;
                case '@': return LatteTokenId.AT;
                case '#': return LatteTokenId.HASH;
                case '?': return LatteTokenId.QUESTION;
                default:
                    return null;
            }
        }

	}

    /**
     * Returns state in which the lexer ended in current tokenizing
     * @return State
     */
	@Override
    public Object state() {
        return state;
    }

    /**
     * Finishes current token representing a number
     * FIXME: single dot is also tokenized as number (in php it is a legal operator for string concatenation)
     * @param int ch character currently tokenized
     * @return LatteTokenId
     */
    private LatteTokenId finishIntOrFloatLiteral(int ch) {
        boolean floatLiteral = false;
        while (true) {
            switch (ch) {
                case '.':
                    if (floatLiteral) {
                        return LatteTokenId.NUMBER;
                    } else {
                        floatLiteral = true;
                    }
                    break;
                case '0': case '1': case '2': case '3': case '4':
                case '5': case '6': case '7': case '8': case '9':
                    break;
                default:
                    input.backup(1);
                    return LatteTokenId.NUMBER;
            }
            ch = input.read();
        }
    }

    /**
     * Creates token from factory
     * @param id
     * @return
     */
    private Token<LatteTokenId> token(LatteTokenId id) {
        return (id.fixedText() != null)
            ? tokenFactory.getFlyweightToken(id, id.fixedText())
            : tokenFactory.createToken(id);
    }

	@Override
    public void release() {
		// intentionally
    }
}
