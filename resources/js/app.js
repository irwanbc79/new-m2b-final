import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

window.Alpine = Alpine;
Alpine.plugin(intersect);

// Auto-detect browser language if not set yet
if (!localStorage.getItem('m2b_lang')) {
    const browserLang = (navigator.language || navigator.userLanguage || '').toLowerCase();
    let defaultLang = 'id';
    if (browserLang.startsWith('zh')) {
        defaultLang = 'zh';
    } else if (browserLang.startsWith('ar')) {
        defaultLang = 'ar';
    } else if (browserLang.startsWith('id') || browserLang.startsWith('ms')) {
        defaultLang = 'id';
    } else {
        defaultLang = 'en';
    }
    localStorage.setItem('m2b_lang', defaultLang);
}

// Global language store — accessible everywhere via $store.lang.current
Alpine.store('lang', {
    current: localStorage.getItem('m2b_lang') || 'id',
    toggle() {
        const langs = ['id', 'en', 'zh', 'ar'];
        const nextIdx = (langs.indexOf(this.current) + 1) % langs.length;
        this.current = langs[nextIdx];
        localStorage.setItem('m2b_lang', this.current);
    },
    t(id, en, zh, ar) {
        if (this.current === 'zh') return zh || en || id;
        if (this.current === 'ar') return ar || en || id;
        if (this.current === 'en') return en || id;
        return id;
    }
});

Alpine.start();
