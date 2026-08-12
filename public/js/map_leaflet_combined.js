/**
 * JavaScript Map System - Seamless tile cache with world-coordinate positioning
 *
 * Architecture:
 *  - Every tile is positioned at (worldX * TW, worldY * TH) in absolute pixels
 *    relative to the tile container. Positions NEVER change.
 *  - The tile container moves via CSS transform (translate) to show the current view.
 *  - Because positions are stable, the tile cache works perfectly:
 *      old tiles stay visible while new edge tiles load in the background.
 *  - No full clear. Only tiles beyond the prune radius (> mapSize/2 + margin) are removed.
 *  - Pre-fetches a buffer (mapSize + 4) larger than the viewport so edges are
 *    already loaded before becoming visible.
 */

class JSMapSystem {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        if (!this.container) return;

        this.currentX = options.currentX || 500;
        this.currentY = options.currentY || 500;
        this.mapSize = options.mapSize || 11;
        this.villageId = options.villageId;

        // Player's own village coords — used for unit travel-time calculations
        this.village_x = options.village_x || (typeof currentVillageX !== 'undefined' ? currentVillageX : 500);
        this.village_y = options.village_y || (typeof currentVillageY !== 'undefined' ? currentVillageY : 500);

        // Tile pixel dimensions
        this.TW = 53;
        this.TH = 38;

        // Viewport dimensions (set after DOM creation)
        this.vpW = 0;
        this.vpH = 570;

        // Transform offset: container is shifted so worldX/Y maps to viewport centre
        // offsetX = vpW/2 - currentX * TW
        this.offsetX = 0;
        this.offsetY = 0;

        // Drag state
        this.isDragging = false;
        this.dragX = 0;
        this.dragY = 0;
        this._rafId = null;
        this._dragStartX = 0;
        this._dragStartY = 0;
        this._dragMoved = false;  // true once drag threshold exceeded
        this.DRAG_THRESHOLD = 6; // px before we consider it a drag, not a tap

        // Tile cache: worldKey "x|y" -> DOM element
        this.tileCache = new Map();

        // Prune radius: tiles further than this (in tiles) from current centre are removed
        this.PRUNE_RADIUS = Math.floor(this.mapSize / 2) + 4;

        // Fetch mode: one active fetch + one queued
        this.isLoading = false;
        this._queuedPos = null;

        // Faith circle overlay toggle (persisted per-browser)
        this.showFaithCircles = localStorage.getItem('map_show_faith') !== '0';
        this._lastFaithCircles = [];
        
        // Watchtower circle overlay toggle
        this.showWatchtowerCircles = localStorage.getItem('map_show_watchtower') !== '0';
        this._lastWatchtowerCircles = [];

