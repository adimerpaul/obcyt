if(!self.define){let e,n={};const i=(i,f)=>(i=new URL(i+".js",f).href,n[i]||new Promise((n=>{if("document"in self){const e=document.createElement("script");e.src=i,e.onload=n,document.head.appendChild(e)}else e=i,importScripts(i),n()})).then((()=>{let e=n[i];if(!e)throw new Error(`Module ${i} didn’t register its module`);return e})));self.define=(f,o)=>{const r=e||("document"in self?document.currentScript.src:"")||location.href;if(n[r])return;let c={};const s=e=>i(e,r),l={module:{uri:r},exports:c,require:s};n[r]=Promise.all(f.map((e=>l[e]||s(e)))).then((e=>(o(...e),c)))}}define(["./workbox-ca2b596c"],(function(e){"use strict";e.setCacheNameDetails({prefix:"front"}),self.addEventListener("message",(e=>{e.data&&"SKIP_WAITING"===e.data.type&&self.skipWaiting()})),e.precacheAndRoute([{url:"certificado.jpg",revision:"dd92f4a13dd9d81306dcb0886c89d1c9"},{url:"certificado2.jpg",revision:"c545694d2bbee3690e75a3d2a6df743d"},{url:"css/app.31d6cfe0.css",revision:null},{url:"css/vendor.67a08026.css",revision:null},{url:"favicon.ico",revision:"f4facfeaed834544d622544acfbb7722"},{url:"firma1png.png",revision:"d4752b5d32f684ecf5806f6737987c55"},{url:"fonts/KFOkCnqEu92Fr1MmgVxIIzQ.68bb21d0.woff",revision:null},{url:"fonts/KFOlCnqEu92Fr1MmEU9fBBc-.48af7707.woff",revision:null},{url:"fonts/KFOlCnqEu92Fr1MmSU5fBBc-.c2f7ab22.woff",revision:null},{url:"fonts/KFOlCnqEu92Fr1MmWUlfBBc-.77ecb942.woff",revision:null},{url:"fonts/KFOlCnqEu92Fr1MmYUtfBBc-.f5677eb2.woff",revision:null},{url:"fonts/KFOmCnqEu92Fr1Mu4mxM.f1e2a767.woff",revision:null},{url:"fonts/LDItaoyNOAY6Uewc665JcIzCKsKc_M9flwmJ.a336ba1a.woff",revision:null},{url:"fonts/LDItaoyNOAY6Uewc665JcIzCKsKc_M9flwmPq_HTTw.df007df8.woff2",revision:null},{url:"fonts/flUhRq6tzZclQEJ-Vdg-IuiaDsNa.99f5f787.woff",revision:null},{url:"fonts/flUhRq6tzZclQEJ-Vdg-IuiaDsNcIhQ8tQ.c08197a9.woff2",revision:null},{url:"fonts/gok-H7zzDkdnRel8-DQ6KAXJ69wP1tGnf4ZGhUcY.fba8609e.woff",revision:null},{url:"fonts/gok-H7zzDkdnRel8-DQ6KAXJ69wP1tGnf4ZGhUcel5euIg.8fceb488.woff2",revision:null},{url:"fonts/oPWQ_lt5nv4pWNJpghLP75WiFR4kLh3kvmvRImcycg.0bcd8fee.woff2",revision:null},{url:"fonts/oPWQ_lt5nv4pWNJpghLP75WiFR4kLh3kvmvX.3e1a2d27.woff",revision:null},{url:"frontal.png",revision:"2bceebd7d7398777599ef5e77ee41fdb"},{url:"icons/apple-icon-120x120.png",revision:"d082235f6e6d2109e84e397f66fa868d"},{url:"icons/apple-icon-152x152.png",revision:"3c728ce3e709b7395be487becf76283a"},{url:"icons/apple-icon-167x167.png",revision:"3fec89672a18e4b402ede58646917c2d"},{url:"icons/apple-icon-180x180.png",revision:"aa47843bd47f34b7ca4b99f65dd25955"},{url:"icons/favicon-128x128.png",revision:"ab92df0270f054ca388127c9703a4911"},{url:"icons/favicon-16x16.png",revision:"e4b046d41e08e6fa06626d6410ab381d"},{url:"icons/favicon-32x32.png",revision:"410858b01fa6d3d66b7bf21447c5f1fc"},{url:"icons/favicon-96x96.png",revision:"db2bde7f824fb4057ffd1c42f6ed756e"},{url:"icons/icon-128x128.png",revision:"ab92df0270f054ca388127c9703a4911"},{url:"icons/icon-192x192.png",revision:"7659f0d3e9602e71811f8b7cf2ce0e8e"},{url:"icons/icon-256x256.png",revision:"cf5ad3498fb6fda43bdafd3c6ce9b824"},{url:"icons/icon-384x384.png",revision:"fdfc1b3612b6833a27a7b260c9990247"},{url:"icons/icon-512x512.png",revision:"2c2dc987945806196bd18cb6028d8bf4"},{url:"icons/ms-icon-144x144.png",revision:"8de1b0e67a62b881cd22d935f102a0e6"},{url:"icons/safari-pinned-tab.svg",revision:"3e4c3730b00c89591de9505efb73afd3"},{url:"index.html",revision:"497384e2fbce5bac38e3ca5f5cbae90b"},{url:"js/862.df0d3d51.js",revision:null},{url:"js/985.946ce9d4.js",revision:null},{url:"js/app.f0bf02f3.js",revision:null},{url:"js/qrcode.min.js",revision:"bc01acb93f18a875cfeac0dbfdc70822"},{url:"js/vendor.f3b195ff.js",revision:null},{url:"logo.png",revision:"9c3cb06abd5f4f2a109399d26532c70d"},{url:"logo2.png",revision:"0c962d4e371ef8c8b92405103d3b9f33"},{url:"logoImage.png",revision:"510fa765091ea4b6a50a5a72e271a2fa"},{url:"manifest.json",revision:"ebdee355720f363ff21cac39ed019545"},{url:"trasera.png",revision:"337e87443da68029c9fd5e7c2eed5a31"},{url:"user.png",revision:"960d9c1c928cebe61055dc3b0bcab8a3"}],{}),e.registerRoute(new e.NavigationRoute(e.createHandlerBoundToURL("index.html"),{denylist:[/service-worker\.js$/,/workbox-(.)*\.js$/]}))}));
