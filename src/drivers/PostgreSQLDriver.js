const { Client } = require('pg');
const DatabaseDriver = require('./DatabaseDriver');

class PostgreSQLDriver extends DatabaseDriver {
  constructor(config) {
    super(config);
    this.port = config.port || 5432;
  }

  async connect() {
    this.connection = new Client({
      host: this.host,
      port: this.port,
      user: this.user,
      password: this.password,
      database: this.database,
    });
    await this.connection.connect();
  }

  async disconnect() {
    if (this.connection) {
      await this.connection.end();
      this.connection = null;
    }
  }

  async getTables() {
    const result = await this.connection.query(
      `SELECT table_name FROM information_schema.tables
       WHERE table_schema = 'public' AND table_type = 'BASE TABLE'`
    );
    return result.rows.map(row => row.table_name);
  }

  async getColumns(tableName) {
    const result = await this.connection.query(
      `SELECT column_name, data_type, is_nullable
       FROM information_schema.columns
       WHERE table_schema = 'public' AND table_name = $1
       ORDER BY ordinal_position`,
      [tableName]
    );
    const pkResult = await this.connection.query(
      `SELECT column_name FROM information_schema.key_column_usage
       WHERE table_name = $1 AND constraint_name LIKE '%pkey%'`,
      [tableName]
    );
    const primaryKeys = pkResult.rows.map(r => r.column_name);
    return result.rows.map(row => ({
      name: row.column_name,
      type: row.data_type,
      nullable: row.is_nullable === 'YES',
      isPrimary: primaryKeys.includes(row.column_name),
    }));
  }

  async getForeignKeys(tableName) {
    const result = await this.connection.query(
      `SELECT kcu.column_name, ccu.table_name AS referenced_table, ccu.column_name AS referenced_column
       FROM information_schema.table_constraints AS tc
       JOIN information_schema.key_column_usage AS kcu
         ON tc.constraint_name = kcu.constraint_name
       JOIN information_schema.constraint_column_usage AS ccu
         ON ccu.constraint_name = tc.constraint_name
       WHERE tc.constraint_type = 'FOREIGN KEY' AND tc.table_name = $1`,
      [tableName]
    );
    return result.rows.map(row => ({
      foreignKey: row.column_name,
      referencedTable: row.referenced_table,
      referencedColumn: row.referenced_column,
    }));
  }
}

module.exports = PostgreSQLDriver;