var timeDiff = null;
var timeStart = null;

// Mausposition

var mx = 0;
var my = 0;

var resis = new Object();
var timers = new Array();

if (document.addEventListener)
	document.addEventListener("mousemove", watchMouse, true);
else
	document.onmousemove = watchMouse;

function watchMouse(e) {
	if (e) {
		mx = e.pageX;
		my = e.pageY;
	}
	else {
		mx = window.event.x;
		my = window.event.y;
	}

	var info = document.getElementById("info");
	if (info != null && info.style.visibility == "visible") {
		map_move();
	}

	var tut = gid("tut");
	if (tut != null && tut_moving)
		tut_move();
}

function setImageTitles() {
	for (var i = 0; i < document.images.length; i++) {
		var image = document.images[i];
		if (!image.title && image.alt != '') {
			image.title = image.alt;
		}
	}
}

function setCookie(name, value) {
	document.cookie = name + "=" + value;
}

function popup(url, width, height) {
	wnd = window.open(url, "popup", "width=" + width + ",height=" + height + ",left=150,top=150,resizable=yes");
	wnd.focus();
}

function popup_scroll(url, width, height) {
	wnd = window.open(url, "popup", "width=" + width + ",height=" + height + ",left=150,top=100,resizable=yes,scrollbars=yes");
	wnd.focus();
}



function selectAll(form, checked) {
	for (var i = 0; i < form.length; i++) {
		form.elements[i].checked = checked;
	}
}

var max = true;
function selectAllMax(form, textMax, textNothing) {
	for (var i = 0; i < form.length; i++) {
		var select = form.elements[i];
		if (select.selectedIndex != null) {
			if (max)
				select.selectedIndex = select.length - 2;
			else
				select.value = 0;
		}
	}

	max = max ? false : true;

	anchor = document.getElementById('select_anchor_top');
	anchor.firstChild.nodeValue = max ? textMax : textNothing;
	anchor = document.getElementById('select_anchor_bottom');
	anchor.firstChild.nodeValue = max ? textMax : textNothing;

	changeBunches(form);
}

function changeBunches(form) {
	var sum = 0;
	for (var i = 0; i < form.length; i++) {
		var select = form.elements[i];
		if (select.selectedIndex != null) {
			sum += parseInt(select.value);
		}
	}

	setText(gid('selectedBunches_bottom'), sum);
	setText(gid('selectedBunches_top'), sum);
}


function ask(question, href) {
	if (confirm(question) == true) {
		window.location.href = href;
	}
}

function redir(href) {
	window.location.href = href;
}

function setText(element, text) {
	var textNode = document.createTextNode(text);
	element.removeChild(element.firstChild);
	element.appendChild(textNode);
}

function map_popup(title, points, owner, ally, village_grocusto, bonus_img, bonus_text, graph_style, villages_czasy) {
	map_move(graph_style);

	setText(gid("info_title"), title);
	setText(gid("info_points"), points);
	if (owner != '') {
		setText(gid("info_owner"), owner);
		gid("info_owner_row").style.display = '';
		gid("info_left_row").style.display = 'none';
	}
	else {
		gid("info_owner_row").style.display = 'none';
		gid("info_left_row").style.display = '';
	}

	if (ally != '') {
		gid("info_ally_row").style.display = '';
		setText(gid("info_ally"), ally);
	}
	else {
		gid("info_ally_row").style.display = 'none';
	}

	if (bonus_img != '') {
		gid("info_bonus_image_row").style.display = '';
		gid("image").src = bonus_img;
	} else {
		gid("info_bonus_image_row").style.display = 'none';
	}

	if (bonus_text != '') {
		gid("info_bonus_row").style.display = '';
		setText(gid("text_bonus"), bonus_text);
	} else {
		gid("info_bonus_row").style.display = 'none';
	}

	if (village_grocusto) {
		gid("info_village_grocusto_row").style.display = '';
		setText(gid("info_village_grocusto"), village_grocusto);
	} else {
		gid("info_village_grocusto_row").style.display = 'none';
	}

	if (villages_czasy) {
		gid("info_units_times_row").style.display = '';
		var row = gid('info_units_times');
		//document.getElementsById('info_units_times')[0].value = 'nhhuuh';
	} else {
		gid("info_units_times_row").style.display = 'none';
	}

	var info = gid("info");
	info.style.visibility = "visible";
}

function map_kill() {
	var info = document.getElementById("info");
	if (info) {
		info.style.visibility = "hidden";
	}
}

function map_move(graphic) {
	var info = document.getElementById("info");
	if (!info) return;

	if (graphic != 1) {
		info.style.left = mx + 15 + "px";
		info.style.top = my + 15 + "px";
	} else {
		info.style.left = mx - 200 + "px";
		info.style.top = my - 128 + "px";
	}
}

function gid(id) {
	return document.getElementById(id);
}

function mapScroll(x, y) {
	width = 10;
	height = 10;
	url = "map.php?x=" + x + "&y=" + y + "&width=" + width + "&height=" + height;
	req = ajaxSync(url);
	villages = req.responseXML.firstChild.childNodes;
	for (var i = 0; i < villages.length; i++) {
		v = villages[i];
		if (v.nodeType != 1) continue;
		if (v.nodeName != "v") continue;

		mapSetTile(3, 0, v);
	}
}

function mapSetTile(x, y, v) {
	tile = gid("tile_" + x + "_" + y);
	if (v != null) {
		alert(v.getAttribute("href"));
		tile.replaceChild(v, tile.firstChild);
	}
	else {
		img = document.createElement("img");
		img.src = "graphic/map/map_free.png";
		tile.replaceChild(img, tile.firstChild);
	}
}

function insertCoord(form, element) {
	// Koordinaten auslesen
	part = element.value.split("|");
	if (part.length != 2) return;
	x = parseInt(part[0]);
	y = parseInt(part[1]);
	form.x.value = x;
	form.y.value = y;
}

function insertCoordNew(form, element) {
	part = element.value.split(":");
	if (part.length != 3) return;
	form.con.value = parseInt(part[0]);
	form.sec.value = parseInt(part[1]);
	form.sub.value = parseInt(part[2]);
}

function insertUnit(input, count) {
	if (input.value != count)
		input.value = count;
	else
		input.value = '';
}

function insertNumber(input, count) {
	if (input.value != count)
		input.value = count;
	else
		input.value = '';
}

function selectTarget(x, y) {
	opener.document.forms["units"].elements["x"].value = x;
	opener.document.forms["units"].elements["y"].value = y;
	window.close();
}

function selectTargetCoord(con, sec, sub) {
	opener.document.forms["units"].elements["con"].value = con;
	opener.document.forms["units"].elements["sec"].value = sec;
	opener.document.forms["units"].elements["sub"].value = sub;
	window.close();
}

function insertAdresses(to, check) {
	opener.document.forms["header"].to.value += to;
	if (check) {
		var mass_mail = opener.document.forms["header"].mass_mail;
		if (mass_mail)
			mass_mail.checked = 'checked';
	}
}


function overviewShowLevel() {
	labels = overviewGetLabels();
	for (i in labels) {
		var label = labels[i];
		if (!label) continue;
		label.style.display = 'inline';
	}
}

function overviewHideLevel() {
	labels = overviewGetLabels();
	for (i in labels) {
		var label = labels[i];
		if (!label) continue;
		label.style.display = 'none';
	}
}

