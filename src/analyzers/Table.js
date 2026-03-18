const Column = require('./Column');
const Relation = require('./Relation');

class Table {
  constructor(name) {
    this.name = name;
    this.columns = [];
    this.relations = [];
  }

  getName() {
    return this.name;
  }

  addColumn(columnData) {
    this.columns.push(new Column(columnData));
  }

  addRelation(relationData) {
    this.relations.push(new Relation(relationData));
  }

  getColumns() {
    return this.columns;
  }

  getRelations() {
    return this.relations;
  }

  getPrimaryKey() {
    const pk = this.columns.find(col => col.isPrimary);
    return pk ? pk.name : 'id';
  }
}

module.exports = Table;