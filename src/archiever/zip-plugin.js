const fs = require('fs');
const archiver = require('archiver');
const path = require('path');

// Path to the plugin folder (relative to project root)
const folderName = 'ckh-booking-engine';
const projectRoot = path.resolve(__dirname, '../../');
const folderPath = path.join(projectRoot, folderName);

// Try to get version from main plugin PHP file
defaultVersion = '1.0.0';
let version = defaultVersion;
try {
    const mainPluginFile = path.join(folderPath, `${folderName}.php`);
    const content = fs.readFileSync(mainPluginFile, 'utf8');
    const match = content.match(/\*\s*Version:\s*([\d.]+)/i);
    if (match) {
        version = match[1];
    }
} catch (e) {
    console.warn('Could not read version from plugin file, using default:', defaultVersion);
}

const distDir = path.join(projectRoot, 'dist');
if (!fs.existsSync(distDir)) {
    fs.mkdirSync(distDir);
}
const outputFile = path.join(distDir, `${folderName}-${version}.zip`);
const output = fs.createWriteStream(outputFile);
const archive = archiver('zip', { zlib: { level: 9 } });

output.on('close', function () {
    console.log(`${archive.pointer()} total bytes`);
    console.log(`Created ${outputFile}`);
});

archive.on('error', function (err) {
    throw err;
});

archive.pipe(output);
archive.directory(folderPath, folderName);
archive.finalize();