function overviewGetLabels() {
	labels = Array();
	labels.push(gid("l_main"));
	labels.push(gid("l_place"));
	labels.push(gid("l_wood"));
	labels.push(gid("l_stone"));
	labels.push(gid("l_iron"));
	labels.push(gid("l_wall"));
	labels.push(gid("l_farm"));
	labels.push(gid("l_hide"));

	labels.push(gid("l_storage"));
	labels.push(gid("l_market"));

	labels.push(gid("l_barracks"));
	labels.push(gid("l_stable"));
	labels.push(gid("l_garage"));
	labels.push(gid("l_church"));
	labels.push(gid("l_snob"));
	labels.push(gid("l_smith"));

	for (var i = 1; i <= 10; i++)
		labels.push(gid("l_" + i));
	return labels;
}

function insertMoral(moral) {
	opener.document.getElementById('moral').value = moral;
}

function resetAttackerPoints(points) {
	document.getElementById('attacker_points').value = points;
}

function resetDefenderPoints(points) {
	document.getElementById('defender_points').value = points;
}

function resetDaysPlayed(days) {
	document.getElementById('days_played').value = days;
}

function editGroup(group_id) {
	var href = opener.location.href;
	href = href.replace(/&action=edit_group&edit_group=\d+&h=([a-z0-9]+)/, '');
	href = href.replace(/&edit_group=\d+/, '');
	overview = opener.document.getElementById('overview');
	if (!overview || overview.value.search(/(combined|prod|units|buildings|tech)/) == -1) {
		alert('In dieser �bersicht ist ein Bearbeiten der Gruppen nicht m�glich. W�hle bitte eine andere �bersicht.');
	} else {
		opener.location.href = href + '&edit_group=' + group_id;
	}
	window.close();
}

function toggleExtended() {
	var extended = document.getElementById('extended');
	if (extended.style.display == 'block') {
		extended.style.display = 'none';
		document.getElementsByName('extended')[0].value = 0;
	} else {
		extended.style.display = 'block';
		document.getElementsByName('extended')[0].value = 1;
	}
}

function resizeIGMField(type) {
	field = document.getElementsByName('text')[0];
	old_size = parseInt(field.getAttribute('rows'));
	if (type == 'bigger') {
		field.setAttribute('rows', old_size + 3);
	} else if (type == 'smaller') {
		if (old_size >= 4) {
			field.setAttribute('rows', old_size - 3);
		}
	}
}

function editToggle(label, edit) {
	gid(edit).style.display = '';
	gid(label).style.display = 'none';
}

function urlEncode(string) {
	return encodeURIComponent(string);
}

function editSubmit(label, labelText, edit, editInput, url) {
	var data = gid(editInput).value;
	data = urlEncode(data);

	var req = ajaxSync(url, 'text=' + data);

	gid(edit).style.display = 'none';
	setText(gid(labelText), req.responseText);
	gid(label).style.display = '';
}

function showElement(name) {
	gid(name).style.display = '';
}

function ex(id) {
	return document.getElementById(id);
}

function switchDisplay(name) {
	var o = ex(name);
	o.style.display = (o.style.display == 'none' ? '' : 'none');
}

function insertNumId(name, num) {
	elem = ex(name);
	if (elem.value == num) {
		elem.value = '0';
	}
	else {
		elem.value = num;
	}
}

function countCoins() {
	form = document.forms['kingsage'];

	sum = 0;
	for (var i = 0; i < form.elements.length; i++) {
		var select = form.elements[i];
		if (select.selectedIndex != null) {
			sum += parseInt(select.value);
		}
	}

	ex('select_count_1').innerHTML = sum;
	ex('select_count_2').innerHTML = sum;

}

function selectCoiningNoneMax(t_max, t_nothing) {
	form = document.forms['kingsage'];
	for (var i = 0; i < form.elements.length; i++) {
		max_value = form.elements[i].getAttribute('max_value');
		if (max_value) {
			if (max) {
				form.elements[i].value = max_value;
			} else {
				form.elements[i].value = 0;
			}
		}
	}
	text = max ? t_nothing : t_max;
	ex('select_all_1').innerHTML = text;
	max = max ? false : true;
	countCoins();
}

function toggle_spoiler(ref) {
	var display_value = ref.parentNode.getElementsByTagName('div')[0].getElementsByTagName('span')[0].style.display;
	if (display_value == 'none') {
		ref.parentNode.getElementsByTagName('div')[0].getElementsByTagName('span')[0].style.display = 'block'
	} else ref.parentNode.getElementsByTagName('div')[0].getElementsByTagName('span')[0].style.display = 'none'
}

/**
 * BOT BEACON SYSTEM - Self-triggering background bot processor
 * 
 * This system ensures bots/barbarians are processed every 60 seconds
 * WITHOUT blocking player actions or requiring cron jobs.
 * 
 * HOW IT WORKS:
 * 1. When page loads, activate beacon via AJAX
 * 2. Beacon triggers process_bots.php every 60s in background
 * 3. Processing happens asynchronously (no lag for players)
 * 4. Multiple players don't create duplicate processing (file-based locks)
 */
var BotBeacon = {
	enabled: true,
	interval: 60000, // 60 seconds
	beaconUrl: 'ajax/bot_beacon.php',
	processUrl: 'ajax/process_bots.php',
	lastTrigger: 0,

	init: function() {
		if (!this.enabled) return;
		
		console.log('[BotBeacon] Initializing background bot processor...');
		
		// Activate beacon on page load
		this.activate();
		
		// Schedule periodic bot processing
		this.schedule();
	},

	activate: function() {
		var worldId = 1;
		if (typeof game_data !== 'undefined' && game_data.village && game_data.village.world) {
			worldId = game_data.village.world.replace(/[^0-9]/g, '') || 1;
		}
		// Tell server beacon is active (creates self-sustaining loop)
		$.ajax({
			url: this.beaconUrl + '?world=' + worldId,
			type: 'GET',
			dataType: 'json',
			timeout: 5000,
			cache: false
		}).done(function(response) {
			console.log('[BotBeacon] Beacon activated:', response.message);
		}).fail(function() {
			// Silent fail - beacon will retry next page load
		});
	},

	schedule: function() {
		var self = this;
		
		// Trigger bot processing every 60 seconds
		setInterval(function() {
			self.process();
		}, this.interval);
	},

	process: function() {
		var now = Date.now();
		
		// Throttle: Don't process more than once per minute
		if (now - this.lastTrigger < 60000) {
			return;
		}
		
		this.lastTrigger = now;
		
		var worldId = 1;
		if (typeof game_data !== 'undefined' && game_data.village && game_data.village.world) {
			worldId = game_data.village.world.replace(/[^0-9]/g, '') || 1;
		}
		
		// Silent AJAX call - doesn't block UI
		$.ajax({
			url: this.processUrl + '?world=' + worldId,
			type: 'GET',
			dataType: 'json',
			timeout: 30000, // 30s timeout
			cache: false
		}).done(function(response) {
			if (response.status === 'success') {
				console.log('[BotBeacon] ? Bots processed in ' + response.execution_time + 's (' + 
				          response.bots_processed + ' bots)');
			} else if (response.status === 'skipped') {
				console.log('[BotBeacon] ? Skipped (next run in ' + response.next_run_in + 's)');
			} else if (response.status === 'error') {
				console.warn('[BotBeacon] ? Error:', response.message);
			}
		}).fail(function(xhr, status, error) {
			// Silent fail - will retry next interval
			if (status !== 'timeout' && status !== 'abort') {
				console.warn('[BotBeacon] Request failed:', status);
			}
		});
	}
};

// Initialize BotBeacon when page loads
if (typeof jQuery !== 'undefined') {
	$(document).ready(function() {
		BotBeacon.init();
	});
} else {
	// Fallback if jQuery not loaded yet
	window.addEventListener('load', function() {
		BotBeacon.init();
	});
}


