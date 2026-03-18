const mysql = require('mysql2/promise');
const DatabaseDriver = require('./DatabaseDriver');

class MySQLDriver extends DatabaseDriver {
  constructor(config) {
    super(config);
    this.port = config.port || 3306;
  }

  async connect() {
    this.connection = await mysql.createConnection({
      host: this.host,
      port: this.port,
      user: this.user,
      password: this.password,
      database: this.database,
    });
  }

  async disconnect() {
    if (this.connection) {
      await this.connection.end();
      this.connection = null;
    }
  }

  async getTables() {
    const [rows] = await this.connection.execute(
      `SELECT TABLE_NAME FROM information_schema.TABLES 
       WHERE TABLE_SCHEMA = ? AND TABLE_TYPE = 'BASE TABLE'
       AND TABLE_NAME NOT IN ('migrations', 'failed_jobs', 'password_resets', 'personal_access_tokens', 'cache', 'jobs', 'sessions')`,
      [this.database]
    );
    return rows.map(row => row.TABLE_NAME);
  }

  async getColumns(tableName) {
    const [rows] = await this.connection.execute(
      `SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_KEY
       FROM information_schema.COLUMNS
       WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
       ORDER BY ORDINAL_POSITION`,
      [this.database, tableName]
    );
    return rows.map(row => ({
      name: row.COLUMN_NAME,
      type: row.DATA_TYPE,
      nullable: row.IS_NULLABLE === 'YES',
      isPrimary: row.COLUMN_KEY === 'PRI',
    }));
  }

  async getForeignKeys(tableName) {
    const [rows] = await this.connection.execute(
      `SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
       FROM information_schema.KEY_COLUMN_USAGE
       WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
       AND REFERENCED_TABLE_NAME IS NOT NULL`,
      [this.database, tableName]
    );
    return rows.map(row => ({
      foreignKey: row.COLUMN_NAME,
      referencedTable: row.REFERENCED_TABLE_NAME,
      referencedColumn: row.REFERENCED_COLUMN_NAME,
    }));
  }
}

module.exports = MySQLDriver;