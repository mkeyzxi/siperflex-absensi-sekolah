const CACHE_NAME = 'siperflex-cache-v6';
const OFFLINE_URL = '/offline.html';

const urlsToCache = [
    OFFLINE_URL,
    '/logo-transparan.png',
    '/logo.webp',
    '/logo-login.webp'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(urlsToCache);
            })
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    // Prevent service worker from handling POST requests incorrectly
    if (event.request.method !== 'GET') {
        return; 
    }

    // Stale-While-Revalidate untuk halaman HTML (khususnya dashboard)
    if (event.request.mode === 'navigate' || (event.request.headers.get('accept') && event.request.headers.get('accept').includes('text/html'))) {
        event.respondWith(
            caches.match(event.request).then((cachedResponse) => {
                const fetchPromise = fetch(event.request).then((networkResponse) => {
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, networkResponse.clone());
                    });
                    return networkResponse;
                }).catch(async () => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    
                    // Jika user membuka root (/) saat offline, paksa buka dashboard yang di-cache
                    const url = new URL(event.request.url);
                    if (url.pathname === '/') {
                        const dashboardSiswa = await caches.match('/siswa/dashboard', {ignoreSearch: true});
                        if (dashboardSiswa) return dashboardSiswa;
                        
                        const dashboardGuru = await caches.match('/guru/dashboard', {ignoreSearch: true});
                        if (dashboardGuru) return dashboardGuru;
                    }

                    return caches.match(OFFLINE_URL);
                });
                return cachedResponse || fetchPromise;
            })
        );
    } else {
        event.respondWith(
            caches.match(event.request).then((response) => {
                return response || fetch(event.request).then((networkResponse) => {
                    return caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, networkResponse.clone());
                        return networkResponse;
                    });
                });
            })
        );
    }
});