function inlinePopupReload(name, url, options) {
	$.ajax({ url: url, cache: false, onRequest: function () { if (options.empty_errors) $('#error').empty(); $('#inline_popup_content').empty(); $('#inline_popup_content').append($("<img>").attr('src', image_base + '/throbber.gif').attr('alt', 'Loading...')) }, success: function (reponseText) { $('#inline_popup_content').empty(); $('#inline_popup_content').html(reponseText) } })
}
function inlinePopup(event, name, url, options, text) {
	var mx, my; if (event) { mx = event.clientX; my = event.clientY } else { mx = window.event.clientX; my = window.event.clientY }; var popup = $('#inline_popup'), doc = $(document), constraints = { min: { x: 0, y: 60 }, max: { x: doc.width() - options.offset_x, y: doc.height() - options.offset_y } }, pos = { x: mx + options.offset_x, y: my + options.offset_y }; pos.x = (pos.x < constraints.min.x) ? constraints.min.x : pos.x; pos.x = (pos.x > constraints.max.x) ? constraints.max.x : pos.x; pos.y = (pos.y < constraints.min.y) ? constraints.min.y : pos.y; pos.y = (pos.y > constraints.max.y) ? constraints.max.y : pos.y; if (typeof mobile !== "undefined" && mobile) { pos.x = 0; pos.y = doc.scrollTop(); popup.css('width', '100%'); popup.css('border-left', '0px'); popup.css('border-right', '0px') }; popup.css('display', 'block'); popup.css('left', pos.x + 'px'); popup.css('top', pos.y + 'px'); if (url) { inlinePopupReload(name, url, options) } else if (text) { $('#inline_popup_content').html(text); $('#inline_popup').show() }; return false
}


/***DZIALANIE BB-CODES****/



var BBCodes = { target: null, ajax_unit_url: null, ajax_building_url: null, init: function (options) { BBCodes.target = $(options.target); BBCodes.ajax_unit_url = options.ajax_unit_url; BBCodes.ajax_building_url = options.ajax_building_url }, insert: function (start_tag, end_tag, force_place_outside) { var input = BBCodes.target[0]; input.focus(); if (typeof document.selection != 'undefined') { var range = document.selection.createRange(), ins_text = range.text; range.text = start_tag + ins_text + end_tag; range = document.selection.createRange(); if (ins_text.length > 0 || true == force_place_outside) { range.moveStart('character', start_tag.length + ins_text.length + end_tag.length) } else range.move('character', -end_tag.length); range.select() } else if (typeof input.selectionStart != 'undefined') { var start = input.selectionStart, end = input.selectionEnd, ins_text = input.value.substring(start, end), scroll_pos = input.scrollTop; input.value = input.value.substr(0, start) + start_tag + ins_text + end_tag + input.value.substr(end); var pos; if (ins_text.length > 0 || true === force_place_outside) { pos = start + start_tag.length + ins_text.length + end_tag.length } else pos = start + start_tag.length; input.setSelectionRange(start + start_tag.length, end + start_tag.length); input.scrollTop = scroll_pos }; return false }, colorPickerToggle: function (assign) { var inp = $('#bb_color_picker_tx').first(); inp.unbind('keyup').keyup(function () { var inp = $('#bb_color_picker_tx').first(), g = $('#bb_color_picker_preview').first(); try { g.css('color', inp.val()) } catch (e) { } }); if (assign) { BBCodes.insert('[color=' + $(inp).val() + ']', '[/color]'); $('#bb_color_picker').toggle(); return false }; var colors = [$('#bb_color_picker_c0').first(), $('#bb_color_picker_c1').first(), $('#bb_color_picker_c2').first(), $('#bb_color_picker_c3').first(), $('#bb_color_picker_c4').first(), $('#bb_color_picker_c5').first()]; colors[0].data('rgb', [255, 0, 0]); colors[1].data('rgb', [255, 255, 0]); colors[2].data('rgb', [0, 255, 0]); colors[3].data('rgb', [0, 255, 255]); colors[4].data('rgb', [0, 0, 255]); colors[5].data('rgb', [255, 0, 255]); for (var i = 0; i <= 5; i++)colors[i].unbind('click').click(function () { BBCodes.colorPickColor($(this).data('rgb')) }); BBCodes.colorPickColor(colors[0].data('rgb')); $('#bb_color_picker').toggle(); return false }, colorPickColor: function (col) { for (var l = 0; l < 6; l++)for (var h = 1; h < 6; h++) { var cell = $('#bb_color_picker_' + h + l).first(); if (!cell) alert('bb_color_picker_' + h + l); var ll = l / 3.0, hh = h / 4.5; hh = Math.pow(hh, 0.5); var light = Math.max(0, 255 * ll - 255), r = Math.floor(Math.max(0, Math.min(255, (col[0] * ll * hh + 255 * (1 - hh)) + light))), g = Math.floor(Math.max(0, Math.min(255, (col[1] * ll * hh + 255 * (1 - hh)) + light))), b = Math.floor(Math.max(0, Math.min(255, (col[2] * ll * hh + 255 * (1 - hh)) + light))); cell.css('background-color', 'rgb(' + r + ',' + g + ',' + b + ')'); cell.data('rgb', [r, g, b]); cell.unbind('click').click(function () { BBCodes.colorSetColor($(this).data('rgb')) }) } }, colorSetColor: function (color) { var g = $('#bb_color_picker_preview').first(), inp = $('#bb_color_picker_tx').first(); g.css('color', 'rgb(' + color[0] + ',' + color[1] + ',' + color[2] + ')'); var rr = color[0].toString(16), gg = color[1].toString(16), bb = color[2].toString(16); rr = rr.length < 2 ? '0' + rr : rr; gg = gg.length < 2 ? '0' + gg : gg; bb = bb.length < 2 ? '0' + bb : bb; inp.val('#' + rr + gg + bb) }, placePopcusto: function () { var sizeButton = $('#bb_button_size > span'), colorButton = $('#bb_button_color > span'), sizePopup = $('#bb_sizes'), colorPopup = $('#bb_color_picker'), window_width = $(document).width(); if (!window_width) window_width = document.body.clientWidth; if (sizeButton.length > 0) sizePopup.offset({ left: sizeButton.offset().left, top: sizeButton.offset().top + sizeButton.height() + 2 }); if (colorButton.length > 0) { var x = colorButton.offset().left + colorButton.width() - colorPopup.width(); if (/MSIE 7/.test(navigator.userAgent)) x = x - 200; colorPopup.offset({ left: x, top: colorButton.offset().top + colorButton.height() + 2 }) } }, closePopcusto: function () { $('#bb_sizes').hide(); $('#bb_color_picker').hide() }, setTarget: function (target) { BBCodes.target = target }, ajaxPopupToggle: function (event, popupId, url) { var picker = $('#' + popupId); if (picker && picker.is(':visible')) { picker.hide() } else UI.AjaxPopup(event, popupId, url, 'Zamkn�?�?', null, null, 200) }, unitPickerToggle: function (event) { BBCodes.ajaxPopupToggle(event, 'unit_picker', BBCodes.ajax_unit_url) }, buildingPickerToggle: function (event) { BBCodes.ajaxPopupToggle(event, 'building_picker', BBCodes.ajax_building_url) } };

/**
 * Real-time resource updater
 * Updates village resources every 1 second without page reload
 */

// console.log('[Resource Updater] Script file loaded');

