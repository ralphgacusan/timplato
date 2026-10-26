import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import test from 'node:test';
import vm from 'node:vm';

const adminLayoutPath = fileURLToPath(new URL('../../resources/views/components/admin-layout.blade.php', import.meta.url));
const customerNavbarPath = fileURLToPath(new URL('../../public/js/customer/navbar.js', import.meta.url));
const adminLayout = readFileSync(adminLayoutPath, 'utf8');
const customerNavbar = readFileSync(customerNavbarPath, 'utf8');

class FakeElement {
    constructor(tagName) {
        this.tagName = tagName;
        this.children = [];
        this.attributes = {};
        this.style = {};
        this.className = '';
        this.text = '';
        this.innerHtmlWasAssigned = false;
        Object.defineProperty(this, 'textContent', {
            get: () => this.text,
            set: (value) => { this.text = value; },
        });
        Object.defineProperty(this, 'innerHTML', {
            get: () => '',
            set: () => { this.innerHtmlWasAssigned = true; },
        });
    }

    setAttribute(name, value) {
        this.attributes[name] = value;
    }

    addEventListener() {}

    append(...nodes) {
        this.children.push(...nodes);
    }

    appendChild(node) {
        this.children.push(node);
        return node;
    }

    remove() {}
}

function extractNotification(source, surface) {
    const start = source.indexOf('function showNotification(');
    const endMarker = surface === 'admin'
        ? '\n        </script>'
        : '\n}\n\ndocument.addEventListener';
    const end = source.indexOf(endMarker, start);
    assert.notEqual(start, -1, `${surface} should define showNotification`);
    assert.notEqual(end, -1, `${surface} showNotification should have a clear function boundary`);

    return source.slice(start, end + (surface === 'admin' ? 0 : 2));
}

for (const [surface, source] of [['admin', adminLayout], ['customer', customerNavbar]]) {
    test(`${surface} toast renders attacker-controlled notification text without parsing HTML`, () => {
    const implementation = extractNotification(source, surface);
    const container = new FakeElement('div');
    const document = {
        getElementById: (id) => id === 'notification-container' ? container : null,
        createElement: (tagName) => new FakeElement(tagName),
    };
    const payload = '<img src=x onerror="globalThis.pwned=true">';
    const context = { document, setTimeout: () => 0 };

    vm.runInNewContext(`${implementation}\nshowNotification(${JSON.stringify(payload)}, 'error', 1000);`, context);

    assert.equal(container.children.length, 1);
    const notification = container.children[0];
    const message = notification.children[0];
    const closeButton = notification.children[1];

    assert.equal(message.tagName, 'span');
    assert.equal(message.textContent, payload);
    assert.equal(message.innerHtmlWasAssigned, false);
    assert.equal(closeButton.tagName, 'button');
    assert.equal(closeButton.textContent, '×');
    assert.equal(closeButton.attributes['aria-label'], 'Close notification');
    assert.equal(context.pwned, undefined);
    });
}