        this._init();
    }

    /* ============================================================ */
    /*  Init                                                         */
    /* ============================================================ */

    _init() {
        // Viewport
        this.viewport = document.createElement('div');
        this.viewport.className = 'js-map-viewport';
        this.viewport.style.cssText = `
            position: relative;
            width: 100%;
            height: ${this.vpH}px;
            overflow: hidden;
            cursor: grab;
            user-select: none;
            touch-action: none;
        `;

        // Tile container — absolute world-coordinate space
        this.tileContainer = document.createElement('div');
        this.tileContainer.className = 'js-map-tiles';
        this.tileContainer.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            will-change: transform;
        `;

        // Coordinate overlays
        this.coordX = document.createElement('div');
        this.coordX.className = 'js-map-coord-x';
        this.coordX.style.cssText = `
            position: absolute; bottom: -20px; left: 0;
            width: 100%; height: 20px;
            background: #f4e4bc; border-top: 1px solid #7d510f;
            display: flex; font-size: 10px; font-weight: bold; color: #000;
        `;

        this.coordY = document.createElement('div');
        this.coordY.className = 'js-map-coord-y';
        this.coordY.style.cssText = `
            position: absolute; top: 0; left: -20px;
            width: 20px; height: 100%;
            background: #f4e4bc; border-right: 1px solid #7d510f;
            display: flex; flex-direction: column;
            font-size: 10px; font-weight: bold; color: #000;
        `;

        this.viewport.appendChild(this.tileContainer);
        this.viewport.appendChild(this.coordX);
        this.viewport.appendChild(this.coordY);
        this.container.appendChild(this.viewport);

        // Single delegated click listener for all village tiles
        this.tileContainer.addEventListener('click', e => this._onTileContainerClick(e));

        // Measure viewport width after insertion
        this.vpW = this.viewport.clientWidth || 800;

        // Compute initial transform to centre (currentX, currentY) in viewport
        this.offsetX = this.vpW / 2 - this.currentX * this.TW;
        this.offsetY = this.vpH / 2 - this.currentY * this.TH;
        this._applyTransform();

        this._attachEvents();

        // Load initial tiles — use a larger buffer size for pre-loading
        this._fetchTiles(this.currentX, this.currentY);
        this._renderCoordinates();

        // Initialize checkbox state
        const cb = document.getElementById('cb-map-faith');
        if (cb) {
            cb.checked = this.showFaithCircles;
        }
        
        const cbWt = document.getElementById('cb-map-watchtower');
        if (cbWt) {
            cbWt.checked = this.showWatchtowerCircles;
        }

        // Start background polling to update command icons in real-time
        this._startPolling();
    }

    _startPolling() {
        setInterval(() => {
            // Only update if page is active/visible, to save bandwidth
            if (document.hidden) return;
            
            // Re-fetch current area to update existing tiles with any new/completed movements
            this._fetchTiles(this.currentX, this.currentY);
        }, 5000); // Poll every 5 seconds
    }

    /* ============================================================ */
    /*  Events                                                       */
    /* ============================================================ */

    _attachEvents() {
        this.viewport.addEventListener('mousedown', e => this._startDrag(e.clientX, e.clientY, e));
        document.addEventListener('mousemove', e => this._moveDrag(e.clientX, e.clientY, e));
        document.addEventListener('mouseup', () => this._endDrag());
        this.viewport.addEventListener('contextmenu', e => e.preventDefault());

        this.viewport.addEventListener('touchstart', e => {
            const t = e.touches[0];
            this._dragStartX = t.clientX;
            this._dragStartY = t.clientY;
            this._dragMoved = false;
            this.dragX = t.clientX;
            this.dragY = t.clientY;
            // Don't call preventDefault yet — let the event propagate to village img touchstart
        }, { passive: true });

        document.addEventListener('touchmove', e => {
            const t = e.touches[0];
            const dx = Math.abs(t.clientX - this._dragStartX);
            const dy = Math.abs(t.clientY - this._dragStartY);
            if (!this._dragMoved && (dx > this.DRAG_THRESHOLD || dy > this.DRAG_THRESHOLD)) {
                this._dragMoved = true;
                this.isDragging = true;
                this.viewport.style.cursor = 'grabbing';
                this._hideTooltip();
                this._hideMobileTip();
            }
            if (this.isDragging) {
                this._moveDrag(t.clientX, t.clientY, e);
            }
        }, { passive: false });

        document.addEventListener('touchend', () => this._endDrag());
    }

    _startDrag(cx, cy, e) {
        this.isDragging = true;
        this.dragX = cx;
        this.dragY = cy;
        this._dragMoved = false;
        this._dragStartX = cx;
        this._dragStartY = cy;
        this._suppressClick = false;
        this.viewport.style.cursor = 'grabbing';
        if (e.target.tagName !== 'IMG') {
            e.preventDefault();
        }
    }

    _moveDrag(cx, cy, e) {
        if (!this.isDragging) return;

        this.offsetX += cx - this.dragX;
        this.offsetY += cy - this.dragY;
        this.dragX = cx;
        this.dragY = cy;

        // Track whether the pointer moved enough to be considered a drag
        if (!this._dragMoved) {
            const dxDrag = cx - this._dragStartX;
            const dyDrag = cy - this._dragStartY;
            if (Math.abs(dxDrag) > this.DRAG_THRESHOLD || Math.abs(dyDrag) > this.DRAG_THRESHOLD) {
                this._dragMoved = true;
            }
        }

        // Single rAF per frame
        if (!this._rafId) {
            this._rafId = requestAnimationFrame(() => {
                this._applyTransform();
                this._rafId = null;
            });
        }

        // Derive current world centre from transform
        const worldCX = Math.round((this.vpW / 2 - this.offsetX) / this.TW);
        const worldCY = Math.round((this.vpH / 2 - this.offsetY) / this.TH);
        const newX = Math.max(0, Math.min(999, worldCX));
        const newY = Math.max(0, Math.min(999, worldCY));

        if (newX !== this.currentX || newY !== this.currentY) {
            this.currentX = newX;
            this.currentY = newY;
            window.currentMapX = newX;
            window.currentMapY = newY;

            if (window.worldMinimap) window.worldMinimap.updateViewport(newX, newY);

            this._renderCoordinates();
            this._fetchTiles(newX, newY);
        }

        e.preventDefault();
    }

    _endDrag() {
        if (!this.isDragging) return;
        const wasDrag = this._dragMoved;
        this.isDragging = false;
        this._dragMoved = false;
        this.viewport.style.cursor = 'grab';
<<<<<<< Updated upstream
=======

        // If this was a real drag, suppress the click event that follows
        if (wasDrag) {
            this._suppressClick = true;
            setTimeout(() => { this._suppressClick = false; }, 100);
        }

        // Trigger fetch on drag release to complete the loaded map area for the final center
        this._fetchTiles(this.currentX, this.currentY);
>>>>>>> Stashed changes
    }

    _applyTransform() {
        this.tileContainer.style.transform =
            `translate(${this.offsetX}px,${this.offsetY}px)`;
    }

    /* ============================================================ */
    /*  Tile fetching                                                */
    /* ============================================================ */

    _fetchTiles(cx, cy) {
        if (this.isLoading) {
            // Only remember the latest position - no point fetching intermediates
            this._queuedPos = { cx, cy };
            return;
        }

        this.isLoading = true;
        this._queuedPos = null;

        // Fetch a slightly larger area than visible to pre-buffer edges
        const fetchSize = this.mapSize + 4;
        const url = `game.php?village=${this.villageId}&screen=map&ajax=js_tiles` +
            `&x=${cx}&y=${cy}&size=${fetchSize}`;

        fetch(url)
            .then(r => r.json())
            .then(data => {
                if (data.success) this._renderTiles(data);
            })
            .catch(() => {/* silent */ })
            .finally(() => {
                this.isLoading = false;
                if (this._queuedPos) {
                    const p = this._queuedPos;
                    this._queuedPos = null;
                    this._fetchTiles(p.cx, p.cy);
                }
            });
    }

    /* ============================================================ */
    /*  Tile rendering (cache-aware, world-coordinate positioned)    */
    /* ============================================================ */

    _renderTiles(data) {
        const activeKeys = new Set();
        const frag = document.createDocumentFragment();

        data.tiles.forEach(td => {
            const key = `${td.x}|${td.y}`;
            activeKeys.add(key);

            if (!this.tileCache.has(key)) {
                // New tile — create with world-absolute position
                const el = this._createTile(td);
                frag.appendChild(el);
                this.tileCache.set(key, el);
            } else {
                // Existing tile: update dynamic decorations in case they changed
                const el = this.tileCache.get(key);
                if (td.type === 'village' && td.village) {
                    const folder = window.mapFolder || 'map';
                    this._decorateTile(el, td, folder);
                }
            }
        });

        this.tileContainer.appendChild(frag);

        // Prune tiles that are far outside the current view
        const pr = this.PRUNE_RADIUS;
        const cx = this.currentX, cy = this.currentY;
        for (const [key, el] of this.tileCache) {
            const [kx, ky] = key.split('|').map(Number);
            if (Math.abs(kx - cx) > pr || Math.abs(ky - cy) > pr) {
                el.parentNode && el.parentNode.removeChild(el);
                this.tileCache.delete(key);
            }
        }

        // Faith circles: remove old ones, add new (respecting toggle)
        document.querySelectorAll('.js-faith-circle, .js-faith-overlay').forEach(e => e.remove());
        if (data.faith_circles && data.faith_circles.length > 0) {
            this._lastFaithCircles = data.faith_circles;
            if (this.showFaithCircles) {
                this._renderFaithCircles(data.faith_circles);
            }
        }
        
        // Watchtower circles: remove old ones, add new (respecting toggle)
        document.querySelectorAll('.js-watchtower-overlay').forEach(e => e.remove());
        if (data.watchtower_circles && data.watchtower_circles.length > 0) {
            this._lastWatchtowerCircles = data.watchtower_circles;
            if (this.showWatchtowerCircles) {
                this._renderWatchtowerCircles(data.watchtower_circles);
            }
        }
    }

    _createTile(tileData) {
        const tile = document.createElement('div');
        tile.className = 'map-tile';

        // World-absolute pixel position — NEVER changes regardless of camera
        const pixelX = tileData.x * this.TW;
        const pixelY = tileData.y * this.TH;

        let graphicPath = tileData.graphic || 'gras1';
        if (!graphicPath.endsWith('.png')) graphicPath += '.png';
        const folder = window.mapFolder || 'map';
        const isNight = folder === 'map_dark' && !graphicPath.startsWith('map/') && !graphicPath.startsWith('map_dark/');
        
        let graphicFile = graphicPath;
        if (isNight) {
            const parts = graphicFile.split('/');
            const filename = parts.pop();
            if (!filename.startsWith('n_')) {
                graphicFile = (parts.length > 0 ? parts.join('/') + '/' : '') + 'n_' + filename;
            }
        }
        
        const finalUrl = graphicPath.startsWith('map/') || graphicPath.startsWith('map_dark/') ? `graphic/${graphicFile}` : `graphic/${folder}/${graphicFile}`;

        tile.style.cssText =
            `position:absolute;left:${pixelX}px;top:${pixelY}px;` +
            `width:${this.TW + 1}px;height:${this.TH + 1}px;` +
            `background-image:url('${finalUrl}');background-size:cover;`;

        // Continent boundaries (every 100 tiles)
        if (tileData.x % 100 === 0) {
            const vLine = document.createElement('div');
            vLine.style.cssText = 'position:absolute; left:0; top:0; width:2px; height:100%; background:rgba(0,0,0,0.6); z-index:40; pointer-events:none;';
            tile.appendChild(vLine);
        }
        if (tileData.y % 100 === 0) {
            const hLine = document.createElement('div');
            hLine.style.cssText = 'position:absolute; left:0; top:0; width:100%; height:2px; background:rgba(0,0,0,0.6); z-index:40; pointer-events:none;';
            tile.appendChild(hLine);
        }

        if (tileData.type === 'village' && tileData.village) {
            this._decorateTile(tile, tileData, folder);
        } else if (tileData.type === 'ghost') {
            this._decorateGhostTile(tile, tileData, folder);
        }

        return tile;
    }

    _decorateGhostTile(tile, tileData, folder) {
        // Remove any previous ghost decorations
        tile.querySelectorAll('.js-ghost-graphic').forEach(el => el.remove());

        const isNight = folder === 'map_dark';
        const graphicFile = isNight ? 'n_ghost.png' : 'ghost.png';

        const img = document.createElement('img');
        img.className = 'js-ghost-graphic';
        img.setAttribute('draggable', 'false');
        img.src = `graphic/${folder}/${graphicFile}`;
        img.alt = tileData.title || 'Ghost';
        img.title = `${tileData.title || 'Convidar amigo'} (${tileData.x}|${tileData.y})`;
        img.style.cssText =
            'position:absolute;width:100%;height:100%;pointer-events:auto;cursor:pointer;z-index:10;';

        img.onclick = e => {
            e.preventDefault();
            e.stopPropagation();
            this._showGhostPopup(tileData, e);
            return false;
        };

        img.addEventListener('touchend', e => {
            if (this._dragMoved) return;
            e.preventDefault();
            e.stopPropagation();
            this._showGhostPopup(tileData, e);
        }, { passive: false });

        tile.appendChild(img);
    }

    _showGhostPopup(tileData, e) {
        // Remove any existing ghost popup
        const existing = document.getElementById('js-ghost-popup');
        if (existing) existing.remove();

        const popup = document.createElement('div');
        popup.id = 'js-ghost-popup';
        popup.style.cssText = `
            position: fixed;
            z-index: 99999;
            background: linear-gradient(180deg, #f4e4bc 0%, #e8d09e 100%);
            border: 2px solid #8C5F0D;
            border-radius: 6px;
            box-shadow: 0 6px 24px rgba(0,0,0,0.55), 0 2px 8px rgba(0,0,0,0.3);
            padding: 14px 18px 14px 14px;
            min-width: 200px;
            max-width: 280px;
            font-family: Verdana, Arial, sans-serif;
            font-size: 12px;
            color: #3a1f00;
            animation: ghostPopupIn 0.15s ease;
        `;

        // Add animation keyframes once
        if (!document.getElementById('js-ghost-popup-style')) {
            const s = document.createElement('style');
            s.id = 'js-ghost-popup-style';
            s.textContent = `
                @keyframes ghostPopupIn {
                    from { opacity: 0; transform: translateY(-8px) scale(0.97); }
                    to   { opacity: 1; transform: translateY(0) scale(1); }
                }
                #js-ghost-popup .ghost-popup-title {
                    font-weight: bold;
                    font-size: 13px;
                    color: #5d2f09;
                    margin-bottom: 6px;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                }
                #js-ghost-popup .ghost-popup-coord {
                    color: #8a6520;
                    font-size: 11px;
                    margin-bottom: 8px;
                }
                #js-ghost-popup .ghost-popup-desc {
                    font-size: 11px;
                    color: #5a3a18;
                    margin-bottom: 12px;
                    line-height: 1.5;
                }
                #js-ghost-popup .ghost-popup-btn {
                    display: block;
                    text-align: center;
                    background: linear-gradient(to bottom, #f5d399 0%, #d4af37 100%);
                    border: 1px solid #8a6d1c;
                    border-radius: 4px;
                    color: #4a2711;
                    text-decoration: none;
                    font-weight: bold;
                    padding: 7px 16px;
                    font-size: 12px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                    cursor: pointer;
                    transition: background 0.15s;
                }
                #js-ghost-popup .ghost-popup-btn:hover {
                    background: linear-gradient(to bottom, #ffe0a8 0%, #e8c34a 100%);
                }
                #js-ghost-popup .ghost-popup-close {
                    position: absolute;
                    top: 6px;
                    right: 8px;
                    background: none;
                    border: none;
                    font-size: 14px;
                    cursor: pointer;
                    color: #8a6520;
                    line-height: 1;
                    padding: 2px 4px;
                }
                #js-ghost-popup .ghost-popup-close:hover { color: #3a1f00; }
            `;
            document.head.appendChild(s);
        }

        const ghostImg = (window.mapFolder === 'map_dark') ? 'n_ghost.png' : 'ghost.png';
        popup.innerHTML = `
            <button class="ghost-popup-close" id="js-ghost-popup-close">✕</button>
            <div class="ghost-popup-title">
                <img src="graphic/${window.mapFolder || 'map'}/${ghostImg}" style="width:20px;height:20px;vertical-align:middle;">
                ${this._escHtml(tileData.title || 'Convidar amigo')}
            </div>
            <div class="ghost-popup-coord">(${tileData.x}|${tileData.y})</div>
            <div class="ghost-popup-desc">${this._escHtml(tileData.description || '')}</div>
            <a href="${this._escHtml(tileData.invite_url || '#')}" class="ghost-popup-btn">
                ${this._escHtml(tileData.invite_text || 'Convidar')}
            </a>
        `;

        // Position near click/touch, keeping within viewport
        const vw = window.innerWidth;
        const vh = window.innerHeight;
        let cx = (e.clientX || e.changedTouches?.[0]?.clientX || vw / 2) + 12;
        let cy = (e.clientY || e.changedTouches?.[0]?.clientY || vh / 2) + 12;
        popup.style.left = '0px';
        popup.style.top  = '0px';
        document.body.appendChild(popup);

        const pw = popup.offsetWidth  || 240;
        const ph = popup.offsetHeight || 160;
        if (cx + pw > vw - 10) cx = (e.clientX || vw / 2) - pw - 12;
        if (cy + ph > vh - 10) cy = (e.clientY || vh / 2) - ph - 12;
        popup.style.left = cx + 'px';
        popup.style.top  = cy + 'px';

        // Close button
        document.getElementById('js-ghost-popup-close').onclick = () => popup.remove();

        // Click outside closes it
        const triggerEl = e.target;
        const onOutside = ev => {
            if (!popup.contains(ev.target) && ev.target !== triggerEl) {
                popup.remove();
                document.removeEventListener('click', onOutside, true);
            }
        };
        setTimeout(() => document.addEventListener('click', onOutside, true), 0);
    }

    _escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    _decorateTile(tile, tileData, folder) {
        // Clear previous decorations if any
        tile.querySelectorAll('.js-village-graphic, .js-village-color, .js-village-command, .js-village-home').forEach(el => el.remove());

        const v = tileData.village;
        
        // Store data for context menu
        tile.dataset.villageId = v.id;
        tile.dataset.vname = v.name || v.village_name || '';
        tile.dataset.vowner = v.player_name || v.owner || '';
        tile.dataset.vx = tileData.x;
        tile.dataset.vy = tileData.y;

        const isNight = folder === 'map_dark';
        let graphicFile = v.graphic;
        
        if (isNight) {
            const parts = graphicFile.split('/');
            const filename = parts.pop();
            if (!filename.startsWith('n_')) {
                graphicFile = (parts.length > 0 ? parts.join('/') + '/' : '') + 'n_' + filename;
            }
        }

        const img = document.createElement('img');
        img.className = 'js-village-graphic';
        img.setAttribute('draggable', 'false');
        img.src = `graphic/${folder}/${graphicFile}`;
        img.style.cssText =
            'position:absolute;width:100%;height:100%;pointer-events:auto;cursor:pointer;';

        // Touch: show mobile info panel on tap (not drag)
        img.addEventListener('touchstart', (e) => {
            this._touchVillage = { v, x: tileData.x, y: tileData.y };
        }, { passive: true });

        img.addEventListener('touchend', (e) => {
            if (this._dragMoved) return; // was a drag, not a tap
            const tv = this._touchVillage;
            if (!tv) return;
            e.preventDefault();
            e.stopPropagation();
            this._showMobileTip(tv.v, tv.x, tv.y);
        }, { passive: false });

        img.onmouseover = (e) => {
            this._showTooltip(e, v, tileData.x, tileData.y);
        };
        img.onmousemove = (e) => { this._moveTooltip(e); };
        img.onmouseout = () => { this._hideTooltip(); };

        tile.appendChild(img);

        if (v.color) {
            const dot = document.createElement('div');
            dot.className = 'js-village-color';
            dot.style.cssText =
                `position:absolute;bottom:30px;left:0;width:6px;height:6px;` +
                `border-radius:50%;${v.color};border:1px solid rgba(0,0,0,.3);` +
                `z-index:15;pointer-events:none;`;
            tile.appendChild(dot);
        }

        if (v.commands && v.commands.length > 0) {
            const seenTypes = new Set();
            let idx = 0;
            v.commands.forEach((cmd) => {
                if (seenTypes.has(cmd.type)) return;
                seenTypes.add(cmd.type);

                const icon = this._cmdIcon(cmd);
                if (!icon) return;
                const ci = document.createElement('img');
                ci.className = 'js-village-command';
                ci.src = icon;
                ci.style.cssText =
                    `position:absolute;top:${2 + idx * 14}px;left:2px;` +
                    `width:12px;height:12px;z-index:16;pointer-events:none;`;
                tile.appendChild(ci);
                idx++;
            });
        }

        // Show home.png around the selected village
        if (this.villageId && v.id == this.villageId) {
            const home = document.createElement('img');
            home.className = 'js-village-home';
            home.src = `graphic/${folder}/home.png`;
            home.style.cssText =
                'position:absolute;top:-52%;left:-11%;width:120%;height:200%;z-index:15;pointer-events:none;';
            tile.appendChild(home);
        }
    }

<<<<<<< Updated upstream
=======
    _undecorateTile(tile) {
        tile.querySelectorAll('.js-village-graphic, .js-village-color, .js-village-command, .js-village-home, .js-ghost-graphic').forEach(el => el.remove());
        delete tile.dataset.villageId;
        delete tile.dataset.vname;
        delete tile.dataset.vowner;
        delete tile.dataset.vx;
        delete tile.dataset.vy;
    }

    _onTileContainerClick(e) {
        if (this._suppressClick) return;
        // Mobile devices use the dedicated bottom panel, not the desktop context menu
        if (window.matchMedia && window.matchMedia('(pointer: coarse)').matches) return;

        const tile = e.target.closest('.map-tile');
        if (!tile || !tile.dataset.villageId) return;

        e.preventDefault();
        e.stopPropagation();

        if (typeof showMapMenu === 'function') {
            showMapMenu(tile, parseInt(tile.dataset.villageId));
        } else if (typeof currentVillageId !== 'undefined') {
            window.location.href = `game.php?village=${currentVillageId}&screen=info_village&id=${tile.dataset.villageId}`;
        }
    }

>>>>>>> Stashed changes
    /* ============================================================ */
    /*  Faith circle toggle                                          */
    /* ============================================================ */

    toggleFaithCircles(forceState) {
        if (typeof forceState !== 'undefined') {
            this.showFaithCircles = forceState;
        } else {
            this.showFaithCircles = !this.showFaithCircles;
        }
        localStorage.setItem('map_show_faith', this.showFaithCircles ? '1' : '0');

        document.querySelectorAll('.js-faith-overlay').forEach(e => e.remove());

        // Re-render if now ON and we have cached data
        if (this.showFaithCircles && this._lastFaithCircles && this._lastFaithCircles.length > 0) {
            this._renderFaithCircles(this._lastFaithCircles);
        }

        // Update checkbox if it exists
        const cb = document.getElementById('cb-map-faith');
        if (cb && cb.checked !== this.showFaithCircles) {
            cb.checked = this.showFaithCircles;
        }

        // Sync with minimap
        if (window.worldMinimap) {
            window.worldMinimap.render();
        }
    }
    
    toggleWatchtowerCircles(forceState) {
        if (typeof forceState !== 'undefined') {
            this.showWatchtowerCircles = forceState;
        } else {
            this.showWatchtowerCircles = !this.showWatchtowerCircles;
        }
        localStorage.setItem('map_show_watchtower', this.showWatchtowerCircles ? '1' : '0');

        document.querySelectorAll('.js-watchtower-overlay').forEach(e => e.remove());

        // Re-render if now ON and we have cached data
        if (this.showWatchtowerCircles && this._lastWatchtowerCircles && this._lastWatchtowerCircles.length > 0) {
            this._renderWatchtowerCircles(this._lastWatchtowerCircles);
        }

        // Update checkbox if it exists
        const cb = document.getElementById('cb-map-watchtower');
        if (cb && cb.checked !== this.showWatchtowerCircles) {
            cb.checked = this.showWatchtowerCircles;
        }

        // Sync with minimap
        if (window.worldMinimap) {
            window.worldMinimap.render();
        }
    }

    /* ============================================================ */
    /*  Self-contained AJAX tooltip — matches official TW style     */
    /* ============================================================ */

    _ensureTooltip() {
        if (this._tooltip) return this._tooltip;

        // Inject CSS once
        if (!document.getElementById('js-map-tip-style')) {
            const s = document.createElement('style');
            s.id = 'js-map-tip-style';
            s.textContent = `
