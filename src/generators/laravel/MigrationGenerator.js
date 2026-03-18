const FileWriter = require('../../writers/FileWriter');

class MigrationGenerator {
  constructor(tables, outputPath) {
    this.tables = tables;
    this.outputPath = outputPath;
    this.writer = new FileWriter(outputPath);
  }

  mapType(type) {
    const types = {
      int: 'integer',
      integer: 'integer',
      bigint: 'bigInteger',
      smallint: 'smallInteger',
      tinyint: 'tinyInteger',
      varchar: 'string',
      char: 'char',
      text: 'text',
      longtext: 'longText',
      mediumtext: 'mediumText',
      tinyint: 'boolean',
      mediumtext: 'mediumText',
      longtext: 'longText',
      float: 'float',
      double: 'double',
      decimal: 'decimal',
      real: 'float',
      numeric: 'decimal',
      boolean: 'boolean',
      bool: 'boolean',
      date: 'date',
      datetime: 'dateTime',
      timestamp: 'timestamp',
      time: 'time',
      json: 'json',
      blob: 'binary',
    };
    return types[type.toLowerCase()] || 'string';
  }

  buildSchema(table) {
    const lines = [];
    const timestampCols = ['created_at', 'updated_at'];
    const foreignKeyColumns = table.getRelations()
      .filter(r => r.type === 'belongsTo')
      .map(r => r.foreignKey);
  
    for (const column of table.getColumns()) {
      if (column.isPrimary) continue;
      if (timestampCols.includes(column.name)) continue;
  
      if (foreignKeyColumns.includes(column.name)) {
        const relation = table.getRelations().find(r => r.foreignKey === column.name && r.type === 'belongsTo');
        let line = `            $table->foreignId('${column.name}')`;
        if (column.isNullable()) line += '->nullable()';
        line += `->constrained('${relation.toTable}')->onDelete('cascade')`;
        line += ';';
        lines.push(line);
      } else {
        const laravelType = this.mapType(column.getType());
        let line = `            $table->${laravelType}('${column.name}')`;
        if (column.isNullable()) line += '->nullable()';
        line += ';';
        lines.push(line);
      }
    }
    return lines.join('\n');
  }

  generate() {
    const timestamp = new Date().toISOString().replace(/[-T:.Z]/g, '').slice(0, 14);
    const results = [];

    for (const table of this.tables) {
      const schema = this.buildSchema(table);
      const content = `<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('${table.getName()}', function (Blueprint $table) {
            $table->id();
${schema}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('${table.getName()}');
    }
};
`;
      const fileName = `database/migrations/${timestamp}_create_${table.getName()}_table.php`;
      const written = this.writer.write(fileName, content);
      results.push(written);
    }

    return results;
  }
}

module.exports = MigrationGenerator;