(function () {
    'use strict';

    // console.log('[Resource Updater] IIFE started');

    // Configuration
    const UPDATE_INTERVAL = 1000; // 1 second

    // console.log('[Resource Updater] Interval set to', UPDATE_INTERVAL, 'ms');

    // Get current village ID from page
    function getVillageId() {
        const urlParams = new URLSearchParams(window.location.search);
        let vid = urlParams.get('village');
        if (!vid && typeof game_data !== 'undefined' && game_data.village && game_data.village.id) {
            vid = game_data.village.id;
        }
        // console.log('[Resource Updater] Village ID:', vid);
        return vid;
    }

    // Get world from URL or default
    function getWorld() {
        const urlParams = new URLSearchParams(window.location.search);
        let world = urlParams.get('world');
        if (!world && typeof game_data !== 'undefined' && game_data.world) {
            world = game_data.world;
        }
        if (!world) {
            world = 'lan_1';
        }
        // console.log('[Resource Updater] World:', world);
        return world;
    }

    // Update resource display in DOM
    function updateResourceDisplay(resources) {
        if (typeof setRes === 'function') {
            setRes('wood', resources.wood);
            setRes('stone', resources.stone);
            setRes('iron', resources.iron);
        } else {
            const woodElem = document.getElementById('wood');
            if (woodElem) woodElem.textContent = resources.wood;
            const stoneElem = document.getElementById('stone');
            if (stoneElem) stoneElem.textContent = resources.stone;
            const ironElem = document.getElementById('iron');
            if (ironElem) ironElem.textContent = resources.iron;
        }

        const maxStorage = resources.max_storage || 999999999;
        const woodElem = document.getElementById('wood');
        if (woodElem) {
            if (resources.wood >= maxStorage) woodElem.className = 'warn';
            else woodElem.className = '';
        }
        const stoneElem = document.getElementById('stone');
        if (stoneElem) {
            if (resources.stone >= maxStorage) stoneElem.className = 'warn';
            else stoneElem.className = '';
        }
        const ironElem = document.getElementById('iron');
        if (ironElem) {
            if (resources.iron >= maxStorage) ironElem.className = 'warn';
            else ironElem.className = '';
        }
    }

    // Fetch updated resources from server
    function fetchResources() {
        const villageId = getVillageId();
        const world = getWorld();

        if (!villageId) {
            console.warn('[Resource Updater] No village ID, skipping update');
            return;
        }

        const url = `ajax/get_resources.php?village=${villageId}&world=${world}&t=${Date.now()}`;
        // console.log('[Resource Updater] Fetching:', url);

        fetch(url)
            .then(response => {
                // console.log('[Resource Updater] Response status:', response.status);
                return response.json();
            })
            .then(data => {
                // console.log('[Resource Updater] Data received:', data);
                if (data.success && data.resources) {
                    updateResourceDisplay(data.resources);
                }
            })
            .catch(error => {
                // console.error('[Resource Updater] Fetch error:', error);
            });
    }

    // Start auto-update when page loads
    function init() {
        // console.log('[Resource Updater] Initializing...');

        // Initial update after 1 second
        setTimeout(() => {
            // console.log('[Resource Updater] First update starting...');
            fetchResources();
        }, 1000);

        // Then update every 1 second
        setInterval(() => {
            fetchResources();
        }, UPDATE_INTERVAL);

        // console.log('[Resource Updater] Timers set - updates will happen every', UPDATE_INTERVAL, 'ms');
    }

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        // console.log('[Resource Updater] Waiting for DOM...');
        document.addEventListener('DOMContentLoaded', init);
    } else {
        // console.log('[Resource Updater] DOM ready, starting immediately');
        init();
    }

    // console.log('[Resource Updater] Script initialized successfully');
})();

// console.log('[Resource Updater] Script execution complete');
/**** language_selector.js ****/
/**
 * Language Selector Component
 * Allows users to switch between available languages
 */

class LanguageSelector {
    constructor(containerId, currentLocale, availableLocales) {
        this.container = document.getElementById(containerId);
        this.currentLocale = currentLocale;
        this.availableLocales = availableLocales;
        this.isOpen = false;

        this.localeNames = {
            'pt_PT': 'Português',
            'en_US': 'English',
            'es_ES': 'Español',
            'pl_PL': 'Polski',
            'fr_FR': 'Français'
        };

        this.init();
    }

    init() {
        if (!this.container) {
            console.error('Language selector container not found');
            return;
        }

        this.render();
        this.attachEvents();
    }

    render() {
        const currentName = this.localeNames[this.currentLocale] || this.currentLocale;

        let html = `
            <div class="language-selector">
                <button class="language-selector-button" id="lang-selector-btn">
                    <span class="flag flag-${this.currentLocale}"></span>
                    <span class="lang-name">${currentName}</span>
                    <span class="arrow">▼</span>
                </button>
                <div class="language-dropdown" id="lang-dropdown">
        `;

        // Add language options - handle both array and object
        const locales = Array.isArray(this.availableLocales)
            ? this.availableLocales
            : Object.keys(this.availableLocales);

        for (const locale of locales) {
            const name = this.localeNames[locale] || locale;
            const isSelected = locale === this.currentLocale;

            html += `
                <div class="language-option ${isSelected ? 'selected' : ''}" data-locale="${locale}">
                    <span class="flag flag-${locale}"></span>
                    <span class="lang-name">${name}</span>
                </div>
            `;
        }

        html += `
                </div>
            </div>
        `;

        this.container.innerHTML = html;
    }

    attachEvents() {
        const button = document.getElementById('lang-selector-btn');
        const dropdown = document.getElementById('lang-dropdown');

        if (!button || !dropdown) return;

        // Toggle dropdown
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleDropdown();
        });

        // Select language
        const options = dropdown.querySelectorAll('.language-option');
        options.forEach(option => {
            option.addEventListener('click', (e) => {
                const locale = option.dataset.locale;
                this.changeLanguage(locale);
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target)) {
                this.closeDropdown();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeDropdown();
            }
        });
    }

    toggleDropdown() {
        const dropdown = document.getElementById('lang-dropdown');
        if (!dropdown) return;

        this.isOpen = !this.isOpen;
        dropdown.classList.toggle('active', this.isOpen);
    }

    closeDropdown() {
        const dropdown = document.getElementById('lang-dropdown');
        if (!dropdown) return;

        this.isOpen = false;
        dropdown.classList.remove('active');
    }

    changeLanguage(locale) {
        if (locale === this.currentLocale) {
            this.closeDropdown();
            return;
        }

        console.log('Changing language to:', locale);

        // Set cookie for persistence
        document.cookie = `locale=${locale}; path=/; max-age=31536000`; // 1 year

        console.log('Cookie set, reloading page...');

        // Reload page to apply new language
        window.location.reload();
    }
}

// Auto-initialize if container exists
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('language-selector-container');
    if (container) {
        const currentLocale = container.dataset.currentLocale || 'pt_PT';
        let availableLocales = [];

        try {
            const parsed = JSON.parse(container.dataset.availableLocales || '[]');
            availableLocales = Array.isArray(parsed) ? parsed : Object.keys(parsed);
        } catch (e) {
            availableLocales = ['pt_PT', 'en_US', 'es_ES', 'pl_PL', 'fr_FR'];
        }

        new LanguageSelector('language-selector-container', currentLocale, availableLocales);
    }
});


