class Column {
    constructor({ name, type, nullable, isPrimary }) {
      this.name = name;
      this.type = type;
      this.nullable = nullable;
      this.isPrimary = isPrimary;
    }
  
    getType() {
      return this.type;
    }
  
    isNullable() {
      return this.nullable;
    }
  }
  
  module.exports = Column;