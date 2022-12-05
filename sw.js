self.addEventListener('install', (e) => {
  e.waitUntil(
    caches.open('radio').then((cache) => cache.addAll([
      '/images/logo.png',
    ]))
  );
});

self.addEventListener('fetch', (e) => {
  console.log(e.request.url);
  e.respondWith(
    caches.match(e.request).then((response) => response || fetch(e.request))
  );
});