#js-map-tooltip {
    position: fixed;
    z-index: 9999;
    pointer-events: none;
    display: none;
    min-width: 240px;
    max-width: 340px;
    font: 13px/1.6 'Outfit', Verdana, Arial, sans-serif;
    border: 1px solid rgba(212,175,55,0.4);
    border-radius: 6px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.7), 0 0 0 1px rgba(212,175,55,0.1);
    background: rgba(43, 29, 18, 0.97);
    overflow: hidden;
    color: #ebdcae;
}
#js-map-tooltip .tip-header {
    background: linear-gradient(135deg, #4e3629 0%, #2b1d12 100%);
    padding: 8px 12px;
    font-weight: bold;
    font-size: 13px;
    color: #f3e5ab;
    letter-spacing: 0.4px;
    border-bottom: 1px solid rgba(212,175,55,0.3);
    text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
    font-family: 'Cinzel', serif;
}
#js-map-tooltip table {
    width: 100%;
    border-collapse: collapse;
    background: transparent;
}
#js-map-tooltip td {
    padding: 5px 12px;
    vertical-align: middle;
    color: #ebdcae;
    font-size: 12px;
    border-bottom: 1px solid rgba(212,175,55,0.08);
}
#js-map-tooltip tr:last-child td { border-bottom: none; }
#js-map-tooltip td.tip-lbl {
    color: #d4af37;
    white-space: nowrap;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    width: 36%;
}
#js-map-tooltip .tip-units {
    background: rgba(212,175,55,0.06);
    border-top: 1px solid rgba(212,175,55,0.2);
    padding: 6px 12px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
#js-map-tooltip .tip-unit {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    font-size: 11px;
    color: #ebdcae;
}
#js-map-tooltip .tip-unit img { width:22px; height:22px; opacity:0.9; }
            `;
            document.head.appendChild(s);
        }

        const el = document.createElement('div');
        el.id = 'js-map-tooltip';
        document.body.appendChild(el);
        this._tooltip = el;
        this._tipCache = {}; // village_id → data
        this._tipTimer = null;
        return el;
    }

    _showTooltip(e, v, wx, wy) {
        const el = this._ensureTooltip();

        // Render instantly with what we already know
        this._renderTooltipBasic(el, v, wx, wy);
        el.style.display = 'block';
        this._moveTooltip(e);

        // Fetch extended data (cached)
        if (v.id) {
            const cacheKey = v.id;
            if (this._tipCache[cacheKey]) {
                this._renderTooltipFull(el, this._tipCache[cacheKey]);
            } else {
                clearTimeout(this._tipTimer);
                this._tipTimer = setTimeout(() => {
                    const url = `game.php?village=${currentVillageId}` +
                        `&screen=map&ajax=village_popup&village_id=${v.id}` +
                        `&from_x=${this.village_x || wx}&from_y=${this.village_y || wy}`;
                    fetch(url)
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this._tipCache[cacheKey] = data;
                                // Only update if tooltip still visible for same village
                                if (el.dataset.vid == v.id) {
                                    this._renderTooltipFull(el, data);
                                }
                            }
                        })
                        .catch(() => { });
                }, 150); // short delay to avoid fetching on fast passes
            }
            el.dataset.vid = v.id;
        }
    }

    _renderTooltipBasic(el, v, wx, wy) {
        const continent = v.continent || '';
        const pts = v.points ? v.points.toLocaleString() : '0';
        const player = v.player_name || '—';
        const tribe = v.ally_tag ? `[${v.ally_tag}]` : '—';
        el.innerHTML = `
<div class="tip-header">${v.name} (${wx}|${wy}) ${continent}</div>
<table>
  <tr><td class="tip-lbl">Pontos:</td><td>${pts}</td></tr>
  <tr><td class="tip-lbl">Proprietário:</td><td>${player}</td></tr>
  <tr><td class="tip-lbl">Tribo:</td><td>${tribe}</td></tr>
  <tr id="tip-moral-row"><td class="tip-lbl">Moral:</td><td id="tip-moral">...</td></tr>
  <tr id="tip-bonus-row" style="display: none;"><td class="tip-lbl">Bónus:</td><td id="tip-bonus"></td></tr>
