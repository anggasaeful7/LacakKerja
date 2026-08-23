const offlineStore = {
    database: null,

    open() {
        if (!('indexedDB' in window)) {
            return Promise.resolve(null);
        }
        if (this.database) {
            return this.database;
        }
        this.database = new Promise((resolve, reject) => {
            const request = window.indexedDB.open('lacakkerja-offline-v1', 2);
            request.onupgradeneeded = () => {
                const database = request.result;
                if (!database.objectStoreNames.contains('work_orders')) {
                    database.createObjectStore('work_orders', { keyPath: 'cache_key' });
                }
                if (!database.objectStoreNames.contains('outbox')) {
                    const outbox = database.createObjectStore('outbox', { keyPath: 'client_operation_id' });
                    outbox.createIndex('scope', 'scope', { unique: false });
                    outbox.createIndex('state', 'state', { unique: false });
                }
                if (!database.objectStoreNames.contains('meta')) {
                    database.createObjectStore('meta', { keyPath: 'key' });
                }
                if (!database.objectStoreNames.contains('uploads')) {
                    const uploads = database.createObjectStore('uploads', { keyPath: 'client_upload_id' });
                    uploads.createIndex('scope', 'scope', { unique: false });
                    uploads.createIndex('state', 'state', { unique: false });
                }
            };
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
        return this.database;
    },

    async read(storeName, key) {
        const database = await this.open();
        if (!database) {
            return null;
        }
        return new Promise((resolve, reject) => {
            const request = database.transaction(storeName, 'readonly').objectStore(storeName).get(key);
            request.onsuccess = () => resolve(request.result ?? null);
            request.onerror = () => reject(request.error);
        });
    },

    async all(storeName) {
        const database = await this.open();
        if (!database) {
            return [];
        }
        return new Promise((resolve, reject) => {
            const request = database.transaction(storeName, 'readonly').objectStore(storeName).getAll();
            request.onsuccess = () => resolve(request.result ?? []);
            request.onerror = () => reject(request.error);
        });
    },

    async put(storeName, value) {
        const database = await this.open();
        if (!database) {
            return;
        }
        return new Promise((resolve, reject) => {
            const request = database.transaction(storeName, 'readwrite').objectStore(storeName).put(value);
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    },

    async remove(storeName, key) {
        const database = await this.open();
        if (!database) {
            return;
        }
        return new Promise((resolve, reject) => {
            const request = database.transaction(storeName, 'readwrite').objectStore(storeName).delete(key);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    },
};

const technicianUi = {
    syncing: false,
    serviceWorkerRegistration: null,
    updateWaiting: false,
    retryTimer: null,

    boot() {
        this.drafts();
        this.photoUploads();
        this.signatures();
        this.offlineMutations();
        this.syncCenter();
        this.logoutGuard();
        this.registerServiceWorker();
        this.bindNetworkEvents();
        this.cacheBootstrap();
        this.refreshState();
    },

    scope() {
        return document.querySelector('meta[name="lk-scope"]')?.content || 'unknown';
    },

    bootstrapUrl() {
        return document.querySelector('meta[name="lk-sync-bootstrap-url"]')?.content || null;
    },

    batchUrl() {
        return document.querySelector('meta[name="lk-sync-batch-url"]')?.content || null;
    },

    cacheKey(workOrderId) {
        return `${this.scope()}:${workOrderId}`;
    },

    operationId() {
        if (window.crypto?.randomUUID) {
            return window.crypto.randomUUID();
        }
        return `${Date.now()}-${Math.random().toString(16).slice(2)}`;
    },

    async cacheBootstrap(force = false) {
        const endpoint = this.bootstrapUrl();
        if (!endpoint || !navigator.onLine) {
            return;
        }
        try {
            const detail = document.querySelector('[data-offline-detail]')?.dataset.workOrderId;
            const url = new URL(endpoint, window.location.origin);
            if (detail) {
                url.searchParams.set('work_order_id', detail);
            }
            const response = await fetch(url, { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            if (!response.ok) {
                return;
            }
            const payload = await response.json();
            const records = await offlineStore.all('outbox');
            const scope = this.scope();
            for (const workOrder of payload.work_orders || []) {
                const hasLocalMutation = records.some((operation) => operation.scope === scope && Number(operation.work_order_id) === Number(workOrder.id) && ['pending', 'conflict', 'failed'].includes(operation.state));
                if (!hasLocalMutation || force) {
                    await offlineStore.put('work_orders', { cache_key: this.cacheKey(workOrder.id), scope, work_order: workOrder, cached_at: Date.now() });
                }
            }
            await offlineStore.put('meta', { key: `${scope}:last_bootstrap`, value: Date.now() });
            this.refreshState();
        } catch (error) {
            // Network failures leave the existing cache and outbox untouched.
        }
    },

    async queueMutation(form) {
        const type = form.dataset.syncType;
        const workOrderId = Number(form.dataset.syncWorkOrderId);
        const formData = new FormData(form);
        let payload;
        if (type === 'checklist.update') {
            payload = {
                item_id: Number(form.dataset.syncItemId),
                value: formData.has('value') ? formData.get('value') : null,
            };
        } else {
            payload = {
                body: String(formData.get('body') || ''),
                visibility: String(formData.get('visibility') || 'internal'),
            };
        }
        const scope = this.scope();
        const cached = await offlineStore.read('work_orders', this.cacheKey(workOrderId));
        const baseVersion = Number(cached?.work_order?.lock_version || form.dataset.syncBaseVersion || 1);
        const operation = {
            client_operation_id: this.operationId(),
            scope,
            type,
            work_order_id: workOrderId,
            base_version: baseVersion,
            payload,
            state: 'pending',
            created_at: Date.now(),
            response: null,
        };
        await offlineStore.put('outbox', operation);
        if (cached?.work_order) {
            const workOrder = structuredClone(cached.work_order);
            workOrder.lock_version = baseVersion + 1;
            if (type === 'checklist.update') {
                const item = (workOrder.checklist_items || []).find((candidate) => Number(candidate.id) === payload.item_id);
                if (item) {
                    item.value = payload.value === null ? null : payload.value === '1' ? true : payload.value;
                }
            } else {
                workOrder.notes = [{ id: `local-${operation.client_operation_id}`, body: payload.body, visibility: payload.visibility, author: 'Kamu', created_at: new Date().toISOString(), pending: true }, ...(workOrder.notes || [])];
            }
            await offlineStore.put('work_orders', { ...cached, work_order: workOrder, cached_at: Date.now() });
        }
        form.dataset.syncBaseVersion = String(baseVersion + 1);
        return operation;
    },

    offlineMutations() {
        document.querySelectorAll('[data-offline-mutation]').forEach((form) => {
            if (form.dataset.offlineReady === 'true') {
                return;
            }
            form.dataset.offlineReady = 'true';
            form.addEventListener('submit', async (event) => {
                if (navigator.onLine) {
                    return;
                }
                event.preventDefault();
                const submit = form.querySelector('button[type="submit"]');
                const status = form.querySelector('[data-offline-status]');
                if (submit) {
                    submit.disabled = true;
                    submit.textContent = 'Menyimpan lokal…';
                }
                try {
                    await this.queueMutation(form);
                    if (form.dataset.syncType === 'note.create') {
                        const draftField = form.querySelector('[data-draft-field]');
                        if (draftField) { draftField.value = ''; }
                        try { window.localStorage.removeItem(form.dataset.draftKey); } catch (error) { /* private mode */ }
                    }
                    if (status) {
                        status.textContent = 'Tersimpan di perangkat · menunggu koneksi';
                    }
                    await this.refreshState();
                } catch (error) {
                    if (status) {
                        status.textContent = 'Gagal menyimpan lokal. Coba lagi.';
                    }
                } finally {
                    if (submit) {
                        submit.disabled = false;
                        submit.textContent = form.dataset.syncType === 'note.create' ? 'Simpan catatan' : 'Simpan';
                    }
                }
            });
        });
    },

    bindNetworkEvents() {
        if (document.documentElement.dataset.syncNetworkReady === 'true') {
            return;
        }
        document.documentElement.dataset.syncNetworkReady = 'true';
        window.addEventListener('online', () => {
            this.refreshState();
            this.syncQueue();
            this.cacheBootstrap();
        });
        window.addEventListener('offline', () => this.refreshState());
    },

    async syncUploads(force = false) {
        const scope = this.scope();
        const uploads = (await offlineStore.all('uploads')).filter((upload) => upload.scope === scope && (upload.state === 'pending' || (force && upload.state === 'failed')) && (! upload.next_retry_at || force || upload.next_retry_at <= Date.now()));
        for (const upload of uploads) {
            try {
                const payload = new FormData();
                payload.append('file', upload.file, upload.file_name);
                payload.append('category', upload.category);
                payload.append('client_upload_id', upload.client_upload_id);
                if (upload.is_required) {
                    payload.append('is_required', '1');
                }
                const response = await fetch(upload.endpoint, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: payload,
                });
                if (!response.ok) {
                    await offlineStore.put('uploads', { ...upload, state: 'failed', response: { message: 'Server menolak foto. Periksa format atau ukuran file.' }, updated_at: Date.now() });
                    continue;
                }
                await offlineStore.remove('uploads', upload.client_upload_id);
            } catch (error) {
                const retryCount = Number(upload.retry_count || 0) + 1;
                const delay = Math.min(60000, 1000 * (2 ** Math.min(retryCount, 6)));
                await offlineStore.put('uploads', { ...upload, state: 'pending', retry_count: retryCount, next_retry_at: Date.now() + delay, response: { message: `Jaringan belum siap. Coba lagi dalam ${Math.ceil(delay / 1000)} detik.` }, updated_at: Date.now() });
            }
        }
        this.scheduleRetry();
    },

    scheduleRetry() {
        if (this.retryTimer) {
            window.clearTimeout(this.retryTimer);
            this.retryTimer = null;
        }
        offlineStore.all('outbox').then((operations) => {
            const scope = this.scope();
            return offlineStore.all('uploads').then((uploads) => [...operations, ...uploads].filter((item) => item.scope === scope && item.state === 'pending' && item.next_retry_at));
        }).then((items) => {
            if (!navigator.onLine || !items.length) {
                return;
            }
            const nextAt = Math.min(...items.map((item) => item.next_retry_at));
            this.retryTimer = window.setTimeout(() => this.syncQueue(), Math.max(250, nextAt - Date.now()));
        }).catch(() => {});
    },
    async syncQueue(force = false) {
        if (this.syncing || !navigator.onLine || !this.batchUrl()) {
            await this.refreshState();
            return;
        }
        const scope = this.scope();
        const allOperations = await offlineStore.all('outbox');
        const operations = allOperations.filter((operation) => operation.scope === scope && (operation.state === 'pending' || (force && ['failed', 'conflict'].includes(operation.state))) && (! operation.next_retry_at || force || operation.next_retry_at <= Date.now()));
        const uploads = (await offlineStore.all('uploads')).filter((upload) => upload.scope === scope && (upload.state === 'pending' || (force && upload.state === 'failed')) && (! upload.next_retry_at || force || upload.next_retry_at <= Date.now()));
        if (!operations.length && !uploads.length) {
            await this.refreshState();
            this.scheduleRetry();
            return;
        }
        this.syncing = true;
        await this.refreshState();
        let metadataSafe = operations.length === 0;
        try {
            if (operations.length) {
                try {
                    const response = await fetch(this.batchUrl(), {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ operations: operations.map(({ scope: ignored, state: ignoredState, created_at: ignoredCreated, response: ignoredResponse, retry_count: ignoredRetry, next_retry_at: ignoredNext, updated_at: ignoredUpdated, ...operation }) => operation) }),
                    });
                    if (!response.ok) {
                        throw new Error('sync-failed');
                    }
                    const result = await response.json();
                    for (const serverResult of result.results || []) {
                        const operation = operations.find((candidate) => candidate.client_operation_id === serverResult.client_operation_id);
                        if (!operation) {
                            continue;
                        }
                        if (serverResult.state === 'synced') {
                            await offlineStore.remove('outbox', operation.client_operation_id);
                        } else {
                            await offlineStore.put('outbox', { ...operation, state: serverResult.state, response: serverResult, updated_at: Date.now(), next_retry_at: null });
                        }
                    }
                    await offlineStore.put('meta', { key: `${scope}:last_sync`, value: Date.now() });
                    metadataSafe = (result.results || []).length === operations.length && (result.results || []).every((serverResult) => serverResult.state === 'synced');
                } catch (error) {
                    metadataSafe = false;
                    for (const operation of operations) {
                        const retryCount = Number(operation.retry_count || 0) + 1;
                        const delay = Math.min(60000, 1000 * (2 ** Math.min(retryCount, 6)));
                        await offlineStore.put('outbox', { ...operation, state: 'pending', retry_count: retryCount, next_retry_at: Date.now() + delay, response: { message: `Jaringan belum siap. Coba lagi dalam ${Math.ceil(delay / 1000)} detik.` }, updated_at: Date.now() });
                    }
                }
            }
            if (metadataSafe) {
                await this.syncUploads(force);
            }
            await this.cacheBootstrap();
        } finally {
            this.syncing = false;
            this.scheduleRetry();
            await this.refreshState();
        }
    },
    async refreshState() {
        const scope = this.scope();
        const operations = (await offlineStore.all('outbox')).filter((operation) => operation.scope === scope);
        const uploads = (await offlineStore.all('uploads')).filter((upload) => upload.scope === scope);
        const pending = operations.filter((operation) => operation.state === 'pending').length + uploads.filter((upload) => upload.state === 'pending').length;
        const conflicts = operations.filter((operation) => operation.state === 'conflict').length;
        const failed = operations.filter((operation) => operation.state === 'failed').length + uploads.filter((upload) => upload.state === 'failed').length;
        const lastSync = await offlineStore.read('meta', `${scope}:last_sync`);
        let state = 'synced';
        let label = 'Tersinkronisasi';
        let description = 'Semua perubahan lokal sudah dikonfirmasi server.';
        if (!navigator.onLine) {
            state = 'offline';
            label = 'Offline · tersimpan lokal';
            description = pending ? `${pending} perubahan menunggu koneksi.` : 'Perubahan baru akan disimpan lokal.';
        } else if (this.syncing) {
            state = 'syncing';
            label = 'Menyinkronkan';
            description = 'Mengirim perubahan dan menunggu konfirmasi server…';
        } else if (conflicts || failed) {
            state = 'failed';
            label = 'Perlu ditinjau';
            description = `${conflicts + failed} perubahan memerlukan tindakan.`;
        } else if (pending) {
            state = 'syncing';
            label = 'Menunggu sinkronisasi';
            description = `${pending} perubahan siap dikirim.`;
        }
        document.querySelectorAll('[data-sync-badge]').forEach((badge) => {
            badge.dataset.syncState = state;
            badge.textContent = label;
            badge.title = description;
        });
        const center = document.querySelector('[data-sync-center]');
        if (center) {
            center.querySelector('[data-sync-state]')?.replaceChildren(document.createTextNode(label));
            center.querySelector('[data-sync-description]')?.replaceChildren(document.createTextNode(description));
            center.querySelector('[data-sync-pending-count]')?.replaceChildren(document.createTextNode(String(pending)));
            center.querySelector('[data-sync-conflict-count]')?.replaceChildren(document.createTextNode(String(conflicts)));
            center.querySelector('[data-sync-failed-count]')?.replaceChildren(document.createTextNode(String(failed)));
            center.querySelector('[data-sync-last-synced]')?.replaceChildren(document.createTextNode(lastSync?.value ? new Date(lastSync.value).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : 'Belum ada'));
            const button = center.querySelector('[data-sync-now]');
            if (button) {
                button.disabled = this.syncing || !navigator.onLine;
            }
        }
        const uploadItems = uploads.map((upload) => ({ ...upload, type: 'photo.upload', queue_kind: 'upload', response: upload.response || {} }));
        await this.renderQueue([...operations, ...uploadItems]);
    },
    async renderQueue(operations = null) {
        const center = document.querySelector('[data-sync-center]');
        if (!center) {
            return;
        }
        const queue = center.querySelector('[data-sync-queue]');
        if (!queue) {
            return;
        }
        let items = operations;
        if (!items) {
            const outbox = (await offlineStore.all('outbox')).filter((operation) => operation.scope === this.scope());
            const uploads = (await offlineStore.all('uploads')).filter((upload) => upload.scope === this.scope()).map((upload) => ({ ...upload, type: 'photo.upload', queue_kind: 'upload', response: upload.response || {} }));
            items = [...outbox, ...uploads];
        }
        if (!items.length) {
            queue.innerHTML = '<p class="p-6 text-center text-sm text-on-surface-variant">Antrean kosong. Perubahan baru akan muncul di sini.</p>';
            return;
        }
        const labels = { 'checklist.update': 'Checklist', 'note.create': 'Catatan', 'photo.upload': 'Foto' };
        queue.innerHTML = items.sort((a, b) => a.created_at - b.created_at).map((operation) => {
            const response = operation.response || {};
            const state = operation.state === 'pending' ? 'Menunggu koneksi' : operation.state === 'conflict' ? 'Konflik' : 'Gagal';
            const action = operation.state === 'pending' ? '' : `<div class="mt-3 flex flex-wrap gap-2"><button type="button" data-sync-action="retry" data-queue-kind="${operation.queue_kind || 'outbox'}" data-operation-id="${this.escape(operation.client_operation_id)}" class="inline-flex min-h-11 cursor-pointer items-center rounded-control border border-accent px-3 text-sm font-semibold text-accent">${operation.state === 'conflict' ? 'Coba pakai lokal' : 'Coba lagi'}</button><button type="button" data-sync-action="discard" data-queue-kind="${operation.queue_kind || 'outbox'}" data-operation-id="${this.escape(operation.client_operation_id)}" class="inline-flex min-h-11 cursor-pointer items-center rounded-control border border-border px-3 text-sm font-semibold text-on-surface">Buang lokal</button></div>`;
            return `<article class="p-5"><div class="flex items-start justify-between gap-3"><div><p class="font-semibold text-on-surface">${labels[operation.type] || this.escape(operation.type)}</p><p class="mt-1 text-xs text-muted-foreground">WO-${this.escape(String(operation.work_order_id))} · ${new Date(operation.created_at).toLocaleString('id-ID')}</p></div><span class="inline-flex min-h-8 items-center rounded-full ${operation.state === 'conflict' ? 'bg-warning-soft text-warning-content' : operation.state === 'failed' ? 'bg-danger-soft text-danger-content' : 'bg-surface-subtle text-on-surface-variant'} px-3 text-xs font-semibold">${state}</span></div><p class="mt-3 text-sm text-on-surface-variant">${this.escape(response.message || (operation.state === 'pending' ? 'Tersimpan di perangkat dan akan dikirim otomatis.' : 'Periksa koneksi atau pilih tindakan.'))}</p>${response.server_version ? `<p class="mt-2 text-xs text-muted-foreground">Versi server: ${this.escape(String(response.server_version))}</p>` : ''}${action}</article>`;
        }).join('');
    },

    async handleQueueAction(action, operationId, queueKind = 'outbox') {
        const storeName = queueKind === 'upload' ? 'uploads' : 'outbox';
        const operation = await offlineStore.read(storeName, operationId);
        if (!operation) {
            return;
        }
        if (action === 'discard') {
            await offlineStore.remove(storeName, operationId);
            await this.cacheBootstrap();
        } else if (queueKind === 'upload') {
            await offlineStore.put('uploads', { ...operation, state: 'pending', next_retry_at: null, response: null, updated_at: Date.now() });
            if (navigator.onLine) {
                await this.syncQueue();
            }
        } else {
            const serverVersion = Number(operation.response?.server_version || operation.base_version);
            await offlineStore.remove('outbox', operationId);
            await offlineStore.put('outbox', { ...operation, client_operation_id: this.operationId(), state: 'pending', base_version: serverVersion, response: null, next_retry_at: null, updated_at: Date.now() });
            if (navigator.onLine) {
                await this.syncQueue();
            }
        }
        await this.refreshState();
    },
    syncCenter() {
        const center = document.querySelector('[data-sync-center]');
        if (!center || center.dataset.syncReady === 'true') {
            return;
        }
        center.dataset.syncReady = 'true';
        center.addEventListener('click', (event) => {
            const action = event.target.closest('[data-sync-action]');
            if (action) {
                this.handleQueueAction(action.dataset.syncAction, action.dataset.operationId, action.dataset.queueKind || 'outbox');
                return;
            }
            if (event.target.closest('[data-sync-now]')) {
                this.syncQueue(true);
                return;
            }
            if (event.target.closest('[data-sync-refresh-cache]')) {
                this.cacheBootstrap(true).then(() => this.refreshState());
                return;
            }
            if (event.target.closest('[data-sync-apply-update]')) {
                this.applyServiceWorkerUpdate();
            }
        });
        this.renderQueue();
    },

    logoutGuard() {
        document.querySelectorAll('form').forEach((form) => {
            if (form.dataset.logoutReady === 'true' || !form.action.endsWith('/logout')) {
                return;
            }
            form.dataset.logoutReady = 'true';
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                let pending = [];
                try {
                    const pendingOperations = (await offlineStore.all('outbox')).filter((operation) => operation.scope === this.scope() && ['pending', 'conflict', 'failed'].includes(operation.state));
                    const pendingUploads = (await offlineStore.all('uploads')).filter((upload) => upload.scope === this.scope() && ['pending', 'failed'].includes(upload.state));
                    pending = [...pendingOperations, ...pendingUploads];
                } catch (error) {
                    pending = [];
                }
                if (pending.length && !window.confirm(String(pending.length) + ' perubahan belum tersinkron. Tetap keluar? Perubahan tetap tersimpan di perangkat ini.')) {
                    return;
                }

                navigator.serviceWorker.controller?.postMessage({ type: 'CLEAR_TECHNICIAN_PAGES' });
                HTMLFormElement.prototype.submit.call(form);
            });
        });
    },

    registerServiceWorker() {
        if (!('serviceWorker' in navigator) || this.serviceWorkerRegistration) {
            return;
        }
        navigator.serviceWorker.register('/sw.js', { scope: '/', updateViaCache: 'none' }).then((registration) => {
            this.serviceWorkerRegistration = registration;
            registration.addEventListener('updatefound', () => {
                const worker = registration.installing;
                worker?.addEventListener('statechange', () => {
                    if (worker.state === 'installed' && navigator.serviceWorker.controller) {
                        this.updateWaiting = true;
                        document.querySelector('[data-sync-update]')?.classList.remove('hidden');
                    }
                });
            });
        }).catch(() => {
            // The application remains usable without PWA installation.
        });
    },

    applyServiceWorkerUpdate() {
        this.serviceWorkerRegistration?.waiting?.postMessage({ type: 'SKIP_WAITING' });
        let reloaded = false;
        navigator.serviceWorker.addEventListener('controllerchange', () => {
            if (!reloaded) {
                reloaded = true;
                window.location.reload();
            }
        }, { once: true });
    },

    escape(value) {
        return String(value).replace(/[&<>'"]/g, (character) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;' })[character]);
    },

    drafts() {
        document.querySelectorAll('[data-draft-form]').forEach((form) => {
            if (form.dataset.draftReady === 'true') {
                return;
            }
            const key = form.dataset.draftKey;
            const field = form.querySelector('[data-draft-field]');
            if (!key || !field) {
                return;
            }
            form.dataset.draftReady = 'true';
            try {
                const saved = window.localStorage.getItem(key);
                if (saved && field.value === '') {
                    field.value = saved;
                }
            } catch (error) {
                // Private browsing may block localStorage; the server form remains usable.
            }
            field.addEventListener('input', () => {
                try {
                    window.localStorage.setItem(key, field.value);
                } catch (error) {
                    // Ignore storage quota/private browsing errors.
                }
            });
            form.addEventListener('submit', () => {
                try {
                    window.localStorage.removeItem(key);
                } catch (error) {
                    // Ignore storage quota/private browsing errors.
                }
            });
        });
    },

    photoUploads() {
        document.querySelectorAll('[data-photo-upload]').forEach((form) => {
            if (form.dataset.photoReady === 'true') {
                return;
            }
            form.dataset.photoReady = 'true';
            const input = form.querySelector('[data-photo-input]');
            const progress = form.querySelector('[data-upload-progress]');
            const status = form.querySelector('[data-upload-status]');
            const cancel = form.querySelector('[data-upload-cancel]');
            const submit = form.querySelector('button[type="submit"]');
            let request = null;
            let cancelled = false;
            let clientUploadId = form.dataset.clientUploadId || this.operationId();
            form.dataset.clientUploadId = clientUploadId;
            const setStatus = (message, isError = false) => {
                if (!status) {
                    return;
                }
                status.textContent = message;
                status.classList.toggle('text-danger-content', isError);
                status.classList.toggle('text-on-surface-variant', !isError);
            };
            const compress = (file) => new Promise((resolve) => {
                if (!file.type.startsWith('image/') || file.size < 500000 || typeof window.createImageBitmap !== 'function') {
                    resolve(file);
                    return;
                }
                window.createImageBitmap(file).then((bitmap) => {
                    const maxSide = 1600;
                    const scale = Math.min(1, maxSide / Math.max(bitmap.width, bitmap.height));
                    const canvas = document.createElement('canvas');
                    canvas.width = Math.max(1, Math.round(bitmap.width * scale));
                    canvas.height = Math.max(1, Math.round(bitmap.height * scale));
                    const context = canvas.getContext('2d');
                    context.drawImage(bitmap, 0, 0, canvas.width, canvas.height);
                    canvas.toBlob((blob) => resolve(blob ? new File([blob], file.name.replace(/\.[^.]+$/, '.jpg'), { type: 'image/jpeg' }) : file), 'image/jpeg', 0.82);
                }).catch(() => resolve(file));
            });
            const queueUpload = async (file) => {
                await offlineStore.put('uploads', {
                    client_upload_id: clientUploadId,
                    scope: this.scope(),
                    endpoint: form.action,
                    work_order_id: Number(form.closest('[data-offline-detail]')?.dataset.workOrderId || 0),
                    category: form.querySelector('[name="category"]')?.value || 'evidence',
                    is_required: form.querySelector('[name="is_required"]')?.checked || false,
                    file,
                    file_name: file.name,
                    file_type: file.type,
                    state: 'pending',
                    created_at: Date.now(),
                    retry_count: 0,
                    next_retry_at: null,
                    response: null,
                });
                setStatus('Foto tersimpan di perangkat · menunggu koneksi');
                await this.refreshState();
            };
            const upload = async () => {
                if (!input || !input.files || !input.files[0] || form.dataset.uploading === 'true') {
                    setStatus('Pilih foto terlebih dahulu.', true);
                    return;
                }
                form.dataset.uploading = 'true';
                cancelled = false;
                if (submit) { submit.disabled = true; submit.textContent = 'Menyiapkan foto…'; }
                setStatus('Menyiapkan kompresi foto…');
                const compressed = await compress(input.files[0]);
                if (compressed !== input.files[0]) {
                    const transfer = new DataTransfer();
                    transfer.items.add(compressed);
                    input.files = transfer.files;
                }
                if (!navigator.onLine) {
                    try {
                        await queueUpload(compressed);
                        input.value = '';
                        clientUploadId = this.operationId();
                        form.dataset.clientUploadId = clientUploadId;
                    } catch (error) {
                        setStatus('Penyimpanan lokal penuh. Kosongkan ruang lalu coba lagi.', true);
                    } finally {
                        form.dataset.uploading = 'false';
                        if (submit) { submit.disabled = false; submit.textContent = 'Unggah foto'; }
                    }
                    return;
                }
                const payload = new FormData(form);
                payload.set('client_upload_id', clientUploadId);
                request = new XMLHttpRequest();
                request.open('POST', form.action);
                request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                request.upload.addEventListener('progress', (event) => {
                    if (!event.lengthComputable) { return; }
                    const percent = Math.round((event.loaded / event.total) * 100);
                    if (progress) { progress.classList.remove('hidden'); progress.value = percent; }
                    setStatus(`Mengunggah foto… ${percent}%`);
                    if (submit) { submit.textContent = `Mengunggah ${percent}%`; }
                });
                request.addEventListener('load', () => {
                    if (request.status >= 200 && request.status < 400) {
                        setStatus('Upload selesai, memuat konfirmasi server…');
                        window.location.assign(request.responseURL || form.action);
                        return;
                    }
                    form.dataset.uploading = 'false';
                    if (submit) { submit.disabled = false; submit.textContent = 'Coba unggah lagi'; }
                    setStatus('Upload gagal. Periksa ukuran atau jaringan lalu coba lagi.', true);
                });
                request.addEventListener('error', async () => {
                    form.dataset.uploading = 'false';
                    if (submit) { submit.disabled = false; submit.textContent = 'Coba unggah lagi'; }
                    if (!cancelled) {
                        try {
                            await queueUpload(compressed);
                        } catch (error) {
                            setStatus('Jaringan bermasalah dan foto gagal disimpan lokal.', true);
                            return;
                        }
                    }
                    setStatus('Jaringan bermasalah · foto disimpan untuk dikirim ulang.');
                });
                request.addEventListener('abort', () => {
                    form.dataset.uploading = 'false';
                    if (submit) { submit.disabled = false; submit.textContent = 'Unggah foto'; }
                    setStatus('Upload dibatalkan.');
                });
                if (cancel) {
                    cancel.classList.remove('hidden');
                    cancel.onclick = () => { cancelled = true; request?.abort(); };
                }
                request.send(payload);
            };
            form.addEventListener('submit', (event) => { event.preventDefault(); upload(); });
        });
    },
    signatures() {
        document.querySelectorAll('[data-signature-form]').forEach((form) => {
            if (form.dataset.signatureReady === 'true') { return; }
            form.dataset.signatureReady = 'true';
            const canvas = form.querySelector('[data-signature-pad]');
            const input = form.querySelector('[data-signature-input]');
            const clear = form.querySelector('[data-signature-clear]');
            if (!canvas || !input) { return; }
            const context = canvas.getContext('2d');
            context.lineWidth = 3;
            context.lineCap = 'round';
            context.strokeStyle = '#0f172a';
            let drawing = false;
            let signed = false;
            const point = (event) => {
                const bounds = canvas.getBoundingClientRect();
                return { x: (event.clientX - bounds.left) * (canvas.width / bounds.width), y: (event.clientY - bounds.top) * (canvas.height / bounds.height) };
            };
            canvas.addEventListener('pointerdown', (event) => { drawing = true; signed = true; canvas.setPointerCapture(event.pointerId); const position = point(event); context.beginPath(); context.moveTo(position.x, position.y); });
            canvas.addEventListener('pointermove', (event) => { if (!drawing) { return; } const position = point(event); context.lineTo(position.x, position.y); context.stroke(); });
            ['pointerup', 'pointercancel', 'pointerleave'].forEach((eventName) => canvas.addEventListener(eventName, () => { drawing = false; }));
            clear?.addEventListener('click', () => { context.clearRect(0, 0, canvas.width, canvas.height); input.value = ''; signed = false; });
            form.addEventListener('submit', (event) => { if (!signed) { event.preventDefault(); window.alert('Tanda tangan belum dibuat.'); return; } input.value = canvas.toDataURL('image/png'); });
        });
    },
};

window.technicianUi = technicianUi;
document.addEventListener('DOMContentLoaded', () => technicianUi.boot());
document.addEventListener('livewire:navigated', () => technicianUi.boot());
document.addEventListener('lk-sync-updated', () => technicianUi.refreshState());

const invoiceEditorUi = {
    boot() {
        document.querySelectorAll('[data-invoice-editor]').forEach((editor) => {
            if (editor.dataset.invoiceReady === 'true') {
                return;
            }
            editor.dataset.invoiceReady = 'true';
            const form = editor.querySelector('[data-invoice-form]');
            const items = editor.querySelector('[data-invoice-items]');
            const currency = document.querySelector('meta[name="lk-currency"]')?.content || 'IDR';
            if (!form || !items) {
                return;
            }
            const money = (value) => `${currency} ${new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(Math.max(0, Math.round(value || 0)))}`;
            const renumber = () => {
                items.querySelectorAll('[data-invoice-item]').forEach((row, index) => {
                    row.querySelectorAll('[name]').forEach((field) => { field.name = field.name.replace(/items\[\d+\]/, `items[${index}]`); });
                    row.querySelectorAll('[id]').forEach((field) => { field.id = field.id.replace(/-\d+$/, `-${index}`); });
                });
            };
            const recalculate = () => {
                let subtotal = 0;
                items.querySelectorAll('[data-invoice-item]').forEach((row) => {
                    const quantity = Number(row.querySelector('[name$="[quantity]"]')?.value || 0);
                    const unitPrice = Number(row.querySelector('[name$="[unit_price]"]')?.value || 0);
                    const lineTotal = Math.round(Math.max(0, quantity) * Math.max(0, unitPrice));
                    subtotal += lineTotal;
                    const target = row.querySelector('[data-invoice-line-total]');
                    if (target) { target.textContent = money(lineTotal); }
                });
                const discount = Math.min(subtotal, Math.max(0, Number(editor.querySelector('[name="discount_amount"]')?.value || 0)));
                const rate = Math.min(100, Math.max(0, Number(editor.querySelector('[name="tax_rate"]')?.value || 0)));
                const tax = Math.round((subtotal - discount) * (rate / 100));
                const subtotalTarget = editor.querySelector('[data-invoice-subtotal]');
                const taxTarget = editor.querySelector('[data-invoice-tax]');
                const totalTarget = editor.querySelector('[data-invoice-total]');
                if (subtotalTarget) { subtotalTarget.textContent = money(subtotal); }
                if (taxTarget) { taxTarget.textContent = money(tax); }
                if (totalTarget) { totalTarget.textContent = money(subtotal - discount + tax); }
            };
            editor.addEventListener('input', recalculate);
            editor.addEventListener('change', (event) => {
                if (event.target.matches('[name="work_order_id"]')) {
                    const option = event.target.selectedOptions[0];
                    const customer = editor.querySelector('[name="customer_id"]');
                    const firstRow = items.querySelector('[data-invoice-item]');
                    const description = firstRow?.querySelector('[name$="[description]"]');
                    const price = firstRow?.querySelector('[name$="[unit_price]"]');
                    if (option?.dataset.customerId && customer) { customer.value = option.dataset.customerId; }
                    if (option?.dataset.title && description && !description.value) { description.value = option.dataset.title; }
                    if (option?.dataset.total && price && (!price.value || price.value === '0')) { price.value = option.dataset.total; }
                }
                recalculate();
            });
            editor.addEventListener('click', (event) => {
                const remove = event.target.closest('[data-invoice-remove-item]');
                if (remove) {
                    const rows = items.querySelectorAll('[data-invoice-item]');
                    if (rows.length === 1) {
                        rows[0].querySelectorAll('input').forEach((field) => { if (!field.name.endsWith('[service_id]')) { field.value = field.name.endsWith('[quantity]') ? '1.000' : '0'; } });
                    } else {
                        remove.closest('[data-invoice-item]')?.remove();
                        renumber();
                    }
                    recalculate();
                    return;
                }
                if (event.target.closest('[data-invoice-add-item]')) {
                    const source = items.querySelector('[data-invoice-item]');
                    if (!source) { return; }
                    const clone = source.cloneNode(true);
                    clone.querySelectorAll('input').forEach((field) => {
                        if (field.name.endsWith('[description]')) { field.value = ''; }
                        if (field.name.endsWith('[service_id]')) { field.value = ''; }
                        if (field.name.endsWith('[quantity]')) { field.value = '1.000'; }
                        if (field.name.endsWith('[unit_price]')) { field.value = '0'; }
                    });
                    items.append(clone);
                    renumber();
                    recalculate();
                }
            });
            form.addEventListener('submit', (event) => {
                const submit = form.querySelector('button[type="submit"]');
                if (submit) { submit.disabled = true; submit.textContent = 'Menyimpan…'; }
                renumber();
                if (!form.checkValidity()) {
                    event.preventDefault();
                    if (submit) { submit.disabled = false; submit.textContent = 'Simpan draft'; }
                }
            });
            renumber();
            recalculate();
        });
    },
};

document.addEventListener('DOMContentLoaded', () => invoiceEditorUi.boot());
document.addEventListener('livewire:navigated', () => invoiceEditorUi.boot());