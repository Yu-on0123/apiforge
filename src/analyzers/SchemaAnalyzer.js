const Table = require('./Table');

class SchemaAnalyzer {
  constructor(driver) {
    this.driver = driver;
    this.tables = [];
  }

  async analyze() {
    const tableNames = await this.driver.getTables();

    for (const tableName of tableNames) {
      const table = new Table(tableName);
      const columns = await this.driver.getColumns(tableName);
      const foreignKeys = await this.driver.getForeignKeys(tableName);

      columns.forEach(col => table.addColumn(col));

      foreignKeys.forEach(fk => {
        table.addRelation({
          fromTable: tableName,
          toTable: fk.referencedTable,
          foreignKey: fk.foreignKey,
          referencedColumn: fk.referencedColumn,
          type: 'belongsTo',
        });
      });

      this.tables.push(table);
    }

    this.detectInverseRelations();
    return this.tables;
  }

  detectInverseRelations() {
    for (const table of this.tables) {
      for (const relation of table.getRelations()) {
        if (relation.type !== 'belongsTo') continue;
        const referencedTable = this.tables.find(t => t.getName() === relation.toTable);
        if (referencedTable) {
          const alreadyExists = referencedTable.getRelations().some(
            r => r.toTable === relation.fromTable && r.type === 'hasMany'
          );
          if (!alreadyExists) {
            referencedTable.addRelation({
              fromTable: relation.toTable,
              toTable: relation.fromTable,
              foreignKey: relation.foreignKey,
              referencedColumn: relation.referencedColumn,
              type: 'hasMany',
            });
          }
        }
      }
    }
  }

  getSchema() {
    return this.tables;
  }
}

module.exports = SchemaAnalyzer;