</table>
<div class="tip-units" id="tip-units"></div>`;
    }

    _renderTooltipFull(el, d) {
        // Update owner line
        const ownerEl = el.querySelector('table tr:nth-child(2) td:last-child');
        if (ownerEl && d.player_name) {
            const ppts = d.player_points ? d.player_points.toLocaleString('pt-PT') : '0';
            const pvil = d.player_villages || 0;
            ownerEl.textContent = `${d.player_name} (${ppts} Pontos | ${pvil} Aldeias)`;
        }

        // Update tribe line
        const tribeEl = el.querySelector('table tr:nth-child(3) td:last-child');
        if (tribeEl && d.tribe_name) {
            const tpts = d.tribe_points ? d.tribe_points.toLocaleString('pt-PT') : '0';
            tribeEl.textContent = `${d.tribe_name} (${tpts} pontos)`;
        } else if (tribeEl && !d.tribe_name) {
            tribeEl.textContent = '—';
        }

        // Moral
        const moralEl = el.querySelector('#tip-moral');
        if (moralEl) moralEl.textContent = (d.moral ?? 100) + '%';

        // Bonus
        const bonusRow = el.querySelector('#tip-bonus-row');
        const bonusVal = el.querySelector('#tip-bonus');
        if (bonusRow && bonusVal) {
            if (d.bonus_text && d.bonus_icon) {
                bonusVal.innerHTML = `<img src="graphic/bonus/${d.bonus_icon}" style="vertical-align: middle; margin-right: 6px; width: 16px; height: 16px;" /> ${d.bonus_text}`;
                bonusRow.style.display = '';
            } else {
                bonusRow.style.display = 'none';
            }
        }

        // Unit times
        const unitsEl = el.querySelector('#tip-units');
        if (unitsEl && d.unit_times && d.unit_times.length) {
            unitsEl.innerHTML = d.unit_times.map(u =>
                `<div class="tip-unit">
                    <img src="graphic/unit/unit_${u.key}.png" alt="${u.key}"
                         onerror="this.style.display='none'">
                    <span>${u.time}</span>
                </div>`
            ).join('');
        } else if (unitsEl) {
            unitsEl.style.display = 'none';
        }
    }

    _moveTooltip(e) {
        const el = this._tooltip;
        if (!el || el.style.display === 'none') return;
        let x = e.clientX + 18;
        let y = e.clientY + 15;
        // Keep inside viewport
        const tw = el.offsetWidth || 250;
        const th = el.offsetHeight || 120;
        if (x + tw > window.innerWidth - 10) x = e.clientX - tw - 10;
        if (y + th > window.innerHeight - 10) y = e.clientY - th - 10;
        el.style.left = x + 'px';
        el.style.top = y + 'px';
    }

    _hideTooltip() {
        if (this._tipTimer) { clearTimeout(this._tipTimer); this._tipTimer = null; }
        if (this._tooltip) {
            this._tooltip.style.display = 'none';
            delete this._tooltip.dataset.vid;
        }
    }

    /* ============================================================ */
    /*  Mobile tap info panel                                        */
    /* ============================================================ */

    _ensureMobileTip() {
        if (this._mobileTip) return this._mobileTip;

        if (!document.getElementById('js-map-mobile-style')) {
            const s = document.createElement('style');
            s.id = 'js-map-mobile-style';
            s.textContent = `