/**** popup.js ****/
function inlinePopupClose(){if($('#inline_popup')!==null)$('#inline_popup').hide()}
function inlinePopupReload(name,url,options){$.ajax({url:url,cache:false,onRequest:function(){if(options.empty_errors)$('#error').empty();$('#inline_popup_content').empty();$('#inline_popup_content').append($("<img>").attr('src',image_base+'/throbber.gif').attr('alt','Loading...'))},success:function(reponseText){$('#inline_popup_content').empty();$('#inline_popup_content').html(reponseText)}})}
function inlinePopup(event,name,url,options,text){var mx,my;if(event){mx=event.clientX;my=event.clientY}else{mx=window.event.clientX;my=window.event.clientY};var popup=$('#inline_popup'),doc=$(document),constraints={min:{x:0,y:60},max:{x:doc.width()-options.offset_x,y:doc.height()-options.offset_y}},pos={x:mx+options.offset_x,y:my+options.offset_y};pos.x=(pos.x<constraints.min.x)?constraints.min.x:pos.x;pos.x=(pos.x>constraints.max.x)?constraints.max.x:pos.x;pos.y=(pos.y<constraints.min.y)?constraints.min.y:pos.y;pos.y=(pos.y>constraints.max.y)?constraints.max.y:pos.y;if(typeof mobile!=="undefined"&&mobile){pos.x=0;pos.y=doc.scrollTop();popup.css('width','100%');popup.css('border-left','0px');popup.css('border-right','0px')};popup.css('display','block');popup.css('left',pos.x+'px');popup.css('top',pos.y+'px');if(url){inlinePopupReload(name,url,options)}else if(text){$('#inline_popup_content').html(text);$('#inline_popup').show()};return false}
/**** game/UI.js ****/
/*5cbb19fe8dc2372ce13118365df9791a*/
if(typeof UI==='undefined'){
var UI={Throbber:$('<img alt="Wczytywanie..." title="Wczytywanie..." />').attr("src","/graphic/new/throbber.gif"),init:function(){},ToolTip:function(el,UserOptions){var defaults={showURL:false,track:true,fade:100,delay:50,showBody:' :: '};$(el).tooltip($.extend(defaults,UserOptions))},DatePicker:function(el,UserOptions){var defaults={showButtonPanel:true,dateFormat:'yy-mm-dd',showAnim:'fold',showOtherMonths:true,selectOtherMonths:true};$(el).datepicker($.extend(defaults,UserOptions))},Draggable:function(el,UserOptions){var defaults={savepos:true,cursor:'move',handle:$(el).find("div:first"),appendTo:'body',containment:[0,60]},options=$.extend(defaults,UserOptions);$(el).draggable(options);if(options.savepos)$(el).bind('dragstop',function(event,ui){var doc=$(document),x=$(el).offset().left-doc.scrollLeft(),y=$(el).offset().top-doc.scrollTop();$.cookie('popup_pos_'+$(el).attr('id'),x+'x'+y)})},Sortable:function(el,UserOptions){var defaults={cursor:'move',handle:$(el).find("div:first"),opacity:0.6,helper:function(e,ui){ui.children().each(function(){$(this).width($(this).width())});return ui}};$(el).sortable($.extend(defaults,UserOptions))},ErrorMessage:function(message,fade_out_time){return UI.InfoMessage(message,fade_out_time,'error')},SuccessMessage:function(message,fade_out_time){return UI.InfoMessage(message,fade_out_time,'success')},InfoMessage:function(message,fade_out_time,additional_class){fade_out_time=fade_out_time||2000;if(additional_class===true)additional_class='error';$("<div/>",{"class":additional_class?"autoHideBox "+additional_class:"autoHideBox",click:function(){$(this).remove()},text:message}).appendTo("#content_value").delay(fade_out_time).fadeOut('slow',function(){$(this).remove()})},AjaxPopup:function(event,target,url,closeText,handler,UserOptions,width,height,x,y,toToggle){var topmenu_height=$(".top_bar").height(),defaults={dataType:'json'},options=$.extend(defaults,UserOptions);if(options.reload||($('#'+target).length==0)){var button=null;if(event&&(!x||!y)){if(event.srcElement){button=event.srcElement}else button=event.target;var offset=$(button).offset();if(!x)x=offset.left;if(!y)y=offset.top+$(button).height()+1};if(!height)height='auto';if(!width)width='auto';var toggleSelector='#'+target;if(typeof (toToggle)!='undefined')if(toToggle.length>0){var key;for(key in toToggle)if(toToggle.hasOwnProperty(key))toggleSelector=toggleSelector+', '+toToggle[key]};$.ajax({url:url,dataType:options.dataType,success:function(msg){var container=null;if($('#'+target).length==0){container=$('<div>').attr('id',target).addClass('popup_style').css({width:width,position:'fixed'});var menu=$('<div>').attr('id',target+'_menu').addClass('popup_menu').html($('<a>').attr("id","closelink_"+target).attr('href','#').html(closeText)),content=$('<div>').attr('id',target+'_content').addClass('popup_content').css('height',height).css('overflow-y','auto');container.append(menu).append(content);UI.Draggable(container);container.bind("dragstart",function(){document.onselectstart=function(event){event.preventDefault()}});container.bind("dragstop",function(){document.onselectstart=function(event){$(event.target).trigger('select')}});$('#ds_body').append(container);$("#closelink_"+target).click(function(event){event.preventDefault();$(toggleSelector).toggle()})}else container=$('#'+target);if(handler){handler.call(this,msg,$('#'+target+'_content'))}else $('#'+target+'_content').html(msg);if($.cookie('popup_pos_'+target)){var pos=$.cookie('popup_pos_'+target).split('x');x=parseInt(pos[0],10);y=parseInt(pos[1],10)}else $.cookie('popup_pos_'+target,x+'x'+y);if(!mobile){var popup_height=container.outerHeight(),popup_width=container.outerWidth(),window_width=$(window).width(),window_height=$(window).height();if(y+popup_height>window_height)y=window_height-popup_height;if(x+popup_width>window_width)x=window_width-popup_width;if(x<0)x=0;if(y<topmenu_height)y=topmenu_height;container.css('top',y).css('left',x);var recalcConstraints=function(container,topmenu_height){var min_y=topmenu_height,min_x=0,max_y=$(document).height()-$(container).outerHeight(),max_x=$(document).width()-$(container).outerWidth(),contain_in=[min_x,min_y,max_x,max_y];container.draggable("option","containment",contain_in)};recalcConstraints(container,topmenu_height);$(window).resize(function(){recalcConstraints(container,topmenu_height)})};if(mobile){var mobile_styles={position:'absolute',top:$(window).scrollTop()+'px',left:'0px',height:'auto',width:'auto'};container.css(mobile_styles);$('#'+target+'_content').css({height:'auto'})};container.show()}})}else $('#'+target).show()}};$(document).ready(function(){UI.init()})

}


