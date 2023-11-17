const express = require('express');
const httpProxy = require('http-proxy');

const app = express();
const proxy = httpProxy.createProxyServer();

const target = 'wss://socket.pasino.io/dice';

app.use((req, res) => {
  proxy.web(req, res, { target });
});

proxy.on('error', (err) => {
  console.error('Proxy error:', err);
});

proxy.on('proxyReq', (proxyReq, req, res, options) => {
  console.log('Proxy request:', req.method, req.url);
});

proxy.on('proxyRes', (proxyRes, req, res) => {
  console.log('Proxy response:', proxyRes.statusCode);
});

const port = 3000;

app.listen(port, () => {
  console.log(`Proxy server listening on port ${port}`);
});
