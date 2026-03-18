const FileWriter = require('../../writers/FileWriter');

class ModelGenerator {
  constructor(tables, outputPath) {
    this.tables = tables;
    this.outputPath = outputPath;
    this.namespace = 'App\\Models';
    this.writer = new FileWriter(outputPath);
  }

  toPascalCase(str) {
    return str
      .split('_')
      .map(word => word.charAt(0).toUpperCase() + word.slice(1))
      .join('');
  }

  toCamelCase(str) {
    const pascal = this.toPascalCase(str);
    return pascal.charAt(0).toLowerCase() + pascal.slice(1);
  }

  isTimestamp(name) {
    return ['created_at', 'updated_at', 'deleted_at'].includes(name);
  }

  buildFillable(table) {
    const fillable = table.getColumns()
      .filter(col => !col.isPrimary && !this.isTimestamp(col.name))
      .map(col => `'${col.name}'`)
      .join(', ');
    return `[${fillable}]`;
  }

  buildRelations(table) {
    const lines = [];
    const seen = new Set();

    for (const relation of table.getRelations()) {
      const relatedModel = this.toPascalCase(relation.toTable);
      const key = `${relation.type}_${relation.toTable}_${relation.foreignKey}`;
      if (seen.has(key)) continue;
      seen.add(key);

      if (relation.type === 'hasMany') {
        const base = this.toCamelCase(relation.toTable);
        const methodName = base.endsWith('s') ? base : base + 's';
        lines.push(`
    public function ${methodName}()
    {
        return $this->hasMany(${relatedModel}::class, '${relation.foreignKey}');
    }`);
      } else {
        const methodName = this.toCamelCase(relation.toTable);
        lines.push(`
    public function ${methodName}()
    {
        return $this->belongsTo(${relatedModel}::class, '${relation.foreignKey}');
    }`);
      }
    }
    return lines.join('\n');
  }

  generate() {
    const results = [];

    for (const table of this.tables) {
      const modelName = this.toPascalCase(table.getName());
      const fillable = this.buildFillable(table);
      const relations = this.buildRelations(table);

      const imports = table.getRelations().length > 0
        ? [...new Set(table.getRelations().map(r =>
            `use ${this.namespace}\\${this.toPascalCase(r.toTable)};`
          ))].join('\n')
        : '';

      const content = `<?php

namespace ${this.namespace};

use Illuminate\\Database\\Eloquent\\Model;
${imports}

class ${modelName} extends Model
{
    protected $table = '${table.getName()}';

    protected $fillable = ${fillable};
${relations}
}
`;
      const fileName = `app/Models/${modelName}.php`;
      const written = this.writer.write(fileName, content);
      results.push(written);
    }

    return results;
  }
}

module.exports = ModelGenerator;