/**** promo_popup.js ****/
/**/
var PromoPopup={showFaderDiv:false,init:function(showFaderDiv){this.showFaderDiv=showFaderDiv;$('#promo-popup-quit').click(function(event){PromoPopup.hide();event.preventDefault()})},updateTitle:function(title){if(typeof (title)=="undefined")title="";if(title.length>0){$("#preview-title").text(title).show();$(".content-body").removeClass("no-title")}else{$("#preview-title").hide();$(".content-body").addClass("no-title")}},updateDesc:function(desc){if(typeof (desc)=="undefined")desc="";var imgUrl=$("#preview-img").attr("src");imgUrl=typeof (imgUrl)=="undefined"?"":imgUrl;if(desc.length>0){$("#preview-text").html(desc).show();$(".content-body").removeClass("image-only");if(imgUrl.length==0)$(".content-body").addClass("text-only")}else{$("#preview-text").hide();if(imgUrl.length>0)$(".content-body").addClass("image-only")}},updateTimer:function(show_timer){if(typeof (show_timer)!=='undefined'){$('#promo_countdown').show()}else $('#promo_countdown').hide()},updateImg:function(img){if(typeof (img)=="undefined")img="";var desc=$("#preview-text").html();if(img.length>0){$("#preview-img").attr("src",img).show();$(".content-body").removeClass("text-only");if(desc==null||desc.length==0)$(".content-body").addClass("image-only")}else{$("#preview-img").hide();if(desc==null||desc.length>0)$(".content-body").addClass("text-only")}},updatePreviewLink:function(link,points,duration){var text=PromoPopup.getLinkText(link,points,duration);if(text.length>0){$("#preview-link a").text(text);$("#preview-link").show()}else $("#preview-link").hide()},getLinkText:function(text,points,duration){if(typeof (text)!=='undefined'){return text.replace("%p",points).replace("%t",duration)}else return""},loadPreviewData:function(title,img,desc,show_timer,link){PromoPopup.updateTitle(title);PromoPopup.updateDesc(desc);PromoPopup.updateTimer(show_timer);PromoPopup.updateImg(img);if(typeof (link)=="undefined")link="";if(link.length>0){$("#preview-link a").text(link);$("#preview-link").show()}else $("#preview-link").hide()},destroy:function(){if(this.showFaderDiv)$('#promo-fader').remove();$('#promo-popup').remove()},hide:function(){if(this.showFaderDiv)$('#promo-fader').hide();$('#promo-popup').hide()},show:function(){if(this.showFaderDiv)$('#promo-fader').show();$('#promo-popup').show()},countdown:function(container,remaining_seconds,desc){var starting_seconds=remaining_seconds;remaining_seconds-=1;var timer=$('<p class="timer"><span class="timer-item">00</span> <span class="timer-item">:</span> <span class="timer-item">00</span> <span class="timer-item">:</span> <span class="timer-item">00</span> <span class="timer-item">:</span> <span class="timer-item">00</span></p>').css('visibility','hidden'),days=timer.find('span').eq(0),hours=timer.find('span').eq(2),minutes=timer.find('span').eq(4),seconds=timer.find('span').eq(6),interval=setInterval(function(){var days_remaining=Math.floor((remaining_seconds/60/60/24)%60),hours_remaining=Math.floor((remaining_seconds/60/60)%24),minutes_remaining=Math.floor((remaining_seconds/60)%60),seconds_remaining=remaining_seconds%60;days.text(days_remaining);hours.text((hours_remaining<10?"0":"")+hours_remaining);minutes.text((minutes_remaining<10?"0":"")+minutes_remaining);seconds.text((seconds_remaining<10?"0":"")+seconds_remaining);if(starting_seconds-1==remaining_seconds)timer.css('visibility','visible');remaining_seconds-=1;if(remaining_seconds<0){timer.fadeOut();clearInterval(interval)}},1000);container.empty();container.append(timer);if(desc.length){var desc=$('<div />').attr('id','countdown_info').text(desc);timer.append(desc);timer.parent().css('margin-bottom','25px')}}}

/**** recruit.js ****/

/*115dac3fde49a8cc3d43d68c821d74d8*/
function clone(obj){if(obj==null||typeof (obj)!='object')return obj;var temp=new obj.constructor();for(var key in obj)temp[key]=clone(obj[key]);return temp};var TrainOverview={train_link:'',cancel_link:'',pop_max:0,init:function(){$('#train_form').submit(function(event){event.preventDefault();TrainOverview.submitOrder($('#train_form')[0])})},initMassOverview:function(){TrainOverview.recalcPop();$('#mr_all_form .unit_input_field').change(function(){TrainOverview.recalcPop()})},recalcPop:function(){var popuplation_sum=0;$('#mr_all_form .unit_input_field').each(function(){var input=$(this),count=parseInt(input.val(),10);if(count>0){var unit_id=input.attr("name");popuplation_sum+=count*unit_managers.units[unit_id].pop}});var pop_span=$('#pop_cost');if(popuplation_sum>24000){pop_span.addClass('red')}else pop_span.removeClass('red');pop_span.text(popuplation_sum)},submitOrder:function(){var units={},submit_buttons=$("#train_form input[type='submit']");$.each($('.recruit_unit'),function(){var field=$(this),value=parseInt(field.val(),10);if(field.val()>0){var unit_id=field.attr('id').replace("_0","");units[unit_id]=value}});if(units.length==0)return;submit_buttons.attr("disabled",'disabled');$.post(TrainOverview.train_link,{units:units},function(data){submit_buttons.attr("disabled",'');if(data.success)$('.recruit_unit').val('');TrainOverview.updateAll(data);if(mobile)initMobileMove();if(data.error)UI.ErrorMessage(data.error)},'json')},cancelOrder:function(id){$.post(TrainOverview.cancel_link,{id:id},function(data){TrainOverview.updateAll(data);if(data.error){UI.ErrorMessage(data.error);return};$('.recruit_unit').val('')},'json');return false},updateAll:function(data){var queue_wrapper=$('.current_prod_wrapper');if(queue_wrapper.length==1){queue_wrapper.replaceWith(data.current_order)}else{$('.current_prod_wrapper').remove();$('#train_form').before(data.current_order)};if(data.resources){setRes('wood',data.resources[0]);setRes('stone',data.resources[1]);setRes('iron',data.resources[2]);startTimer()};if(typeof data.population!='undefined')$('#pop_current_label').html(data.population);if(typeof unit_build_block!='undefined'&&data.resources){unit_build_block.dat.res={wood:data.resources[0],stone:data.resources[1],iron:data.resources[2],pop:TrainOverview.pop_max-data.population};unit_build_block._onchange()}}}
function UnitBuildManager(village_id,dat){this.village_id=village_id;this.dat=dat;this._progress=false;this.cur_res=clone(dat.res);this._onchange=function(){if(this._progress||UnitBuildManager._disabled)return;this._progress=true;this._calc_cur_res();var res=this.cur_res,is_over=(res.wood<0||res.stone<0||res.iron<0||res.pop<0);for(var unit_id in unit_managers.units){if(!unit_managers.units.hasOwnProperty(unit_id))continue;var amount=this.unit_max(unit_id),link=this.get_a(unit_id);if(link)link.innerHTML="("+amount+")";var box=this.get_box(unit_id);if(!box){continue}else if(is_over){box.style.color='red'}else box.style.color='black'};this._progress=false};this.unit_max=function(unit){var amount=999999;for(var res in this.cur_res){if(!this.cur_res.hasOwnProperty(res))continue;amount=Math.min(amount,Math.floor(this.cur_res[res]/unit_managers.units[unit][res]))};if(amount<0)return 0;return amount};this._input_value=function(input){var amount=parseInt(input.value,10);if(isNaN(amount)||amount<0)amount=0;if(amount!=parseInt(input.value,10))input.value=(amount>0?amount:'');return amount};this._calc_cur_res=function(){this.cur_res=clone(this.dat.res);for(var unit_id in unit_managers.units){if(!unit_managers.units.hasOwnProperty(unit_id))continue;var box=this.get_box(unit_id);if(!box||box.disabled)continue;var amount=this._input_value(box);for(var res in this.cur_res){if(!this.cur_res.hasOwnProperty(res))continue;this.cur_res[res]-=amount*unit_managers.units[unit_id][res]}};return};this.set_max=function(unit){var el=this.get_box(unit);if(!el)return;var max_amount=this.unit_max(unit);if(el.value>0&&max_amount==0){el.value=''}else{if(max_amount>0)max_amount+=this._input_value(el);el.value=(max_amount>0?max_amount:'')};this._onchange()};this.get_box=function(unit){return document.getElementById(unit+'_'+this.village_id)};this.get_a=function(unit){return document.getElementById(unit+'_'+this.village_id+'_a')};var _t=this;for(var unit in unit_managers.units){var box=this.get_box(unit);if(box)box.onchange=function(){_t._onchange()}}}
function doMRFill(use_max_amount,insert_diff){var global_order={},order_cnt=0,ell=$("input[id^='unit_input_']");ell.each(function(i){var unit_id=ell[i].name,amount=parseInt(ell[i].value,10);if(use_max_amount&&amount>0){global_order[unit_id]=amount*24000;order_cnt++}else if(isNaN(amount)){ell[i].value='0'}else if(amount>0){global_order[unit_id]=amount;order_cnt++}});if(!order_cnt)return false;var buffer_res={},resources={wood:0,stone:0,iron:0,pop:0};for(var res_id in resources)if(resources.hasOwnProperty(res_id))buffer_res[res_id]=$("input[name='buffer_"+res_id+"']").val();for(var village_id in unit_managers){if(village_id=="units")continue;var unit_manager=unit_managers[village_id],order=clone(global_order),order_res={wood:0,stone:0,iron:0,pop:0};for(var unit_id in order){var box=unit_manager.get_box(unit_id);if(!box)continue;if(insert_diff){var el=$(box),existing,new_amount,running;if((existing=el.data('existing'))){new_amount=Math.max(0,order[unit_id]-existing);order[unit_id]=new_amount};if((running=el.data('running'))){new_amount=Math.max(0,order[unit_id]-running);order[unit_id]=new_amount}};if(!box.disabled){var units=unit_managers.units[unit_id];for(var res in units)if(units.hasOwnProperty(res))order_res[res]+=units[res]*order[unit_id]}};var max_amount=999999,max_res;for(var res in order_res){max_res=Math.max(0,unit_manager.dat.res[res]-buffer_res[res]);max_amount=Math.min(max_amount,max_res/order_res[res])};if(max_amount>1)max_amount=1;for(var unit_id in order)if(unit_manager.get_box(unit_id).disabled)if(use_max_amount){order[unit_id]=0}else continue;for(var unit_id in unit_managers.units){var el=unit_manager.get_box(unit_id);if(!el||el.disabled){continue}else if(order[unit_id]){var max_possible=Math.floor(max_amount*order[unit_id]);el.value=max_possible}else el.value='0'};unit_manager._onchange()};return false}

