// (A) FILES TO CACHE
const cName = "hired-adm",
cFiles = [
  // (A1) BOOTSTRAP + TINYMCE
  "assets/tinymce/tinymce.min.js",
  "assets/bootstrap.bundle.min.js",
  "assets/bootstrap.bundle.min.js.map",
  "assets/bootstrap.min.css",
  "assets/bootstrap.min.css.map",
  "assets/CB-selector.css",
  "assets/CB-selector.js",
  // (A2) ICONS + IMAGES
  "assets/favicon.png",
  "assets/ico-512.png",
  // (A3) COMMON INTERFACE
  "assets/ADM-cb.js",
  "assets/maticon.woff2",
  // (A4) PAGES
  "assets/ADM-company.js",
  "assets/ADM-jobs.js",
  "assets/ADM-settings.js",
  "assets/ADM-users.js"
];

// (B) CREATE/INSTALL CACHE
self.addEventListener("install", (evt) => {
  evt.waitUntil(
    caches.open(cName)
    .then((cache) => { return cache.addAll(cFiles); })
    .catch((err) => { console.error(err) })
  );
});

// (C) LOAD FROM CACHE FIRST, FALLBACK TO NETWORK IF NOT FOUND
self.addEventListener("fetch", (evt) => {
  evt.respondWith(
    caches.match(evt.request)
    .then((res) => { return res || fetch(evt.request); })
  );
});
