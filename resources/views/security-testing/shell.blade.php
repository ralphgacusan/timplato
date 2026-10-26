<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Timplato · Security training</title>
    <style>html,body{margin:0;height:100%;background:#f7f8fb}iframe{display:block;width:100%;height:100%;border:0}#lab-error{position:fixed;bottom:16px;left:16px;right:16px;background:#fff0ed;color:#912018;padding:16px;border:1px solid #e7a49b;font:14px Arial;z-index:2}</style>
</head>
<body>
    <iframe id="security-lab-frame" title="Timplato training storefront" sandbox="allow-scripts allow-forms"></iframe>
    <p id="lab-error" role="alert" hidden></p>
    <script>
    (() => {
        'use strict';
        const frame = document.getElementById('security-lab-frame');
        const error = document.getElementById('lab-error');
        const origin = {{ Illuminate\Support\Js::from($origin) }};
        const allowed = /^\/(?:signin-test|signup-test|logout-test|products-test|product-test\/\d+|review-test(?:\/reset)?|database-test(?:\/reset)?|cart-test)$/;
        let busy = false;
        // Scripts can change this whole training document, but have no access to
        // the real application's cookies, DOM, storage, or request endpoints.
        function bridge() {
            window.labNavigate = (url, fields = {}, method = 'POST') => {
                parent.postMessage({type: 'security-lab:navigate', url, method, fields: Object.entries(fields)}, '*');
            };
            document.addEventListener('click', event => {
                const link = event.target.closest('a[href]');
                if (!link || link.getAttribute('href').startsWith('#')) return;
                event.preventDefault();
                window.labNavigate(link.href, {}, 'GET');
            }, true);
            document.addEventListener('submit', event => {
                event.preventDefault();
                const form = event.target;
                const fields = Array.from(new FormData(form, event.submitter).entries());
                parent.postMessage({type: 'security-lab:navigate', url: form.action, method: form.method.toUpperCase(), fields}, '*');
            }, true);
        }
        function display(documentHtml) {
            const csp = `default-src 'none'; script-src 'unsafe-inline'; style-src ${origin}/css/security-testing.css 'unsafe-inline'; img-src ${origin}/images/products/ ${origin}/timplatoLogo/ ${origin}/Assets/ data:; font-src 'none'; connect-src 'none'; form-action 'none'; frame-src 'none'; object-src 'none'; base-uri 'none'`;
            const prefix = '<meta http-equiv="Content-Security-Policy" content="' + csp + '"><script>(' + bridge.toString() + ')();<\/script>';
            frame.srcdoc = documentHtml.replace(/<head[^>]*>/i, match => match + prefix);
        }
        display({{ Illuminate\Support\Js::from($document) }});
        window.addEventListener('message', async event => {
            if (event.source !== frame.contentWindow || event.data?.type !== 'security-lab:navigate' || busy) return;
            try {
                const url = new URL(event.data.url, origin);
                if (url.origin !== origin || !allowed.test(url.pathname)) throw new Error('This link is outside the training storefront.');
                const method = event.data.method;
                if (!['GET', 'POST'].includes(method) || !Array.isArray(event.data.fields)) throw new Error('Unsupported training request.');
                const fields = new URLSearchParams(event.data.fields);
                if (method === 'GET') url.search = fields.toString() || url.search;
                busy = true;
                error.hidden = true;
                const response = await fetch(url, {
                    method,
                    credentials: 'same-origin',
                    headers: {'X-Security-Lab-Document': '1', 'Accept': 'text/html'},
                    ...(method === 'POST' ? {body: fields} : {}),
                });
                const destination = new URL(response.url);
                if (destination.origin !== origin || !allowed.test(destination.pathname)) throw new Error('Unexpected training destination.');
                if (!response.ok) throw new Error(response.status === 419 ? 'Session expired. Refresh this page and try again.' : 'The training request failed (' + response.status + '). Refresh or reset the lab database.');
                display(await response.text());
                history.replaceState(null, '', destination.pathname + destination.search);
            } catch (exception) {
                error.textContent = exception.message;
                error.hidden = false;
            } finally {
                busy = false;
            }
        });
    })();
    </script>
</body>
</html>
