const VERSION = 'lacakkerja-shell-v2';
const TECHNICIAN_PAGE_PREFIX = '/technician/work-orders/';
const SHELL_ASSETS = [
    '/offline.html',
    '/manifest.webmanifest',
    '/favicon.svg',
    '/favicon.ico',
    '/pwa-icon-192.svg',
    '/pwa-icon-512.svg',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(VERSION)
            .then((cache) => cache.addAll(SHELL_ASSETS))
            .then(() => self.skipWaiting()),
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(keys.filter((key) => key !== VERSION).map((key) => caches.delete(key))))
            .then(() => self.clients.claim()),
    );
});

self.addEventListener('message', (event) => {
    if (event.data?.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }

    if (event.data?.type === 'CLEAR_TECHNICIAN_PAGES') {
        event.waitUntil(clearTechnicianPages());
    }
});

async function clearTechnicianPages() {
    const cache = await caches.open(VERSION);
    const requests = await cache.keys();

    await Promise.all(requests
        .filter((request) => new URL(request.url).pathname.startsWith(TECHNICIAN_PAGE_PREFIX))
        .map((request) => cache.delete(request)));
}

function isTechnicianPage(request) {
    const url = new URL(request.url);

    return request.method === 'GET'
        && request.mode === 'navigate'
        && url.origin === self.location.origin
        && url.pathname.startsWith(TECHNICIAN_PAGE_PREFIX);
}

async function fetchAndCacheTechnicianPage(request) {
    const response = await fetch(request);
    const responseUrl = new URL(response.url);
    const contentType = response.headers.get('content-type') || '';

    if (response.ok && responseUrl.origin === self.location.origin && responseUrl.pathname.startsWith(TECHNICIAN_PAGE_PREFIX) && contentType.includes('text/html')) {
        const cache = await caches.open(VERSION);
        await cache.put(request, response.clone());
    }

    return response;
}

self.addEventListener('fetch', (event) => {
    const request = event.request;
    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);
    if (url.origin !== self.location.origin) {
        return;
    }

    if (isTechnicianPage(request)) {
        event.respondWith(
            fetchAndCacheTechnicianPage(request)
                .catch(async () => {
                    const cached = await caches.match(request);
                    return cached || caches.match('/offline.html');
                }),
        );
        return;
    }

    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => caches.match('/offline.html')),
        );
        return;
    }

    if (!url.pathname.startsWith('/build/') && !SHELL_ASSETS.includes(url.pathname)) {
        return;
    }

    event.respondWith(
        caches.match(request).then((cached) => {
            const network = fetch(request).then((response) => {
                if (response.ok) {
                    const copy = response.clone();
                    caches.open(VERSION).then((cache) => cache.put(request, copy));
                }

                return response;
            });

            return cached || network.catch(() => caches.match('/offline.html'));
        }),
    );
});