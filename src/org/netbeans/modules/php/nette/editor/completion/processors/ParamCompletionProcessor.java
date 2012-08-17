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
package org.netbeans.modules.php.nette.editor.completion.processors;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import javax.swing.text.Document;
import org.netbeans.api.lexer.Token;
import org.netbeans.api.lexer.TokenSequence;
import org.netbeans.modules.parsing.api.Source;
import org.netbeans.modules.php.nette.editor.completion.items.BaseCompletionItem;
import org.netbeans.modules.php.nette.editor.completion.items.ControlCompletionItem;
import org.netbeans.modules.php.nette.editor.completion.items.PresenterCompletionItem;
import org.netbeans.modules.php.nette.lexer.LatteTokenId;
import org.netbeans.modules.php.nette.lexer.LatteTopTokenId;
import org.netbeans.modules.php.nette.utils.EditorUtils;
import org.netbeans.spi.editor.completion.CompletionItem;
import org.openide.filesystems.FileObject;

/**
 *
 * @author Radek Ježdík
 */
public class ParamCompletionProcessor {

	public List<CompletionItem> process(TokenSequence<LatteTopTokenId> sequence, TokenSequence<LatteTokenId> sequence2,
			Document document, int caretOffset) {

		List<CompletionItem> list = new ArrayList<CompletionItem>();

		String macroName = (String) sequence.token().getProperty("macro");
		boolean isAttr = (macroName != null);

		sequence2.moveStart();
		while(isAttr || sequence2.moveNext()) {
			Token<LatteTokenId> token2 = (isAttr ? null : sequence2.token());
			if(!isAttr && sequence2.offset() + sequence.offset() > caretOffset) {
				break;
			}
			if((token2 != null && token2.id() == LatteTokenId.MACRO) || macroName != null) {
				if(!isAttr) {
					macroName = token2.text().toString();
				}
				if(macroName.equals("plink") || macroName.equals("link")
						|| macroName.equals("widget") || macroName.equals("control")
						|| macroName.equals("extends") || macroName.equals("include")
						|| macroName.equals("syntax")) {
					String written = "";					// text written to caret pos
					String whole = "";						// whole text of the param (overwritten by completion)

					int whiteOffset = -1, whiteLength = 0, whiteNum = 0;
					boolean ok = false;

					while(sequence2.moveNext()) {
						token2 = sequence2.token();
						//if processing token after caret position just update whole
						if(sequence2.offset() + sequence.offset() >= caretOffset) {
							if(token2.id() != LatteTokenId.COLON && token2.id() != LatteTokenId.TEXT) {
								break;
							}
							whole += token2.text();
						}

						if(isAttr && whiteNum == 0) {
							whiteNum++;
							whiteOffset = sequence2.offset() + sequence.offset();
						}
						if(whiteNum == 1 && sequence2.offset() + sequence.offset() < caretOffset) {
							written += token2.text();
							whole = written;
							ok = true;
						} else if(whiteNum > 1) {
							ok = false;
							break;
						}

						// counts whitespaces, this completion is used in first param only
						if(token2.id() == LatteTokenId.WHITESPACE && !isAttr) {
							whiteOffset = sequence2.offset() + sequence.offset();
							whiteLength = token2.length();
							whiteNum++;
							if(whiteNum == 1) {
								ok = true;
							}
						}
					}
					if(ok && (macroName.equals("plink") || macroName.equals("link"))) {
						list.addAll(parseLink(document, written, whiteOffset + whiteLength, whole.length()));
					}
					if(ok && (macroName.equals("widget") || macroName.equals("control"))) {
						list.addAll(parseControl(document, written, whiteOffset + whiteLength, whole.length()));
					}
					if(ok && (macroName.equals("extends") || macroName.equals("include"))) {
						list.addAll(parseLayout(document, written, whiteOffset + whiteLength, whole.length()));
					}
					if(ok && macroName.equals("syntax")) {
						list.addAll(getSyntaxCompletions(written.trim(), whiteOffset + whiteLength, whole.length()));
					}
				}
				break;
			}
		}
		return list;
	}

