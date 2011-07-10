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

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.FilenameFilter;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Enumeration;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import org.netbeans.modules.php.api.editor.PhpBaseElement;
import org.netbeans.modules.php.api.editor.PhpClass;
import org.netbeans.modules.php.api.phpmodule.PhpModule;
import org.netbeans.spi.project.support.ant.PropertyUtils;
import org.netbeans.modules.php.nette.NetteFramework;
import org.openide.filesystems.FileObject;
import org.openide.filesystems.FileUtil;

/**
 * Some utils used for editor operations
 * @author Radek Ježdík, Ondřej Brejla
 */
public final class EditorUtils {

	private static final String FILE_VIEW_RELATIVE_CLASSIC = "../templates/%s/%s" + NetteFramework.NETTE_LATTE_TEMPLATE_EXTENSION; // NOI18N

	private static final String FILE_VIEW_RELATIVE_DOTTED = "../templates/%s.%s" + NetteFramework.NETTE_LATTE_TEMPLATE_EXTENSION; // NOI18N
    
    private static final String FILE_PRESENTER_RELATIVE_CLASSIC = "../../presenters/%s" + NetteFramework.NETTE_PRESENTER_SUFFIX + NetteFramework.NETTE_PRESENTER_EXTENSION;
    
    private static final String FILE_PRESENTER_RELATIVE_DOTTED = "../presenters/%s" + NetteFramework.NETTE_PRESENTER_SUFFIX + NetteFramework.NETTE_PRESENTER_EXTENSION;

	/**
	 * @author Ondřej Brejla <ondrej@brejla.cz>
	 */
	private EditorUtils() {
	}

    /**
     * Gets presenter name of the Template file
     * @param fo Latte Template file object
     * @return String presenter name
     */
    public static String getPresenter(FileObject fo) {
        String[] fn = fo.getName().split("\\."); // NOI18N

        if (fn.length == 2) {
            return fn[0];                         //Presenter.view.latte
        } else {
            return fo.getParent().getName();        //Presenter/view.latte
        }
    }

    /**
     * Gets presenter name of the Template file
     * @param fo Latte Template file object
     * @return String presenter name
     */
    public static FileObject getPresenterFile(FileObject fo) {
		String presenter = getPresenter(fo) + "Presenter.php"; // NOI18N

        byte level = 0;
        while (true) {
            level++;

            fo = fo.getParent();
			if (fo == null) {
				return null;
			}
			
            if(fo.getName().equals("sessions") // NOI18N
                    || fo.getName().equals("temp") || fo.getName().equals("logs")) // NOI18N
                continue;
            for (FileObject f : fo.getChildren()) {
                if (f.isFolder() && f.getName().equals("presenters")) { // NOI18N
                    File p = new File(f.getPath(), presenter);
                    if (p.exists()) {
                        return FileUtil.toFileObject(p);
                    }
                    break;
                }
            }
            if(fo.getName().equals("app")) { // NOI18N
                break;
            }
            if(level > 6) {   // just 5 levels up
                break;
            }
        }

        return null;
    }

    /**
     * Searches for all presenter paths (modules + presenters)
     * @param fo File which is in php module
     * @return List of all presenter paths
     */
    public static List<String> getAllPresenters(FileObject fo) {
        File appDir = new File(PhpModule.forFileObject(fo).getSourceDirectory().getPath() + NetteFramework.NETTE_APP_DIR);
        
        Enumeration<? extends FileObject> files = FileUtil.toFileObject(appDir).getChildren(true);

        Pattern p = Pattern.compile("class +([A-Za-z_][A-Za-z0-9_]*)Presenter"); // NOI18N
        
        List<String> list = new ArrayList<String>();
        while (files.hasMoreElements()) {
            FileObject pfo = files.nextElement();
            File file = FileUtil.toFile(pfo);
            if (pfo.getNameExt().endsWith("Presenter.php") && file.exists()) { // NOI18N
                try {
                    BufferedReader bis = new BufferedReader(new FileReader(file));
                    String line;
                    while ((line = bis.readLine()) != null) {
                        if(line.contains("class ") && !line.contains("abstract")) { // NOI18N
                            Matcher m = p.matcher(line);
                            String presenterPath = "";
                            if(m.find()) {
                                presenterPath = m.group(1);     //presenter name
                            }
                            if(presenterPath.contains("_")) {
                                //creates path with modules
                                presenterPath = ":"+presenterPath.replaceAll("_", ":"); // NOI18N
                            }
                            presenterPath += ":";
                            list.add(presenterPath);
                            break;
                        }
                    }
                } catch (IOException ioe) {
                    
                }
            }
        }
        return list;
    }

    /**
     * Searches for all layouts or global templates (with preceding @ char)
     * @param fo file in app folder from which a relative path will be constructed
     * @return list of layouts relative path
     */
    public static List<String> getLayouts(FileObject fo) {
        ArrayList<String> layouts = new ArrayList<String>();

        FileObject fp = fo;
        while(true) {
            fp = fp.getParent();
            if(fp.isFolder() && fp.getName().equals("app"))
                break;
        }
        List<FileObject> fos = FileUtils.getFilesRecursive(fp, new FilenameFilter() {
			@Override
            public boolean accept(File dir, String name) {
                return name.startsWith("@") && name.endsWith(NetteFramework.NETTE_LATTE_TEMPLATE_EXTENSION);  // NOI18N
            }
        });
        for(FileObject f : fos) {
            String rel = getRelativePath(fo, f);
            if(rel != null)
                layouts.add(rel);
        }

        return layouts;
    }

