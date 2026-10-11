#!/usr/bin/env node

'use strict';

const fs = require('fs');
const path = require('path');
const { spawnSync } = require('child_process');

const themeDir = path.resolve(__dirname, '..');
const parentDir = path.dirname(themeDir);
const themeName = path.basename(themeDir); // classilist

// Extract version from style.css
const styleCss = fs.readFileSync(path.join(themeDir, 'style.css'), 'utf8');
const versionMatch = styleCss.match(/^Version:\s*(.+)$/m);
if (!versionMatch) {
	console.error('Error: Version not found in style.css');
	process.exit(1);
}
const version = versionMatch[1].trim();

const zipName = `${themeName}.${version}.zip`;
const distDir = path.join(themeDir, 'dist');

if (!fs.existsSync(distDir)) {
	fs.mkdirSync(distDir, { recursive: true });
}

const zipOutput = path.join(distDir, zipName);

if (fs.existsSync(zipOutput)) {
	fs.unlinkSync(zipOutput);
}

console.log(`Packaging ${themeName} v${version}...`);

const n = themeName;
const excludePatterns = [
	`${n}/.git`,
	`${n}/.git/*`,
	`${n}/.gitignore`,
	`${n}/.gitattributes`,
	`${n}/.DS_Store`,
	`${n}/CLAUDE.md`,
	`${n}/node_modules`,
	`${n}/node_modules/*`,
	`${n}/package.json`,
	`${n}/package-lock.json`,
	`${n}/scripts`,
	`${n}/scripts/*`,
	`${n}/dist`,
	`${n}/dist/*`,
	`*/.DS_Store`,
];

const excludeArgs = excludePatterns.flatMap((p) => ['-x', p]);

const result = spawnSync('zip', ['-rq', zipOutput, themeName, ...excludeArgs], {
	cwd: parentDir,
	stdio: 'inherit',
});

if (result.status !== 0) {
	console.error('zip failed');
	process.exit(result.status || 1);
}

const stats = fs.statSync(zipOutput);
const sizeMB = (stats.size / 1024 / 1024).toFixed(2);
console.log(`Done: dist/${zipName} (${sizeMB} MB)`);
