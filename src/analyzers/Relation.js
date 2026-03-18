class Relation {
  constructor({ fromTable, toTable, foreignKey, referencedColumn, type }) {
    this.fromTable = fromTable;
    this.toTable = toTable;
    this.foreignKey = foreignKey;
    this.referencedColumn = referencedColumn;
    this.type = type || 'belongsTo';
  }

  getType() {
    return this.type;
  }

  getForeignKey() {
    return this.foreignKey;
  }
}

module.exports = Relation;