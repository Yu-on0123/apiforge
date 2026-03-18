const Database = require('better-sqlite3');
const DatabaseDriver = require('./DatabaseDriver');

class SQLiteDriver extends DatabaseDriver {
  constructor(config) {
    super(config);
    this.filePath = config.filePath;
  }

  async connect() {
    this.connection = new Database(this.filePath);
  }

  async disconnect() {
    if (this.connection) {
      this.connection.close();
      this.connection = null;
    }
  }

  async getTables() {
    const rows = this.connection.prepare(
      `SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'`
    ).all();
    return rows.map(row => row.name);
  }

  async getColumns(tableName) {
    const rows = this.connection.prepare(
      `PRAGMA table_info(${tableName})`
    ).all();
    return rows.map(row => ({
      name: row.name,
      type: row.type.toLowerCase().split('(')[0],
      nullable: row.notnull === 0,
      isPrimary: row.pk === 1,
    }));
  }

  async getForeignKeys(tableName) {
    const rows = this.connection.prepare(
      `PRAGMA foreign_key_list(${tableName})`
    ).all();
    return rows.map(row => ({
      foreignKey: row.from,
      referencedTable: row.table,
      referencedColumn: row.to,
    }));
  }
}

module.exports = SQLiteDriver;