    /**
     *
     * @param from file or folder which to to create relative path from
     * @param to file which create a relative path to
     * @return relative path
     */
    public static String getRelativePath(FileObject from, FileObject to) {
        ArrayList<String> fPath = new ArrayList<String>(Arrays.asList(from.getPath().split("/")));
        ArrayList<String> tPath = new ArrayList<String>(Arrays.asList(to.getPath().split("/")));

        String relPath = "";
        try {
            while(true) {
                if(fPath.get(0).equals(tPath.get(0))) {
                    fPath.remove(0);
                    tPath.remove(0);
                }
                else
                    break;
            }
            if(fPath.size() > 1) {
                for(int i = 0; i < fPath.size()-1; i++) {
                    relPath += "../";
                }
            }
            for(int i = 0; i < tPath.size(); i++) {
                relPath += tPath.get(i);
                if(i != tPath.size()-1)
                    relPath += "/";
            }
        } catch (Exception e) {
            // intentionally
            // when relativizing two same files -> returning null
        }
        return relPath.equals("") ? null : relPath;
    }

	/**
	 * Returns string with first letter capital.
	 *
	 * @param s
	 * @return
	 */
	public static String firstLetterCapital(String s) {
        if (s.length() == 0) {
			return s;
		}

        return s.substring(0, 1).toUpperCase() + s.substring(1);
    }

	/**
	 * Returns string with first letter small.
	 *
	 * @param s
	 * @return
	 */
	public static String firstLetterSmall(String s) {
		if (s.length() == 0) {
			return s;
		}

		return s.substring(0, 1).toLowerCase() + s.substring(1);
	}

	/**
	 * Gets 'Whatever_MyPresenter.php' and returns 'My'.
	 *
	 * @param presenterFileName
	 * @return
	 */
	public static String extractPresenterName(String presenterFileName) {
		String modulePrefixPattern = "^(.*)_"; // NOI18N
		
		return firstLetterCapital(presenterFileName.replaceAll(NetteFramework.NETTE_PRESENTER_EXTENSION, "").replaceAll("Presenter", "").replaceFirst(modulePrefixPattern, "")); // NOI18N
	}

	public static FileObject getView(FileObject fo, PhpBaseElement phpElement) {
        FileObject view = null;
        if (phpElement instanceof PhpClass.Method) {
            view = getView(fo, getViewName(phpElement.getName()));
        }
        return view;
    }

	private static String getViewName(String actionName) {
		if (actionName.startsWith(NetteFramework.NETTE_ACTION_METHOD_PREFIX) || actionName.startsWith(NetteFramework.NETTE_RENDER_METHOD_PREFIX)) {
			return extractActionName(actionName);
		}

		return null;
    }

	private static String extractActionName(String actionName) {
		String name = null;

		if (actionName.startsWith(NetteFramework.NETTE_ACTION_METHOD_PREFIX)) {
			name = actionName.replace(NetteFramework.NETTE_ACTION_METHOD_PREFIX, ""); // NOI18N
		} else {
			name = actionName.replace(NetteFramework.NETTE_RENDER_METHOD_PREFIX, ""); // NOI18N
		}

		return firstLetterSmall(name);
	}

    private static FileObject getView(FileObject fo, String viewName) {
        File parent = FileUtil.toFile(fo).getParentFile();
        File classicView = PropertyUtils.resolveFile(parent, String.format(FILE_VIEW_RELATIVE_CLASSIC, extractPresenterName(fo.getName()), viewName));
        if (classicView.isFile()) {
            return FileUtil.toFileObject(classicView);
        }

		File dottedView = PropertyUtils.resolveFile(parent, String.format(FILE_VIEW_RELATIVE_DOTTED, extractPresenterName(fo.getName()), viewName));
        if (dottedView.isFile()) {
            return FileUtil.toFileObject(dottedView);
        }

        return null;
    }
    
    public static boolean isViewWithAction(FileObject fo) {
        return isView(fo) && getAction(fo) != null;
    }
    
    public static boolean isView(FileObject fo) {
        return NetteFramework.NETTE_LATTE_TEMPLATE_EXTENSION.endsWith(fo.getExt());
    }
    
    public static FileObject getAction(FileObject fo) {
        File parent = FileUtil.toFile(fo).getParentFile();
        
        File action = PropertyUtils.resolveFile(parent, String.format(resolveActionRelativePath(fo), parent.getName()));
        
        if (action.isFile()) {
            return FileUtil.toFileObject(action);
        }
        
        return null;
    }
    
    private static String resolveActionRelativePath(FileObject fo) {
        if (isDottedView(fo)) {
            return FILE_PRESENTER_RELATIVE_DOTTED;
        }
        
        return FILE_PRESENTER_RELATIVE_CLASSIC;
    }
    
    private static boolean isDottedView(FileObject fo) {
        return firstLetterCapital(fo.getName()).equals(fo.getName());
    }

    public static boolean isAction(FileObject fo) {
        return fo.isData() && fo.getName().endsWith(NetteFramework.NETTE_PRESENTER_SUFFIX);
    }
    
    public static String getActionName(FileObject view) {
        return getActionRenderName(view, NetteFramework.NETTE_ACTION_METHOD_PREFIX);
    }
    
    public static String getRenderName(FileObject view) {
        return getActionRenderName(view, NetteFramework.NETTE_RENDER_METHOD_PREFIX);
    }
    
    private static String getActionRenderName(FileObject view, String methodPrefix) {
        String[] parts;
        
        if (isDottedView(view)) {
            parts = view.getNameExt().split("\\.", 3);
            
            return methodPrefix + firstLetterCapital(parts[1]);
        }

        parts = view.getNameExt().split("\\.");
        
        return methodPrefix + firstLetterCapital(parts[0]);
    }

}
