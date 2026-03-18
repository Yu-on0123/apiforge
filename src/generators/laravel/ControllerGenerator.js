const FileWriter = require('../../writers/FileWriter');

class ControllerGenerator {
  constructor(tables, outputPath) {
    this.tables = tables;
    this.outputPath = outputPath;
    this.writer = new FileWriter(outputPath);
  }

  toPascalCase(str) {
    return str
      .split('_')
      .map(word => word.charAt(0).toUpperCase() + word.slice(1))
      .join('');
  }

  buildCRUD(table) {
    const modelName = this.toPascalCase(table.getName());
    const varName = table.getName();
    const fillable = table.getColumns()
    .filter(col => !col.isPrimary && !['created_at', 'updated_at', 'deleted_at'].includes(col.name))
    .map(col => `'${col.name}' => '${col.isNullable() ? 'nullable' : 'required'}'`)
    .join(',\n            ');

    return `
    public function index()
    {
        return response()->json(${modelName}::all());
    }

    public function show($id)
    {
        $${varName} = ${modelName}::findOrFail($id);
        return response()->json($${varName});
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $${varName} = ${modelName}::create($validated);
        return response()->json($${varName}, 201);
    }

    public function update(Request $request, $id)
    {
        $${varName} = ${modelName}::findOrFail($id);
        $validated = $request->validate($this->rules());
        $${varName}->update($validated);
        return response()->json($${varName});
    }

    public function destroy($id)
    {
        $${varName} = ${modelName}::findOrFail($id);
        $${varName}->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            ${fillable}
        ];
    }`;
  }

  generate() {
    const results = [];

    for (const table of this.tables) {
      const modelName = this.toPascalCase(table.getName());
      const crud = this.buildCRUD(table);

      const content = `<?php

namespace App\\Http\\Controllers;

use App\\Models\\${modelName};
use Illuminate\\Http\\Request;

class ${modelName}Controller extends Controller
{
${crud}
}
`;
      const fileName = `app/Http/Controllers/${modelName}Controller.php`;
      const written = this.writer.write(fileName, content);
      results.push(written);
    }

    return results;
  }
}

module.exports = ControllerGenerator;