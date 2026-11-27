const fs = require('node:fs');
const path = require('node:path');
const root = __dirname;
const raw = process.env.PUBLIC_BACKEND_URL;
if (!raw) throw new Error('Set PUBLIC_BACKEND_URL in Vercel.');
const url = new URL(raw);
if (url.protocol !== 'https:' || url.username || url.password || url.pathname !== '/' || url.search || url.hash) {
    throw new Error('PUBLIC_BACKEND_URL must be an HTTPS origin.');
}
const dist = path.join(root, 'dist');
fs.rmSync(dist, {recursive:true, force:true});
fs.mkdirSync(dist);
for (const entry of fs.readdirSync(root, {withFileTypes:true})) {
    if (entry.name === 'assets' || (entry.isFile() && /\.(html|txt|ico|xml|webmanifest)$/i.test(entry.name))) {
        fs.cpSync(path.join(root, entry.name), path.join(dist, entry.name), {recursive:true});
    }
}
const config = path.join(dist, 'assets/js/config.js');
const original = fs.readFileSync(config, 'utf8');
const pattern = /backendUrl:\s*"http:\/\/127\.0\.0\.1:8000"/;
if (!pattern.test(original)) throw new Error('Backend configuration placeholder not found.');
fs.writeFileSync(config, original.replace(pattern, 'backendUrl: ' + JSON.stringify(url.origin)));
console.log('Static frontend generated.');
