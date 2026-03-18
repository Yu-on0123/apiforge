const FileWriter = require('../../writers/FileWriter');

class RouteGenerator {
  constructor(tables, outputPath) {
    this.tables = tables;
    this.outputPath = outputPath;
    this.prefix = 'api';
    this.writer = new FileWriter(outputPath);
  }

  toPascalCase(str) {
    return str
      .split('_')
      .map(word => word.charAt(0).toUpperCase() + word.slice(1))
      .join('');
  }

  buildRoutes() {
    return this.tables.map(table => {
      const modelName = this.toPascalCase(table.getName());
      const routeName = table.getName();
      return `Route::apiResource('/${routeName}', ${modelName}Controller::class);`;
    }).join('\n');
  }

  groupByResource() {
    return this.tables.map(t => t.getName());
  }

  generate() {
    const routes = this.buildRoutes();
    const imports = this.tables.map(table => {
      const modelName = this.toPascalCase(table.getName());
      return `use App\\Http\\Controllers\\${modelName}Controller;`;
    }).join('\n');

    const content = `<?php

use Illuminate\\Support\\Facades\\Route;
${imports}

${routes}
`;
    const fileName = 'routes/api.php';
    const written = this.writer.write(fileName, content);
    return [written];
  }
}

module.exports = RouteGenerator;