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

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import org.netbeans.api.lexer.Token;
import org.netbeans.api.lexer.TokenSequence;
import org.netbeans.modules.php.nette.lexer.LatteTokenId;
import org.netbeans.modules.php.nette.lexer.LatteTopTokenId;
import org.netbeans.modules.php.nette.utils.LexUtils;
import org.netbeans.spi.tasklist.FileTaskScanner;
import org.netbeans.spi.tasklist.Task;
import org.openide.filesystems.FileObject;
import org.openide.util.Exceptions;


/**
 *
 * @author Radek Ježdík
 */
public class LatteTaskScanner extends FileTaskScanner {
	
	private static final String EOL_PATTERN = "\\r?\\n";
	
	private static final Pattern pattern = Pattern.compile("(?i)(@(todo|fixme) .*)");
	
	private List<Task> tasks = new ArrayList<Task>();
	
	private int currentLine = 1;
	
	
	public LatteTaskScanner() {
		super("Latte Task Scanner", "Scanning Latte files for user tasks", null);
	}
	
	
	@Override
	public List<? extends Task> scan(FileObject resource) {
		if(!resource.getExt().equals("latte")) {
			return null;
		}
		currentLine = 1;
		tasks.clear();
		try {
			TokenSequence<LatteTopTokenId> sequence = LexUtils.getTopSequence(resource.asText());
			sequence.moveStart();
			
			while(sequence.moveNext()) {
				Token<LatteTopTokenId> token = sequence.token();
				
				if(token.id() == LatteTopTokenId.LATTE) {
					TokenSequence<LatteTokenId> sequence2 = LexUtils.getSequence(token);
					sequence2.moveStart();
					
					if(sequence2.moveNext()) {
						Token<LatteTokenId> token2 = sequence2.token();
						// if it is LD, the next one must be comment
						if(token2.id() == LatteTokenId.LD) {
							sequence2.moveNext();
							token2 = sequence2.token();
						}
						// is comment?
						if(token2.id() == LatteTokenId.COMMENT) {
							String comment = token2.toString();
							comment = comment.substring(0, token2.length() - 1);
							tasks.addAll(searchForTasks(comment, resource));
							continue;
						}
					}
				}
				currentLine += computeLineNum(token);
			}
		} catch(IOException ex) {
			Exceptions.printStackTrace(ex);
		}
		return tasks;
	}
	
	
	@Override
	public void attach(Callback callback) {
	}
	

	private int computeLineNum(Token token) {
		// split -1 counts trailing pattern
		return token.toString().split(EOL_PATTERN, -1).length - 1;
	}
	
	
	private List<Task> searchForTasks(String comment, FileObject resource) {
		List<Task> list = new ArrayList<Task>();
		
		String[] lines = comment.split(EOL_PATTERN);
		Matcher matcher = pattern.matcher(lines[0]);
		
		for(String line : lines) {
			matcher.reset(line);
			if(matcher.find()) {
				String desc = matcher.group(0);
				Task tsk = Task.create(resource, "nb-tasklist-todo", desc, currentLine);
				list.add(tsk);
			}
			currentLine++;
		}
		return list;
	}
	
}
