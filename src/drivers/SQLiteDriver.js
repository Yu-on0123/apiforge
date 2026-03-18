const initSqlJs = require('sql.js');
const fs = require('fs');
const DatabaseDriver = require('./DatabaseDriver');

class SQLiteDriver extends DatabaseDriver {
  constructor(config) {
    super(config);
    this.filePath = config.filePath;
    this.db = null;
  }

  async connect() {
    const SQL = await initSqlJs();
    if (fs.existsSync(this.filePath)) {
      const fileBuffer = fs.readFileSync(this.filePath);
      this.db = new SQL.Database(fileBuffer);
    } else {
      this.db = new SQL.Database();
    }
  }

  async disconnect() {
    if (this.db) {
      this.db.close();
      this.db = null;
    }
  }

  async getTables() {
    const result = this.db.exec(
      `SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'`
    );
    if (!result || result.length === 0) return [];
    return result[0].values.map(row => row[0]);
  }

  async getColumns(tableName) {
    const result = this.db.exec(`PRAGMA table_info(${tableName})`);
    if (!result || result.length === 0) return [];
    return result[0].values.map(row => ({
      name: row[1],
      type: row[2].toLowerCase().split('(')[0],
      nullable: row[3] === 0,
      isPrimary: row[5] === 1,
    }));
  }

  async getForeignKeys(tableName) {
    const result = this.db.exec(`PRAGMA foreign_key_list(${tableName})`);
    if (!result || result.length === 0) return [];
    return result[0].values.map(row => ({
      foreignKey: row[3],
      referencedTable: row[2],
      referencedColumn: row[4],
    }));
  }
}

module.exports = SQLiteDriver;