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

import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author Ondřej Brejla
 */
abstract public class MacroProcessorFactory {

	private static final List<String> ARRAY_MACROS = new ArrayList<String>();
	static {
		ARRAY_MACROS.add("var");
		ARRAY_MACROS.add("default");
		ARRAY_MACROS.add("assign");
	};

	private static final List<String> SPECIAL_MACROS = new ArrayList<String>();
	static {
		SPECIAL_MACROS.add("plink");
		SPECIAL_MACROS.add("link");
		SPECIAL_MACROS.add("widget");
		SPECIAL_MACROS.add("control");
		SPECIAL_MACROS.add("include");
		SPECIAL_MACROS.add("extends");
		SPECIAL_MACROS.add("cache");
	};

	public static MacroProcessor getMacroProcessor(String macro) {
		if (ARRAY_MACROS.contains(macro)) {
			return new ArrayMacroProcessor();
		} else if (SPECIAL_MACROS.contains(macro)) {
			return new SpecialMacroProcessor();
		} else {
			return MacroProcessor.NONE;
		}
	}

	private MacroProcessorFactory() {}

}
