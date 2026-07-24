const CACHE_NAME = 'amikomeventhub-v2';

self.addEventListener('install', () => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key)))
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    // Halaman HTML (navigasi) -> SELALU ambil versi terbaru dari server dulu
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(() => caches.match(event.request))
        );
        return;
    }

    // Aset statis (gambar, css, js) -> boleh tetap cache-first, aman karena tidak ada token di dalamnya
    event.respondWith(
        caches.match(event.request).then((response) => response || fetch(event.request))
    );
});