#js-map-mobile-tip {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 99999;
    background: #2c1505;
    border-top: 2px solid #c1922a;
    box-shadow: 0 -6px 24px rgba(0,0,0,0.65);
    padding: 0;
    font: 14px/1.6 Verdana, Arial, sans-serif;
    transform: translateY(100%);
    transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
    max-height: 60vh;
    overflow-y: auto;
    color: #f4e4bc;
}
#js-map-mobile-tip.visible { transform: translateY(0); }
#js-map-mobile-tip .mtp-header {
    background: linear-gradient(135deg, #5a2d08 0%, #3a1a02 100%);
    color: #f4e4bc;
    font-weight: bold;
    font-size: 15px;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #c1922a;
    position: sticky;
    top: 0;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
    letter-spacing: 0.3px;
}
#js-map-mobile-tip .mtp-close {
    background: rgba(0,0,0,0.3);
    border: 1px solid rgba(193,146,42,0.4);
    border-radius: 50%;
    width: 30px;
    height: 30px;
    font-size: 18px;
    cursor: pointer;
    line-height: 28px;
    text-align: center;
    color: #f4e4bc;
}
#js-map-mobile-tip .mtp-body {
    padding: 4px 0;
    background: #3a1c06;
}
#js-map-mobile-tip table {
    width: 100%;
    border-collapse: collapse;
}
#js-map-mobile-tip td {
    padding: 10px 16px;
    border-bottom: 1px solid rgba(193,146,42,0.15);
    font-size: 13px;
    color: #f4e4bc;
    vertical-align: middle;
}
#js-map-mobile-tip tr:last-child td { border-bottom: none; }
#js-map-mobile-tip td:first-child {
    color: #d4a844;
    font-weight: bold;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.7px;
    white-space: nowrap;
    width: 38%;
}
#js-map-mobile-tip .mtp-actions {
    display: flex;
    gap: 10px;
    padding: 12px 16px;
    border-top: 1px solid rgba(193,146,42,0.3);
    flex-wrap: wrap;
    background: #2c1505;
}
#js-map-mobile-tip .mtp-btn {
    flex: 1;
    min-width: 130px;
    padding: 12px 14px;
    border: 1px solid #7d510f;
    border-radius: 4px;
    background: linear-gradient(to bottom, #7a4915 0%, #4a2808 100%);
    color: #f4e4bc;
    font-weight: bold;
    font-size: 13px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: block;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
    transition: background 0.2s, border-color 0.2s;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.1), 0 2px 4px rgba(0,0,0,0.4);
}
#js-map-mobile-tip .mtp-btn:active {
    background: linear-gradient(to bottom, #5a3510 0%, #3a1e06 100%);
    border-color: #c1922a;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.4);
}
            `;
            document.head.appendChild(s);
        }

        const el = document.createElement('div');
        el.id = 'js-map-mobile-tip';
        el.innerHTML = `
            <div class="mtp-header">
                <span id="mtp-title">Aldeia</span>
                <button class="mtp-close" id="mtp-close">✕</button>
            </div>
            <div class="mtp-body">
                <table id="mtp-table"></table>
            </div>
            <div class="mtp-actions" id="mtp-actions"></div>
        `;
        document.body.appendChild(el);

        // Close on button or backdrop tap
        el.querySelector('#mtp-close').addEventListener('click', () => this._hideMobileTip());
        document.addEventListener('touchstart', (e) => {
            if (this._mobileTip && this._mobileTip.classList.contains('visible')) {
                if (!this._mobileTip.contains(e.target)) this._hideMobileTip();
            }
        }, { passive: true });

        this._mobileTip = el;
        return el;
    }

    _showMobileTip(v, wx, wy) {
        const el = this._ensureMobileTip();
        const continent = v.continent || '';
        const pts = v.points ? v.points.toLocaleString() : '0';
        const player = v.player_name || '(sem dono)';
        const tribe = v.ally_tag ? `[${v.ally_tag}]` : '—';

        el.querySelector('#mtp-title').textContent = `${v.name} (${wx}|${wy}) ${continent}`;
        el.querySelector('#mtp-table').innerHTML = `
            <tr><td>Pontos</td><td>${pts}</td></tr>
            <tr><td>Proprietário</td><td>${player}</td></tr>
            <tr><td>Tribo</td><td>${tribe}</td></tr>
            <tr><td>Moral</td><td id="mtp-moral">…</td></tr>
            <tr id="mtp-bonus-row" style="display: none;"><td>Bónus</td><td id="mtp-bonus"></td></tr>
        `;

        const actions = el.querySelector('#mtp-actions');
        actions.innerHTML = `
            <a class="mtp-btn" href="game.php?village=${currentVillageId}&screen=info_village&id=${v.id}">ℹ️ Informação</a>
            <a class="mtp-btn" href="game.php?village=${currentVillageId}&screen=place&target=${v.id}">⚔️ Atacar</a>
        `;

        el.classList.add('visible');

        // Fetch extended info
        if (v.id) {
            const cacheKey = v.id;
            const updateFull = (data) => {
                if (data.player_name) {
                    const ppts = data.player_points ? data.player_points.toLocaleString('pt-PT') : '0';
                    const pvil = data.player_villages || 0;
                    const ownerCell = el.querySelector('#mtp-table tr:nth-child(2) td:last-child');
                    if (ownerCell) ownerCell.textContent = `${data.player_name} (${ppts} pts | ${pvil} ald.)`;
                }
                if (data.tribe_name) {
                    const tpts = data.tribe_points ? data.tribe_points.toLocaleString('pt-PT') : '0';
                    const tribeCell = el.querySelector('#mtp-table tr:nth-child(3) td:last-child');
                    if (tribeCell) tribeCell.textContent = `${data.tribe_name} (${tpts} pts)`;
                }
                const moralEl = el.querySelector('#mtp-moral');
                if (moralEl) moralEl.textContent = (data.moral ?? 100) + '%';

                // Bonus
                const bonusRow = el.querySelector('#mtp-bonus-row');
                const bonusVal = el.querySelector('#mtp-bonus');
                if (bonusRow && bonusVal) {
                    if (data.bonus_text && data.bonus_icon) {
                        bonusVal.innerHTML = `<img src="graphic/bonus/${data.bonus_icon}" style="vertical-align: middle; margin-right: 6px; width: 16px; height: 16px;" /> ${data.bonus_text}`;
                        bonusRow.style.display = '';
                    } else {
                        bonusRow.style.display = 'none';
                    }
                }
            };

            if (this._tipCache && this._tipCache[cacheKey]) {
                updateFull(this._tipCache[cacheKey]);
            } else {
                const url = `game.php?village=${currentVillageId}&screen=map&ajax=village_popup&village_id=${v.id}&from_x=${this.village_x || wx}&from_y=${this.village_y || wy}`;
                fetch(url).then(r => r.json()).then(data => {
                    if (data.success) {
                        if (!this._tipCache) this._tipCache = {};
                        this._tipCache[cacheKey] = data;
                        updateFull(data);
                    }
                }).catch(() => {});
            }
        }
    }

    _hideMobileTip() {
        if (this._mobileTip) this._mobileTip.classList.remove('visible');
    }

    _renderFaithCircles(circles) {
        document.querySelectorAll('.js-faith-overlay').forEach(e => e.remove());
        if (!this.showFaithCircles || !circles || circles.length === 0) return;

        const isFaith = (nx, ny) => {
            for (const c of circles) {
                if (Math.sqrt(Math.pow(nx - c.x, 2) + Math.pow(ny - c.y, 2)) <= c.radius) return true;
            }
            return false;
        };

        const faithTiles = [];

        // Identify which cached tiles are in faith radius
        for (const [key, tile] of this.tileCache.entries()) {
            const [tx, ty] = key.split('|').map(Number);
            if (isFaith(tx, ty)) {
                faithTiles.push({ tx, ty, tile });
            }
        }

        // Apply dark blue overlay and crisp borders
        for (const ft of faithTiles) {
            let borderStyle = 'border: 2px solid transparent; box-sizing: border-box;';
            let borders = [];

            // Faded neon bright blue
            const blColor = 'rgba(0, 150, 255, 0.8)';

            if (!isFaith(ft.tx, ft.ty - 1)) borders.push(`border-top-color: ${blColor}`);
            if (!isFaith(ft.tx + 1, ft.ty)) borders.push(`border-right-color: ${blColor}`);
            if (!isFaith(ft.tx, ft.ty + 1)) borders.push(`border-bottom-color: ${blColor}`);
            if (!isFaith(ft.tx - 1, ft.ty)) borders.push(`border-left-color: ${blColor}`);

            // If it has boundaries, draw them with neon filter
            // No borders = completely inside, no need to draw anything since background is transparent!
            if (borders.length > 0) {
                const overlay = document.createElement('div');
                overlay.className = 'js-faith-overlay';
                overlay.style.cssText = `position:absolute; left:0; top:0; width:100%; height:100%; ` +
                    `background:transparent; ` +
                    borderStyle + ` ${borders.join(';')}; ` +
                    `filter: drop-shadow(0px 0px 4px rgba(0,50,255,0.8)) drop-shadow(0px 0px 8px rgba(0,100,255,0.5)); ` +
                    `pointer-events:none; z-index:5;`;

                ft.tile.appendChild(overlay);
            }
        }
    }
    
    _renderWatchtowerCircles(circles) {
        document.querySelectorAll('.js-watchtower-overlay').forEach(e => e.remove());
        if (!this.showWatchtowerCircles || !circles || circles.length === 0) return;

        // Draw true geometric circles (ellipses in pixel space since TW=53, TH=38)
        for (const c of circles) {
            const rx = c.radius * this.TW;
            const ry = c.radius * this.TH;
            const px = c.x * this.TW + this.TW / 2 - rx;
            const py = c.y * this.TH + this.TH / 2 - ry;

            const circle = document.createElement('div');
            circle.className = 'js-watchtower-overlay';
            circle.style.cssText = `
                position: absolute;
                left: ${px}px;
                top: ${py}px;
                width: ${rx * 2}px;
                height: ${ry * 2}px;
                border-radius: 50%;
                border: 2px solid rgba(150, 255, 0, 0.8);
                background-color: rgba(150, 255, 0, 0.12);
                box-shadow: 0 0 10px rgba(150, 255, 0, 0.6), inset 0 0 10px rgba(150, 255, 0, 0.4);
                pointer-events: none;
                z-index: 25; /* Above villages */
            `;
            this.tileContainer.appendChild(circle);
        }
    }

    _renderCoordinates() {
        this.coordX.innerHTML = '';
        this.coordY.innerHTML = '';
        const half = Math.floor(this.mapSize / 2);
        for (let i = 0; i < this.mapSize; i++) {
            const lx = document.createElement('div');
            lx.style.cssText = `width:${this.TW}px;text-align:center;line-height:20px;`;
            lx.textContent = this.currentX - half + i;
            this.coordX.appendChild(lx);

            const ly = document.createElement('div');
            ly.style.cssText =
                `height:${this.TH}px;text-align:center;line-height:${this.TH}px;`;
            ly.textContent = this.currentY - half + i;
            this.coordY.appendChild(ly);
        }
    }

    _cmdIcon(cmd) {
        switch (cmd.type) {
            case 'attack': return 'graphic/command/attack.webp';
            case 'support': return 'graphic/command/support.webp';
            case 'return': return 'graphic/command/return.webp';
            case 'back': return 'graphic/command/back.webp';
            case 'cancel': return 'graphic/command/cancel.webp';
            default: return null;
        }
    }
}

/* ============================================================ */
/*  Auto-init                                                    */
/* ============================================================ */
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('js-map-container');
    if (container && typeof currentVillageId !== 'undefined') {
        window.jsMapSystem = new JSMapSystem('js-map-container', {
            currentX: window.currentMapX || 500,
            currentY: window.currentMapY || 500,
            mapSize: window.currentMapSize || 11,
            villageId: currentVillageId,
        });
    }
});
/**
 * TW Leaflet Map - Draggable map with 100% visual fidelity
 * Renders tiles exactly as static map using mapData
 */

const TWLeafletMap = {
    map: null,
    markers: {},
    TILE_SCALE: 50,  // Scale factor to make tiles visible
    tileLayer: null,
    currentX: 500,
    currentY: 500,

    /**
     * Initialize Leaflet map with visual fidelity
     */
    init: function (x, y) {
        // Use global variables if not provided
        if (typeof x === 'undefined' && typeof window.currentMapX !== 'undefined') {
            x = window.currentMapX;
        }
        if (typeof y === 'undefined' && typeof window.currentMapY !== 'undefined') {
            y = window.currentMapY;
        }

        this.currentX = x || 500;
        this.currentY = y || 500;

        console.log('Initializing Leaflet map at', this.currentX, this.currentY);

        // Create map with simple coordinate system
        this.map = L.map('map-leaflet', {
            crs: L.CRS.Simple,
            minZoom: -3,
            maxZoom: 3,
            zoomControl: true,
            attributionControl: false,
            dragging: true,
            scrollWheelZoom: true
        });

        // Set bounds (0-1000 for TW map)
        // Define bounds based on actual coordinate range
        const xCoords = window.mapData?.x_coords || [];
        const yCoords = window.mapData?.y_coords || [];
        const minX = xCoords.length > 0 ? Math.min(...xCoords) : 0;
        const maxX = xCoords.length > 0 ? Math.max(...xCoords) : 1000;
        const minY = yCoords.length > 0 ? Math.min(...yCoords) : 0;
        const maxY = yCoords.length > 0 ? Math.max(...yCoords) : 1000;

        // Scale coordinates to make tiles visible
        const bounds = [[minY * this.TILE_SCALE, minX * this.TILE_SCALE],
        [(maxY + 1) * this.TILE_SCALE, (maxX + 1) * this.TILE_SCALE]];
        this.map.fitBounds(bounds);

        // Center on current player position
        const centerY = (window.currentMapY || ((minY + maxY) / 2)) * this.TILE_SCALE;
        const centerX = (window.currentMapX || ((minX + maxX) / 2)) * this.TILE_SCALE;
        this.map.setView([centerY, centerX], 0);

        // Render tiles using mapData
        this.renderTiles();

        // Change cursor during drag
        this.map.on('mousedown', () => {
            document.getElementById('map-leaflet').style.cursor = 'grabbing';
        });

        this.map.on('mouseup', () => {
            document.getElementById('map-leaflet').style.cursor = 'grab';
        });

        // Set initial cursor
        document.getElementById('map-leaflet').style.cursor = 'grab';

        // Load more tiles when map is moved
        this.map.on('moveend', () => {
            this.loadVisibleTiles();
        });

        // Render Continent Grid and Labels
        this.renderContinents();

        console.log('Leaflet map initialized successfully');
    },

    /**
     * Render all tiles from mapData
     */
    renderTiles: function () {
        if (typeof window.mapData === 'undefined') {
            console.warn('mapData not available, using default grass');
            this.renderDefaultGrass();
            return;
        }

        const mapData = window.mapData;
        const tileSize = 53;
        const tileHeight = 38;

        // Create pane for tiles
        this.map.createPane('tiles');
        this.map.getPane('tiles').style.zIndex = 200;

        // Create pane for villages
        this.map.createPane('villages');
        this.map.getPane('villages').style.zIndex = 300;

        // Create pane for faith circles
        this.map.createPane('faith');
        this.map.getPane('faith').style.zIndex = 250;

        // Create pane for village ownership indicators (above villages)
        this.map.createPane('ownership');
        this.map.getPane('ownership').style.zIndex = 350;

        // Render each tile
        let villageCount = 0;
        let terrainCount = 0;
        let minX = Infinity, maxX = -Infinity, minY = Infinity, maxY = -Infinity;

        for (let coords in mapData.tiles) {
            const [x, y] = coords.split('|').map(Number);
            const tile = mapData.tiles[coords];

            minX = Math.min(minX, x);
            maxX = Math.max(maxX, x);
            minY = Math.min(minY, y);
            maxY = Math.max(maxY, y);

            if (tile.type === 'village') villageCount++;
            else terrainCount++;

            this.renderTile(x, y, tile);
        }

        console.log('Rendered', villageCount, 'villages and', terrainCount, 'terrain tiles');
        console.log('Coordinate range: X', minX, '-', maxX, ', Y', minY, '-', maxY);

        // Render faith circles
        if (mapData.faith_circles && mapData.faith_circles.length > 0) {
            this.renderFaithCircles(mapData.faith_circles);
        }

        console.log('Rendered', Object.keys(mapData.tiles).length, 'tiles');
    },

    /**
     * Render a single tile
     */
    renderTile: function (x, y, tile) {
        const tileSize = 53;
        const tileHeight = 38;

        // Calculate position - scale coordinates to make tiles visible
        const scale = this.TILE_SCALE;
        const bounds = [
            [y * scale, x * scale],
            [(y + 1) * scale, (x + 1) * scale]
        ];

        if (tile.type === 'village') {
            // Render village with ownership indicator integrated into icon
            let villageIcon;
            
            const folder = window.mapFolder || 'map';
            const isNight = folder === 'map_dark';
            let graphicFile = tile.graphic;
            
            if (isNight) {
                if (graphicFile.includes('/')) {
                    const parts = graphicFile.split('/');
                    const filename = parts.pop();
                    graphicFile = parts.join('/') + '/n_' + filename;
                } else {
                    graphicFile = 'n_' + graphicFile;
                }
            }
            
            const graphicPath = `graphic/${folder}/${graphicFile}`;
            const isHome = (typeof currentVillageId !== 'undefined' && tile.id == currentVillageId);
            
            let bgColor = null;
            if (tile.color) {
                const colorMatch = tile.color.match(/background-color:\s*([^;]+)/);
                if (colorMatch) {
                    bgColor = colorMatch[1].trim();
                }
            }
            
            if (isHome || bgColor) {
                const borderHtml = bgColor ? `<div style="position: absolute; top: -1px; left: 0px; width: 4px; height: 4px; background: ${bgColor}; border: 1px solid ${bgColor}; border-radius: 50%;"></div>` : '';
                const homeHtml = isHome ? `<img src="graphic/${folder}/home.png" style="position: absolute; top: -50%; left: -25%; width: 150%; height: 200%; z-index: 5; pointer-events: none;" />` : '';
                
                const iconHtml = `
                    <div style="position: relative; width: ${scale}px; height: ${scale * 0.72}px;">
                        <img src="${graphicPath}" style="width: 100%; height: 100%;" />
                        ${borderHtml}
                        ${homeHtml}
                    </div>
                `;
                
                villageIcon = L.divIcon({
                    html: iconHtml,
                    iconSize: [scale, scale * 0.72],
                    iconAnchor: [0, 0],
                    className: 'village-icon-with-ownership'
                });
            } else {
                // Regular icon
                villageIcon = L.icon({
                    iconUrl: graphicPath,
                    iconSize: [scale, scale * 0.72],
                    iconAnchor: [0, 0]
                });
            }

            // Position marker at exact tile coordinates
            const marker = L.marker([y * scale, x * scale], {
                icon: villageIcon,
                pane: 'villages'
            }).addTo(this.map);

            // Add popup
            const popupContent = `
                <strong>${tile.name}</strong><br>
                (${x}|${y}) K${tile.continent}<br>
                ${tile.player}<br>
                ${tile.ally}
            `;
            marker.bindPopup(popupContent);

            this.markers[tile.id] = marker;

        } else if (tile.type === 'ghost') {
            const folder = window.mapFolder || 'map';
            const isNight = folder === 'map_dark';
            const graphicFile = isNight ? 'n_ghost.png' : 'ghost.png';
            const graphicPath = `graphic/${folder}/${graphicFile}`;
            
            const ghostIcon = L.icon({
                iconUrl: graphicPath,
                iconSize: [scale, scale * 0.72],
                iconAnchor: [0, 0]
            });
            
            const marker = L.marker([y * scale, x * scale], {
                icon: ghostIcon,
                pane: 'villages'
            }).addTo(this.map);
            
            const popupContent = `
                <div style="text-align: center; font-family: sans-serif; padding: 5px; min-width: 140px;">
                    <strong style="color: #5d2f09; font-size: 13px;">${tile.title}</strong><br>
                    <span style="color: #777; font-size: 11px;">(${x}|${y})</span><br>
                    <p style="font-size: 11px; margin: 8px 0; color: #333; line-height: 1.3;">${tile.description}</p>
                    <a href="${tile.invite_url}" style="background: linear-gradient(to bottom, #f5d399 0%, #d4af37 100%); border: 1px solid #8a6d1c; border-radius: 4px; color: #4a2711; text-decoration: none; font-weight: bold; padding: 4px 12px; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.2); font-size: 11px;">${tile.invite_text}</a>
                </div>
            `;
            marker.bindPopup(popupContent);

        } else {
            // Render terrain (grass, decoration, bush)
            // Check if graphic already has .png extension (decorations do, grass doesn't)
            const graphic = tile.graphic.endsWith('.png') ? tile.graphic : tile.graphic + '.png';
            const hasMapFolder = graphic.startsWith('map/') || graphic.startsWith('map_dark/');
            const folder = window.mapFolder || 'map';
            const isNight = folder === 'map_dark' && !hasMapFolder;
            
            let graphicFile = graphic;
            if (isNight) {
                if (graphicFile.includes('/')) {
                    const parts = graphicFile.split('/');
                    const filename = parts.pop();
                    graphicFile = parts.join('/') + '/n_' + filename;
                } else {
                    graphicFile = 'n_' + graphicFile;
                }
            }

            const imageUrl = hasMapFolder ? `graphic/${graphicFile}` : `graphic/${folder}/${graphicFile}`;

            const overlay = L.imageOverlay(imageUrl, bounds, {
                pane: 'tiles',
                opacity: 1,
                interactive: false
            }).addTo(this.map);
        }
    },

    /**
     * Render faith circles
     */
    renderFaithCircles: function (circles) {
        circles.forEach(circle => {
            // Coordinate system is scaled by TILE_SCALE (50)
            // Village tiles are positioned at their top-left corner
            // To center the circle on the village, add half a tile (0.5 * TILE_SCALE)
            const centerY = (circle.y * this.TILE_SCALE) + (this.TILE_SCALE / 2);
            const centerX = (circle.x * this.TILE_SCALE) + (this.TILE_SCALE / 2);
            // Radius is in tiles, so multiply by TILE_SCALE to get pixels
            const scaledRadius = circle.radius * this.TILE_SCALE;

            L.circle([centerY, centerX], {
                radius: scaledRadius,
                color: 'rgba(0, 0, 255, 0.4)',
                fillColor: 'rgba(0, 0, 255, 0.2)',
                fillOpacity: 0.2,
                weight: 2,
                dashArray: '5, 5',
                pane: 'faith'
            }).addTo(this.map);
        });
    },

    /**
     * Render default grass (fallback)
     */
    renderDefaultGrass: function () {
        const folder = window.mapFolder || 'map';
        const isNight = folder === 'map_dark';
        const graphicFile = isNight ? 'n_gras4.png' : 'gras4.png';
        const tileLayer = L.tileLayer(`graphic/${folder}/${graphicFile}`, {
            tileSize: 53,
            bounds: [[0, 0], [1000, 1000]],
            noWrap: true
        });
        tileLayer.addTo(this.map);
    },

    /**
     * Render continents grid and labels
     */
    renderContinents: function() {
        if (!this.map) return;
        
        // Create pane for continents right above tiles
        this.map.createPane('continents');
        this.map.getPane('continents').style.zIndex = 220; // 200 is tiles, 250 is faith, 300 is villages
        this.map.getPane('continents').style.pointerEvents = 'none';
        
        const scale = this.TILE_SCALE;
        
        // Draw vertical lines every 100
        for(let i = 0; i <= 10; i++) {
            const x = i * 100 * scale;
            L.polyline([[0, x], [1000 * scale, x]], {
                color: 'rgba(0,0,0,0.6)',
                weight: 2,
                pane: 'continents',
                interactive: false
            }).addTo(this.map);
        }
        
        // Draw horizontal lines every 100
        for(let i = 0; i <= 10; i++) {
            const y = i * 100 * scale;
            L.polyline([[y, 0], [1000 * scale, y]], {
                color: 'rgba(0,0,0,0.6)',
                weight: 2,
                pane: 'continents',
                interactive: false
            }).addTo(this.map);
        }
    },

    /**
     * Load tiles for currently visible area
     */
    loadVisibleTiles: function () {
        const bounds = this.map.getBounds();
        const scale = this.TILE_SCALE;

        // Convert Leaflet bounds to game coordinates
        const minX = Math.floor(bounds.getWest() / scale);
        const maxX = Math.ceil(bounds.getEast() / scale);
        const minY = Math.floor(bounds.getSouth() / scale);
        const maxY = Math.ceil(bounds.getNorth() / scale);

        // Check if we already have these tiles
        const loadedTiles = window.mapData?.tiles || {};
        let needsLoading = false;

        for (let y = minY; y <= maxY; y++) {
            for (let x = minX; x <= maxX; x++) {
                const coords = x + '|' + y;
                if (!loadedTiles[coords]) {
                    needsLoading = true;
                    break;
                }
            }
            if (needsLoading) break;
        }

        if (!needsLoading) {
            console.log('All visible tiles already loaded');
            return;
        }

        console.log('Loading tiles for bounds:', minX, maxX, minY, maxY);

        // Make AJAX request to load tiles
        const url = `game.php?village=${window.game_data?.village?.id || 0}&screen=map&ajax=load_tiles&minX=${minX}&maxX=${maxX}&minY=${minY}&maxY=${maxY}&t=${Date.now()}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Loaded', Object.keys(data.tiles).length, 'new tiles');

                    // Merge new tiles into mapData
                    if (!window.mapData) {
                        window.mapData = { tiles: {} };
                    }
                    Object.assign(window.mapData.tiles, data.tiles);

                    // Render new tiles
                    for (let coords in data.tiles) {
                        const [x, y] = coords.split('|').map(Number);
                        this.renderTile(x, y, data.tiles[coords]);
                    }
                }
            })
            .catch(error => {
                console.error('Error loading tiles:', error);
            });
    },

    /**
     * Toggle between static and Leaflet map
     */
    toggle: function () {
        const staticMap = document.getElementById('map-static');
        const leafletMap = document.getElementById('map-leaflet');
        const toggleBtn = document.getElementById('mode-text');

        if (staticMap.style.display !== 'none') {
            // Activate Leaflet mode
            staticMap.style.display = 'none';
            leafletMap.style.display = 'block';
            toggleBtn.textContent = 'Desativar Modo Arrastável';

            // Initialize if not already done
            if (!this.map) {
                const x = window.currentMapX || 500;
                const y = window.currentMapY || 500;
                this.init(x, y);
            } else {
                // Invalidate size to ensure proper rendering
                setTimeout(() => {
                    this.map.invalidateSize();
                }, 100);
            }
        } else {
            // Deactivate Leaflet mode
            staticMap.style.display = 'block';
            leafletMap.style.display = 'none';
            toggleBtn.textContent = '🖱️ Ativar Modo Arrastável';
        }
    },

    /**
     * Center map on specific coordinates
     */
    centerOn: function (x, y) {
        if (this.map) {
            this.map.setView([y, x], 0);
            this.currentX = x;
            this.currentY = y;
        }
    },

    /**
     * Get current center coordinates
     */
    getCenter: function () {
        if (this.map) {
            const center = this.map.getCenter();
            return { x: Math.round(center.lng), y: Math.round(center.lat) };
        }
        return { x: this.currentX, y: this.currentY };
    }
};

