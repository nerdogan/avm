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
package org.netbeans.modules.php.nette.macros;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

/**
 *
 * @author Radek Ježdík
 */
public class MacroDefinitions {

	public static LatteMacro[] macros = {
        new LatteCommentMacro(),
        new LatteSingleMacro("$"),
        new LatteSingleMacro("!$"),
        new LatteSingleMacro("="),
        new LatteSingleMacro("!="),
        new LatteSingleMacro("?", false, true),
        new LatteSingleMacro("_"),
        new LatteSingleMacro("!_"),
        new LatteParamMacro("link", false),
        new LatteParamMacro("plink", false),
        new LatteParamMacro("if", true, true),
        new LatteParamMacro("ifset", true, true),
        new LatteParamMacro("ifCurrent", true, true),
        new LatteParamMacro("for", true, true),
        new LatteParamMacro("foreach", true, true),
        new LatteParamMacro("while", true, true),
        new LatteParamMacro("include", false),
        new LatteParamMacro("extends", false, true),
        new LatteParamMacro("layout", false, true),
        new LatteParamMacro("widget", false),
        new LatteParamMacro("control", false),
        new LatteParamMacro("cache", true, true),
        new LatteParamMacro("snippet", true, true),
        new LatteParamMacro("attr", false),
        new LatteParamMacro("block", true),
        new LatteParamMacro("define", true, true),
        new LatteParamMacro("includeblock", false, true),
        new LatteParamMacro("contentType", false),
        new LatteParamMacro("status", false, true),
        new LatteParamMacro("capture", true, true),
        new LatteParamMacro("assign", false, true),
        new LatteParamMacro("default", false, true),
        new LatteParamMacro("var", false, true),
        new LatteParamMacro("dump", false, true),
        new LatteParamMacro("syntax", true, true),
        new LatteParamMacro("use", false, true),
        new LatteParamMacro("form", true),
        new LatteParamMacro("label", true),
        new LatteParamMacro("input", true),
        new LatteMacro("debugbreak", false, true),
        new LatteMacro("l", false),
        new LatteMacro("r", false),
        new LatteMacro("first", true, true),
        new LatteMacro("last", true, true),
        new LatteMacro("sep", true, true),
        new LatteMacro("_", true),
    };

	public static LatteMacro[] nAttrs = {
        new LatteParamMacro("href", true),
        new LatteParamMacro("class", true),
        new LatteParamMacro("input", true),
        new LatteParamMacro("attr", true),
    };

	/**
	 * Defines friend macros of some block macros
	 */
    public final static HashMap<String, LatteMacro[]> friendMacros = new HashMap<String, LatteMacro[]>();
    static {
        friendMacros.put("if", new LatteMacro[] {
            new LatteMacro("else", false, true),
            new LatteParamMacro("elseif", false, true)
        });
        friendMacros.put("ifset", new LatteMacro[] {
            new LatteMacro("else", false, true),
            new LatteParamMacro("elseif", false, true),
            new LatteParamMacro("elseifset", false, true)
        });
        friendMacros.put("ifCurrent", new LatteMacro[] {
            new LatteMacro("else", false, true),
            new LatteParamMacro("elseif", false, true)
        });
        friendMacros.put("while", new LatteMacro[] {
            new LatteParamMacro("continueIf", false, true),
            new LatteParamMacro("breakIf", false, true)
        });
        friendMacros.put("foreach", new LatteMacro[] {
            new LatteParamMacro("continueIf", false, true),
            new LatteParamMacro("breakIf", false, true)
        });
        friendMacros.put("for", new LatteMacro[] {
            new LatteParamMacro("continueIf", false, true),
            new LatteParamMacro("breakIf", false, true)
        });
        /*friendMacros.put("foreach", new LatteMacro[] {
            new LatteMacro("first", true),
            new LatteMacro("last", true),
            new LatteMacro("sep", true)
        });*/
    };

	/**
	 * Defines macros, which can be used as <n:tag
	 */
    public final static HashMap<String, String[]> tagMacros = new HashMap<String, String[]>();
    static {
        tagMacros.put("assign", new String[] { "" });
        tagMacros.put("include", new String[] { "block" });
        tagMacros.put("for", new String[] { "each" });
        tagMacros.put("block", new String[] { "name" });
        tagMacros.put("if", new String[] { "cond" });
        tagMacros.put("elseif", new String[] { "cond" });
    };

	/*
	 * List of helpers (TODO: dynamically)
	 */
    public static String[] helpers = {
        "truncate", "substr", "trim", "striptags", "strip", "webalize", "toAscii", "indent",
		"padLeft", "padRight", "repeat", "implode", "lower", "upper", "firstUpper", "capitalize",
        "replace", "replaceRE", "nl2br", "stripTags", "number", "date", "bytes", "url", "length", "dataStream",
		"null"
    };


	/**
	 * Searches for macro object with specified name
	 * @param name
	 * @return
	 */
    public static LatteMacro getMacro(String name) {
		if(name.equals("!")) {
			name = name + "$";
		}
        for(LatteMacro m : macros) {
            if(m.getMacroName().equals(name)) {
                return m;
            }
        }
        return null;
    }

	/**
	 * Searches for all Macro objects with specifiend end name
	 * @param name
	 * @return
	 */
    public static List<LatteMacro> getMacrosByEnd(String name) {
        List<LatteMacro> list = new ArrayList<LatteMacro>();
        for(LatteMacro m : macros) {
            if(m.isPair && m.getEndMacroName().equals(name)) {
                list.add(m);
            }
        }
        return list;
    }

}
