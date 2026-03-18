const fs = require('fs');
const path = require('path');

class FileWriter {
  constructor(basePath) {
    this.basePath = basePath;
  }

  createDir(dirPath) {
    if (!fs.existsSync(dirPath)) {
      fs.mkdirSync(dirPath, { recursive: true });
    }
  }

  write(filePath, content) {
    const fullPath = path.join(this.basePath, filePath);
    const dir = path.dirname(fullPath);
    this.createDir(dir);
    fs.writeFileSync(fullPath, content, 'utf8');
    return fullPath;
  }

  fileExists(filePath) {
    return fs.existsSync(path.join(this.basePath, filePath));
  }
}

module.exports = FileWriter;