// Initialize toggle button when DOM is ready
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggle-drag-mode');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            TWLeafletMap.toggle();
        });
    }
});
/**
 * World Minimap Component for Tribal Wars
 * Shows entire world (1000x1000) with villages colored by ownership
 * Allows clicking to navigate main map
 */

class WorldMinimap {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            console.error('Minimap container not found:', containerId);
            return;
        }

        // Configuration
        this.fullWorldSize = 1000; // Full world is 1000x1000
        this.worldSize = options.worldSize || 100; //Show 20x20 area (zoomed in 50x - ultra zoom)
        this.minimapSize = options.minimapSize || 200; // 200x200 pixels
        this.currentX = options.currentX || 500;
        this.currentY = options.currentY || 500;
        this.viewportSize = options.viewportSize || 1; // 11x11 visible area
        this.onNavigate = options.onNavigate || function () { };

        // Colors
        this.colors = {
            background: '#7a9b4a', // Green grass
            ownVillage: '#f0c800', // Yellow
            tribeVillage: '#0000f4', // Blue
            allyVillage: '#00a0f4', // Light blue
            enemyVillage: '#f40000', // Red
            pnaVillage: '#800080', // Purple
            barbarianVillage: '#969696', // Gray
            otherVillage: '#823c0a', // Brown
            viewport: 'rgba(255, 255, 255, 0.3)', // White semi-transparent
            viewportBorder: '#ffffff' // White
        };

        this.init();
    }

    init() {
        // Create canvas
        this.canvas = document.createElement('canvas');
        this.canvas.width = this.minimapSize;
        this.canvas.height = this.minimapSize;
        this.canvas.style.cursor = 'crosshair';
        this.canvas.style.border = '2px solid #8C5F0D';
        this.canvas.style.backgroundColor = this.colors.background;

        this.ctx = this.canvas.getContext('2d');
        this.container.appendChild(this.canvas);

        // Remove click handler because user wants drag only
        // this.canvas.addEventListener('click', (e) => this.handleClick(e));

        // Add drag handlers
        this.isDragging = false;
        this.dragStartX = 0;
        this.dragStartY = 0;

        this.canvas.addEventListener('mousedown', (e) => {
            this.isDragging = true;
            this.dragStartX = e.clientX;
            this.dragStartY = e.clientY;
            
            // Gravar a posicao original em modo tiles (usado pro fallback se não houver jsMapSystem)
            this.dragStartCurrentX = this.currentX;
            this.dragStartCurrentY = this.currentY;
            
            this.canvas.style.cursor = 'grabbing';
            e.preventDefault();
        });

        this.canvas.addEventListener('mousemove', (e) => {
            if (this.isDragging) {
                const deltaX = e.clientX - this.dragStartX;
                const deltaY = e.clientY - this.dragStartY;
                
                if (window.jsMapSystem) {
                    // Se o mapa avançado está ativo, traduzir o movimento de pixels do minimapa
                    // para o equivalente em pixels no mapa gigante.
                    const scale = this.minimapSize / this.worldSize;
                    // Invertemos o deslocamento porque ao arrastar o minimapa pra direita, queremos 
                    // que a CÂMERA se mova pra esquerda (o terreno desliza para a direita).
                    const mainPxDeltaX = deltaX * (window.jsMapSystem.TW / scale);
                    const mainPxDeltaY = deltaY * (window.jsMapSystem.TH / scale);

                    window.jsMapSystem.offsetX += mainPxDeltaX;
                    window.jsMapSystem.offsetY += mainPxDeltaY;
                    
                    if (!window.jsMapSystem._rafId) {
                        window.jsMapSystem._rafId = requestAnimationFrame(() => {
                            window.jsMapSystem._applyTransform();
                            window.jsMapSystem._rafId = null;
                        });
                    }

                    // Encontrar o novo centro do mundo após o movimento suave
                    const newX = Math.round((window.jsMapSystem.vpW / 2 - window.jsMapSystem.offsetX) / window.jsMapSystem.TW);
                    const newY = Math.round((window.jsMapSystem.vpH / 2 - window.jsMapSystem.offsetY) / window.jsMapSystem.TH);
                    
                    const safeX = Math.max(0, Math.min(this.fullWorldSize - 1, newX));
                    const safeY = Math.max(0, Math.min(this.fullWorldSize - 1, newY));

                    // Atualiza o bloco atual apenas se mudou de quadradinho inteiro para renderizar novos tiles no JSMapSystem
                    if (safeX !== this.currentX || safeY !== this.currentY) {
                        this.currentX = safeX;
                        this.currentY = safeY;
                        
                        this.render(); 
                        
                        window.jsMapSystem.currentX = safeX;
                        window.jsMapSystem.currentY = safeY;
                        window.currentMapX = safeX;
                        window.currentMapY = safeY;
                        
                        window.jsMapSystem._renderCoordinates();
                        window.jsMapSystem._fetchTiles(safeX, safeY);
                    } else {
                        // Sempre continua renderizando o box branco em movimento fluido!
                        this.render();
                    }
                } else {
                    // Fallback se estivermos num mapa estático simples ou no ecrã da Torre de Vigia
                    const scale = this.minimapSize / this.worldSize;
                    const worldDeltaX = deltaX / scale;
                    const worldDeltaY = deltaY / scale;

                    this.dragStartCurrentX -= worldDeltaX;
                    this.dragStartCurrentY -= worldDeltaY;

                    const newX = Math.max(0, Math.min(this.fullWorldSize - 1, Math.round(this.dragStartCurrentX)));
                    const newY = Math.max(0, Math.min(this.fullWorldSize - 1, Math.round(this.dragStartCurrentY)));

                    if (newX !== this.currentX || newY !== this.currentY) {
                        this.currentX = newX;
                        this.currentY = newY;

                        this.render();
                        
                        if (this.onNavigate) {
                            // Envia só pra disparar hooks que nao usem ajax
                            this.onNavigate(this.currentX, this.currentY, false);
                        }
                    }
                }

                // Update drag start position
                this.dragStartX = e.clientX;
                this.dragStartY = e.clientY;
            }
        });

        this.canvas.addEventListener('mouseup', (e) => {
            if (this.isDragging) {
                this.isDragging = false;
                this.canvas.style.cursor = 'crosshair';
                
                // Final update or page load mode if needed
                if (!window.jsMapSystem && this.onNavigate) {
                    this.onNavigate(this.currentX, this.currentY, true);
                }
            }
        });

        this.canvas.addEventListener('mouseleave', (e) => {
            if (this.isDragging) {
                this.isDragging = false;
                this.canvas.style.cursor = 'crosshair';
            }
        });

        // Add title
        const title = document.createElement('div');
        title.textContent = '» Mostrar mapa-mundo';
        title.style.textAlign = 'center';
        title.style.fontSize = '11px';
        title.style.fontWeight = 'bold';
        title.style.marginTop = '5px';
        title.style.cursor = 'pointer';
        title.onclick = () => this.toggleExpanded();
        this.container.insertBefore(title, this.canvas);

        // Load villages data
        this.loadVillages();
    }

    async loadVillages() {
        try {
            // Fetch villages data from server
            const villageId = typeof currentVillageId !== 'undefined' ? currentVillageId : '';
            const url = `game.php?village=${villageId}&screen=map&ajax=minimap_data&t=${Date.now()}`;
            console.log('Minimap: Fetching data from', url);

            const response = await fetch(url);
            console.log('Minimap: Response status', response.status);

            const data = await response.json();
            console.log('Minimap: Data received', data);

            this.villages = data.villages || [];
            this.userId = data.userId;
            this.userAlly = data.userAlly;
            this.customColors = data.customColors || {};
            this.contracts = data.contracts || {};

            console.log('Minimap: Villages loaded:', this.villages.length);
            console.log('Minimap: User ID:', this.userId, 'Ally:', this.userAlly);

            this.render();
        } catch (error) {
            console.error('Minimap: Failed to load data:', error);
            // Render empty minimap
            this.villages = [];
            this.render();
        }
    }

    render() {
        const ctx = this.ctx;
        const scale = this.minimapSize / this.worldSize;

        // Calculate the region to show (centered on current position)
        const halfRegion = Math.floor(this.worldSize / 2);
        const minX = Math.max(0, this.currentX - halfRegion);
        const maxX = Math.min(this.fullWorldSize, this.currentX + halfRegion);
        const minY = Math.max(0, this.currentY - halfRegion);
        const maxY = Math.min(this.fullWorldSize, this.currentY + halfRegion);

        console.log('Minimap: Rendering region', minX, minY, 'to', maxX, maxY, 'scale:', scale);

        // Clear canvas
        ctx.clearRect(0, 0, this.minimapSize, this.minimapSize);

        // Draw faith
        if (window.mapData && window.mapData.faith_circles && window.mapData.faith_circles.length > 0 && localStorage.getItem('map_show_faith') !== '0') {
            this.drawFaithRegion(ctx, minX, minY, maxX, maxY, scale);
        }
        
        // Draw watchtower
        const showWatchtower = window.isWatchtowerScreen || localStorage.getItem('map_show_watchtower') !== '0';
        if (window.mapData && window.mapData.watchtower_circles && window.mapData.watchtower_circles.length > 0 && showWatchtower) {
            this.drawWatchtowerRegion(ctx, minX, minY, maxX, maxY, scale);
        }

        // Draw villages in the visible region
        if (this.villages && this.villages.length > 0) {
            let drawnCount = 0;
            this.villages.forEach(village => {
                // Only draw villages in the visible region
                if (village.x >= minX && village.x <= maxX &&
                    village.y >= minY && village.y <= maxY) {

                    const x = Math.floor((village.x - minX) * scale);
                    const y = Math.floor((village.y - minY) * scale);

                    ctx.fillStyle = this.getVillageColor(village);
                    ctx.fillRect(x, y, 3, 3); // Increased to 3px for better visibility
                    drawnCount++;
                }
            });
            console.log('Minimap: Drew', drawnCount, 'villages in region');
        } else {
            console.log('Minimap: No villages to draw');
        }

        // Draw continent borders on the small minimap
        ctx.strokeStyle = 'rgba(0,0,0,0.5)';
        ctx.lineWidth = 1;
        
        // Find all multiples of 100 within [minX, maxX]
        const firstGridX = Math.floor(minX / 100) * 100;
        for (let gridX = firstGridX; gridX <= maxX; gridX += 100) {
            if (gridX >= minX && gridX <= maxX) {
                const pxX = Math.floor((gridX - minX) * scale);
                ctx.beginPath();
                ctx.moveTo(pxX, 0);
                ctx.lineTo(pxX, this.minimapSize);
                ctx.stroke();
            }
        }
        
        // Find all multiples of 100 within [minY, maxY]
        const firstGridY = Math.floor(minY / 100) * 100;
        for (let gridY = firstGridY; gridY <= maxY; gridY += 100) {
            if (gridY >= minY && gridY <= maxY) {
                const pxY = Math.floor((gridY - minY) * scale);
                ctx.beginPath();
                ctx.moveTo(0, pxY);
                ctx.lineTo(this.minimapSize, pxY);
                ctx.stroke();
            }
        }

        // Draw viewport rectangle
        this.drawViewport();
    }

    drawFaithRegion(ctx, minX, minY, maxX, maxY, scale) {
        const circles = window.mapData.faith_circles;
        
        const isFaith = (nx, ny) => {
            for (const c of circles) {
                if (Math.hypot(nx - c.x, ny - c.y) <= c.radius) return true;
            }
            return false;
        };

        ctx.strokeStyle = 'rgba(0, 150, 255, 0.9)';
        ctx.lineWidth = 1;
        ctx.shadowBlur = 4;
        ctx.shadowColor = 'rgba(0, 50, 255, 0.8)';

        ctx.beginPath(); // Start ONE single path for the whole grid

        // Iterate over tiles in the visible minimap area
        for (let tx = minX; tx <= maxX; tx++) {
            for (let ty = minY; ty <= maxY; ty++) {
                if (isFaith(tx, ty)) {
                    const pxX = Math.floor((tx - minX) * scale);
                    const pxY = Math.floor((ty - minY) * scale);
                    const s = Math.max(1, Math.ceil(scale));

                    // Draw exposed borders
                    if (!isFaith(tx, ty - 1)) {
                        ctx.moveTo(pxX, pxY);
                        ctx.lineTo(pxX + s, pxY);
                    }
                    if (!isFaith(tx + 1, ty)) {
                        ctx.moveTo(pxX + s, pxY);
                        ctx.lineTo(pxX + s, pxY + s);
                    }
                    if (!isFaith(tx, ty + 1)) {
                        ctx.moveTo(pxX, pxY + s);
                        ctx.lineTo(pxX + s, pxY + s);
                    }
                    if (!isFaith(tx - 1, ty)) {
                        ctx.moveTo(pxX, pxY);
                        ctx.lineTo(pxX, pxY + s);
                    }
                }
            }
        }
        
        ctx.stroke();

        // Reset shadow so it doesn't affect villages
        ctx.shadowBlur = 0;
    }
    
    drawWatchtowerRegion(ctx, minX, minY, maxX, maxY, scale) {
        const circles = window.mapData.watchtower_circles;
        if (!circles) return;

        ctx.strokeStyle = 'rgba(150, 255, 0, 0.9)';
        ctx.fillStyle = 'rgba(150, 255, 0, 0.15)';
        ctx.lineWidth = 1.5;
        ctx.shadowBlur = 4;
        ctx.shadowColor = 'rgba(100, 255, 0, 0.6)';

        for (const c of circles) {
            // Only draw if inside or intersecting visible region
            // (Strict bounding box check could be added, but full loop is fine for now)
            const cx = (c.x - minX) * scale;
            const cy = (c.y - minY) * scale;
            const r = c.radius * scale;

            ctx.beginPath();
            ctx.arc(cx, cy, r, 0, 2 * Math.PI);
            ctx.fill();
            ctx.stroke();
        }

        ctx.shadowBlur = 0;
    }

    drawViewport() {
        const ctx = this.ctx;
        const scale = this.minimapSize / this.worldSize;

        // Calculate the region bounds
        const halfRegion = Math.floor(this.worldSize / 2);
        const minX = Math.max(0, this.currentX - halfRegion);
        const minY = Math.max(0, this.currentY - halfRegion);

        // Calculate viewport position and size (relative to region)
        let vW = this.viewportSize;
        let vH = this.viewportSize;
        
        // Offset pra movimentacao suave do retangulo branco
        let smoothOffsetX = 0;
        let smoothOffsetY = 0;

        // Se o mapa estiver no modo js moderno, pegamos a amostragem real exata do box (ex 15x15) e a fluidez (pixels do pan interpolados)
        if (window.jsMapSystem) {
            vW = window.jsMapSystem.vpW / window.jsMapSystem.TW;
            vH = window.jsMapSystem.vpH / window.jsMapSystem.TH;

            // Diferença fluida - a coordenada mundo fracionada real do mapa animado menos a coordenada inteira calculada
            const realWorldCX = (window.jsMapSystem.vpW / 2 - window.jsMapSystem.offsetX) / window.jsMapSystem.TW;
            const realWorldCY = (window.jsMapSystem.vpH / 2 - window.jsMapSystem.offsetY) / window.jsMapSystem.TH;
            smoothOffsetX = realWorldCX - this.currentX;
            smoothOffsetY = realWorldCY - this.currentY;
        }

        const halfViewW = vW / 2;
        const halfViewH = vH / 2;
        
        const viewX = (this.currentX + smoothOffsetX - halfViewW - minX) * scale;
        const viewY = (this.currentY + smoothOffsetY - halfViewH - minY) * scale;
        const viewWidth = vW * scale;
        const viewHeight = vH * scale;

        // Draw semi-transparent rectangle
        ctx.fillStyle = this.colors.viewport;
        ctx.fillRect(viewX, viewY, viewWidth, viewHeight);

        // Draw border
        ctx.strokeStyle = this.colors.viewportBorder;
        ctx.lineWidth = 1;
        ctx.strokeRect(viewX, viewY, viewWidth, viewHeight);
    }

    getVillageColor(village) {
        // Own village
        if (village.userid == this.userId) {
            return this.colors.ownVillage;
        }

        // Barbarian
        if (village.userid == -1 || village.userid == '-1') {
            return this.colors.barbarianVillage;
        }

        // Custom player colors (from awards / player markings)
        if (this.customColors && this.customColors[village.userid]) {
            return 'rgb(' + this.customColors[village.userid] + ')';
        }

        // Tribe member
        if (this.userAlly && this.userAlly != -1 && village.ally == this.userAlly) {
            return this.colors.tribeVillage;
        }

        // Diplomacy (Contracts)
        if (village.ally && village.ally != -1 && this.contracts && this.contracts[village.ally]) {
            const type = this.contracts[village.ally];
            if (type === 'enemy') {
                return this.colors.enemyVillage;
            } else if (type === 'nap') {
                return this.colors.pnaVillage;
            } else if (type === 'partner') {
                return this.colors.allyVillage;
            }
        }

        // For now, just use "other" color
        return this.colors.otherVillage;
    }

    handleClick(event) {
        // Return placeholder since we removed click navigation
    }

    updateViewport(x, y, size) {
        this.currentX = x;
        this.currentY = y;
        if (size) this.viewportSize = size;

        this.render();
    }

    toggleExpanded() {
        // Create or toggle expanded minimap modal
        let modal = document.getElementById('expanded-minimap-modal');

        if (modal) {
            // Toggle visibility
            modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
            return;
        }

        // Create modal
        modal = document.createElement('div');
        modal.id = 'expanded-minimap-modal';
        modal.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 450px;
            height: 500px;
            background: #f4e4bc;
            border: 2px solid #8C5F0D;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
            z-index: 10000;
            display: block;
        `;

        // Create header
        const header = document.createElement('div');
        header.style.cssText = `
            background: linear-gradient(to bottom, #c1a264 0%, #9d7c3f 100%);
            padding: 8px 12px;
            cursor: move;
            border-bottom: 2px solid #8C5F0D;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
            font-weight: bold;
        `;
        header.innerHTML = `
            <span>Mapa do Mundo</span>
            <button id="close-expanded-map" style="background: #7d510f; color: #fff; border: 1px solid #5a3a0a; padding: 2px 8px; cursor: pointer; font-weight: bold;">fechar</button>
        `;

        // Create canvas container
        const canvasContainer = document.createElement('div');
        canvasContainer.style.cssText = `
            padding: 10px;
            background: #f4e4bc;
            height: calc(100% - 90px);
            overflow: hidden;
        `;

        // Create canvas for world map
        const canvas = document.createElement('canvas');
        canvas.width = 400;
        canvas.height = 400;
        canvas.style.cssText = `
            display: block;
            margin: 0 auto;
            background: #7a9b4a;
            border: 1px solid #8C5F0D;
        `;

        canvasContainer.appendChild(canvas);

        // Create stats footer
        const footer = document.createElement('div');
        footer.style.cssText = `
            background: #f4e4bc;
            padding: 8px 12px;
            border-top: 1px solid #8C5F0D;
            font-size: 11px;
            display: flex;
            justify-content: space-around;
        `;

        // Calculate statistics
        const totalVillages = this.villages.length;
        const barbarianVillages = this.villages.filter(v => v.userid == -1 || v.userid == '-1').length;
        const tribeVillages = this.userAlly && this.userAlly != -1 ?
            this.villages.filter(v => v.ally == this.userAlly).length : 0;
        const ownVillages = this.villages.filter(v => v.userid == this.userId).length;

        const barbarianPercent = totalVillages > 0 ? ((barbarianVillages / totalVillages) * 100).toFixed(2) : 0;
        const tribePercent = totalVillages > 0 ? ((tribeVillages / totalVillages) * 100).toFixed(2) : 0;
        const ownPercent = totalVillages > 0 ? ((ownVillages / totalVillages) * 100).toFixed(2) : 0;

        footer.innerHTML = `
            <span><b>Aldeias</b> ${totalVillages}</span>
            <span><b>Bárbaras</b> ${barbarianVillages} (${barbarianPercent}%)</span>
            <span><b>A sua tribo</b> ${tribeVillages} (${tribePercent}%)</span>
            <span><b>As suas próprias</b> ${ownVillages} (${ownPercent}%)</span>
        `;

        // Assemble modal
        modal.appendChild(header);
        modal.appendChild(canvasContainer);
        modal.appendChild(footer);
        document.body.appendChild(modal);

        // Make draggable
        this.makeDraggable(modal, header);

        // Close button
        document.getElementById('close-expanded-map').onclick = () => {
            modal.style.display = 'none';
        };

        // Draw world map with continents
        this.drawExpandedMap(canvas);
    }

    makeDraggable(element, handle) {
        let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;

        handle.onmousedown = dragMouseDown;

        function dragMouseDown(e) {
            e.preventDefault();
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e.preventDefault();
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            element.style.top = (element.offsetTop - pos2) + "px";
            element.style.left = (element.offsetLeft - pos1) + "px";
            element.style.transform = 'none'; // Remove centering transform
        }

        function closeDragElement() {
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }

    drawExpandedMap(canvas) {
        const ctx = canvas.getContext('2d');
        const size = 400;
        const continentSize = size / 4; // 4x4 grid of continents (K00-K33)

        // Clear canvas
        ctx.fillStyle = '#7a9b4a';
        ctx.fillRect(0, 0, size, size);

        // Draw all villages
        const scale = size / this.fullWorldSize;

        // Draw continent grid lines (10x10)
        const continentPx = 100 * scale;
        ctx.strokeStyle = 'rgba(0,0,0,0.5)';
        ctx.lineWidth = 1;
        for (let i = 0; i <= 10; i++) {
            // Vertical lines
            ctx.beginPath();
            ctx.moveTo(i * continentPx, 0);
            ctx.lineTo(i * continentPx, size);
            ctx.stroke();

            // Horizontal lines
            ctx.beginPath();
            ctx.moveTo(0, i * continentPx);
            ctx.lineTo(size, i * continentPx);
            ctx.stroke();
        }

        if (this.villages && this.villages.length > 0) {
            this.villages.forEach(village => {
                const x = Math.floor(village.x * scale);
                const y = Math.floor(village.y * scale);

                ctx.fillStyle = this.getVillageColor(village);
                ctx.fillRect(x, y, 2, 2); // Increased to 2px for better visibility
            });
        }

        console.log('Expanded map: Drew', this.villages.length, 'villages');
    }
}

// Auto-initialize if container exists
document.addEventListener('DOMContentLoaded', function () {
    const minimapContainer = document.getElementById('world-minimap');
    if (minimapContainer && typeof currentVillageX !== 'undefined' && typeof currentVillageY !== 'undefined') {
        console.log('Minimap: Initializing from DOMContentLoaded');
        window.worldMinimap = new WorldMinimap('world-minimap', {
            currentX: currentVillageX,
            currentY: currentVillageY,
            viewportSize: typeof currentMapSize !== 'undefined' ? currentMapSize : 11,
            onNavigate: function (x, y, forcesReload) {
                if (window.isWatchtowerScreen) return; // Prevent navigation on Watchtower screen

                // Se o JSMapSystem (mapa animado) estiver ativo
                if (window.jsMapSystem) {
                    window.jsMapSystem.currentX = x;
                    window.jsMapSystem.currentY = y;
                    window.currentMapX = x;
                    window.currentMapY = y;

                    window.jsMapSystem.offsetX = window.jsMapSystem.vpW / 2 - x * window.jsMapSystem.TW;
                    window.jsMapSystem.offsetY = window.jsMapSystem.vpH / 2 - y * window.jsMapSystem.TH;

                    if (!window.jsMapSystem._rafId) {
                        window.jsMapSystem._rafId = requestAnimationFrame(() => {
                            window.jsMapSystem._applyTransform();
                            window.jsMapSystem._rafId = null;
                        });
                    }
                    window.jsMapSystem._renderCoordinates();
                    window.jsMapSystem._fetchTiles(x, y);
                    
                } else if (forcesReload) {
                    // Sem JSMapSystem, recarrega a página ao soltar o mouse
                    const villageId = typeof currentVillageId !== 'undefined' ? currentVillageId : '';
                    window.location.href = `game.php?village=${villageId}&screen=map&x=${x}&y=${y}`;
                }
            }
        });
    }
});

// Fallback: If DOM already loaded, init immediately
if (document.readyState === 'complete' || document.readyState === 'interactive') {
    setTimeout(function () {
        const minimapContainer = document.getElementById('world-minimap');
        if (minimapContainer && !window.worldMinimap && typeof currentVillageX !== 'undefined' && typeof currentVillageY !== 'undefined') {
            console.log('Minimap: Initializing from immediate fallback');
            window.worldMinimap = new WorldMinimap('world-minimap', {
                currentX: currentVillageX,
                currentY: currentVillageY,
                viewportSize: typeof currentMapSize !== 'undefined' ? currentMapSize : 11,
                onNavigate: function (x, y, forcesReload) {
                    if (window.isWatchtowerScreen) return; // Prevent navigation on Watchtower

                    if (window.jsMapSystem) {
                        window.jsMapSystem.currentX = x;
                        window.jsMapSystem.currentY = y;
                        window.currentMapX = x;
                        window.currentMapY = y;

                        window.jsMapSystem.offsetX = window.jsMapSystem.vpW / 2 - x * window.jsMapSystem.TW;
                        window.jsMapSystem.offsetY = window.jsMapSystem.vpH / 2 - y * window.jsMapSystem.TH;

                        if (!window.jsMapSystem._rafId) {
                            window.jsMapSystem._rafId = requestAnimationFrame(() => {
                                window.jsMapSystem._applyTransform();
                                window.jsMapSystem._rafId = null;
                            });
                        }
                        window.jsMapSystem._renderCoordinates();
                        window.jsMapSystem._fetchTiles(x, y);
                    } else if (forcesReload) {
                        const villageId = typeof currentVillageId !== 'undefined' ? currentVillageId : '';
                        window.location.href = `game.php?village=${villageId}&screen=map&x=${x}&y=${y}`;
                    }
                }
            });
        }
    }, 100);
}