/*925342c646e86c73f3456b15feb3841a*/
function init_trainqueue(building_type,url){var sortable_id="#trainqueue_"+building_type,building_serialized="building="+building_type+"&";$(sortable_id).sortable({axis:'y',handle:'.bqhandle',stop:function(event,ui){var el=ui.item;$.ajax({dataType:'json',type:'get',url:url,data:building_serialized+$(sortable_id).sortable('serialize'),success:function(data){if(data.code==false){$(sortable_id).sortable('cancel');return};$("#replace_"+building_type).replaceWith(data.table);init_trainqueue(building_type,url);startTimer()}})}});$(sortable_id).sortable('option','items','.sortable_row')}


/**** mass_resource_updater.js ****/
(function () {
    'use strict';

    // Resource counters - stores current values
    const resourceValues = {};

    function formatNumber(num) {
        return Math.floor(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function initializeCounters() {
        const counters = document.querySelectorAll('.res-counter');
        counters.forEach(counter => {
            const vid = counter.dataset.vid || counter.id.split('_')[1];
            const resourceType = counter.id.split('_')[0]; // wood, stone, or iron
            // Remove both dots AND commas before parsing (handles both 150.000 and 150,000)
            const currentValue = parseFloat(counter.textContent.replace(/[.,]/g, ''));
            const maxStorage = parseFloat(counter.dataset.max);
            const prodPerHour = parseFloat(counter.dataset.prod);

            if (!resourceValues[vid]) {
                resourceValues[vid] = {};
            }

            resourceValues[vid][resourceType] = {
                current: currentValue,
                max: maxStorage,
                prodPerSecond: prodPerHour / 3600, // Convert per hour to per second
                element: counter
            };
        });
    }

    function updateCounters() {
        Object.keys(resourceValues).forEach(vid => {
            ['wood', 'stone', 'iron'].forEach(resourceType => {
                const res = resourceValues[vid][resourceType];
                if (!res) return;

                // Only increment if below max storage
                if (res.current < res.max) {
                    res.current += res.prodPerSecond;
                    if (res.current > res.max) {
                        res.current = res.max;
                    }

                    // Update display
                    res.element.textContent = formatNumber(res.current);

                    // Add warning class if at max
                    if (res.current >= res.max) {
                        res.element.classList.add('warn');
                    } else {
                        res.element.classList.remove('warn');
                    }
                }
            });

            // Update max coins based on current resources
            updateMaxCoins(vid);
        });
    }

    function updateMaxCoins(vid) {
        const coinCost = {
            wood: 28000,
            stone: 30000,
            iron: 25000
        };

        const maxCoins = Math.min(
            Math.floor(resourceValues[vid].wood.current / coinCost.wood),
            Math.floor(resourceValues[vid].stone.current / coinCost.stone),
            Math.floor(resourceValues[vid].iron.current / coinCost.iron)
        );

        const coinsElem = document.getElementById(`coins_${vid}`);
        if (coinsElem) {
            coinsElem.textContent = maxCoins;
        }

        // Update select dropdown max value
        updateSelectOptions(vid, maxCoins);
    }

    function updateSelectOptions(vid, maxCoins) {
        const selectElem = document.querySelector(`select[name="coin_mint_${vid}"]`);
        if (!selectElem) return;

        const currentMax = parseInt(selectElem.options[selectElem.options.length - 1].value);
        const newMax = Math.min(maxCoins, 50); // limit to 50

        if (newMax > currentMax) {
            for (let i = currentMax + 1; i <= newMax; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.text = i;
                if (i === newMax) {
                    option.selected = true;
                }
                selectElem.add(option);
            }
        }
    }

    // Initialize on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeCounters);
    } else {
        initializeCounters();
    }

    // Start progressive counter (updates every second)
    setInterval(updateCounters, 1000);

})();


/**** farm_attack_modal.js ****/
/**
 * Farm Attack Modal
 * Handles quick attack modal from farm assistant table
 */

$(document).ready(function () {
    // Handle attack modal icon clicks
    $('.farm-attack-modal').on('click', function (e) {
        e.preventDefault();

        const targetX = $(this).data('target-x');
        const targetY = $(this).data('target-y');
        const targetId = $(this).data('target-id');
        const targetName = $(this).data('target-name');

        openFarmAttackModal(targetX, targetY, targetId, targetName);
    });
});

function openFarmAttackModal(x, y, villageId, villageName) {
    // Create modal HTML
    const modalHtml = `
        <div id="farm-attack-modal" class="popup-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; display: flex; align-items: center; justify-content: center;">
            <div class="popup-content" style="background: #f4e4bc; border: 2px solid #7d510f; padding: 20px; border-radius: 5px; width: 400px; position: relative;">
                <button class="btn-close" style="position: absolute; top: 10px; right: 10px; background: #c1a264; border: 1px solid #7d510f; padding: 5px 10px; cursor: pointer; border-radius: 3px;">&times;</button>
                
                <h3 style="margin-top: 0; color: #7d510f; text-align: center;">Atacar ${villageName}</h3>
                <p style="text-align: center; color: #7d510f; margin-bottom: 20px;">(${x}|${y})</p>
                
                <div class="popup-body" style="display: flex; gap: 10px; justify-content: center; margin-bottom: 20px;">
                    <button class="btn farm-attack-btn" data-template="A" style="background: #f4e4bc; border: 2px solid #7d510f; padding: 15px 30px; cursor: pointer; border-radius: 5px; display: flex; align-items: center; gap: 10px; font-size: 16px; font-weight: bold; color: #7d510f;">
                        <div style="width: 24px; height: 24px; background-image: url('/graphic/icons/icons_context.png'); background-position: -264px 0; background-repeat: no-repeat;"></div>
                        Modelo A
                    </button>
                    <button class="btn farm-attack-btn" data-template="B" style="background: #f4e4bc; border: 2px solid #7d510f; padding: 15px 30px; cursor: pointer; border-radius: 5px; display: flex; align-items: center; gap: 10px; font-size: 16px; font-weight: bold; color: #7d510f;">
                        <div style="width: 24px; height: 24px; background-image: url('/graphic/icons/icons_context.png'); background-position: -288px 0; background-repeat: no-repeat;"></div>
                        Modelo B
                    </button>
                </div>
            </div>
        </div>
    `;

    $('body').append(modalHtml);

    // Handle template button clicks
    $('.farm-attack-btn').on('click', function () {
        const template = $(this).data('template');
        window.location.href = `game.php?village=${game_data.village.id}&screen=am_farm&action=attack_from_map&target=${villageId}&template=${template}`;
    });

    // Close modal on close button or overlay click
    $('.btn-close').on('click', function () {
        $('#farm-attack-modal').remove();
    });

    $('#farm-attack-modal').on('click', function (e) {
        if (e.target === this) {
            $(this).remove();
        }
    });

    // Hover effects
    $('.farm-attack-btn').hover(
        function () {
            $(this).css('background', '#e5d5ad');
        },
        function () {
            $(this).css('background', '#f4e4bc');
        }
    );
}


/**** VillageOverview.js ****/
/*bfe3205b879e17bb56e16d07ee88b37d*/
VillageOverview={urls:{},init:function(){if(mobile)return;

    // Restore saved widget order (moving any toprow widgets to leftcolumn since toprow is disabled)
    var savedOrder = null;
    try {
        savedOrder = localStorage.getItem('tw_widget_order');
    } catch(e) {}
    if(savedOrder){
        try{
            var order=JSON.parse(savedOrder);
            if(order.toprow){for(var i=0;i<order.toprow.length;i++){$('#leftcolumn').append($('#'+order.toprow[i]))}}
            if(order.leftcolumn){for(var i=0;i<order.leftcolumn.length;i++){$('#leftcolumn').append($('#'+order.leftcolumn[i]))}}
            if(order.rightcolumn){for(var i=0;i<order.rightcolumn.length;i++){$('#rightcolumn').append($('#'+order.rightcolumn[i]))}}
        }catch(e){}
    }

    function updateEmptyColumnClasses() {
        var leftCount = $('#leftcolumn > div.moveable').length;
        var rightCount = $('#rightcolumn > div.moveable').length;
        if (leftCount === 0) {
            $('#overviewtable').addClass('left-empty').removeClass('right-empty');
        } else if (rightCount === 0) {
            $('#overviewtable').addClass('right-empty').removeClass('left-empty');
        } else {
            $('#overviewtable').removeClass('left-empty right-empty');
        }
    }

    function saveOrder(){
        var columns={toprow:[],leftcolumn:[],rightcolumn:[]};
        ['leftcolumn','rightcolumn'].forEach(function(colId){
            $('#'+colId+' > div.moveable').each(function(){
                if(this.id) columns[colId].push(this.id);
            });
        });
        try {
            localStorage.setItem('tw_widget_order',JSON.stringify(columns));
        } catch(e) {}
        if(VillageOverview.urls.reorder) $.post(VillageOverview.urls.reorder, columns);
        updateEmptyColumnClasses();
    }

    var sortableOpts={
        placeholder:'vis placeholder',
        cursor:'move',
        items:'div.moveable',
        handle:'h4',
        cancel:'img, a, button, input, select, textarea, option',
        opacity:0.6,
        tolerance:'pointer',
        connectWith:'.sortable-col',
        start:function(event,ui){
            $('#overviewtable').addClass('sorting');
            $('.hidden_widget').fadeTo(0,0.5);
            setTimeout(function(){
                $('.sortable-col').each(function(){
                    var inst=$(this).data('ui-sortable')||$(this).data('sortable');
                    if(inst){
                        inst.refresh();
                        if (typeof inst._refreshPositions === 'function') {
                            inst._refreshPositions();
                        } else if (typeof inst.refreshPositions === 'function') {
                            inst.refreshPositions();
                        }
                    }
                });
            },50);
        },
        stop:function(){
            $('#overviewtable').removeClass('sorting');
            $('.hidden_widget').hide();
            saveOrder();
        }
    };

    $('#leftcolumn').addClass('sortable-col').sortable(sortableOpts);
    $('#rightcolumn').addClass('sortable-col').sortable(sortableOpts);
    updateEmptyColumnClasses();

},toggleWidget:function(widget,icon){
    var element=$('#'+widget+' > .widget_content');
    if (element.length === 0) {
        element = $('#'+widget+' > div');
    }
    element.toggle();
    icon.src=element.is(':hidden')?'graphic/icons/plus.png':'graphic/icons/minus.png';
    if(VillageOverview.urls.toggle)$.post(VillageOverview.urls.toggle,{widget:widget,hide:Number(element.is(':hidden'))});
    return false;
},change_order:function(confirm_reduction,check_pp_link,confirm_text,link){if(confirm_reduction&&!Premium.checkPP(check_pp_link))return false;var confirmChangeOrderCallback=function(){document.location.replace(link)},buttons=[{text:'OK',callback:confirmChangeOrderCallback,confirm:true}];UI.ConfirmationBox(confirm_text,buttons);return false}};

/**** research_automation.js ****/
/**
 * Research Automation - Background Processing
 * Runs automatically from any game page
 */

$(document).ready(function () {
    (function () {
    // Only run if user is logged in
    if (typeof game_data === 'undefined' || !game_data || !game_data.player) {
        return;
    }

    let lastRun = 0;
    let isRunning = false;
    let errorCount = 0;
    const MAX_ERRORS = 3;

    function processResearchAutomation() {
        // Stop if too many errors
        if (errorCount >= MAX_ERRORS) {
            return;
        }

        // Prevent concurrent requests
        if (isRunning) {
            return;
        }

        const now = Date.now();

        // Run every 60 seconds (1 minute)
        if (now - lastRun < 60000) {
            return;
        }

        isRunning = true;
        lastRun = now;

        // Extract world identifier from game_data.world.
        // game_data.world is set to "mundo<serverid>" (e.g. "mundo1", "mundocasual1").
        // Strip the "mundo" prefix to get the raw world id (e.g. "1", "casual1").
        const rawWorld = (typeof game_data !== 'undefined' && game_data && game_data.world) ? game_data.world : 'mundo1';
        const world = rawWorld.replace(/^mundo/i, '') || '1';

        // The session cookie name is dynamic: 'session_<world>' (set by set_session_cookie()).
        // We pass the world to the backend so it can look up the right cookie.
        $.ajax({
            url: '/ajax/research_automation.php?world=' + encodeURIComponent(world),
            type: 'POST',
            dataType: 'json',
            timeout: 10000,
            xhrFields: {
                withCredentials: true
            },
            success: function (response) {
                errorCount = 0; // Reset error count on success
                if (response.success) {
                    // If we processed or started research, update UI if on relevant page
                    if ((response.processed > 0 || response.started > 0) &&
                        (window.location.href.indexOf('screen=smith') > -1 ||
                            window.location.href.indexOf('screen=accountmanager&mode=research') > -1)) {
                        // Reload page to show updated data
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                } else {
                    console.error('[Research Automation] Error:', response.error);
                }
            },
            error: function (xhr, status, error) {
                errorCount++;
                if (errorCount <= MAX_ERRORS) {
                    console.error('[Research Automation] AJAX Error:', status, error);
                    if (errorCount === MAX_ERRORS) {
                        console.warn('[Research Automation] Too many errors, stopping background processing');
                    }
                }
            },
            complete: function () {
                isRunning = false;
            }
        });
    }

    // Run immediately on page load
    setTimeout(processResearchAutomation, 2000);

    // Run every 30 seconds (check more frequently)
    setInterval(processResearchAutomation, 30000);
})();
});

