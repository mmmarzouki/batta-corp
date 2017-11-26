<script> Sfdump = window.Sfdump || (function (doc) { var refStyle = doc.createElement('style'), rxEsc = /([.*+?^${}()|\[\]\/\\])/g, idRx = /\bsf-dump-\d+-ref[012]\w+\b/, keyHint = 0 <= navigator.platform.toUpperCase().indexOf('MAC') ? 'Cmd' : 'Ctrl', addEventListener = function (e, n, cb) { e.addEventListener(n, cb, false); }; (doc.documentElement.firstElementChild || doc.documentElement.children[0]).appendChild(refStyle); if (!doc.addEventListener) { addEventListener = function (element, eventName, callback) { element.attachEvent('on' + eventName, function (e) { e.preventDefault = function () {e.returnValue = false;}; e.target = e.srcElement; callback(e); }); }; } function toggle(a, recursive) { var s = a.nextSibling || {}, oldClass = s.className, arrow, newClass; if (/\bsf-dump-compact\b/.test(oldClass)) { arrow = '&#9660;'; newClass = 'sf-dump-expanded'; } else if (/\bsf-dump-expanded\b/.test(oldClass)) { arrow = '&#9654;'; newClass = 'sf-dump-compact'; } else { return false; } if (doc.createEvent && s.dispatchEvent) { var event = doc.createEvent('Event'); event.initEvent('sf-dump-expanded' === newClass ? 'sfbeforedumpexpand' : 'sfbeforedumpcollapse', true, false); s.dispatchEvent(event); } a.lastChild.innerHTML = arrow; s.className = s.className.replace(/\bsf-dump-(compact|expanded)\b/, newClass); if (recursive) { try { a = s.querySelectorAll('.'+oldClass); for (s = 0; s < a.length; ++s) { if (-1 == a[s].className.indexOf(newClass)) { a[s].className = newClass; a[s].previousSibling.lastChild.innerHTML = arrow; } } } catch (e) { } } return true; }; function collapse(a, recursive) { var s = a.nextSibling || {}, oldClass = s.className; if (/\bsf-dump-expanded\b/.test(oldClass)) { toggle(a, recursive); return true; } return false; }; function expand(a, recursive) { var s = a.nextSibling || {}, oldClass = s.className; if (/\bsf-dump-compact\b/.test(oldClass)) { toggle(a, recursive); return true; } return false; }; function collapseAll(root) { var a = root.querySelector('a.sf-dump-toggle'); if (a) { collapse(a, true); expand(a); return true; } return false; } function reveal(node) { var previous, parents = []; while ((node = node.parentNode || {}) && (previous = node.previousSibling) && 'A' === previous.tagName) { parents.push(previous); } if (0 !== parents.length) { parents.forEach(function (parent) { expand(parent); }); return true; } return false; } function highlight(root, activeNode, nodes) { resetHighlightedNodes(root); Array.from(nodes||[]).forEach(function (node) { if (!/\bsf-dump-highlight\b/.test(node.className)) { node.className = node.className + ' sf-dump-highlight'; } }); if (!/\bsf-dump-highlight-active\b/.test(activeNode.className)) { activeNode.className = activeNode.className + ' sf-dump-highlight-active'; } } function resetHighlightedNodes(root) { Array.from(root.querySelectorAll('.sf-dump-str, .sf-dump-key, .sf-dump-public, .sf-dump-protected, .sf-dump-private')).forEach(function (strNode) { strNode.className = strNode.className.replace(/\bsf-dump-highlight\b/, ''); strNode.className = strNode.className.replace(/\bsf-dump-highlight-active\b/, ''); }); } return function (root, x) { root = doc.getElementById(root); var indentRx = new RegExp('^('+(root.getAttribute('data-indent-pad') || ' ').replace(rxEsc, '\\$1')+')+', 'm'), options = {"maxDepth":1,"maxStringLength":160,"fileLinkFormat":false}, elt = root.getElementsByTagName('A'), len = elt.length, i = 0, s, h, t = []; while (i < len) t.push(elt[i++]); for (i in x) { options[i] = x[i]; } function a(e, f) { addEventListener(root, e, function (e) { if ('A' == e.target.tagName) { f(e.target, e); } else if ('A' == e.target.parentNode.tagName) { f(e.target.parentNode, e); } else if (e.target.nextElementSibling && 'A' == e.target.nextElementSibling.tagName) { f(e.target.nextElementSibling, e, true); } }); }; function isCtrlKey(e) { return e.ctrlKey || e.metaKey; } function xpathString(str) { var parts = str.match(/[^'"]+|['"]/g).map(function (part) { if ("'" == part) { return '"\'"'; } if ('"' == part) { return "'\"'"; } return "'" + part + "'"; }); return "concat(" + parts.join(",") + ", '')"; } addEventListener(root, 'mouseover', function (e) { if ('' != refStyle.innerHTML) { refStyle.innerHTML = ''; } }); a('mouseover', function (a, e, c) { if (c) { e.target.style.cursor = "pointer"; } else if (a = idRx.exec(a.className)) { try { refStyle.innerHTML = 'pre.sf-dump .'+a[0]+'{background-color: #B729D9; color: #FFF !important; border-radius: 2px}'; } catch (e) { } } }); a('click', function (a, e, c) { if (/\bsf-dump-toggle\b/.test(a.className)) { e.preventDefault(); if (!toggle(a, isCtrlKey(e))) { var r = doc.getElementById(a.getAttribute('href').substr(1)), s = r.previousSibling, f = r.parentNode, t = a.parentNode; t.replaceChild(r, a); f.replaceChild(a, s); t.insertBefore(s, r); f = f.firstChild.nodeValue.match(indentRx); t = t.firstChild.nodeValue.match(indentRx); if (f && t && f[0] !== t[0]) { r.innerHTML = r.innerHTML.replace(new RegExp('^'+f[0].replace(rxEsc, '\\$1'), 'mg'), t[0]); } if (/\bsf-dump-compact\b/.test(r.className)) { toggle(s, isCtrlKey(e)); } } if (c) { } else if (doc.getSelection) { try { doc.getSelection().removeAllRanges(); } catch (e) { doc.getSelection().empty(); } } else { doc.selection.empty(); } } else if (/\bsf-dump-str-toggle\b/.test(a.className)) { e.preventDefault(); e = a.parentNode.parentNode; e.className = e.className.replace(/\bsf-dump-str-(expand|collapse)\b/, a.parentNode.className); } }); elt = root.getElementsByTagName('SAMP'); len = elt.length; i = 0; while (i < len) t.push(elt[i++]); len = t.length; for (i = 0; i < len; ++i) { elt = t[i]; if ('SAMP' == elt.tagName) { elt.className = 'sf-dump-expanded'; a = elt.previousSibling || {}; if ('A' != a.tagName) { a = doc.createElement('A'); a.className = 'sf-dump-ref'; elt.parentNode.insertBefore(a, elt); } else { a.innerHTML += ' '; } a.title = (a.title ? a.title+'\n[' : '[')+keyHint+'+click] Expand all children'; a.innerHTML += '
    <span>&#9660;</span>'; a.className += ' sf-dump-toggle'; x = 1; if ('sf-dump' != elt.parentNode.className) { x += elt.parentNode.getAttribute('data-depth')/1; } elt.setAttribute('data-depth', x); if (x > options.maxDepth) { toggle(a); } } else if (/\bsf-dump-ref\b/.test(elt.className) && (a = elt.getAttribute('href'))) { a = a.substr(1); elt.className += ' '+a; if (/[\[{]$/.test(elt.previousSibling.nodeValue)) { a = a != elt.nextSibling.id && doc.getElementById(a); try { s = a.nextSibling; elt.appendChild(a); s.parentNode.insertBefore(a, s); if (/^[@#]/.test(elt.innerHTML)) { elt.innerHTML += '
    <span>&#9654;</span>'; } else { elt.innerHTML = '
    <span>&#9654;</span>'; elt.className = 'sf-dump-ref'; } elt.className += ' sf-dump-toggle'; } catch (e) { if ('&' == elt.innerHTML.charAt(0)) { elt.innerHTML = '&hellip;'; elt.className = 'sf-dump-ref'; } } } } } if (doc.evaluate && Array.from && root.children.length > 1) { root.setAttribute('tabindex', 0); SearchState = function () { this.nodes = []; this.idx = 0; }; SearchState.prototype = { next: function () { if (this.isEmpty()) { return this.current(); } this.idx = this.idx< (this.nodes.length - 1) ? this.idx + 1 : this.idx; return this.current(); }, previous: function () { if (this.isEmpty()) { return this.current(); } this.idx = this.idx > 0 ? this.idx - 1 : this.idx; return this.current(); }, isEmpty: function () { return 0 === this.count(); }, current: function () { if (this.isEmpty()) { return null; } return this.nodes[this.idx]; }, reset: function () { this.nodes = []; this.idx = 0; }, count: function () { return this.nodes.length; }, }; function showCurrent(state) { var currentNode = state.current(); if (currentNode) { reveal(currentNode); highlight(root, currentNode, state.nodes); } counter.textContent = (state.isEmpty() ? 0 : state.idx + 1) + ' of ' + state.count(); } var search = doc.createElement('div'); search.className = 'sf-dump-search-wrapper sf-dump-search-hidden'; search.innerHTML = ' 
    <input type="text" class="sf-dump-search-input">
    <span class="sf-dump-search-count">0 of 0<\/span>
        <button type="button" class="sf-dump-search-input-previous" tabindex="-1">
            <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                <path d="M1683 1331l-166 165q-19 19-45 19t-45-19l-531-531-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"\/><\/svg><\/button>
                <button type="button" class="sf-dump-search-input-next" tabindex="-1">
                    <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1683 808l-742 741q-19 19-45 19t-45-19l-742-741q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"\/><\/svg><\/button> '; root.insertBefore(search, root.firstChild); var state = new SearchState(); var searchInput = search.querySelector('.sf-dump-search-input'); var counter = search.querySelector('.sf-dump-search-count'); var searchInputTimer = 0; var previousSearchQuery = ''; addEventListener(searchInput, 'keyup', function (e) { var searchQuery = e.target.value; /* Don't perform anything if the pressed key didn't change the query */ if (searchQuery === previousSearchQuery) { return; } previousSearchQuery = searchQuery; clearTimeout(searchInputTimer); searchInputTimer = setTimeout(function () { state.reset(); collapseAll(root); resetHighlightedNodes(root); if ('' === searchQuery) { counter.textContent = '0 of 0'; return; } var xpathResult = doc.evaluate('//pre[@id="' + root.id + '"]//span[@class="sf-dump-str" or @class="sf-dump-key" or @class="sf-dump-public" or @class="sf-dump-protected" or @class="sf-dump-private"][contains(child::text(), ' + xpathString(searchQuery) + ')]', document, null, XPathResult.ORDERED_NODE_ITERATOR_TYPE, null); while (node = xpathResult.iterateNext()) state.nodes.push(node); showCurrent(state); }, 400); }); Array.from(search.querySelectorAll('.sf-dump-search-input-next, .sf-dump-search-input-previous')).forEach(function (btn) { addEventListener(btn, 'click', function (e) { e.preventDefault(); -1 !== e.target.className.indexOf('next') ? state.next() : state.previous(); searchInput.focus(); collapseAll(root); showCurrent(state); }) }); addEventListener(root, 'keydown', function (e) { var isSearchActive = !/\bsf-dump-search-hidden\b/.test(search.className); if ((114 === e.keyCode && !isSearchActive) || (isCtrlKey(e) && 70 === e.keyCode)) { /* F3 or CMD/CTRL + F */ e.preventDefault(); search.className = search.className.replace(/\bsf-dump-search-hidden\b/, ''); searchInput.focus(); } else if (isSearchActive) { if (27 === e.keyCode) { /* ESC key */ search.className += ' sf-dump-search-hidden'; e.preventDefault(); resetHighlightedNodes(root); searchInput.value = ''; } else if ( (isCtrlKey(e) && 71 === e.keyCode) /* CMD/CTRL + G */ || 13 === e.keyCode /* Enter */ || 114 === e.keyCode /* F3 */ ) { e.preventDefault(); e.shiftKey ? state.previous() : state.next(); collapseAll(root); showCurrent(state); } } }); } if (0 >= options.maxStringLength) { return; } try { elt = root.querySelectorAll('.sf-dump-str'); len = elt.length; i = 0; t = []; while (i < len) t.push(elt[i++]); len = t.length; for (i = 0; i < len; ++i) { elt = t[i]; s = elt.innerText || elt.textContent; x = s.length - options.maxStringLength; if (0 < x) { h = elt.innerHTML; elt[elt.innerText ? 'innerText' : 'textContent'] = s.substring(0, options.maxStringLength); elt.className += ' sf-dump-str-collapse'; elt.innerHTML = '
                        <span class=sf-dump-str-collapse>'+h+'
                            <a class="sf-dump-ref sf-dump-str-toggle" title="Collapse"> &#9664;</a>
                        </span>'+ '
                        <span class=sf-dump-str-expand>'+elt.innerHTML+'
                            <a class="sf-dump-ref sf-dump-str-toggle" title="'+x+' remaining characters"> &#9654;</a>
                        </span>'; } } } catch (e) { } }; })(document);
                    </script>
                    <style> pre.sf-dump { display: block; white-space: pre; padding: 5px; } pre.sf-dump:after { content: ""; visibility: hidden; display: block; height: 0; clear: both; } pre.sf-dump span { display: inline; } pre.sf-dump .sf-dump-compact { display: none; } pre.sf-dump abbr { text-decoration: none; border: none; cursor: help; } pre.sf-dump a { text-decoration: none; cursor: pointer; border: 0; outline: none; color: inherit; } pre.sf-dump .sf-dump-ellipsis { display: inline-block; overflow: visible; text-overflow: ellipsis; max-width: 5em; white-space: nowrap; overflow: hidden; vertical-align: top; } pre.sf-dump .sf-dump-ellipsis+.sf-dump-ellipsis { max-width: none; } pre.sf-dump code { display:inline; padding:0; background:none; } .sf-dump-str-collapse .sf-dump-str-collapse { display: none; } .sf-dump-str-expand .sf-dump-str-expand { display: none; } .sf-dump-public.sf-dump-highlight, .sf-dump-protected.sf-dump-highlight, .sf-dump-private.sf-dump-highlight, .sf-dump-str.sf-dump-highlight, .sf-dump-key.sf-dump-highlight { background: rgba(111, 172, 204, 0.3); border: 1px solid #7DA0B1; border-radius: 3px; } .sf-dump-public.sf-dump-highlight-active, .sf-dump-protected.sf-dump-highlight-active, .sf-dump-private.sf-dump-highlight-active, .sf-dump-str.sf-dump-highlight-active, .sf-dump-key.sf-dump-highlight-active { background: rgba(253, 175, 0, 0.4); border: 1px solid #ffa500; border-radius: 3px; } pre.sf-dump .sf-dump-search-hidden { display: none; } pre.sf-dump .sf-dump-search-wrapper { float: right; font-size: 0; white-space: nowrap; max-width: 100%; text-align: right; } pre.sf-dump .sf-dump-search-wrapper > * { vertical-align: top; box-sizing: border-box; height: 21px; font-weight: normal; border-radius: 0; background: #FFF; color: #757575; border: 1px solid #BBB; } pre.sf-dump .sf-dump-search-wrapper > input.sf-dump-search-input { padding: 3px; height: 21px; font-size: 12px; border-right: none; width: 140px; border-top-left-radius: 3px; border-bottom-left-radius: 3px; color: #000; } pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-next, pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-previous { background: #F2F2F2; outline: none; border-left: none; font-size: 0; line-height: 0; } pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-next { border-top-right-radius: 3px; border-bottom-right-radius: 3px; } pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-next > svg, pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-previous > svg { pointer-events: none; width: 12px; height: 12px; } pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-count { display: inline-block; padding: 0 5px; margin: 0; border-left: none; line-height: 21px; font-size: 12px; }pre.sf-dump, pre.sf-dump .sf-dump-default{background-color:#fff; color:#222; line-height:1.2em; font-weight:normal; font:12px Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:100000}pre.sf-dump .sf-dump-num{color:#a71d5d}pre.sf-dump .sf-dump-const{color:#795da3}pre.sf-dump .sf-dump-str{color:#df5000}pre.sf-dump .sf-dump-cchr{color:#222}pre.sf-dump .sf-dump-note{color:#a71d5d}pre.sf-dump .sf-dump-ref{color:#a0a0a0}pre.sf-dump .sf-dump-public{color:#795da3}pre.sf-dump .sf-dump-protected{color:#795da3}pre.sf-dump .sf-dump-private{color:#795da3}pre.sf-dump .sf-dump-meta{color:#b729d9}pre.sf-dump .sf-dump-key{color:#df5000}pre.sf-dump .sf-dump-index{color:#a71d5d}</style>
                    <pre class=sf-dump id=sf-dump-1036523571 data-indent-pad="  ">
                        <abbr title="Illuminate\Http\Request" class=sf-dump-note>Request</abbr> {
                        <a class=sf-dump-ref>#42</a>
                        <samp>
  #
                            <span class=sf-dump-protected title="Protected property">json</span>:
                            <abbr title="Symfony\Component\HttpFoundation\ParameterBag" class=sf-dump-note>ParameterBag</abbr> {
                            <a class=sf-dump-ref>#200</a>
                            <samp>
    #
                                <span class=sf-dump-protected title="Protected property">parameters</span>: []
                            </samp>}
  #
                            <span class=sf-dump-protected title="Protected property">convertedFiles</span>:
                            <span class=sf-dump-const>null</span>
  #
                            <span class=sf-dump-protected title="Protected property">userResolver</span>:
                            <span class=sf-dump-note>Closure</span> {
                            <a class=sf-dump-ref>#161</a>
                            <samp>
                                <span class=sf-dump-meta>class</span>: "
                                <span class=sf-dump-str title="Illuminate\Auth\AuthServiceProvider
35 characters">
                                    <span class="sf-dump-ellipsis sf-dump-ellipsis-class">Illuminate\Auth</span>
                                    <span class=sf-dump-ellipsis>\</span>AuthServiceProvider
                                </span>"
                                <span class=sf-dump-meta>this</span>:
                                <abbr title="Illuminate\Auth\AuthServiceProvider" class=sf-dump-note>AuthServiceProvider</abbr> {
                                <a class=sf-dump-ref>#38</a> &hellip;}
                                <span class=sf-dump-meta>parameters</span>: {
                                <samp>
                                    <span class=sf-dump-meta>$guard</span>: {
                                    <samp>
                                        <span class=sf-dump-meta>default</span>:
                                        <span class=sf-dump-const>null</span>
                                    </samp>}
                                </samp>}
                                <span class=sf-dump-meta>use</span>: {
                                <samp>
                                    <span class=sf-dump-meta>$app</span>:
                                    <abbr title="Illuminate\Foundation\Application" class=sf-dump-note>Application</abbr> {
                                    <a class=sf-dump-ref>#2</a> &hellip;}
                                </samp>}
                                <span class=sf-dump-meta>file</span>: "
                                <span class=sf-dump-str title="/home/ghassen/Desktop/batta/vendor/laravel/framework/src/Illuminate/Auth/AuthServiceProvider.php
96 characters">
                                    <span class="sf-dump-ellipsis sf-dump-ellipsis-path">/home/ghassen/Desktop/batta/vendor</span>
                                    <span class=sf-dump-ellipsis>/laravel/framework/</span>src/Illuminate/Auth/AuthServiceProvider.php
                                </span>"
                                <span class=sf-dump-meta>line</span>: "
                                <span class=sf-dump-str title="8 characters">85 to 87</span>"
                            </samp>}
  #
                            <span class=sf-dump-protected title="Protected property">routeResolver</span>:
                            <span class=sf-dump-note>Closure</span> {
                            <a class=sf-dump-ref>#163</a>
                            <samp>
                                <span class=sf-dump-meta>class</span>: "
                                <span class=sf-dump-str title="Illuminate\Routing\Router
25 characters">
                                    <span class="sf-dump-ellipsis sf-dump-ellipsis-class">Illuminate\Routing</span>
                                    <span class=sf-dump-ellipsis>\</span>Router
                                </span>"
                                <span class=sf-dump-meta>this</span>:
                                <abbr title="Illuminate\Routing\Router" class=sf-dump-note>Router</abbr> {
                                <a class=sf-dump-ref>#25</a> &hellip;}
                                <span class=sf-dump-meta>use</span>: {
                                <samp>
                                    <span class=sf-dump-meta>$route</span>:
                                    <abbr title="Illuminate\Routing\Route" class=sf-dump-note>Route</abbr> {
                                    <a class=sf-dump-ref>#129</a> &hellip;}
                                </samp>}
                                <span class=sf-dump-meta>file</span>: "
                                <span class=sf-dump-str title="/home/ghassen/Desktop/batta/vendor/laravel/framework/src/Illuminate/Routing/Router.php
86 characters">
                                    <span class="sf-dump-ellipsis sf-dump-ellipsis-path">/home/ghassen/Desktop/batta/vendor</span>
                                    <span class=sf-dump-ellipsis>/laravel/framework/</span>src/Illuminate/Routing/Router.php
                                </span>"
                                <span class=sf-dump-meta>line</span>: "
                                <span class=sf-dump-str title="10 characters">628 to 630</span>"
                            </samp>}
  +
                            <span class=sf-dump-public title="Public property">attributes</span>:
                            <abbr title="Symfony\Component\HttpFoundation\ParameterBag" class=sf-dump-note>ParameterBag</abbr> {
                            <a class=sf-dump-ref>#44</a>
                            <samp>
    #
                                <span class=sf-dump-protected title="Protected property">parameters</span>: []
                            </samp>}
  +
                            <span class=sf-dump-public title="Public property">request</span>:
                            <abbr title="Symfony\Component\HttpFoundation\ParameterBag" class=sf-dump-note>ParameterBag</abbr> {
                            <a class=sf-dump-ref>#43</a>
                            <samp>
    #
                                <span class=sf-dump-protected title="Protected property">parameters</span>:
                                <span class=sf-dump-note>array:1</span> [
                                <samp>
      "
                                    <span class=sf-dump-key>email</span>" => "
                                    <span class=sf-dump-str title="20 characters">0Eo7ftPt56@gmail.com</span>"
                                </samp>]
                            </samp>}
  +
                            <span class=sf-dump-public title="Public property">query</span>:
                            <abbr title="Symfony\Component\HttpFoundation\ParameterBag" class=sf-dump-note>ParameterBag</abbr> {
                            <a class=sf-dump-ref>#50</a>
                            <samp>
    #
                                <span class=sf-dump-protected title="Protected property">parameters</span>: []
                            </samp>}
  +
                            <span class=sf-dump-public title="Public property">server</span>:
                            <abbr title="Symfony\Component\HttpFoundation\ServerBag" class=sf-dump-note>ServerBag</abbr> {
                            <a class=sf-dump-ref>#46</a>
                            <samp>
    #
                                <span class=sf-dump-protected title="Protected property">parameters</span>:
                                <span class=sf-dump-note>array:27</span> [
                                <samp>
      "
                                    <span class=sf-dump-key>DOCUMENT_ROOT</span>" => "
                                    <span class=sf-dump-str title="34 characters">/home/ghassen/Desktop/batta/public</span>"
      "
                                    <span class=sf-dump-key>REMOTE_ADDR</span>" => "
                                    <span class=sf-dump-str title="9 characters">127.0.0.1</span>"
      "
                                    <span class=sf-dump-key>REMOTE_PORT</span>" => "
                                    <span class=sf-dump-str title="5 characters">59384</span>"
      "
                                    <span class=sf-dump-key>SERVER_SOFTWARE</span>" => "
                                    <span class=sf-dump-str title="46 characters">PHP 7.0.22-0ubuntu0.16.04.1 Development Server</span>"
      "
                                    <span class=sf-dump-key>SERVER_PROTOCOL</span>" => "
                                    <span class=sf-dump-str title="8 characters">HTTP/1.1</span>"
      "
                                    <span class=sf-dump-key>SERVER_NAME</span>" => "
                                    <span class=sf-dump-str title="9 characters">127.0.0.1</span>"
      "
                                    <span class=sf-dump-key>SERVER_PORT</span>" => "
                                    <span class=sf-dump-str title="4 characters">8000</span>"
      "
                                    <span class=sf-dump-key>REQUEST_URI</span>" => "
                                    <span class=sf-dump-str title="6 characters">/login</span>"
      "
                                    <span class=sf-dump-key>REQUEST_METHOD</span>" => "
                                    <span class=sf-dump-str title="4 characters">POST</span>"
      "
                                    <span class=sf-dump-key>SCRIPT_NAME</span>" => "
                                    <span class=sf-dump-str title="10 characters">/index.php</span>"
      "
                                    <span class=sf-dump-key>SCRIPT_FILENAME</span>" => "
                                    <span class=sf-dump-str title="44 characters">/home/ghassen/Desktop/batta/public/index.php</span>"
      "
                                    <span class=sf-dump-key>PATH_INFO</span>" => "
                                    <span class=sf-dump-str title="6 characters">/login</span>"
      "
                                    <span class=sf-dump-key>PHP_SELF</span>" => "
                                    <span class=sf-dump-str title="16 characters">/index.php/login</span>"
      "
                                    <span class=sf-dump-key>HTTP_CACHE_CONTROL</span>" => "
                                    <span class=sf-dump-str title="8 characters">no-cache</span>"
      "
                                    <span class=sf-dump-key>HTTP_POSTMAN_TOKEN</span>" => "
                                    <span class=sf-dump-str title="36 characters">3b5445f2-a07f-4a18-8475-136583517406</span>"
      "
                                    <span class=sf-dump-key>CONTENT_TYPE</span>" => "
                                    <span class=sf-dump-str title="80 characters">multipart/form-data; boundary=--------------------------670014809873306918858473</span>"
      "
                                    <span class=sf-dump-key>HTTP_CONTENT_TYPE</span>" => "
                                    <span class=sf-dump-str title="80 characters">multipart/form-data; boundary=--------------------------670014809873306918858473</span>"
      "
                                    <span class=sf-dump-key>HTTP_USER_AGENT</span>" => "
                                    <span class=sf-dump-str title="20 characters">PostmanRuntime/6.4.1</span>"
      "
                                    <span class=sf-dump-key>HTTP_ACCEPT</span>" => "
                                    <span class=sf-dump-str title="3 characters">*/*</span>"
      "
                                    <span class=sf-dump-key>HTTP_HOST</span>" => "
                                    <span class=sf-dump-str title="14 characters">localhost:8000</span>"
      "
                                    <span class=sf-dump-key>HTTP_COOKIE</span>" => "
                                    <span class=sf-dump-str title="294 characters">laravel_session=eyJpdiI6IjdJM1I2NFJcL1VsV2FmMDBOaXFYd3hRPT0iLCJ2YWx1ZSI6InBXY0I0UTRnRm1YWXZ1SE9sNHBVanJwazkwT1hJNFZnYkUwbkpkZWNZWStZOElJMnpvclBub2lDWHlmdHdEMDhzclR2UmUxUncrSXE4SldoOCtiV1hBPT0iLCJtYWMiOiJjNDU3MjdmYzQzZWQwNWI0MWU3ODY5YjU0NmNkM2JjM2M0YmE3YWZjNmNmNjdjNzRjZjU4MzcwOGNkZTcwMjY4In0%3D</span>"
      "
                                    <span class=sf-dump-key>HTTP_ACCEPT_ENCODING</span>" => "
                                    <span class=sf-dump-str title="13 characters">gzip, deflate</span>"
      "
                                    <span class=sf-dump-key>CONTENT_LENGTH</span>" => "
                                    <span class=sf-dump-str title="3 characters">180</span>"
      "
                                    <span class=sf-dump-key>HTTP_CONTENT_LENGTH</span>" => "
                                    <span class=sf-dump-str title="3 characters">180</span>"
      "
                                    <span class=sf-dump-key>HTTP_CONNECTION</span>" => "
                                    <span class=sf-dump-str title="10 characters">keep-alive</span>"
      "
                                    <span class=sf-dump-key>REQUEST_TIME_FLOAT</span>" =>
                                    <span class=sf-dump-num>1511672474.245</span>
      "
                                    <span class=sf-dump-key>REQUEST_TIME</span>" =>
                                    <span class=sf-dump-num>1511672474</span>
                                </samp>]
                            </samp>}
  +
                            <span class=sf-dump-public title="Public property">files</span>:
                            <abbr title="Symfony\Component\HttpFoundation\FileBag" class=sf-dump-note>FileBag</abbr> {
                            <a class=sf-dump-ref>#47</a>
                            <samp>
    #
                                <span class=sf-dump-protected title="Protected property">parameters</span>: []
                            </samp>}
  +
                            <span class=sf-dump-public title="Public property">cookies</span>:
                            <abbr title="Symfony\Component\HttpFoundation\ParameterBag" class=sf-dump-note>ParameterBag</abbr> {
                            <a class=sf-dump-ref>#45</a>
                            <samp>
    #
                                <span class=sf-dump-protected title="Protected property">parameters</span>:
                                <span class=sf-dump-note>array:1</span> [
                                <samp>
      "
                                    <span class=sf-dump-key>laravel_session</span>" => "
                                    <span class=sf-dump-str title="40 characters">k5yrPjwPt336Fldes6i2Lvq5Ho1NlAIP3pxJ8aPf</span>"
                                </samp>]
                            </samp>}
  +
                            <span class=sf-dump-public title="Public property">headers</span>:
                            <abbr title="Symfony\Component\HttpFoundation\HeaderBag" class=sf-dump-note>HeaderBag</abbr> {
                            <a class=sf-dump-ref>#48</a>
                            <samp>
    #
                                <span class=sf-dump-protected title="Protected property">headers</span>:
                                <span class=sf-dump-note>array:10</span> [
                                <samp>
      "
                                    <span class=sf-dump-key>cache-control</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="8 characters">no-cache</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>postman-token</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="36 characters">3b5445f2-a07f-4a18-8475-136583517406</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>content-type</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="80 characters">multipart/form-data; boundary=--------------------------670014809873306918858473</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>user-agent</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="20 characters">PostmanRuntime/6.4.1</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>accept</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="3 characters">*/*</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>host</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="14 characters">localhost:8000</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>cookie</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="294 characters">laravel_session=eyJpdiI6IjdJM1I2NFJcL1VsV2FmMDBOaXFYd3hRPT0iLCJ2YWx1ZSI6InBXY0I0UTRnRm1YWXZ1SE9sNHBVanJwazkwT1hJNFZnYkUwbkpkZWNZWStZOElJMnpvclBub2lDWHlmdHdEMDhzclR2UmUxUncrSXE4SldoOCtiV1hBPT0iLCJtYWMiOiJjNDU3MjdmYzQzZWQwNWI0MWU3ODY5YjU0NmNkM2JjM2M0YmE3YWZjNmNmNjdjNzRjZjU4MzcwOGNkZTcwMjY4In0%3D</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>accept-encoding</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="13 characters">gzip, deflate</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>content-length</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="3 characters">180</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>connection</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
                                        <span class=sf-dump-index>0</span> => "
                                        <span class=sf-dump-str title="10 characters">keep-alive</span>"
                                    </samp>]
                                </samp>]
    #
                                <span class=sf-dump-protected title="Protected property">cacheControl</span>:
                                <span class=sf-dump-note>array:1</span> [
                                <samp>
      "
                                    <span class=sf-dump-key>no-cache</span>" =>
                                    <span class=sf-dump-const>true</span>
                                </samp>]
                            </samp>}
  #
                            <span class=sf-dump-protected title="Protected property">content</span>: ""
  #
                            <span class=sf-dump-protected title="Protected property">languages</span>:
                            <span class=sf-dump-const>null</span>
  #
                            <span class=sf-dump-protected title="Protected property">charsets</span>:
                            <span class=sf-dump-const>null</span>
  #
                            <span class=sf-dump-protected title="Protected property">encodings</span>:
                            <span class=sf-dump-const>null</span>
  #
                            <span class=sf-dump-protected title="Protected property">acceptableContentTypes</span>:
                            <span class=sf-dump-const>null</span>
  #
                            <span class=sf-dump-protected title="Protected property">pathInfo</span>: "
                            <span class=sf-dump-str title="6 characters">/login</span>"
  #
                            <span class=sf-dump-protected title="Protected property">requestUri</span>: "
                            <span class=sf-dump-str title="6 characters">/login</span>"
  #
                            <span class=sf-dump-protected title="Protected property">baseUrl</span>: ""
  #
                            <span class=sf-dump-protected title="Protected property">basePath</span>:
                            <span class=sf-dump-const>null</span>
  #
                            <span class=sf-dump-protected title="Protected property">method</span>: "
                            <span class=sf-dump-str title="4 characters">POST</span>"
  #
                            <span class=sf-dump-protected title="Protected property">format</span>:
                            <span class=sf-dump-const>null</span>
  #
                            <span class=sf-dump-protected title="Protected property">session</span>:
                            <abbr title="Illuminate\Session\Store" class=sf-dump-note>Store</abbr> {
                            <a class=sf-dump-ref>#107</a>
                            <samp>
    #
                                <span class=sf-dump-protected title="Protected property">id</span>: "
                                <span class=sf-dump-str title="40 characters">k5yrPjwPt336Fldes6i2Lvq5Ho1NlAIP3pxJ8aPf</span>"
    #
                                <span class=sf-dump-protected title="Protected property">name</span>: "
                                <span class=sf-dump-str title="15 characters">laravel_session</span>"
    #
                                <span class=sf-dump-protected title="Protected property">attributes</span>:
                                <span class=sf-dump-note>array:3</span> [
                                <samp>
      "
                                    <span class=sf-dump-key>_token</span>" => "
                                    <span class=sf-dump-str title="40 characters">OrNLQJtxGlTkxhywmEPjqyslfXiXmdMU6bA5KakS</span>"
      "
                                    <span class=sf-dump-key>_previous</span>" =>
                                    <span class=sf-dump-note>array:1</span> [
                                    <samp>
        "
                                        <span class=sf-dump-key>url</span>" => "
                                        <span class=sf-dump-str title="34 characters">http://localhost:8000/unautherized</span>"
                                    </samp>]
      "
                                    <span class=sf-dump-key>_flash</span>" =>
                                    <span class=sf-dump-note>array:2</span> [
                                    <samp>
        "
                                        <span class=sf-dump-key>old</span>" => []
        "
                                        <span class=sf-dump-key>new</span>" => []
                                    </samp>]
                                </samp>]
    #
                                <span class=sf-dump-protected title="Protected property">handler</span>:
                                <abbr title="Illuminate\Session\FileSessionHandler" class=sf-dump-note>FileSessionHandler</abbr> {
                                <a class=sf-dump-ref>#106</a>
                                <samp>
      #
                                    <span class=sf-dump-protected title="Protected property">files</span>:
                                    <abbr title="Illuminate\Filesystem\Filesystem" class=sf-dump-note>Filesystem</abbr> {
                                    <a class=sf-dump-ref>#96</a>}
      #
                                    <span class=sf-dump-protected title="Protected property">path</span>: "
                                    <span class=sf-dump-str title="54 characters">/home/ghassen/Desktop/batta/storage/framework/sessions</span>"
      #
                                    <span class=sf-dump-protected title="Protected property">minutes</span>:
                                    <span class=sf-dump-num>120</span>
                                </samp>}
    #
                                <span class=sf-dump-protected title="Protected property">started</span>:
                                <span class=sf-dump-const>true</span>
                            </samp>}
  #
                            <span class=sf-dump-protected title="Protected property">locale</span>:
                            <span class=sf-dump-const>null</span>
  #
                            <span class=sf-dump-protected title="Protected property">defaultLocale</span>: "
                            <span class=sf-dump-str title="2 characters">en</span>"
  -
                            <span class=sf-dump-private title="Private property defined in class:&#10;`Symfony\Component\HttpFoundation\Request`">isHostValid</span>:
                            <span class=sf-dump-const>true</span>
  -
                            <span class=sf-dump-private title="Private property defined in class:&#10;`Symfony\Component\HttpFoundation\Request`">isForwardedValid</span>:
                            <span class=sf-dump-const>true</span>
                            <span class=sf-dump-meta>basePath</span>: ""
                            <span class=sf-dump-meta>format</span>: "
                            <span class=sf-dump-str title="4 characters">html</span>"
                        </samp>}
                    </pre>
                    <script>Sfdump("sf-dump-1036523571")</script>