/*
 *  The MIT License
 *
 *  Copyright (c) 2011 Radek Ježdík <redhead@email.cz>, Ondřej Brejla <ondrej@brejla.cz>
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

package org.netbeans.modules.php.nette;

import java.io.File;
import java.io.IOException;
import java.util.HashSet;
import java.util.Set;
import org.netbeans.modules.php.nette.options.NetteOptions;
import org.netbeans.modules.php.nette.utils.FileUtils;
import org.netbeans.modules.php.nette.validators.SandboxPathValidator;
import org.netbeans.modules.php.nette.validators.Validable;
import org.openide.filesystems.FileObject;
import org.openide.filesystems.FileUtil;

/**
 *
 * @author Ondřej Brejla <ondrej@brejla.cz>
 */
public class NetteSandboxCreator {

	private String projectDirectory;

	private Set<FileObject> set = new HashSet<FileObject>();

	public NetteSandboxCreator(String projectDirectory) {
		this.projectDirectory = projectDirectory;
	}

	public void copyFrameworkFiles() {
		FileUtils.copyDirectory(new File(NetteOptions.getInstance().getNettePath()), new File(projectDirectory + NetteFramework.NETTE_LIBS_DIR));
	}

	public void create() throws IOException {
		if (isValidSandboxPath()) {
			FileUtils.copyDirectory(new File(NetteOptions.getInstance().getSandboxPath()), new File(projectDirectory));
		} else {
			createDefaultDirectoryStructure();
		}
	}

	private boolean isValidSandboxPath() {
		Validable sandboxPathValidator = new SandboxPathValidator();
		String sandboxPath = NetteOptions.getInstance().getSandboxPath();

		return sandboxPathValidator.validate(sandboxPath) && !sandboxPath.trim().isEmpty();
	}

	private void createDefaultDirectoryStructure() throws IOException {
		createDocumentRoot();
		createApp();
		createLibs();
		createTemp();
		createLog();
	}

	private void createDocumentRoot() throws IOException {
        File folder = new File(projectDirectory + NetteFramework.NETTE_DOCUMENT_ROOT_DIR);
        FileObject doc_root = FileUtil.createFolder(folder);
        set.add(doc_root);

        set.add(FileUtil.createFolder(new File(doc_root.getPath() + "/css")));
        set.add(FileUtil.createFolder(new File(doc_root.getPath() + "/js")));
        set.add(FileUtil.createFolder(new File(doc_root.getPath() + "/images")));

        FileUtils.copyFile(getClass().getResourceAsStream("/org/netbeans/modules/php/nette/resources/index.php"), new File(projectDirectory + NetteFramework.NETTE_DOCUMENT_ROOT_DIR + "/index.php"));

        FileUtils.copyFile(getClass().getResourceAsStream("/org/netbeans/modules/php/nette/resources/.htaccess-DOCUMENT_ROOT"), new File(projectDirectory + NetteFramework.NETTE_DOCUMENT_ROOT_DIR + "/.htaccess"));
    }

    private void createApp() throws IOException {
        File folder = new File(projectDirectory + NetteFramework.NETTE_APP_DIR);
        FileObject app = FileUtil.createFolder(folder);
        set.add(app);

        set.add(FileUtil.createFolder(new File(app.getPath() + "/presenters")));
        set.add(FileUtil.createFolder(new File(app.getPath() + "/templates")));

        FileUtils.copyFile(getClass().getResourceAsStream("/org/netbeans/modules/php/nette/resources/bootstrap.php"), new File(projectDirectory + NetteFramework.NETTE_APP_DIR + "/bootstrap.php"));

        FileUtils.copyFile(getClass().getResourceAsStream("/org/netbeans/modules/php/nette/resources/.htaccess-APP"), new File(projectDirectory + NetteFramework.NETTE_APP_DIR + "/.htaccess"));

        FileUtils.copyFile(getClass().getResourceAsStream("/org/netbeans/modules/php/nette/resources/config.ini"), new File(projectDirectory + NetteFramework.NETTE_APP_DIR + "/config.ini"));
    }

    private void createLibs() throws IOException {
        File folder = new File(projectDirectory + NetteFramework.NETTE_LIBS_DIR);
        FileObject app = FileUtil.createFolder(folder);
        set.add(app);
    }

    private void createTemp() throws IOException {
        File folder = new File(projectDirectory + NetteFramework.NETTE_TEMP_DIR);
        FileObject app = FileUtil.createFolder(folder);
        set.add(app);
    }

    private void createLog() throws IOException {
        File folder = new File(projectDirectory + NetteFramework.NETTE_LOG_DIR);
        FileObject app = FileUtil.createFolder(folder);
        set.add(app);
    }

	public Set<FileObject> getCreatedFileObjects() {
		return set;
	}

}
