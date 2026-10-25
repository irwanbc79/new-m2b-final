import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import vm from 'node:vm';

const source = readFileSync(new URL('../public/js/mora.js', import.meta.url), 'utf8');
const start = source.indexOf('  async function submitLead()');
const end = source.indexOf('  function appendBubble(', start);
assert.ok(start >= 0 && end > start);

for (const scenario of ['success', '422', '500', 'invalid-json', 'network', 'false-success']) {
  test(`MORA lead: ${scenario}`, async () => {
    let hidden = false;
    let saved = false;
    const bubbles = [];
    const button = { textContent: '', disabled: false };
    const elements = {
      'mora-lead-name': { value: 'Test' }, 'mora-lead-phone': { value: '0812345' },
      'mora-lead-submit': button,
      'mora-lead-form': { classList: { remove: () => { hidden = true; } } },
    };
    const context = vm.createContext({
      el: id => elements[id], localStorage: { getItem: () => 'id' },
      TRANSLATIONS: { id: { sending: 'Sending', submitBtn: 'Submit', connError: 'Failed',
        successText: () => 'Success', successHist: () => 'Success' } },
      history: [], leadDone: false, LEAD_URL: '/mora/lead', CSRF_TOKEN: () => 'test',
      saveHistory: () => { saved = true; }, appendBubble: (...args) => bubbles.push(args),
      fetch: async () => {
        if (scenario === 'network') throw new Error('Offline');
        return {
          ok: !['422', '500'].includes(scenario),
          json: async () => {
            if (scenario === 'invalid-json') throw new Error('Invalid JSON');
            return { success: scenario !== 'false-success' };
          },
        };
      },
    });
    vm.runInContext(source.slice(start, end), context);
    await vm.runInContext('submitLead()', context);
    const success = scenario === 'success';
    assert.equal(context.leadDone, success);
    assert.equal(hidden, success);
    assert.equal(saved, success);
    assert.equal(button.disabled, success);
    assert.equal(bubbles[0][1], success ? 'Success' : 'Failed');
  });
}