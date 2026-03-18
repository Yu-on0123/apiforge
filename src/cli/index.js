#!/usr/bin/env node

require('dotenv').config();
const { Command } = require('commander');
const MySQLDriver = require('../drivers/MySQLDriver');
const SQLiteDriver = require('../drivers/SQLiteDriver');
const PostgreSQLDriver = require('../drivers/PostgreSQLDriver');
const SchemaAnalyzer = require('../analyzers/SchemaAnalyzer');
const MigrationGenerator = require('../generators/laravel/MigrationGenerator');
const ModelGenerator = require('../generators/laravel/ModelGenerator');
const ControllerGenerator = require('../generators/laravel/ControllerGenerator');
const RouteGenerator = require('../generators/laravel/RouteGenerator');

const program = new Command();

program
  .name('apiforge')
  .description('Générateur automatique d\'API REST à partir d\'un schéma de base de données')
  .version('1.0.0');

function resolveOptions(options) {
  return {
    driver:   options.driver   || process.env.DB_DRIVER   || 'mysql',
    host:     options.host     || process.env.DB_HOST     || 'localhost',
    port:     options.port     || process.env.DB_PORT,
    user:     options.user     || process.env.DB_USER     || 'root',
    password: options.password !== undefined ? options.password : (process.env.DB_PASSWORD || ''),
    database: options.database || process.env.DB_DATABASE,
    output:   options.output   || process.env.OUTPUT_PATH || './output',
  };
}

function createDriver(options) {
  const config = resolveOptions(options);

  if (!config.database) {
    console.error('Erreur : aucune base de données spécifiée. Utilisez --database ou définissez DB_DATABASE dans .env');
    process.exit(1);
  }

  switch (config.driver) {
    case 'mysql':
      return new MySQLDriver({
        host:     config.host,
        port:     config.port || 3306,
        user:     config.user,
        password: config.password,
        database: config.database,
      });
    case 'sqlite':
      return new SQLiteDriver({
        filePath: config.database,
      });
    case 'postgres':
      return new PostgreSQLDriver({
        host:     config.host,
        port:     config.port || 5432,
        user:     config.user,
        password: config.password,
        database: config.database,
      });
    default:
      console.error(`Driver inconnu : ${config.driver}. Utilisez mysql | sqlite | postgres`);
      process.exit(1);
  }
}

function printConfig(config) {
  console.log('\nConfiguration utilisée :');
  console.log(`  Driver   : ${config.driver}`);
  if (config.driver !== 'sqlite') {
    console.log(`  Hôte     : ${config.host}:${config.port || (config.driver === 'postgres' ? 5432 : 3306)}`);
    console.log(`  User     : ${config.user}`);
  }
  console.log(`  Base     : ${config.database}`);
  console.log('');
}

program
  .command('analyze')
  .description('Analyser le schéma de la base de données')
  .option('--driver <driver>',     'Type de BDD : mysql | sqlite | postgres')
  .option('--database <database>', 'Nom de la BDD (ou chemin pour SQLite)')
  .option('--host <host>',         'Hôte')
  .option('--port <port>',         'Port')
  .option('--user <user>',         'Utilisateur')
  .option('--password <password>', 'Mot de passe')
  .action(async (options) => {
    const config = resolveOptions(options);
    printConfig(config);
    const driver = createDriver(options);
    try {
      console.log('Connexion à la base de données...');
      await driver.connect();
      const analyzer = new SchemaAnalyzer(driver);
      const tables = await analyzer.analyze();
      console.log(`Analyse terminée. ${tables.length} table(s) détectée(s) :\n`);
      tables.forEach(table => {
        console.log(`  • ${table.getName()} (${table.getColumns().length} colonnes, ${table.getRelations().length} relations)`);
      });
      await driver.disconnect();
    } catch (err) {
      console.error('Erreur :', err.message);
      process.exit(1);
    }
  });

program
  .command('generate')
  .description('Générer les fichiers Laravel à partir du schéma')
  .option('--driver <driver>',     'Type de BDD : mysql | sqlite | postgres')
  .option('--database <database>', 'Nom de la BDD (ou chemin pour SQLite)')
  .option('--host <host>',         'Hôte')
  .option('--port <port>',         'Port')
  .option('--user <user>',         'Utilisateur')
  .option('--password <password>', 'Mot de passe')
  .option('--output <output>',     'Répertoire de sortie')
  .option('--only <only>',         'Générer uniquement : migrations | models | controllers | routes')
  .action(async (options) => {
    const config = resolveOptions(options);
    printConfig(config);
    const driver = createDriver(options);
    try {
      console.log('Connexion à la base de données...');
      await driver.connect();
      const analyzer = new SchemaAnalyzer(driver);
      const tables = await analyzer.analyze();
      console.log(`${tables.length} table(s) détectée(s). Génération en cours...\n`);

      const only = options.only;
      const results = [];

      if (!only || only === 'migrations') {
        const gen = new MigrationGenerator(tables, config.output);
        const files = gen.generate();
        files.forEach(f => console.log(`  [migration]   ${f}`));
        results.push(...files);
      }

      if (!only || only === 'models') {
        const gen = new ModelGenerator(tables, config.output);
        const files = gen.generate();
        files.forEach(f => console.log(`  [model]       ${f}`));
        results.push(...files);
      }

      if (!only || only === 'controllers') {
        const gen = new ControllerGenerator(tables, config.output);
        const files = gen.generate();
        files.forEach(f => console.log(`  [controller]  ${f}`));
        results.push(...files);
      }

      if (!only || only === 'routes') {
        const gen = new RouteGenerator(tables, config.output);
        const files = gen.generate();
        files.forEach(f => console.log(`  [routes]      ${f}`));
        results.push(...files);
      }

      console.log(`\nGénération terminée. ${results.length} fichier(s) créé(s) dans ${config.output}`);
      await driver.disconnect();
    } catch (err) {
      console.error('Erreur :', err.message);
      process.exit(1);
    }
  });

program.parse(process.argv);