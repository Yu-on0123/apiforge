class DatabaseDriver {
    constructor(config) {
      this.host = config.host || 'localhost';
      this.port = config.port;
      this.database = config.database;
      this.user = config.user;
      this.password = config.password;
      this.connection = null;
    }
  
    async connect() {
      throw new Error('connect() doit être implémenté par le driver');
    }
  
    async disconnect() {
      throw new Error('disconnect() doit être implémenté par le driver');
    }
  
    async getTables() {
      throw new Error('getTables() doit être implémenté par le driver');
    }
  
    async getColumns(tableName) {
      throw new Error('getColumns() doit être implémenté par le driver');
    }
  
    async getForeignKeys(tableName) {
      throw new Error('getForeignKeys() doit être implémenté par le driver');
    }
  }
  
  module.exports = DatabaseDriver;