	/**
     * Parses out links from modules/presenters which are in the current application
     * @param doc Latte Template document
     * @param written user-written text (until caret)
     * @param startOffset document text offset where to start completion
     * @param length of text to overwrite
     * @return List<CompletionItem> ready completion set to add to CompletionResultSet
     */
    private static List<CompletionItem> parseLink(Document doc, String link, int startOffset, int length) {
        FileObject fo = Source.create(doc).getFileObject();

        List<CompletionItem> list = new ArrayList<CompletionItem>();

        if (link.contains(":")) { // NOI18N
            String[] parts = link.split(":"); // NOI18N
            for(String s : EditorUtils.getAllPresenters(fo)) {
                String[] pPath = s.split(":"); // NOI18N
                boolean ok = false;
                if(pPath.length >= parts.length) {
                    for(int i = 0; i < parts.length; i++) {
                        if(( i != parts.length - 1 && pPath[i].equals(parts[i]) )
                                || pPath[i].startsWith(parts[i])) {
                            ok = true;
                        }
                        else {
                            ok = false;
                            break;
                        }
                    }
                }
                if(ok || (parts.length == 0 && s.startsWith(":")) ) {
                    list.add(new PresenterCompletionItem(s, startOffset, startOffset + length));
                }
            }
        } else {
            for(String s : EditorUtils.getAllPresenters(fo)) {
                if(s.startsWith(link)) {
                    list.add(new PresenterCompletionItem(s, startOffset, startOffset + length));
                }
            }
        }
        return list;
    }

    /**
     * Parses components/controls from presenter php file which this template belongs to
     * @param doc Latte Template document
     * @param written user-written text (until caret)
     * @param startOffset document text offset where to start completion
     * @param length of text to overwrite
     * @return List<CompletionItem> ready completion set to add to CompletionResultSet
     */
    private static List<CompletionItem> parseControl(Document doc, String written, int startOffset, int length) {
        List<CompletionItem> list = new ArrayList<CompletionItem>();
        try {
            FileObject fo = Source.create(doc).getFileObject();

            String presenter = EditorUtils.getPresenter(fo);

            Pattern pattern = Pattern.compile("createComponent([A-Za-z_][A-Za-z_]*) *\\("); // NOI18N

            presenter += "Presenter.php"; // NOI18N
            byte ps = 0;
            while (true) {
                fo = fo.getParent();
                for (FileObject f : fo.getChildren()) {
                    if (f.isFolder() && f.getName().equals("presenters")) { // NOI18N
                        File p = new File(f.getPath(), presenter);
                        if (p.exists()) {
                            try {
                                BufferedReader bis = new BufferedReader(new FileReader(p));
                                String line;
                                while ((line = bis.readLine()) != null) {
                                    if (line.contains("createComponent")) { // NOI18N
                                        Matcher m = pattern.matcher(line);
                                        String control = null;
                                        if (m.find()) {
                                            String parsedName = m.group(1);
                                            control = EditorUtils.firstLetterSmall(parsedName);
                                        }
                                        if(control != null && control.startsWith(written)) {
                                            list.add(new ControlCompletionItem(control, startOffset, startOffset + length));
                                        }
                                    }
                                }
                            } catch (IOException ioe) {
                                //Logger.getLogger("TmplCompletionQuery").warning("scanning of unnexisting file " + p.getAbsolutePath());
                            }
                        }
                        break;
                    }
                }
                // just 5 levels up
                if (ps > 5) {
                    break;
                }
                ps++;
            }
        } catch (Exception e) {
            // intentionaly
        }

        return list;
    }

    /**
     *
     * @param doc Latte Template document
     * @param written user-written text (until caret)
     * @param startOffset document text offset where to start completion
     * @param length of text to overwrite
     * @return List<CompletionItem> ready completion set to add to CompletionResultSet
     */
    private static List<CompletionItem> parseLayout(Document doc, String written, int startOffset, int length) {
        List<CompletionItem> list = new ArrayList<CompletionItem>();

        FileObject fo = Source.create(doc).getFileObject();
        List<String> layouts = EditorUtils.getLayouts(fo);

        for(String path : layouts) {
            if(path.startsWith(written)) {
                list.add(new PresenterCompletionItem(path, startOffset, startOffset + length));
            }
        }

        return list;
    }

	/**
	 * Returns syntax macro param completion (double)
	 * @return
	 */
	private static List<CompletionItem> getSyntaxCompletions(String written, int startOffset, int length) {
		List<CompletionItem> list = new ArrayList<CompletionItem>();
		String[] types = {
			"latte",
			"double",
			"asp",
			"python",
			"off"
		};
		for(String t : types) {
			if(t.startsWith(written)) {
				list.add(new BaseCompletionItem(t, startOffset, startOffset+length));
			}
		}
		return list;
	}
}
